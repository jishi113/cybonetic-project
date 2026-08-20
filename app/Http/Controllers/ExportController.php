<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function leads(Request $request): StreamedResponse
    {
        $leads = Lead::with(['assignedTo', 'company'])
            ->forAgent(auth()->user())
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->get();

        $filename = 'leads_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ];

        $callback = function () use ($leads) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'ID', 'Title', 'Contact Name', 'Contact Email', 'Contact Phone',
                'Company', 'Status', 'Value (INR)', 'Source', 'Assigned To',
                'Expected Close', 'Created At',
            ]);

            foreach ($leads as $lead) {
                fputcsv($handle, [
                    $lead->id,
                    $lead->title,
                    $lead->contact_name,
                    $lead->contact_email,
                    $lead->contact_phone,
                    $lead->company?->name ?? '',
                    $lead->status_badge,
                    number_format($lead->value, 2),
                    $lead->source,
                    $lead->assignedTo?->name ?? '',
                    $lead->expected_close?->format('d-m-Y') ?? '',
                    $lead->created_at->format('d-m-Y H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}