<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ $lead->title }}</h2>
            <a href="{{ route('leads.edit', $lead) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Edit
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded p-6 space-y-4">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Contact Name</div>
                        <div class="font-medium">{{ $lead->contact_name }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Contact Email</div>
                        <div class="font-medium">{{ $lead->contact_email ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Contact Phone</div>
                        <div class="font-medium">{{ $lead->contact_phone ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Company</div>
                        <div class="font-medium">{{ $lead->company->name ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Status</div>
                        <div class="font-medium">
                            <span class="px-2 py-1 text-xs rounded bg-gray-100">{{ $lead->status_badge }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Source</div>
                        <div class="font-medium">{{ ucfirst(str_replace('_',' ',$lead->source)) }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Assigned To</div>
                        <div class="font-medium">{{ $lead->assignedTo->name ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Value</div>
                        <div class="font-medium">₹{{ number_format($lead->value, 2) }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Expected Close</div>
                        <div class="font-medium">{{ $lead->expected_close?->format('d M Y') ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Created By</div>
                        <div class="font-medium">{{ $lead->createdBy->name ?? '—' }}</div>
                    </div>
                </div>

                @if($lead->notes)
                <div>
                    <div class="text-sm text-gray-500">Notes</div>
                    <div class="mt-1">{{ $lead->notes }}</div>
                </div>
                @endif

                <div class="pt-4 border-t">
                    <a href="{{ route('leads.index') }}" class="text-gray-600 hover:underline">&larr; Back to Leads</a>
                </div>
            </div>

            {{-- Activities --}}
            <div class="bg-white shadow rounded p-6 mt-4">
                <h3 class="font-semibold text-gray-800 mb-3">Activity History</h3>
                @forelse($lead->activities as $activity)
                    <div class="border-b py-2">
                        <div class="text-sm font-medium">{{ ucfirst($activity->type) }} — {{ $activity->subject }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $activity->user->name ?? 'Unknown' }} &middot; {{ $activity->occurred_at->format('d M Y, h:i A') }}
                        </div>
                        @if($activity->description)
                            <div class="text-sm text-gray-700 mt-1">{{ $activity->description }}</div>
                        @endif
                    </div>
                @empty
                    <div class="text-gray-500 text-sm">No activities logged yet.</div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>