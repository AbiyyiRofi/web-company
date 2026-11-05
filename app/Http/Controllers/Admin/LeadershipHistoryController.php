<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeadershipHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeadershipHistoryController extends Controller
{
    public function index()
    {
        $leadershipHistories = LeadershipHistory::orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();
        return view('admin.history.leadership', compact('leadershipHistories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'period' => 'required|string|max:100',
            'position' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:3072',
            'sort_order' => 'nullable|integer',
            'duration' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('leadership_histories', 'public');
        }

        if (empty($validated['sort_order'])) {
            $validated['sort_order'] = (LeadershipHistory::max('sort_order') ?? 0) + 1;
        }

        if (empty($validated['duration'])) {
            $validated['duration'] = 6000; // 6 seconds default
        }

        LeadershipHistory::create($validated);

        return back()->with('success', 'Data Sejarah Kepemimpinan berhasil ditambahkan.');
    }

    public function update(Request $request, LeadershipHistory $leadershipHistory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'period' => 'required|string|max:100',
            'position' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:3072',
            'sort_order' => 'nullable|integer',
            'duration' => 'nullable|integer',
        ]);

        if ($request->hasFile('photo')) {
            if ($leadershipHistory->photo) {
                Storage::disk('public')->delete($leadershipHistory->photo);
            }
            $validated['photo'] = $request->file('photo')->store('leadership_histories', 'public');
        }

        if (empty($validated['duration'])) {
            $validated['duration'] = 6000;
        }

        $leadershipHistory->update($validated);

        return back()->with('success', 'Data Sejarah Kepemimpinan berhasil diperbarui.');
    }

    public function destroy(LeadershipHistory $leadershipHistory)
    {
        if ($leadershipHistory->photo) {
            Storage::disk('public')->delete($leadershipHistory->photo);
        }
        $leadershipHistory->delete();

        return back()->with('success', 'Data Sejarah Kepemimpinan berhasil dihapus.');
    }
}
