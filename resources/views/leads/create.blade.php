<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">New Lead</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
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

                <form method="POST" action="{{ route('leads.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="mt-1 block w-full border rounded px-3 py-2">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Name *</label>
                            <input type="text" name="contact_name" value="{{ old('contact_name') }}"
                                   class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Email</label>
                            <input type="email" name="contact_email" value="{{ old('contact_email') }}"
                                   class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Phone</label>
                            <input type="text" name="contact_phone" value="{{ old('contact_phone') }}"
                                   class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Company</label>
                            <select name="company_id" class="mt-1 block w-full border rounded px-3 py-2">
                                <option value="">— None —</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Source *</label>
                            <select name="source" class="mt-1 block w-full border rounded px-3 py-2">
                                @foreach(['website','referral','cold_call','social','event','other'] as $src)
                                    <option value="{{ $src }}" {{ old('source') === $src ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_',' ',$src)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status *</label>
                            <select name="status" class="mt-1 block w-full border rounded px-3 py-2">
                                @foreach(\App\Models\Lead::STATUSES as $key => $val)
                                    <option value="{{ $key }}" {{ old('status', 'new') === $key ? 'selected' : '' }}>
                                        {{ $val['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    @if(auth()->user()->role !== 'agent')
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Assign To</label>
                        <select name="assigned_to" class="mt-1 block w-full border rounded px-3 py-2">
                            <option value="">— Unassigned —</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" {{ old('assigned_to') == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Value (₹)</label>
                            <input type="number" step="0.01" name="value" value="{{ old('value', 0) }}"
                                   class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Expected Close</label>
                            <input type="date" name="expected_close" value="{{ old('expected_close') }}"
                                   class="mt-1 block w-full border rounded px-3 py-2">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" rows="3" class="mt-1 block w-full border rounded px-3 py-2">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('leads.index') }}" class="px-4 py-2 text-gray-600">Cancel</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            Create Lead
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>