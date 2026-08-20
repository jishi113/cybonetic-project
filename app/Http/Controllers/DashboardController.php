<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $baseQuery = Lead::query()->forAgent($user);

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'won' => (clone $baseQuery)->where('status', 'won')->count(),
            'lost' => (clone $baseQuery)->where('status', 'lost')->count(),
            'in_progress' => (clone $baseQuery)->whereNotIn('status', ['won', 'lost'])->count(),
            'total_value' => (clone $baseQuery)->where('status', 'won')->sum('value'),
            'pipeline_value' => (clone $baseQuery)->whereNotIn('status', ['won', 'lost'])->sum('value'),
            'conversion_rate' => 0,
        ];

        if ($stats['total'] > 0) {
            $stats['conversion_rate'] = round(($stats['won'] / $stats['total']) * 100, 1);
        }

        $byStatus = (clone $baseQuery)
            ->select('status', DB::raw('count(*) as count'), DB::raw('sum(value) as total_value'))
            ->groupBy('status')
            ->get()
            ->keyBy('status');

        $closingThisWeek = (clone $baseQuery)
            ->whereNotIn('status', ['won', 'lost'])
            ->whereBetween('expected_close', [now()->startOfWeek(), now()->endOfWeek()])
            ->with('assignedTo', 'company')
            ->get();

        $recentLeads = (clone $baseQuery)->with(['assignedTo', 'company'])->latest()->take(10)->get();

        $agentStats = null;
        if (in_array($user->role, ['admin', 'manager'])) {
            $agentStats = User::where('role', 'agent')->withCount([
                'assignedLeads as total_leads',
                'assignedLeads as won_leads' => fn($q) => $q->where('status', 'won'),
                'assignedLeads as active_leads' => fn($q) => $q->whereNotIn('status', ['won', 'lost']),
            ])->orderByDesc('won_leads')->get();
        }

        return view('dashboard', compact(
            'stats', 'byStatus', 'recentLeads', 'closingThisWeek', 'agentStats'
        ));
    }
}