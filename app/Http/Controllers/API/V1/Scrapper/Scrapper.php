<?php

namespace App\Http\Controllers\API\V1\Scrapper;

use App\Models\ScrappedItems;
use App\Models\ScrapperKey;

class Scrapper
{
    public $type;
    public $url;

    public $user;

    public function __construct($type, $url, $user)
    {
        $this->type = $type;
        $this->url = $url;
        $this->user = $user;
    }

    public function Scrape()
    {
        if ($this->type === "email") {
            return $this->EmailScrapper($this->url);
        }
        if ($this->type === "phone") {
            return $this->PhoneScrapper($this->url);
        }
    }

    public function EmailScrapper($url)
    {
        ini_set('memory_limit', '-1');
        // get all content of the url
        $url_content = @file_get_contents($url);
        // scrapped data
        $collected_data = [];
        // if get the content
        if ($url_content) {
            // make lower case content
            $url_content = strtolower($url_content);
            // email scrapper key
            $keys = ScrapperKey::where(["type" => "email"])->get();
            // run loop trough key
            foreach ($keys as $key) {
                // make key lowercase
                $key->key = strtolower($key->key);
                // key range
                if ($key->range < 100) {
                    $key->range = 100;
                }

                do {
                    // find the position of the key in the content
                    $targetPosIndex = strpos($url_content, $key->key);
                    $targetContent = substr($url_content, $targetPosIndex, $key->range);
                    $restContent = substr($url_content, $targetPosIndex + $key->range, strlen($url_content));

                    // set the rest 
                    $url_content = $restContent;

                    // if target content not empty
                    if (!empty($targetContent)) {
                        $res = preg_match_all(
                            "/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i",
                            $targetContent,
                            $matches
                        );

                        if ($res) {
                            foreach (array_unique($matches[0]) as $scrappedData) {
                                if (strlen($scrappedData) > 9) {
                                    // create scrapped item if not already present
                                    $scrapped_item = ScrappedItems::firstOrCreate([
                                        "url" => $url,
                                        "value" => $scrappedData,
                                        "type" => $this->type,
                                        "user_ref" => $this->user->id,
                                    ]);
                                    // return find item if not already present
                                    if (!$scrapped_item->wasRecentlyCreated) {
                                        $scrapped_item = ScrappedItems::where([
                                            "url" => $url,
                                            "value" => $scrappedData,
                                            "type" => $this->type,
                                            "user_ref" => $this->user->id,
                                        ])->first();
                                    }

                                    return $scrapped_item;
                                }
                            }
                        }
                    }
                } while ($targetPosIndex > 0);
            }
        }

        return $collected_data;
    }

    public function PhoneScrapper($url)
    {
        ini_set('memory_limit', '-1');
        // get all content of the url
        $url_content = @file_get_contents($url);
        // scrapped data
        $collected_data = null;
        // if get the content
        if ($url_content) {
            // make lower case content
            $url_content = strtolower($url_content);
            // email scrapper key
            $keys = ScrapperKey::where(["type" => "phone"])->get();
            // run loop trough key
            foreach ($keys as $key) {
                // make key lowercase
                $key->key = strtolower($key->key);
                // key range
                if ($key->range < 100) {
                    $key->range = 100;
                }

                do {
                    // find the position of the key in the content
                    $targetPosIndex = strpos($url_content, $key->key);
                    $targetContent = substr($url_content, $targetPosIndex, $key->range);
                    $restContent = substr($url_content, $targetPosIndex + $key->range, strlen($url_content));

                    // set the rest 
                    $url_content = $restContent;

                    // if target content not empty
                    if (!empty($targetContent)) {
                        $res = preg_match_all(
                            "!\d+!",
                            $targetContent,
                            $matches
                        );

                        if ($res) {
                            foreach (array_unique($matches[0]) as $scrappedData) {
                                if (strlen($scrappedData) > 9) {
                                    // create scrapped item if not already present
                                    $scrapped_item = ScrappedItems::firstOrCreate([
                                        "url" => $url,
                                        "value" => $scrappedData,
                                        "type" => $this->type,
                                        "user_ref" => $this->user->id,
                                    ]);
                                    // return find item if not already present
                                    if (!$scrapped_item->wasRecentlyCreated) {
                                        $scrapped_item = ScrappedItems::where([
                                            "url" => $url,
                                            "value" => $scrappedData,
                                            "type" => $this->type,
                                            "user_ref" => $this->user->id,
                                        ])->first();
                                    }

                                    return $scrapped_item;
                                }
                            }
                        }
                    }
                } while ($targetPosIndex > 0);
            }
        }

        return $collected_data;
    }

}