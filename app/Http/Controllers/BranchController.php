<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\HubungiKamiContent;

class BranchController extends Controller
{
    public function index()
    {
        $content = HubungiKamiContent::singleton();
        $branches = Branch::cabang()->orderByDesc('is_head_office')->orderBy('name')->get();
        $ipas = Branch::ipa()->orderBy('name')->get();

        return view('branches.index', compact('content', 'branches', 'ipas'));
    }

    public function json()
    {
        return response()->json(Branch::all([
            'id', 'name', 'type', 'address', 'phone', 'whatsapp',
            'latitude', 'longitude', 'operational_hours', 'is_head_office',
            'kapasitas_terpasang_text', 'kapasitas_produksi', 'idle_capacity',
        ])->map(function ($b) {
            $b->whatsapp_link = $b->whatsapp_link;
            return $b;
        }));
    }
}