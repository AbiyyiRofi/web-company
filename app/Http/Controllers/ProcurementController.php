<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use App\Models\ProcurementContent;
use App\Models\ProcurementDocument;
use Illuminate\Support\Facades\Storage;

class ProcurementController extends Controller
{
    public function index()
    {
        $content = ProcurementContent::singleton();
        $procurements = Procurement::with('documents')->latest()->get();

        return view('procurement.index', compact('content', 'procurements'));
    }

    public function download(ProcurementDocument $document)
    {
        return Storage::disk('public')->download($document->file_path, $document->title . '.' . $document->file_type);
    }
}
