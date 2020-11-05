<?php

namespace App\Http\Controllers;

use App\Exceptions\IncorrectValueException;
use App\Models\Lists;
use App\Models\Plans;
use Illuminate\Http\Request;
use App\Helpers\Helpers;

class PlansController extends Controller
{
    public function createPlan(Lists $list, Request $request)
    {
        $title = Helpers::getRequiredHttpParam($request,'title');

        $description = $request->get('description');

        $priority = (int)Helpers::getRequiredHttpParam($request,'priority');
        Helpers::clamp($priority, 1, 5);

        $list->getPlans->create([
            'list_id' => $list->id,
            'title' => $title,
            'description' => $description,
            'priority' => $priority,
            'complete' => false
        ]);


        $list->increment('undone');

        return response()->json(null, 201);
    }

    public function deletePlan(Plans $plan)
    {
        if (!$plan->complete)
            $plan->getList->decrement('undone');

        $plan->delete();

        return response()->json(null, 200);
    }

    public function changePlan(Plans $plan, Request $request, Lists $newList = null)
    {
        $foundList = $plan->getList;

        $complete = $request->get('complete');

        //Если лист план привязывается к новому листу
        if (isset($newList))
        {
            if (isset($complete)) {
                $complete = (bool)$complete;

                if (!$plan->complete) {
                    $foundList->decrement('undone');
                }

                if (!$complete) {
                    $newList->increment('undone');
                }
            } elseif (!$plan->complete) { //Если план не был как-то отмечен
                $foundList->decrement('undone');

                $newList->increment('undone');
            }

            $plan->list_id = $newList->id;
        } elseif (isset($complete)) { //Если лист остается прежним
            $complete = (bool)$complete;

            if (!$plan->complete && $complete) {
                $foundList->decrement('undone');
            } elseif ($plan->complete && !$complete) {
                $foundList->increment('undone');
            }
        }

        if (isset($complete)) {
            $plan->complete = $complete;
        }

        $title = $request->get('title');
        if (isset($title)) {
            $plan->title = $title;
        }

        $description = $request->get('description');
        if (isset($description)) {
            $plan->description = $description;
        }

        $priority = (int)$request->get('priority');
        if (isset($priority)) {
            Helpers::clamp($priority, 1, 5);
            $plan->priority = $priority;
        }

        $plan->save();

        return response()->json(null, 200);
    }

    public function markPlanComplete(Plans $plan)
    {
        if (!$plan->complete) {
            $plan->getList->decrement('undone');

            $plan->update(['complete' => true]);
        }

        return response()->json(null, 200);
    }
}