<?php

namespace Wcli\Wconfig\Functions\Tags;

use Db;
use Wcli\Crm\Models\Gamme;
use Wcli\Crm\Models\Sale;
use Waka\Segator\Classes\BaseTag;
use Wcli\Wconfig\Models\UniqueAgg;

class ClientTags extends BaseTag
{
    public $model;
    public $list;

    use \Wcli\Wconfig\Functions\Traits\Helpers;

    public function listTagAttributes()
    {
        return [
            'evolutionVente' => [
                'name' => "Rechercher volume de vente sur une période",
                'attributes' => [
                    'periode' => $this->getPeriodeAgg("Choisissez une aggrégation", "left"),
                    'periode_calc' => $this->getPeriodeCalc("opérateur", "left"),
                    'nb' => [
                        'label' => "Valeur",
                        'type' => "number",
                        'required' => true,
                        'span' => 'right',
                    ],
                ],
            ],
            'progressionVente' => [
                'name' => "Rechercher progression vente entre deux période",
                'attributes' => [
                    'periode_1' => $this->getPeriodeAgg("Choisissez 1ere aggrégation", "left"),
                    'periode_2' => $this->getPeriodeAgg("Choisissez 2nd aggrégation", "right"),
                    'periode_calc' => $this->getPeriodeCalc("opérateur", "left"),
                    'valeur' => [
                        'label' => "% de progression (0.1)",
                        'type' => "number",
                        'default' => 0.1,
                        'required' => true,
                        'span' => 'right',
                    ],
                ],
            ],
            'nbVentesGammes' => [
                'name' => "Tague si NB ventes supérieures à XX sur les gammes ",
                'attributes' => [
                    'nb' => [
                        'label' => "Nombre",
                        'type' => "number",
                    ],
                    'gammes' => [
                        'label' => "Gammes",
                        'type' => "taglist",
                        'useKey' => true,
                        'options' => Gamme::lists('name', 'id'),
                    ],
                    'periode' => $this->getPeriode("Choisissez une période"),
                ],
            ],
        ];
    }
    public function evolutionVente($attributes = [], $ids = [])
    {

        $aggs = UniqueAgg::where('uniqueable_type', 'client')->where($attributes['periode'], $attributes['periode_calc'], $attributes['nb']);
        if (count($ids)) {
            $aggs = $aggs->whereIn('uniqueable_id', $ids);
        }
        //trace_log($aggs->pluck('uniqueable_id'));
        return $aggs->pluck('uniqueable_id');

    }

    public function progressionVente($attributes = [], $ids = [])
    {
        //trace_sql();
        $aggs = UniqueAgg::where('uniqueable_type', 'client');
        if (in_array($attributes['periode_calc'], ["<", '<='])) {
            $aggs = $aggs->where(function ($q) use ($attributes) {
                $q->whereRaw($attributes['periode_1'] . '/' . $attributes['periode_2'] . ' ' . $attributes['periode_calc'] . ' ' . $attributes['valeur']);
            });
        } else {
            $aggs = $aggs->whereRaw($attributes['periode_1'] . '/' . $attributes['periode_2'] . ' ' . $attributes['periode_calc'] . ' ' . $attributes['valeur']);
        }
        if (count($ids)) {
            $aggs = $aggs->whereIn('uniqueable_id', $ids);
        }
        return $aggs->get()->pluck('uniqueable_id');

    }

    public function nbVentes($attributes = [], $ids = [])
    {
        $période = $attributes['periode'] ?? false;

        $sales = Sale::select('client_id');

        $sales = $this->getPeriode($sales, $periode);

        $sales = $sales->groupBy('client_id')
            ->havingRaw('COUNT(*) >' . $attributes['nb']);
        if ($attributes['nbm'] > 0) {
            $sales = $sales->havingRaw('COUNT(*) <=' . $attributes['nbm']);
        }
        if (count($ids)) {
            $sales = $sales->whereIn('client_id', $ids);
        }
        return $sales->get()->pluck('client_id');
    }
    public function nbVentesGammes($attributes = [], $ids = [])
    {
        $periode = $attributes['periode'] ?? false;

        $sales = Sale::whereIn('gamme_id', $attributes['gammes']);

        $sales = $this->filterByPeriode($sales, $periode);

        $sales = $sales->select('client_id', Db::raw('COUNT(*) as nb_sales'))
            ->groupBy('client_id')
            ->havingRaw('COUNT(*) > ' . $attributes['nb']);

        if (count($ids)) {
            $sales->whereIn('client_id', $ids);
        }
        return $sales->get()->pluck('client_id');
    }

}
