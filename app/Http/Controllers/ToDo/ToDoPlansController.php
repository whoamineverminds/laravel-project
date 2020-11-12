<?php

namespace App\Http\Controllers\ToDo;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToDo\GetRequest;
use App\Models\ToDo\ToDoList;
use App\Models\ToDo\ToDoPlan;
use App\Http\Requests\ToDo\CreatePlanRequest;
use App\Services\ToDo\ToDoPlansService;

class ToDoPlansController extends Controller
{
    private $plansService;

    public function __construct(ToDoPlansService $service)
    {
        $this->plansService = $service;
    }

    public function create(CreatePlanRequest $request, ToDoList $list)
    {
        \Gate::authorize('list-owner', $list);

        return self::response($this->plansService->create($request->validated(), $list));
    }

    public function delete(ToDoPlan $plan)
    {
        $this->authorize('actions', $plan);

        return self::response($this->plansService->delete($plan));
    }

    public function change(\Request $request, ToDoPlan $plan, ToDoList $newList = null)
    {
        $this->authorize('actions', $plan);
        if (isset($newList)) {
            \Gate::authorize('list-owner', $newList);
        }

        return self::response($this->plansService->change($request, $plan, $newList));
    }

    public function get(GetRequest $request, ToDoList $list)
    {
        \Gate::authorize('list-owner', $list);

        return self::response([
            'message' => $this->plansService->plans($request->validated(), $list),
            'code' => 200
        ]);
    }

    public function markComplete(ToDoPlan $plan)
    {
        $this->authorize('actions', $plan);

        return self::response($this->plansService->change(['complete' => true], $plan));
    }
}
