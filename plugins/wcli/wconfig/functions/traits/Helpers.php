<?php namespace Wcli\Wconfig\Functions\Traits;

use Carbon\Carbon;

trait Helpers
{
    public function filterPeriode($request, $type, $num)
    {
        //trace_log("nombre de vente " . $request->count());

        if ($type == 'y') {
            $year = Carbon::now()->subYears($num);
            return $request->whereYear('sale_at', $year);
        }
        if ($type == 'q') {
            $date = Carbon::now()->subQuarters($num);
            $start_at = $date->copy()->startOfQuarter();
            $end_at = $date->copy()->endOfQuarter();
            return $request->whereBetween('sale_at', [$start_at, $end_at]);
        }
        if ($type == 'm') {
            $date = Carbon::now()->subMonths($num);
            $start_at = $date->copy()->startOfMonth();
            $end_at = $date->copy()->endOfMonth();
            return $request->whereBetween('sale_at', [$start_at, $end_at]);
        }
        if ($type == 'w') {
            $date = Carbon::now()->subWeeks($num);
            $start_at = $date->copy()->startOfWeek();
            $end_at = $date->copy()->endOfWeek();
            return $request->whereBetween('sale_at', [$start_at, $end_at]);
        }
    }

    public function getPeriodeType($label = 'Choisssez une période', $span = "full")
    {
        return [
            'label' => 'Choisssez une période',
            'type' => 'dropdown',
            'span' => $span,
            'options' => [
                'y' => "Année",
                'q' => "Trimestres",
                'm' => "Mois",
                'w' => 'Semaine',
            ],
        ];
    }

    public function filterByPeriode($request, $periode)
    {
        $year = Carbon::now()->year;

        if ($periode == 'all') {
            return $request;
        }
        if ($periode == 'y') {
            return $request->whereYear('sale_at', $year);
        }
        if ($periode == 'y_1') {
            $year = Carbon::now()->subYear()->year;
            return $request->whereYear('sale_at', $year);
        }
        if ($periode == 't') {
            $date = Carbon::now();
            $start_at = $date->copy()->startOfQuarter();
            $end_at = $date->copy()->endOfQuarter();
            return $request->whereBetween('sale_at', [$start_at, $end_at]);
        }
        if ($periode == 't_1') {
            $date = Carbon::now()->subQuarter();
            $start_at = $date->copy()->startOfQuarter();
            $end_at = $date->copy()->endOfQuarter();
            return $request->whereBetween('sale_at', [$start_at, $end_at]);
        }
        if ($periode == 't_n_1') {
            $date = Carbon::now()->subYear();
            $start_at = $date->copy()->startOfQuarter();
            $end_at = $date->copy()->endOfQuarter();
            return $request->whereBetween('sale_at', [$start_at, $end_at]);
        }
        if ($periode == 't_1_n_1') {
            $date = Carbon::now()->subQuarter()->subYear();
            $start_at = $date->copy()->startOfQuarter();
            $end_at = $date->copy()->endOfQuarter();
            return $request->whereBetween('sale_at', [$start_at, $end_at]);
        }
        if ($periode == 'm') {
            $date = Carbon::now();
            $start_at = $date->copy()->startOfMonth();
            $end_at = $date->copy()->endOfMonth();
            return $request->whereBetween('sale_at', [$start_at, $end_at]);
        }
        if ($periode == 'm_1') {
            $date = Carbon::now()->subMonth();
            $start_at = $date->copy()->startOfMonth();
            $end_at = $date->copy()->endOfMonth();
            return $request->whereBetween('sale_at', [$start_at, $end_at]);
        }
        if ($periode == 'm_n_1') {
            $date = Carbon::now()->subYear();
            $start_at = $date->copy()->startOfMonth();
            $end_at = $date->copy()->endOfMonth();
            return $request->whereBetween('sale_at', [$start_at, $end_at]);
        }
        if ($periode == 'm_1_n_1') {
            $date = Carbon::now()->subMonth()->subYear();
            $start_at = $date->copy()->startOfMonth();
            $end_at = $date->copy()->endOfMonth();
            return $request->whereBetween('sale_at', [$start_at, $end_at]);
        }

    }

    public function getPeriode($label = 'Choisssez une période', $span = "full")
    {
        return [
            'label' => 'Choisssez une période',
            'type' => 'dropdown',
            'span' => $span,
            'options' => [
                'all' => "Tout le temps",
                'y' => "Année N",
                'y_1' => "N-1",
                't' => 'Trimestre T',
                't_1' => "T-1",
                't_n_1' => "T N-1 ( trimestre  de l'année précédente)",
                't_1_n_1' => "T-1 N-1 ( trimestre prescedent de l'année précédente)",
                'm' => 'Mois M',
                'm_1' => "M-1",
                'm_n_1' => "M-1 N-1 ( mois  de l'année précédente)",
                'm_1_n_1' => "M-1 N-1 ( mois prescedent de l'année précédente)",
            ],
        ];
    }

    public function getPeriodeAgg($label = "choisissez une aggrégation", $span = "full")
    {
        return [
            'label' => $label,
            'type' => 'dropdown',
            'span' => $span,
            'options' => [
                's_y' => "Année N  (CA)",
                's_y_1' => "N-1 (CA)",
                'c_y' => "N  (Nb)",
                'c_y_1' => "N-1 (Nb)",
                's_q' => 'Trimestre T (CA)',
                's_q_1' => "T-1 (CA)",
                's_q_n_1' => "T N-1 ( trimestre  de l'année précédente) (CA)",
                's_q_1_n_1' => "T-1 N-1 ( trimestre prescedent de l'année précédente) (CA)",
                's_m' => 'Mois M (CA)',
                's_m_1' => "M-1 (CA)",
                's_m_n_1' => "M-1 N-1 ( mois  de l'année précédente) (CA)",
                's_m_1_n_1' => "M-1 N-1 ( mois prescedent de l'année précédente) (CA)",
            ],
        ];
    }

    public function getPeriodeRegionAgg($label = "choisissez une aggrégation", $span = "full")
    {
        return [
            'label' => $label,
            'type' => 'dropdown',
            'span' => $span,
            'options' => [
                's_y' => "Année N  (CA)",
                's_y_1' => "N-1 (CA)",
                'c_y' => "N  (Nb)",
                'c_y_1' => "N-1 (Nb)",
                's_q' => 'Trimestre T (CA)',
                's_q_1' => "T-1 (CA)",
                's_q_n_1' => "T N-1 ( trimestre  de l'année précédente) (CA)",
                's_q_1_n_1' => "T-1 N-1 ( trimestre prescedent de l'année précédente) (CA)",
                's_m' => 'Mois M (CA)',
                's_m_1' => "M-1 (CA)",
                's_m_n_1' => "M-1 N-1 ( mois  de l'année précédente) (CA)",
                's_m_1_n_1' => "M-1 N-1 ( mois prescedent de l'année précédente) (CA)",
                's_m_1_n_1' => "M-1 N-1 ( mois prescedent de l'année précédente) (CA)",
                's_m_1_n_1' => "M-1 N-1 ( mois prescedent de l'année précédente) (CA)",
                's_w_1' => "S-1 (semaine prescedente)",
                's_w_2' => "S-2",

            ],
        ];
    }

    public function getPeriodeCalc($label, $span = "full")
    {
        return [
            'label' => $label,
            'type' => 'dropdown',
            'span' => $span,
            'options' => [
                '=' => "égale à",
                '>' => "supérieur à",
                '<' => 'inférieur à',
                '>=' => "supérieur ou égale à",
                '<=' => "inférieur ou égale à",
            ],
        ];
    }
}
