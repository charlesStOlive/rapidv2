<?php

namespace Wcli\Wconfig\Functions\Querys;

use Waka\Agg\Classes\AggQueryBase;
use \Db;

class RegionSalesQuery extends AggQueryBase
{

    public static function get($ids, $periode)
    {
        // calcul des raws dans la classe de base.
        //trace_log('region');
        $raws = self::CreateAutoDbRaw($periode['calculs']);
        return DB::table('wcli_crm_sales')
            ->join('wcli_crm_clients', 'wcli_crm_sales.client_id', '=', 'wcli_crm_clients.id')
            ->select('wcli_crm_clients.region_id as id', Db::raw($raws))
            ->whereIn('wcli_crm_clients.region_id', $ids)
            ->groupBy('wcli_crm_clients.region_id')
            ->whereBetween('wcli_crm_sales.sale_at', [$periode['start_at'], $periode['end_at']])
            ->get();
    }
}
