<?php

namespace App\Http\Controllers;

use App\Models\AboutUsContent;
use App\Models\Director;

class AboutUsController extends Controller
{
    public function index()
    {
        $content = AboutUsContent::singleton();
        $historyItems = \App\Models\HistoryItem::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        $leadershipHistories = \App\Models\LeadershipHistory::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        $direksi = Director::direksi()->orderBy('sort_order')->get();
        $pemilikModal = Director::pemilikModal()->orderBy('sort_order')->get();

        return view('about-us.index', compact('content', 'historyItems', 'leadershipHistories', 'direksi', 'pemilikModal'));
    }
    public function historyJson()
    {
        return response()->json(
            \App\Models\HistoryItem::orderBy('sort_order')->orderBy('id')->get(['id', 'year', 'title', 'content'])
        );
    }
}









































