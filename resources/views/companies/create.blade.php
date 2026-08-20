<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">New Company</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">

                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('companies.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="mt-1 block w-full border rounded px-3 py-2">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Industry</label>
                            <input type="text" name="industry" value="{{ old('industry') }}"
                                   class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Website</label>
                        <input type="url" name="website" value="{{ old('website') }}" placeholder="https://example.com"
                               class="mt-1 block w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <textarea name="address" rows="3" class="mt-1 block w-full border rounded px-3 py-2">{{ old('address') }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('companies.index') }}" class="px-4 py-2 text-gray-600">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Create Company
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>