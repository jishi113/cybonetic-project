<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            {{-- KPI Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white shadow rounded p-4">
                    <div class="text-sm text-gray-500">Total Leads</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-white shadow rounded p-4 border-l-4 border-green-500">
                    <div class="text-sm text-gray-500">Won</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['won'] }}</div>
                    <div class="text-xs text-gray-400">Conversion: {{ $stats['conversion_rate'] }}%</div>
                </div>
                <div class="bg-white shadow rounded p-4 border-l-4 border-blue-500">
                    <div class="text-sm text-gray-500">Pipeline Value</div>
                    <div class="text-2xl font-bold text-gray-800">₹{{ number_format($stats['pipeline_value'], 0) }}</div>
                </div>
                <div class="bg-white shadow rounded p-4 border-l-4 border-orange-500">
                    <div class="text-sm text-gray-500">In Progress</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['in_progress'] }}</div>
                </div>
            </div>

            {{-- Pipeline Breakdown --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Pipeline Breakdown</h3>

                <div class="w-full h-6 bg-gray-100 rounded overflow-hidden flex">
                    @foreach(\App\Models\Lead::STATUSES as $key => $meta)
                        @php $count = $byStatus[$key]->count ?? 0; @endphp
                        @if($count > 0)
                            <div class="bg-{{ $meta['color'] }}-500 h-full"
                                 style="width: {{ $stats['total'] > 0 ? ($count / $stats['total'] * 100) : 0 }}%"
                                 title="{{ $meta['label'] }}: {{ $count }}">
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-4 mt-4">
                    @foreach(\App\Models\Lead::STATUSES as $key => $meta)
                        <span class="flex items-center text-sm text-gray-600">
                            <span class="w-3 h-3 rounded-full bg-{{ $meta['color'] }}-500 mr-2"></span>
                            {{ $meta['label'] }}: {{ $byStatus[$key]->count ?? 0 }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Closing This Week --}}
            @if($closingThisWeek->isNotEmpty())
            <div class="bg-white shadow rounded p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Closing This Week</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 uppercase">
                            <th class="py-2">Lead</th>
                            <th class="py-2">Company</th>
                            <th class="py-2">Value</th>
                            <th class="py-2">Close Date</th>
                            <th class="py-2">Agent</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($closingThisWeek as $lead)
                        <tr>
                            <td class="py-2"><a href="{{ route('leads.show', $lead) }}" class="text-indigo-600 hover:underline">{{ $lead->title }}</a></td>
                            <td class="py-2">{{ $lead->company?->name ?? '—' }}</td>
                            <td class="py-2">₹{{ number_format($lead->value, 0) }}</td>
                            <td class="py-2">{{ $lead->expected_close->format('d M') }}</td>
                            <td class="py-2">{{ $lead->assignedTo?->name ?? 'Unassigned' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Agent Performance (admin/manager only) --}}
            @if($agentStats)
            <div class="bg-white shadow rounded p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Agent Performance</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="text-left text-xs text-gray-500 uppercase">
                            <th class="py-2">Agent</th>
                            <th class="py-2">Total Leads</th>
                            <th class="py-2">Active</th>
                            <th class="py-2">Won</th>
                            <th class="py-2">Conversion</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($agentStats as $agent)
                        <tr>
                            <td class="py-2">{{ $agent->name }}</td>
                            <td class="py-2">{{ $agent->total_leads }}</td>
                            <td class="py-2">{{ $agent->active_leads }}</td>
                            <td class="py-2">{{ $agent->won_leads }}</td>
                            <td class="py-2">
                                @php $rate = $agent->total_leads > 0 ? round($agent->won_leads / $agent->total_leads * 100, 1) : 0; @endphp
                                <span class="{{ $rate >= 50 ? 'text-green-600' : 'text-gray-500' }}">{{ $rate }}%</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            {{-- Recent Leads --}}
            <div class="bg-white shadow rounded p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Recent Leads</h3>
                @forelse($recentLeads as $lead)
                    <div class="flex justify-between items-center py-2 border-b last:border-0">
                        <a href="{{ route('leads.show', $lead) }}" class="text-indigo-600 hover:underline">{{ $lead->title }}</a>
                        <span class="text-xs px-2 py-1 rounded bg-gray-100">{{ $lead->status_badge }}</span>
                    </div>
                @empty
                    <div class="text-gray-500 text-sm">No leads yet.</div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>