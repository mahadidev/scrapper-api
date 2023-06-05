<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ScrappedItemCollection;
use App\Models\ScrappedItems;
use App\Http\Requests\StoreScrappedItemsRequest;
use App\Http\Requests\UpdateScrappedItemsRequest;
use App\Http\Resources\V1\ApiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScrappedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ScrappedItemCollection(ScrappedItems::where(["user_ref" => Auth::user()->id])->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScrappedItemsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $type)
    {
        $orderBy = "id";
        if (isset($request->orderBy)) {
            $orderBy = $request->orderBy;
        }
        $orderDir = "asc";
        if (isset($request->orderDir)) {
            $orderDir = $request->orderDir;
        }
        $search_query_key = "id";
        $search_query_value = "%";
        if (isset($request->id)) {
            $search_query_key = "id";
            $search_query_value = $request->id;
        }
        if (isset($request->url)) {
            $search_query_key = "url";
            $search_query_value = $request->url;
        }
        if (isset($request->value)) {
            $search_query_key = "value";
            $search_query_value = $request->value;
        }

        return new ScrappedItemCollection(ScrappedItems::where(["user_ref" => Auth::user()->id])->where(["type" => $type])->where($search_query_key, "LIKE", "%{$search_query_value}%")->orderBy($orderBy, $orderDir)->paginate(20));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ScrappedItems $scrappedItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScrappedItemsRequest $request, ScrappedItems $scrappedItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScrappedItems $scrappedItems)
    {
        //
    }
}