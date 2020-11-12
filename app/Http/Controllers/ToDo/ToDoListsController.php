<?php

namespace App\Http\Controllers\ToDo;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToDo\CreateListRequest;
use App\Http\Requests\ToDo\FilterListsRequest;
use App\Http\Requests\ToDo\GetRequest;
use App\Http\Requests\ToDo\SortListsRequest;
use App\Models\ToDo\ToDoList;
use App\Services\ToDo\ToDoListsService;

class ToDoListsController extends Controller
{
    private $listsService;

    public function __construct(ToDoListsService $service)
    {
        $this->listsService = $service;
    }

    public function create(CreateListRequest $request)
    {
        $this->authorize('create', ToDoList::class);

        return self::response($this->listsService->create($request->validated()));
    }

    public function delete(ToDoList $list)
    {
        $this->authorize('actions', $list);

        return self::response($this->listsService->delete($list));
    }

    public function change(CreateListRequest $request, ToDoList $list)
    {
        $this->authorize('actions', $list);

        return self::response($this->listsService->change($request->validated(), $list));
    }

    public function get(GetRequest $request)
    {
        $result = $this->listsService->lists($request->validated())->get();
        $result->map(function($result) {
            $result->count = $result->getPlans()->count();
        });
        return self::response(['message' => $result, 'code' => 200]);
    }

    public function sort(SortListsRequest $request)
    {
        return self::response($this->listsService->sort($request->validated()));
    }

    public function filter(FilterListsRequest $request)
    {
        return self::response($this->listsService->filter($request->validated()));
    }
}
