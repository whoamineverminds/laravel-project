<?php

namespace App\Http\Controllers\to_do_list;

use App\Http\Controllers\Controller;
use App\Http\Requests\to_do_list\GetRequest;
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
        self::response($this->plansService->create($request->validated(), $list));
    }

    public function delete(ToDoPlan $plan)
    {
        self::response($this->plansService->delete($plan->validated()));
    }

    public function change(Request $request, ToDoPlan $plan, ToDoList $newList = null)
    {
        self::response($this->plansService->change($request, $plan, $newList));
    }

    public function get(GetRequest $request, ToDoList $list)
    {
        self::response([
            'message' => $this->plansService->plans($request->validated(), $list)->get(),
            'code' => 200
        ]);
    }

    public function markComplete(ToDoPlan $plan)
    {
        self::response($this->plansService->change(['complete' => true], $plan, null));
    }
}
