<?php

namespace App\Http\Controllers;

use App\Models\KarirContent;
use App\Models\KarirPoster;

class KarirController extends Controller
{
    public function index()
    {
        $content = KarirContent::singleton();
        $poster = KarirPoster::active()->latest()->first();

        return view('karir.index', compact('content', 'poster'));
    }
}