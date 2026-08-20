<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Companies</h2>
            <a href="{{ route('companies.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                + New Company
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <form method="GET" class="mb-4 flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search companies..."
                       class="border rounded px-3 py-2 flex-1">
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded">Search</button>
                <a href="{{ route('companies.index') }}" class="px-4 py-2 text-gray-600">Reset</a>
            </form>

            <div class="bg-white shadow rounded overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Industry</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Website</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($companies as $company)
                        <tr>
                            <td class="px-4 py-3">{{ $company->name }}</td>
                            <td class="px-4 py-3">{{ $company->industry ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $company->phone ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $company->website ?? '—' }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('companies.edit', $company) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('companies.destroy', $company) }}" class="inline"
                                      onsubmit="return confirm('Delete this company?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">No companies found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $companies->links() }}
            </div>

        </div>
    </div>
</x-app-layout>