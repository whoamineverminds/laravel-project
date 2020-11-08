<?php

namespace App\Http\Controllers\to_do_list;

use App\Http\Controllers\Controller;
use App\Models\to_do_list\ToDoList;
use App\Models\to_do_list\ToDoPlan;
use Illuminate\Http\Request;
use App\Http\Requests\to_do_list\CreatePlanRequest;
use App\Services\to_do_list\PlansService;

class ToDoPlansController extends Controller
{
    private $plansService;

    public function __construct(PlansService $service)
    {
        $this->plansService = $service;
    }

    public function create(CreatePlanRequest $request, ToDoList $list)
    {
        return response()->json($this->plansService->create($request->validated(), $list), 201);
    }

    public function delete(ToDoPlan $plan)
    {
        return response()->json($this->plansService->delete($plan), 200);
    }

    public function change(Request $request, ToDoPlan $plan, ToDoList $newList = null)
    {
        return response()->json($this->plansService->change($request, $plan, $newList), 200);
    }

    public function markComplete(ToDoPlan $plan)
    {
        return response()->json($this->plansService->change(['complete' => true], $plan, null), 200);
    }
}
