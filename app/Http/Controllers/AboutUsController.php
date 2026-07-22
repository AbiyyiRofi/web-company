<?php

namespace App\Http\Controllers;

use App\Models\AboutUsContent;
use App\Models\Director;

class AboutUsController extends Controller
{
    public function index()
    {
        $content = AboutUsContent::singleton();
        $direksi = Director::direksi()->orderBy('sort_order')->get();
        $pemilikModal = Director::pemilikModal()->orderBy('sort_order')->get();

        return view('about-us.index', compact('content', 'direksi', 'pemilikModal'));
    }
}
