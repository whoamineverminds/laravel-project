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
