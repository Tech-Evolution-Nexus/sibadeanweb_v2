<x-app-layout :title="$title">
    <div class="md:px-12 px-6 md:py-10 py-5">
        <div class="mb-10">
            <div class="text-sm">
                Dashboard / <a class="hover:underline" href="{{ route('users.index') }}">User</a> / {{ $title }}
            </div>
            <div class="flex">
                <h1 class="text-2xl font-bold">{{ $title }}</h1>
            </div>
        </div>

        <x-alert-status class="mb-4" :status="'success'" :message="session('success')" />
        <x-alert-status class="mb-4" :status="'error'" :message="session('error')" />

        <form action="{{ $action_form }}" method="POST" class="card">
            @csrf
            @method($method)

            <div class="grid md:grid-cols-2 grid-cols-1 gap-4">
                <h6 class="font-bold md:col-span-2 text-lg">Informasi User</h6>

                <!-- Nama -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input :value="old('name', $data->name)" type="text" class="block mt-1 w-full"
                        placeholder="Nama Lengkap" name="name" id="name" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-xs" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input :value="old('email', $data->email)" type="email" class="block mt-1 w-full"
                        placeholder="Email" name="email" id="email" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input type="password" class="block mt-1 w-full" placeholder="Password" name="password"
                        id="password" />
                    <small class="text-gray-500">Kosongkan jika tidak ingin mengubah password</small>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
                </div>

                <!-- Role -->
                <div>
                    <x-input-label for="role" :value="__('Role')" />
                    <select name="role" id="role" class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role', $data->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="petugas" {{ old('role', $data->role) == 'petugas' ? 'selected' : '' }}>Petugas
                        </option>
                        <option value="user" {{ old('role', $data->role) == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2 text-red-500 text-xs" />
                </div>

                <!-- Status -->
                <div>
                    <x-input-label for="status" :value="__('Status')" />
                    <select name="status" id="status" class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                        <option value="">Pilih Status</option>
                        <option value="aktif" {{ old('status', $data->status) == 'aktif' ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="nonaktif" {{ old('status', $data->status) == 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2 text-red-500 text-xs" />
                </div>

                <!-- Masa Jabatan -->
                <h6 class="font-bold mt-4 md:col-span-2 text-lg">Masa Jabatan</h6>

                <div>
                    <x-input-label for="masa_jabatan_mulai" :value="__('Mulai Jabatan')" />
                    <x-text-input :value="old('masa_jabatan_mulai', $data->masa_jabatan_mulai)" type="date"
                        class="block mt-1 w-full" name="masa_jabatan_mulai" id="masa_jabatan_mulai" required />
                    <x-input-error :messages="$errors->get('masa_jabatan_mulai')" class="mt-2 text-red-500 text-xs" />
                </div>

                <div>
                    <x-input-label for="masa_jabatan_selesai" :value="__('Selesai Jabatan')" />
                    <x-text-input :value="old('masa_jabatan_selesai', $data->masa_jabatan_selesai)" type="date"
                        class="block mt-1 w-full" name="masa_jabatan_selesai" id="masa_jabatan_selesai" required />
                    <x-input-error :messages="$errors->get('masa_jabatan_selesai')" class="mt-2 text-red-500 text-xs" />
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex md:justify-end md:flex-row flex-col-reverse mt-8 gap-4">
                <a href="{{ route('users.index') }}"
                    class="px-4 md:w-auto w-full py-2 bg-slate-200 text-center rounded-md text-gray-900">Kembali</a>
                <button type="submit"
                    class="px-4 md:w-auto w-full py-2 bg-[--primary] rounded-md text-white">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
