<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\HubungiKamiContent;

class BranchController extends Controller
{
    public function index()
    {
        $content = HubungiKamiContent::singleton();
        $branches = Branch::orderByDesc('is_head_office')->orderBy('name')->get();

        return view('branches.index', compact('content', 'branches'));
    }

    // dipanggil AJAX dari Leaflet di view publik
    public function json()
    {
        return response()->json(Branch::all([
            'id', 'name', 'address', 'phone', 'whatsapp',
            'latitude', 'longitude', 'operational_hours', 'is_head_office',
        ])->map(function ($b) {
            $b->whatsapp_link = $b->whatsapp_link;
            return $b;
        }));
    }
}
