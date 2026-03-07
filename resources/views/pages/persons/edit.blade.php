@extends('layouts.admin')

@section('title', 'Edit Orang')

@section('content')

    @include('layouts.partials.admin.breadcrumb', [
        'title' => 'Edit Orang',
        'breadcrumbs' => [
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Data Master', 'url' => '#'],
            ['name' => 'Orang', 'url' => route('persons.index')],
            ['name' => 'Edit', 'url' => '#'],
        ],
    ])

    <form action="{{ route('persons.update', $person->id) }}" method="POST" enctype="multipart/form-data" id="personForm">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6 grid-cols-12 mb-6">
            
            <!-- Photo Upload Section -->
            <div class="col-span-3">
                <div class="rounded-lg border border-gray-200 bg-white p-6">

                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto
                    </label>
                    <div class="relative">
                        <div id="photoPreview"
                            class="w-full h-56 aspect-square rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 flex items-center justify-center overflow-hidden">
                            @if($person->photo)
                                <img id="photoImage" src="{{ asset('storage/' . $person->photo) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Preview">
                                <div id="photoPlaceholder" style="display: none;" class="text-center">
                                    <i class="ti ti-photo text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-500">Belum ada foto</p>
                                </div>
                            @else
                                <div id="photoPlaceholder" class="text-center">
                                    <i class="ti ti-photo text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-500">Belum ada foto</p>
                                </div>
                                <img id="photoImage" style="display: none; width: 100%; height: 100%; object-fit: cover;" alt="Preview">
                            @endif
                        </div>
                        <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden">
                        <button type="button" onclick="document.getElementById('photoInput').click()"
                            class="mt-2 w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                            <i class="ti ti-upload mr-2"></i>Ubah Foto
                        </button>
                        @error('photo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-span-9">
                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <div class="grid grid-cols-1 gap-6 grid-cols-2">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Depan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="first_name" value="{{ old('first_name', $person->first_name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror" placeholder="Nama depan">
                    @error('first_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Belakang
                    </label>
                    <input type="text" name="last_name" value="{{ old('last_name', $person->last_name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-500 @enderror" placeholder="Nama belakang">
                    @error('last_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Identitas
                    </label>
                    <input type="text" name="identity_number" value="{{ old('identity_number', $person->identity_number) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('identity_number') border-red-500 @enderror" placeholder="NIK, NIM, NIP, etc">
                    @error('identity_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $person->email) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" placeholder="email@example.com">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Telepon
                    </label>
                    <input type="tel" name="phone" value="{{ old('phone', $person->phone) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror" placeholder="08xxxxxxxxxx">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kelamin
                    </label>
                    <select name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gender') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="male" {{ old('gender', $person->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender', $person->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Lahir
                    </label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $person->birth_date) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('birth_date') border-red-500 @enderror">
                    @error('birth_date')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tempat Lahir
                    </label>
                    <input type="text" name="birth_place" value="{{ old('birth_place', $person->birth_place) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('birth_place') border-red-500 @enderror" placeholder="Kota kelahiran">
                    @error('birth_place')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                

                <div class="grid grid-cols-1 gap-1">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kota
                        </label>
                        <input type="text" name="city" value="{{ old('city', $person->city) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('city') border-red-500 @enderror" placeholder="Kota">
                        @error('city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Provinsi
                        </label>
                        <input type="text" name="province" value="{{ old('province', $person->province) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('province') border-red-500 @enderror" placeholder="Provinsi">
                        @error('province')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kode Pos
                        </label>
                        <input type="text" name="postal_code" value="{{ old('postal_code', $person->postal_code) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('postal_code') border-red-500 @enderror" placeholder="12345">
                        @error('postal_code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4">
                    <div class="">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat
                        </label>
                        <textarea name="address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror" placeholder="Alamat lengkap" rows="3">{{ old('address', $person->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status Aktif
                        </label>
                        <div class="flex items-center h-10 px-4 border border-gray-300 rounded-lg bg-white">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $person->is_active) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                            <label for="is_active" class="ml-3 text-sm font-semibold text-gray-700 cursor-pointer">
                                Aktif
                            </label>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition">
                            <i class="ti ti-check mr-2"></i>Simpan
                        </button>
                        <a href="{{ route('persons.show', $person->id) }}" class="inline-flex items-center rounded-lg bg-gray-300 px-6 py-2 text-gray-800 hover:bg-gray-400 transition">
                            <i class="ti ti-x mr-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
<script>
document.getElementById('photoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPlaceholder').style.display = 'none';
            document.getElementById('photoImage').style.display = 'block';
            document.getElementById('photoImage').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>

    @include('components.confirm-toastr')
@endpush
