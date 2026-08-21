<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $byStatus = Lead::query()->forAgent($user)
            ->select('status', DB::raw('count(*) as count'), DB::raw('sum(value) as total_value'))
            ->groupBy('status')
            ->get()
            ->map(function ($row) {
                $row->status_label = Lead::STATUSES[$row->status]['label'] ?? $row->status;
                return $row;
            });

        $byAgent = null;
        if (in_array($user->role, ['admin', 'manager'])) {
            $byAgent = User::where('role', 'agent')->withCount([
                'assignedLeads as total_leads',
                'assignedLeads as won_leads' => fn($q) => $q->where('status', 'won'),
                'assignedLeads as active_leads' => fn($q) => $q->whereNotIn('status', ['won', 'lost']),
            ])->orderByDesc('total_leads')->get();
        }

        return view('reports.index', compact('byStatus', 'byAgent'));
    }
}