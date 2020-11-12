<?php

namespace App\Services\ToDo;

use App\Helpers\Helpers;
use App\Models\ToDo\ToDoList;
use App\Models\ToDo\ToDoPlan;

class ToDoPlansService
{
    const GET_ALL = 0;
    const GET_COMPLETE_ONLY = 1;
    const GET_INCOMPLETE_ONLY = 2;

    public function create(array $request, ToDoList $list)
    {
        return [
            'message' => $list->getPlans()->create(array_merge(['list_id' => $list->id], $request)),
            'code' => 201
        ];
    }

    public function delete(ToDoPlan $plan)
    {
        try {
            $plan->delete();

            return [
                'message' => null,
                'code' => 200
            ];
        } catch (\Exception $e) {
            return [
                'message' => "Plan hasn't been deleted",
                'code' => 304
            ];
        }
    }

    public function change(array $request, ToDoPlan $plan, ToDoList $newList = null)
    {
        try {
            \DB::transaction(function () use ($request, $plan, $newList) {
                $foundList = $plan->getList()->first();

                $complete = null;
                if (isset($request['complete'])) {
                    $complete = $request['complete'];
                }

                if (isset($newList)) {//Если лист план привязывается к новому листу
                    if (isset($complete)) {
                        $complete = (bool)$complete;

                        if (!$plan->complete) {
                            --$foundList->undone;
                            $foundList->save();
                        }

                        if (!$complete) {
                            ++$newList->undone;
                            $newList->save();
                        }
                    } elseif (!$plan->complete) { //Если план не был как-то отмечен
                        --$foundList->undone;
                        $foundList->save();

                        ++$newList->undone;
                        $newList->save();
                    }

                    $plan->list_id = $newList->id;
                } elseif (isset($complete)) { //Если лист остается прежним
                    $complete = (bool)$complete;

                    if (!$plan->complete && $complete) {
                        --$foundList->undone;
                        $foundList->save();
                    } elseif ($plan->complete && !$complete) {
                        ++$foundList->undone;
                        $foundList->save();
                    }
                }

                if (isset($complete)) {
                    $plan->complete = $complete;
                }

                if (isset($request['title'])) {
                    $plan->title = $request['title'];
                }

                if (isset($request['description'])) {
                    $plan->description = $request['description'];
                }

                if (isset($request['priority'])) {
                    $priority = $request['priority'];
                    Helpers::clamp($priority, 1, 5);
                    $plan->priority = $priority;
                }

                $plan->save();
            });

            return [
                'message' => "Plan hasn't been changed",
                'code' => 304
            ];
        } catch (\Throwable $e) {
            return [
                'message' => $plan->unsetRelation('getList'),
                'code' => 200
            ];
        }
    }

    public function plans(array $request, ToDoList $list)
    {
        $type = self::GET_ALL;
        if (isset($request['type'])) {
            $type = $request['type'];
            Helpers::clamp($type, self::GET_ALL, self::GET_INCOMPLETE_ONLY);
        }

        $offset = 0;
        if (isset($request['offset'])) {
            $offset = $request['offset'];
            if ($offset < 0) {
                $offset = 0;
            }
        }

        $count = 10;
        if (isset($request['count'])) {
            $count = $request['count'];
            Helpers::clamp($count, 1, 100, 1, 10);
        }

        $queryResult = $list->getPlans()->skip($offset)->take($count);

        if ($type == self::GET_COMPLETE_ONLY) {
            $queryResult->where('complete', '=', true);
        } elseif ($type == self::GET_INCOMPLETE_ONLY) {
            $queryResult->where('complete', '=', false);
        }

        return $queryResult->get();
    }
}
