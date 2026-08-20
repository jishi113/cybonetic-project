<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Leads</h2>
            <div class="space-x-2">
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('leads.trashed') }}" class="text-sm text-gray-600 hover:underline">Trashed</a>
                @endif
                <a href="{{ route('leads.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    + New Lead
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <form method="GET" class="mb-4 flex flex-wrap gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search leads..."
                       class="border rounded px-3 py-2 flex-1 min-w-[200px]">

                <select name="status" class="border rounded px-3 py-2">
                    <option value="">All Statuses</option>
                    @foreach(\App\Models\Lead::STATUSES as $key => $val)
                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                            {{ $val['label'] }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded">Filter</button>
                <a href="{{ route('leads.index') }}" class="px-4 py-2 text-gray-600">Reset</a>
            </form>

            <div class="bg-white shadow rounded overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned To</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($leads as $lead)
                        <tr>
                            <td class="px-4 py-3">{{ $lead->title }}</td>
                            <td class="px-4 py-3">{{ $lead->contact_name }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded bg-gray-100">{{ $lead->status_badge }}</span>
                            </td>
                            <td class="px-4 py-3">{{ $lead->assignedTo->name ?? '—' }}</td>
                            <td class="px-4 py-3">₹{{ number_format($lead->value, 2) }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('leads.show', $lead) }}" class="text-indigo-600 hover:underline">View</a>
                                <a href="{{ route('leads.edit', $lead) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('leads.destroy', $lead) }}" class="inline"
                                      onsubmit="return confirm('Delete this lead?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                No leads found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $leads->links() }}
            </div>

        </div>
    </div>
</x-app-layout>