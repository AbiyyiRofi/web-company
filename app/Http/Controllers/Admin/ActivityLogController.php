<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('action')) {
            $query->where('action', strtolower($request->action));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('user_email', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(20)->withQueryString();

        $modules = ActivityLog::select('module')->distinct()->pluck('module');
        $users = User::orderBy('name')->get(['id', 'name', 'role']);

        return view('admin.activity_logs.index', compact('logs', 'modules', 'users'));
    }

    /**
     * API endpoint for live Alpine.js polling
     */
    public function fetchLogs(Request $request)
    {
        $lastId = $request->query('last_id', 0);

        $newLogs = ActivityLog::with('user')
            ->where('id', '>', $lastId)
            ->latest()
            ->take(15)
            ->get();

        $formattedLogs = $newLogs->map(function ($log) {
            return [
                'id'          => $log->id,
                'user_name'   => $log->user_name ?? ($log->user ? $log->user->name : 'System'),
                'user_email'  => $log->user_email ?? ($log->user ? $log->user->email : '-'),
                'action'      => $log->action,
                'module'      => $log->module,
                'description' => $log->description,
                'ip_address'  => $log->ip_address ?? '-',
                'created_at'  => $log->created_at->translatedFormat('d M Y H:i:s'),
                'time_ago'    => $log->created_at->diffForHumans(),
                'properties'  => $log->properties,
            ];
        });

        return response()->json([
            'new_count' => $newLogs->count(),
            'latest_id' => ActivityLog::max('id') ?? 0,
            'logs'      => $formattedLogs,
        ]);
    }
}
