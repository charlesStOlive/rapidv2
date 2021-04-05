<?php

namespace Wcli\Wconfig\Functions\Querys;

use Waka\Agg\Classes\AggQueryBase;
use Wcli\Crm\Models\Sale;
use \Db;

class ClientSalesQuery extends AggQueryBase
{

    public static function get($ids, $periode)
    {
        $raws = self::CreateAutoDbRaw($periode['calculs']);
        // tres important la requête doit retourner une unique valeur id en lien avec la classe de reception. ex client_id as id pour Client
        return Sale::whereIn('client_id', $ids)->select('client_id as id', Db::raw($raws))
            ->groupBy('client_id')
            ->whereBetween('sale_at', [$periode['start_at'], $periode['end_at']])
            ->get();
    }

}
