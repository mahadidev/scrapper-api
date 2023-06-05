<?php

namespace App\Http\Controllers\API\V1\Scrapper;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ScrappedItemResource;
use Illuminate\Http\Request;
use App\Http\Requests\StoreScrappedItemsRequest;
use App\Http\Resources\V1\ApiResource;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Auth;

class ScrapperController extends Controller
{
    public $scrapper;

    public function scrape(StoreScrappedItemsRequest $request)
    {
        // get user 
        $user = Auth::user();
        $subscription = Subscribe::where(["id" => $user->subscribe_ref])->first();

        // init scrapper
        $type = $request->type;
        $url = $request->url;
        $this->scrapper = new Scrapper($type, $url, $user);

        // request validation
        if ($subscription->requests_available > 0) {
            // remove 1 request 
            $subscription->update(["requests_used" => $subscription->requests_used + 1, "requests_available" => $subscription->requests_available - 1]);

            $scrapped_data = $this->scrapper->Scrape();
            if ($scrapped_data) {
                $scrapped_data = new ScrappedItemResource($this->scrapper->Scrape());
            } else {
                $scrapped_data = null;
            }

            // scrape and return data
            return new ApiResource([
                "status" => 1,
                "message" => "Url has been scrapped successfully.",
                "data" => $scrapped_data,
            ]);


        } else {
            return new ApiResource([
                "status" => 0,
                "message" => "Request limit exceeded.",
                "data" => null,
            ]);
        }

    }
}