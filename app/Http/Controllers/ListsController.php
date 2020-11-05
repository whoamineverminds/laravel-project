<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use Illuminate\Http\Request;
use App\Helpers\Helpers;

class ListsController extends Controller
{
    const GET_ALL = 0;
    const GET_DONE_ONLY = 1;
    const GET_UNDONE_ONLY = 2;

    const SORT_BY_CREATION = 0;
    const SORT_BY_CHANGING = 1;
    const SORT_BY_TITLE = 2;

    public function createList(Request $request)
    {
        Lists::create(['title' => Helpers::getRequiredHttpParam($request, 'title')]);

        return response()->json(null,201);
    }

    public function deleteList(Lists $list, Request $request)
    {
        $list->delete();

        return response()->json(null, 200);
    }

    public function changeList(Lists $list, Request $request)
    {
        $list->update(['title' => Helpers::getRequiredHttpParam($request, 'title')]);

        return response()->json(null, 200);
    }

    public function sortLists(Request $request)
    {
        $type = (int)$request->get('type');
        Helpers::clamp($type, self::SORT_BY_CREATION, self::SORT_BY_TITLE);

        $offset = (int)$request->get('offset');
        if ($offset < 0) {
            $offset = 0;
        }

        $count = (int)$request->get('count', 10);
        Helpers::clamp($count, 1, 100, 1, 10);

        $queryResult = Lists::skip($offset)->take($count);

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

        return response()->json($queryResult->get(), 200);
    }

    public function filterLists(Request $request)
    {
        $arg = Helpers::getRequiredHttpParam($request,'arg');

        $offset = (int)$request->get('offset');
        if ($offset < 0) {
            $offset = 0;
        }

        $count = (int)$request->get('count', 10);
        Helpers::clamp($count, 1, 100, 1, 10);

        return response()->json(
            Lists::skip($offset)
                ->take($count)
                ->where('date_create', '=', $arg)
                ->orWhere('date_change', '=', $arg)
                ->orWhere('title', '=', $arg)
                ->get(),
            200
        );
    }

    public function getLists(Request $request)
    {
        $type = (int)$request->get('type');
        Helpers::clamp($type, self::GET_ALL, self::GET_UNDONE_ONLY);

        $offset = (int)$request->get('offset');
        if ($offset < 0) {
            $offset = 0;
        }

        $count = (int)$request->get('count', 10);
        Helpers::clamp($count, 1, 100, 1, 10);

        $queryResult = Lists::skip($offset)->take($count);

        if ($type == self::GET_DONE_ONLY) {
            $queryResult->where('undone', '=', 0);
        } elseif ($type == self::GET_UNDONE_ONLY) {
            $queryResult->where('undone', '>', 0);
        }

        return response()->json($queryResult->get(), 200);
    }

    public function getPlans(Lists $list, Request $request)
    {
        $type = (int)$request->get('type');
        Helpers::clamp($type, self::GET_ALL, self::GET_UNDONE_ONLY);

        $offset = (int)$request->get('offset');
        if ($offset < 0) {
            $offset = 0;
        }

        $count = (int)$request->get('count', 10);
        Helpers::clamp($count, 1, 100, 1, 10);

        $plans = $list->getPlans()->skip($offset)->take($count);

        if ($type == self::GET_DONE_ONLY) {
            $plans->where('complete', '=', true);
        } elseif ($type == self::GET_UNDONE_ONLY) {
            $plans->where('complete', '=', false);
        }

        return response()->json($plans, 200);
    }
}
