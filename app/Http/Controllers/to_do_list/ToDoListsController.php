<?php

namespace App\Http\Controllers\to_do_list;

use App\Http\Controllers\Controller;
use App\Http\Requests\to_do_list\CreateListRequest;
use App\Http\Requests\to_do_list\FilterListsRequest;
use App\Http\Requests\to_do_list\GetRequest;
use App\Http\Requests\to_do_list\SortListsRequest;
use App\Models\to_do_list\ToDoList;
use App\Services\to_do_list\ListsService;

class ToDoListsController extends Controller
{
    private $listsService;

    public function __construct(ListsService $service)
    {
        $this->listsService = $service;
    }

    public function create(CreateListRequest $request)
    {
        return response()->json($this->listsService->create($request->validated()), 201);
    }

    public function delete(ToDoList $list)
    {
        return response()->json($this->listsService->delete($list), 200);
    }

    public function change(CreateListRequest $request, ToDoList $list)
    {
        return response()->json($this->listsService->change($request->validated(), $list), 200);
    }

    public function get(GetRequest $request)
    {
        $result = $this->listsService->lists($request->validated())->get();
        $result->map(function($result) {
            $result->count = $result->getPlans()->count();
        });
        return response()->json($result, 200);
    }

    public function sort(SortListsRequest $request)
    {
        return response()->json($this->listsService->sort($request->validated()), 200);
    }

    public function filter(FilterListsRequest $request)
    {
        return response()->json($this->listsService->filter($request->validated()), 200);
    }

    public function plans(ToDoList $list, GetRequest $request)
    {
        return response()->json($this->listsService->plans($request->validated(), $list), 200);
    }
}
