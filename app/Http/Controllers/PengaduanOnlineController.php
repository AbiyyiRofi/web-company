<?php

namespace App\Http\Controllers;

use App\Models\PengaduanOnlineContent;

class PengaduanOnlineController extends Controller
{
    public function index()
    {
        $content = PengaduanOnlineContent::singleton();
        return view('pengaduan-online.index', compact('content'));
    }
}
