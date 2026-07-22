<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\PageHeader;
use Illuminate\Support\Facades\Storage;

class PublicationController extends Controller
{
    public function index()
    {
        $header = PageHeader::get('publikasi');
        $dokumenPublik = Document::dokumenPublik()->latest()->paginate(10, ['*'], 'dokumen_page');
        $companyProfiles = Document::companyProfile()->latest()->get();

        return view('publications.index', compact('header', 'dokumenPublik', 'companyProfiles'));
    }

    public function download(Document $document)
    {
        $document->increment('download_count');
        return Storage::disk('public')->download($document->file_path, $document->title . '.' . $document->file_type);
    }
}
