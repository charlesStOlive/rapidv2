<?php

namespace Wcli\Wconfig\Functions;

use Wcli\Crm\Models\Gamme;
use Waka\Utils\Classes\FunctionsBase;
use Wcli\Wconfig\Models\UniqueAgg;
use Waka\Charter\Controllers\Charts;

class Region extends FunctionsBase
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
        $datas = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $dataSet,
                    'label' => 'CA',
                ],
            ],
        ];

        $chart = new Charts();
        $chart_url = $chart->setChartType('bar_or_line')
                    ->addChartDatas($datas)
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
            array_push($labels, $result->year . '-' . $attributes['type'] . '-' . $result->num);
        }

        $options = [
            'type' => $attributes['chartType'],
            'beginAtZero' => $attributes['beginAtZero'] ?? false,
        ];
        $datas = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $dataSet,
                    'label' => 'CA',
                    'yAxisID' => 'y_1',
                ],
                [
                    'data' => $dataSet2,
                    'label' => 'Volume',
                    'yAxisID' => 'y_2',
                ],
            ],
        ];

        $chart = new Charts();
        $chart_url = $chart->setChartType('bar_or_line_2_axis')
                    ->addChartDatas($datas)
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
        $datas = [
            'labels' => $sales->pluck('labels')->toArray(),
            'datasets' => [
                [
                    'data' => $sales->pluck('value')->toArray(),
                ],
            ],
        ];

        $chart = new Charts();
        $chart_url = $chart->setChartType('pie_or_doughnut')
                    ->addChartDatas($datas)
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
     * Top client
     */
    public function topClient($attributes)
    {
        $clients = $this->model->clients()->get(['name', 'id']);
        $ids = $clients->pluck('id');
        $clients = $clients->keyBy('id')->toArray();

        $results = UniqueAgg::where('uniqueable_type', 'client')->whereIn('uniqueable_id', $ids)->orderBy($attributes['periode'], 'desc')->take($attributes['qty'])->get();

        $results = $results->map(function ($item, $key) use ($clients) {
            $item['name'] = $clients[$item['uniqueable_id']]['name'];
            return $item;
        });

        //trace_log($results->toArray());
        return $results->toArray();
    }

    /**
     * Periode editable
     */
    public function periodeGraph($attributes)
    {
        $num_start = $attributes['start_at'];
        $num_end = $attributes['end_at'];
        $type = $attributes['type'];

        $results = [];
        $labels = [];

        $i = $num_end;
        for ($i; $i >= $num_start; $i--) {
            $request = $this->model->sales();
            $periodeValue = $this->filterPeriode($request, $type, $i);
            array_push($results, $periodeValue->count());
            array_push($labels, $type . '-' . $i);
        }

        $options = [
            'type' => $attributes['chartType'],
            'beginAtZero' => $attributes['beginAtZero'] ?? false,
            'color' => $attributes['color'],
        ];
        $datas = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $results,
                    'label' => 'CA',
                ],
            ],
        ];

        $chart = new Charts();
        $chart_url = $chart->setChartType('bar_or_line')
                    ->addChartDatas($datas)
                    ->addChartOptions($options)
                    ->getChartUrl($attributes['width'], $attributes['height']);

        

        $finalResult[0]['chart'] = [
            'path' => $chart_url,
            'width' => $attributes['width'],
            'height' => $attributes['height'],
        ];
        return $finalResult;
    }

}
