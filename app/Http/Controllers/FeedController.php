<?php

namespace App\Http\Controllers;

use App\Models\FeedData;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;
use App\Library\FeedReader\FeedReader;

class FeedController extends Controller
{
    public function index()
    {
        $feedData = FeedData::all();

        return view('feed.index', compact(
             'feedData'
        ));
    }

    /**
     * Using factory design pattern, read in RSS Feed URL as feed type could be RSS, Atom or other.
     * With scaling of application, the reading of RSS would likely become dynamic so want to handle different types.
     * RSS Feed is hardcoded for purposes of this exercise.
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function feedReader(): RedirectResponse
    {
        $rss = FeedReader::load('https://rss.nytimes.com/services/xml/rss/nyt/Technology.xml');

        if ($rss) {
            // factory design pattern - we do not know if feed is rss or atom so let the feed reader handle this logic
            $feedData = $rss->getContentAsArray();
            foreach ($feedData as $item) {
                $request = new Request([
                    'title' => $item['title'],
                    'link' => $item['link'],
                    'guid' => $item['guid'],
                    'description' => $item['description'],
                    'pub_date' => $item['pub_date'],
                    // 'categories' => $item['categories'],
                ]);

                // in current structure, validation is specifically for the chosen RSS feed. As application expands
                // would need to refactor and consider what is optional and what is not, date formatting, etc.
                // Could also create a trait class to handle similar fields we want validated if we were accepting feeds
                // from numerous sources.
                try {
                    Validator::make($request->all(), [
                        'title' => 'required',
                        'link' => 'required',
                        'guid' => 'required',
                        'description' => 'required',
                        'pubDate' => 'required',
                    ]);
                } catch (Exception $e) {
                    Log::error("Validation error: " . $e->getMessage());
                }

                // store
                FeedData::query()
                    ->updateOrCreate(
                        ['guid' => $request->input('guid')],
                        [
                            'title' => $request->input('title'),
                            'link' => $request->input('link'),
                            'description' => $request->input('description'),
                            'pub_date' => Carbon::parse($request->input('pubDate'))->format('Y-m-d H:i:s'),
                            'updated_at' => now()
                        ]
                    );
            }
            return response()->redirectTo(route('home'));
        }
    }

    /**
     * With time would scale out and make use of resource controller and more strictly adhere to SOLID principles
     * i.e. Singular use and use this method to store the data after validation, etc.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        // refactored
    }
}
