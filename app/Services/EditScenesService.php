<?php


namespace App\Services;


use App\Models\Image;
use App\Models\Novel;
use App\Models\Scene;

class EditScenesService
{
    public function getScenesTree(Novel $novel): array
    {
        if ($novel->first_scene_id === null) {
            return [];
        }

        $scenes = $novel->scenes()->with('image')->get()->keyBy('id');
        $choices = $novel->choices;

        return $this->addSceneToTree([], $scenes, $choices, $novel->first_scene_id);
    }

    private function addSceneToTree(array $nodes, $scenes, $choices, $sceneId, $parentId = null, $choiceValue = null): array
    {
        $scene = $scenes->find($sceneId);
        $nodes[$sceneId] = [
            'id' => $scene->id,
            'pid' => $parentId,
            'name' => $scene->name,
            'img' => $scene->image->path,
            'question' => $scene->question,
            'choice' => $choiceValue,
        ];
        if ($scene->next_scene_id) {
            return $this->addSceneToTree($nodes, $scenes, $choices, $scene->next_scene_id, $scene->id);
        }
        $nextChoices = $choices->where('scene_id', $scene->id);
        if ($nextChoices->isEmpty()) {
            return $nodes;
        }
        foreach ($nextChoices as $choice) {
            if (!$choice->next_scene_id) {
                continue;
            }
            $nodes = $this->addSceneToTree($nodes, $scenes, $choices, $choice->next_scene_id, $scene->id, $choice->value);
        }
        return $nodes;
    }
}
