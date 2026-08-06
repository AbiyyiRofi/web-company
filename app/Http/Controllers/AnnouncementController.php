<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\PageHeader;

class AnnouncementController extends Controller
{
    public function index()
    {
        $header = PageHeader::get('pengumuman');
        $announcements = Announcement::active()->latest()->get();
        return view('announcements.index', compact('header', 'announcements'));
    }
}