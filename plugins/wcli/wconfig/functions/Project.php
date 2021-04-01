<?php

namespace Wcli\Wconfig\Functions;

use Waka\Crm\Models\Mission;
use Waka\Crm\Models\Sector;
use Waka\Crm\Models\Variante;
use Waka\Utils\Classes\FunctionsBase;
use Waka\Wcms\Models\Solution;

class Project extends FunctionsBase
{

    public function missionsByPeriod($attributes)
    {
        $result = $this->model->missions();

        if ($attributes['periods'] ?? false) {
            $result = $result->whereIn('period_id', $attributes['periods']);
        }
        $result = $result->with('period')->get()->toArray();

        return $result;
    }
    // public function missionsTemplate($attributes)
    // {
    //     $result = Mission::whereIn('id', $attributes['missions'])->get()->toArray();
    //     return $result;
    // }
    public function variantes($attributes)
    {
        $variantes = $this->model->variantes->toArray();
        $missionTotal = $this->model->projectPeriodTotal;
        $mensuelTotal = $this->model->allMensuel;
        $result = [];
        foreach ($variantes as $variante) {
            $variante['newTotal'] = $missionTotal + $variante['projet'];
            $variante['newMensualite'] = $mensuelTotal + intval($variante['licence'] + $variante['maintenance'] + $variante['abonnement']);
            array_push($result, $variante);

        }
        return $result;
    }

    public function workflows($attributes)
    {
        $workflows = $this->model->create_wfs;
        if (!$workflows) {
            return [];
        }
        $width = $attributes['width'] ?? null;
        $height = $attributes['height'] ?? null;
        $workflows->each(function ($item, $key) use ($attributes, $width, $height) {
            //trace_log($item);
            $item['imagetd'] = [
                'path' => $item->image_td->getThumb(1024, null, ['mode' => 'auto']),
                'width' => $width,
                'height' => $height,
            ];
            $item['imagelr'] = [
                'path' => $item->image_lr->getThumb(null, 1024, ['mode' => 'auto']),
                'width' => $width,
                'height' => $height,
            ];
        });
        return $workflows->toArray();
    }
    public function solutionsFiltered($attributes)
    {
        $results = Solution::whereIn('id', $attributes['solutions'])->with('main_image')->get();
        $finalResult;
        foreach ($results as $key => $result) {
            $finalResult[$key] = $result->toArray();
            $options = [
                'width' => $attributes['width'] ?? null,
                'height' => $attributes['height'] ?? null,
                'crop' => $attributes['crop'] ?? 'fit',
                'gravity' => $attributes['gravity'] ?? 'center',
            ];
            $finalResult[$key]['main_image'] = [
                'path' => $result->main_image->getUrl($options),
                'width' => $attributes['width'] ?? null,
                'height' => $attributes['height'] ?? null,
            ];
        }
        return $finalResult;
    }

    public function allContacts($attributes)
    {
        $result = $this->model->client->contacts;
        $result = $this->getAttributesDs($result);
        return $result->toArray();
    }

    public function getSectorContent($attributes)
    {
        $contents = $this->model->client->sector->content;
        $result = [];
        foreach ($contents as $content) {
            if (in_array($content['code'], $attributes['codes'])) {
                array_push($result, $content);
            }
        }
        return $result;
    }

    public function tasks($attributes)
    {
        $result = $this->model->tasks();
        if ($attributes['task_state'] ?? false) {
            $result = $result->whereHas('task_state', function ($query) use ($attributes) {
                $query->whereIn('id', $attributes['task_state']);
            });
        }
        if ($attributes['task_type'] ?? false) {
            $result = $result->whereHas('task_type', function ($query) use ($attributes) {
                $query->whereIn('id', $attributes['task_type']);
            });
        }
        if ($attributes['start_date'] ?? false) {
            $result = $result->whereDate('updated_at', '>=', $attributes['start_date']);
        }
        if ($attributes['end_date'] ?? false) {
            $result = $result->whereDate('updated_at', '<=', $attributes['start_date']);
        }
        $result = $result->with('task_state', 'task_type')->orderby('start_at', 'asc')->get()->toArray();
        return $result;
    }

    /**
     * Fonctions pour attributs et outputs
     */

    // public function listPeriodes() {
    //     return Period::lists('name', 'id');
    // }
    public function listMissionTemplate()
    {
        return Mission::where('is_template', true)->lists('name', 'id');
    }
    public function getMissionTemplate()
    {
        return Mission::where('is_template', true)->first()->toArray();
    }
    // public function listSolutions() {
    //     return Solution::lists('name', 'id');
    // }
    public function getSolution()
    {
        return Solution::first()->toArray();
    }
    public function getVariantes()
    {
        return Variante::first()->toArray();
    }
    // public function listTaskState() {
    //     return TaskState::lists('name', 'id');
    // }
    // public function listTaskType() {
    //     return TaskType::lists('name', 'id');
    // }

}
