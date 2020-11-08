<?php

namespace App\Services\to_do_list;

use App\Helpers\Helpers;
use App\Models\to_do_list\ToDoList;
use App\Models\to_do_list\ToDoPlan;

class PlansService
{
    const GET_ALL = 0;
    const GET_COMPLETE_ONLY = 1;
    const GET_INCOMPLETE_ONLY = 2;

    public function create($request, ToDoList $list)
    {
        return [
            'message' => $list->getPlans()->create(array_merge(['list_id' => $list->id], $request)),
            'code' => 201
        ];
    }

    public function delete(ToDoPlan $plan)
    {
        $plan->delete();

        return [
            'message' => null,
            'code' => 200
        ];
    }

    public function change($request, ToDoPlan $plan, ToDoList $newList)
    {
        $foundList = $plan->getList;

        $complete = null;
        if (isset($request['complete'])) {
            $complete = $request['complete'];
        }

        //Если лист план привязывается к новому листу
        if (isset($newList))
        {
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

        return [
            'message' => $plan,
            'code' => 200
        ];
    }

    public function plans($request, ToDoList $list)
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

        $queryResult = $list->getPlans->skip($offset)->take($count);

        if ($type == self::GET_COMPLETE_ONLY) {
            $queryResult->where('complete', '=', true);
        } elseif ($type == self::GET_INCOMPLETE_ONLY) {
            $queryResult->where('complete', '=', false);
        }

        return $queryResult;
    }
}
