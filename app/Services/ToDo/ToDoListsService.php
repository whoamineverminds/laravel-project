<?php

namespace App\Services\ToDo;

use App\Helpers\Helpers;
use App\Models\ToDo\ToDoList;

class ToDoListsService
{
    const GET_ALL = 0;
    const GET_DONE_ONLY = 1;
    const GET_UNDONE_ONLY = 2;

    const SORT_BY_CREATION = 0;
    const SORT_BY_CHANGING = 1;
    const SORT_BY_TITLE = 2;

    public function create(array $request)
    {
        return [
            'message' => ToDoList::create(array_merge(
                $request,
                ['user_id' => auth()->user()->id]
            )),
            'code' => 201
        ];
    }

    public function delete(ToDoList $list)
    {
        $list->delete();

        return [
            'message' => null,
            'code' => 200
        ];
    }

    public function change(array $request, ToDoList $list)
    {
        return [
            'message' => $list->update($request),
            'code' => 200
        ];
    }

    public function lists(array $request)
    {
        $type = self::GET_ALL;
        if (isset($request['type'])) {
            $type = $request['type'];
            Helpers::clamp($type, self::GET_ALL, self::GET_UNDONE_ONLY);
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

        $queryResult = auth()->user()->getLists()
            ->skip($offset)
            ->take($count)
            ->where('user_id', '=', auth()->user()->id);

        if ($type == self::GET_DONE_ONLY) {
            $queryResult->where('undone', '=', 0);
        } elseif ($type == self::GET_UNDONE_ONLY) {
            $queryResult->where('undone', '>', 0);
        }

        return $queryResult;
    }

    public function sort(array $request)
    {
        $type = 0;
        if (isset($request['type'])) {
            $type = $request['type'];
            $request['type'] = self::GET_ALL;
        }
        Helpers::clamp($type, self::SORT_BY_CREATION, self::SORT_BY_TITLE);

        $queryResult = $this->lists($request);

        switch ($type) {
            case self::SORT_BY_CREATION:
                $queryResult->orderBy('date_create');
                break;
            case self::SORT_BY_CHANGING:
                $queryResult->orderBy('date_change');
                break;
            case self::SORT_BY_TITLE:
                $queryResult->orderBy('title');
                break;
        }

        return [
            'message' => $queryResult->get(),
            'code' => 200
        ];
    }

    public function filter(array $request)
    {
        $queryResult = $this->lists(array_merge($request, ['type' => self::GET_ALL]));

        if (isset($request['date'])) {
            $queryResult->where('date_create', '=', $request['date'])
                ->orWhere('date_change', '=', $request['date']);
        }
        if (isset($request['title'])) {
            $queryResult->orWhere('title', '=', $request['title']);
        }

        return [
            'message' => $queryResult->get(),
            'code' => 200
        ];
    }
}
