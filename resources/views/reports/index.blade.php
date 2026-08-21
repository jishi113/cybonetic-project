<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Reports</h2>
            <a href="{{ route('leads.export') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Export CSV
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow rounded p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Leads by Status</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 uppercase">
                            <th class="py-2">Status</th>
                            <th class="py-2">Count</th>
                            <th class="py-2">Total Value</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($byStatus as $row)
                        <tr>
                            <td class="py-2">{{ $row->status_label }}</td>
                            <td class="py-2">{{ $row->count }}</td>
                            <td class="py-2">₹{{ number_format($row->total_value, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($byAgent)
            <div class="bg-white shadow rounded p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Leads by Agent</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 uppercase">
                            <th class="py-2">Agent</th>
                            <th class="py-2">Total</th>
                            <th class="py-2">Won</th>
                            <th class="py-2">Active</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($byAgent as $agent)
                        <tr>
                            <td class="py-2">{{ $agent->name }}</td>
                            <td class="py-2">{{ $agent->total_leads }}</td>
                            <td class="py-2">{{ $agent->won_leads }}</td>
                            <td class="py-2">{{ $agent->active_leads }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>