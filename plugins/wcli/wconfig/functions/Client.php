<?php

namespace Wcli\Wconfig\Functions;

use Wcli\Crm\Models\Gamme;
use Waka\Utils\Classes\FunctionsBase;
use Waka\Charter\Controllers\Charts;

class Client extends FunctionsBase
{
    public $model;
    use \Wcli\Wconfig\Functions\Traits\Helpers;

    /**
     * Groupe de fonctions oneSet et Two set
     */
    public function chooseOneTwoSetComon($attributes)
    {
        $results = $this->model->aggs()
            ->where('type', $attributes['type'])
            ->orderBy('ended_at', 'desc')->take($attributes['qty'])->get();

        //On inverse les resultats ( les resultats on été pris préalablement en desc pour utiliser Take())
        return $results->sortBy('ended_at');
    }
    public function chooseOneSetAgg($attributes)
    {
        $results = $this->chooseOneTwoSetComon($attributes);

        $dataSet = [];
        $labels = [];
        foreach ($results as $key => $result) {
            array_push($dataSet, $result[$attributes['calcul']]);
            array_push($labels, $result->year . '-' . $attributes['type'] . '-' . $result->num);
        }

        $options = [
            'type' => $attributes['chartType'],
            'beginAtZero' => $attributes['beginAtZero'] ?? false,
            'color' => $attributes['color'],
        ];
        // $datas = [
        //     'labels' => $labels,
        //     'datasets' => [
        //         [
        //             'data' => $dataSet,
        //             'label' => 'CA',
        //         ],
        //     ],
        // ];
        
        // $charts = new \Waka\Charter\Controllers\Charts();

        // $chart_url = $charts->createChartUrl($datas, 'bar_or_line', $options, $attributes['width'], $attributes['height']);

        $chart = new Charts();
        $chart_url = $chart->setChartType('bar_or_line')
                    ->addLabels($labels)
                    ->addManualDataSet('CA', $dataSet)
                    ->addChartOptions($options)
                    ->getChartUrl($attributes['width'], $attributes['height']);

        $finalResult[0]['chart'] = [
            'path' => $chart_url,
            'width' => $attributes['width'],
            'height' => $attributes['height'],
        ];
        return $finalResult;
    }

    public function chooseTwoSetAgg($attributes)
    {
        $results = $this->chooseOneTwoSetComon($attributes);

        $dataSet = [];
        $dataSet2 = [];
        $labels = [];
        foreach ($results as $key => $result) {
            array_push($dataSet, $result['sum']);
            array_push($dataSet2, $result['count']);
            array_push($labels, $result->year . '-' . $attributes['type'] . '--' . $result->num);
        }

        $options = [
            'type' => $attributes['chartType'],
            'beginAtZero' => $attributes['beginAtZero'] ?? false,
        ];
        $chart = new Charts();
        $chart_url = $chart->setChartType('bar_or_line_2_axis')
                    //->addChartDatas($datas)
                    ->addLabels($labels)
                    ->addManualDataSet('CA', $dataSet)
                    ->addManualDataSet('Volume', $dataSet2)
                    ->addChartOptions($options)
                    ->getChartUrl($attributes['width'], $attributes['height']);

        $finalResult[0]['chart'] = [
            'path' => $chart_url,
            'width' => $attributes['width'],
            'height' => $attributes['height'],
        ];
        return $finalResult;

    }
    public function chooseSetAggTab($attributes)
    {
        $results = $this->chooseOneTwoSetComon($attributes);
        //trace_log($results->toArray());

        $results = $results->map(function ($item, $key) use ($attributes) {
            $item['name'] = $item['year'] . '-' . $attributes['type'] . '-' . $item['num'];
            return $item;
        });

        //trace_log($results->toArray());

        return $results->toArray();

    }

    /**
     * Gammes
     */

    public function graphGammes($attributes = [], $ids = [])
    {
        $sales = $this->model->sales();

        $sales = $this->filterByPeriode($sales, $attributes['periode']);

        $sales = $sales->select('gamme_id', \Db::raw('COUNT(*) as value'))
            ->groupBy('gamme_id')->get();

        $totalSales = $sales->sum('value');
        $countSales = $sales->count();

        $others = [];
        $grouped = null;

        if ($sales->count() > $attributes['nb']) {
            $grouped = $sales->reject(function ($item, $key) use ($totalSales, $attributes) {
                $value = $item['value'];
                if ($value / $totalSales * 100 > $attributes['seuil']) {
                    return $item;
                }
            });
            $sales = $sales->reject(function ($item, $key) use ($totalSales, $attributes) {
                $value = $item['value'];
                if ($value / $totalSales * 100 < $attributes['seuil']) {
                    return $item;
                }
            });
        }

        $sales = $sales->map(function ($item, $key) use ($totalSales) {
            $mapped = [];
            if ($item['gamme_id'] != 'autres') {
                $mapped['labels'] = Gamme::find($item['gamme_id'])->name;
            }
            $mapped['value'] = $item['value'];
            return $mapped;
        });
        if ($grouped) {
            $groupedObj = [
                'labels' => 'autres (' . $grouped->count() . ')',
                'value' => $grouped->sum('value'),
            ];
            $sales->push($groupedObj);
        }

        $options = [
            'type' => $attributes['chartType'],
            'beginAtZero' => $attributes['beginAtZero'] ?? false,
        ];
        // $datas = [
        //     'labels' => $sales->pluck('labels')->toArray(),
        //     'datasets' => [
        //         [
        //             'data' => $sales->pluck('value')->toArray(),
        //         ],
        //     ],
        // ];
        // $charts = new \Waka\Charter\Controllers\Charts();
        // $chart_url = $charts->createChartUrl($datas, 'pie_or_doughnut', $options, $attributes['width'], $attributes['height']);

        $chart = new Charts();
        $chart_url = $chart->setChartType('pie_or_doughnut')
                    ->addLabels($sales->pluck('labels')->toArray())
                    ->addManualDataSet('', $sales->pluck('value')->toArray())
                    ->addChartOptions($options)
                    ->getChartUrl($attributes['width'], $attributes['height']);

        $finalResult[0]['chart'] = [
            'path' => $chart_url,
            'width' => $attributes['width'],
            'height' => $attributes['height'],
        ];
        return $finalResult;
    }

/**
 * listeDesVentes
 */
    public function listeDesVentes($attributes)
    {
        $sales = $this->model->sales();
        $sales = $sales->where('sale_at', '>=', $attributes['sale_at']);
        return $sales->with('gamme')->get()->toArray();
    }

}
