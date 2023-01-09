<?php

namespace App\Http\Controllers;

use App\Models\FeedData;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Vedmant\FeedReader\Facades\FeedReader;

class FeedController extends Controller
{
    public function index()
    {
        $feedData = FeedData::all();

        return view('feed.index', compact(
             'feedData'
        ));
    }

    public function feedReader()
    {
        $rss = simplexml_load_file('https://rss.nytimes.com/services/xml/rss/nyt/Technology.xml');
        // dd($rss);
        $items = $rss->channel->item;
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'link' => 'required',
            'guid' => 'required',
            'description' => 'required',
            'pub_date' => 'required|date_format',
            'categories' => 'required|array', // tbc - add json validation type?...
        ];

        $request->validate($rules);

        $feedData = new FeedData();
        $feedData->title = request('title');
        $feedData->link = request('link');
        $feedData->guid = request('guid');
        $feedData->description = request('description');
        $feedData->pub_date = request('pub_date');
        $feedData->categories = request('categories');

        // find better solution for the below
        try {
            $feedData->save();
        } catch (Exception $e) {}
    }
}
