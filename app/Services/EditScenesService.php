<?php


namespace App\Services;


use App\Exceptions\CannotCreateScene;
use App\Exceptions\ChoiceValueMissed;
use App\Exceptions\ParentSceneMissed;
use App\Exceptions\SceneCannotBeDeleted;
use App\Models\Choice;
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

    public function createScene(Novel $novel, array $data): Scene
    {
        /** @var Scene $scene */
        $scene = $novel->scenes()->create($data);

        if ($novel->first_scene_id !== null) {
            if (!isset($data['parent_scene_id'])) {
                throw new ParentSceneMissed();
            }
            $parent_scene = Scene::find($data['parent_scene_id']);
            if ($parent_scene->question) {
                if (!isset($data['choice_value'])) {
                    throw new ChoiceValueMissed();
                }
                $novel->choices()->create([
                    'scene_id' => $parent_scene->id,
                    'next_scene_id' => $scene->id,
                    'value' => $data['choice_value'],
                ]);
            } elseif (!$parent_scene->next_scene_id) {
                $parent_scene->nextScene()->associate($scene)->save();
            } else {
                throw new CannotCreateScene();
            }
        } else {
            $novel->firstScene()->associate($scene)->save();
        }

        return $scene;
    }

    public function editScene(Scene $scene, array $data): Scene
    {
        $scene->update($data);
        Choice::whereNextSceneId($scene->id)->update([
            'value' => $data['choice_value'] ?? '',
        ]);
        return $scene;
    }

    public function deleteScene(Novel $novel, Scene $scene): void
    {
        if ($scene->choices()->exists()) {
            throw new SceneCannotBeDeleted();
        }
        if ($scene->id === $novel->first_scene_id) {
            $novel->first_scene_id = $scene->next_scene_id;
            $novel->save();
            return;
        }
        if ($scene->next_scene_id) {
            $choices = Choice::whereNextSceneId($scene->id);
            $choices->update(['next_scene_id' => $scene->next_scene_id]);
        } else {
            Choice::whereNextSceneId($scene->id)->delete();
        }
        $scenes = Scene::whereNextSceneId($scene->id);
        $scenes->update(['next_scene_id' => $scene->next_scene_id]);
    }

    private function addSceneToTree(array $nodes, $scenes, $choices, $sceneId, $parentId = null, $choiceValue = null): array
    {
        $scene = $scenes->find($sceneId);
        $nodes[$sceneId] = [
            'id' => $scene->id,
            'pid' => $parentId,
            'name' => $scene->name,
            'img' => $scene->image ? $scene->image->path : null,
            'question' => $scene->question,
            'choice' => $choiceValue,
            'text' => $scene->text,
            'image_id' => $scene->image_id,
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
