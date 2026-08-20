<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Trashed Leads</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned To</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deleted At</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($leads as $lead)
                        <tr>
                            <td class="px-4 py-3">{{ $lead->title }}</td>
                            <td class="px-4 py-3">{{ $lead->contact_name }}</td>
                            <td class="px-4 py-3">{{ $lead->assignedTo->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $lead->deleted_at?->format('d M Y, h:i A') }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('leads.restore', $lead->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline">Restore</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">
                                No trashed leads.
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