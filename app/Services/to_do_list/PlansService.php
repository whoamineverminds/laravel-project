<?php

namespace App\Services\to_do_list;

use App\Helpers\Helpers;
use App\Models\to_do_list\ToDoList;
use App\Models\to_do_list\ToDoPlan;

class PlansService
{
    public function create($request, ToDoList $list)
    {
        $result = array_merge(['list_id' => $list->id], $request);
        $list->getPlans()->create($result);
        return $result;
    }

    public function delete(ToDoPlan $plan)
    {
        $plan->delete();
        return null;
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

        return $plan->save();
    }
}
