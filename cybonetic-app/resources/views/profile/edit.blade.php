<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>
                            <p class="mt-1 text-sm text-gray-600">Update your account's profile information and email address.</p>
                        </header>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="name">Name</label>
                                <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div>
                                <label for="email">Email</label>
                                <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <!-- Avatar Upload -->
                            <div>
                                <label>Avatar</label>
                                <div class="mb-2">
                                    <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('default-avatar.png') }}"
                                         alt="Avatar" width="100" height="100" class="rounded-circle">
                                </div>
                                <input type="file" name="avatar" class="form-control" accept="image/*">
                                <small class="text-muted">Max 2MB, min 100x100px, JPG/PNG/WEBP</small>
                                @error('avatar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">SAVE</button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>