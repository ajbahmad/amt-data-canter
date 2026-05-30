@extends('layouts.admin')

@section('title', 'Edit Orang')

@section('content')

@include('layouts.partials.admin.breadcrumb', [
    'title' => 'Edit Orang',
    'breadcrumbs' => [
        ['name' => 'Dashboard', 'url' => route('dashboard')],
        ['name' => 'Data Master', 'url' => '#'],
        ['name' => 'Orang', 'url' => route('persons.index')],
        ['name' => 'Edit', 'url' => '#']
    ]
])

<form action="{{ route('persons.update', $person->id) }}" method="POST" enctype="multipart/form-data" id="personForm">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        
        <!-- Photo Upload Section -->
        <div class="lg:col-span-4 xl:col-span-3">
            <div class="rounded-2xl border border-slate-50 bg-white p-6 shadow-none">
                <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-4">
                    <i class="ti ti-photo mr-1 text-emerald-700"></i>Foto Profil
                </label>
                
                <div class="relative">
                    <div id="photoPreview" class="w-full aspect-square rounded-xl border-2 border-dashed border-slate-200 bg-slate-50 flex items-center justify-center overflow-hidden transition-all duration-200">
                        @if($person->photo)
                            <img id="photoImage" src="{{ asset('storage/' . $person->photo) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Preview">
                            <div id="photoPlaceholder" style="display: none;" class="text-center p-4">
                                <iconify-icon icon="lucide:image" class="text-4xl text-slate-400 mb-2"></iconify-icon>
                                <p class="text-xs text-slate-500 font-semibold">Belum ada foto</p>
                            </div>
                        @else
                            <div id="photoPlaceholder" class="text-center p-4">
                                <iconify-icon icon="lucide:image" class="text-4xl text-slate-400 mb-2"></iconify-icon>
                                <p class="text-xs text-slate-500 font-semibold">Belum ada foto</p>
                            </div>
                            <img id="photoImage" style="display: none; width: 100%; height: 100%; object-fit: cover;" alt="Preview">
                        @endif
                    </div>
                    
                    <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden">
                    
                    <button type="button" onclick="document.getElementById('photoInput').click()" class="mt-4 w-full inline-flex items-center justify-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-4 py-2.5 text-xs font-bold text-slate-700 transition-all">
                        <iconify-icon icon="lucide:upload" class="text-sm"></iconify-icon>
                        Ubah Foto
                    </button>
                    
                    @error('photo')
                        <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                            <i class="ti ti-alert-circle"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Fields Section -->
        <div class="lg:col-span-8 xl:col-span-9">
            <div class="rounded-2xl border border-slate-50 bg-white p-8 shadow-none">
                
                <div class="mb-8 pb-4 border-b border-slate-100">
                    <h2 class="text-xl font-extrabold text-emerald-800 flex items-center gap-2">
                        <span class="size-8 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center">
                            <iconify-icon icon="lucide:user-check" class="text-base"></iconify-icon>
                        </span>
                        Form Edit Orang
                    </h2>
                    <p class="text-xs text-slate-400 mt-1">Perbarui informasi biodata pribadi di bawah ini.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                            <i class="ti ti-building mr-1 text-emerald-700"></i>Lembaga
                        </label>
                        <div class="relative">
                            <select name="school_institution_id" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('school_institution_id') border-red-500 @enderror">
                                <option value="">-- Pilih Lembaga --</option>
                                @foreach($schoolInstitutions ?? [] as $institution)
                                    <option value="{{ $institution->id }}" {{ old('school_institution_id', $person->school_institution_id) === $institution->id ? 'selected' : '' }}>
                                        {{ $institution->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                            </div>
                        </div>
                        @error('school_institution_id')
                            <p class="text-red-655 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                <i class="ti ti-alert-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                            Nama Depan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="first_name" value="{{ old('first_name', $person->first_name) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('first_name') border-red-500 @enderror" placeholder="Nama depan">
                        @error('first_name')
                            <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                <i class="ti ti-alert-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                            Nama Belakang
                        </label>
                        <input type="text" name="last_name" value="{{ old('last_name', $person->last_name) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('last_name') border-red-500 @enderror" placeholder="Nama belakang">
                        @error('last_name')
                            <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                <i class="ti ti-alert-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                            <i class="ti ti-id mr-1 text-emerald-700"></i>Nomor Identitas
                        </label>
                        <input type="text" name="identity_number" value="{{ old('identity_number', $person->identity_number) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('identity_number') border-red-500 @enderror" placeholder="NIK, NIM, NIP, etc">
                        @error('identity_number')
                            <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                <i class="ti ti-alert-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $person->email) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('email') border-red-500 @enderror" placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                <i class="ti ti-alert-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                            Telepon
                        </label>
                        <input type="tel" name="phone" value="{{ old('phone', $person->phone) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('phone') border-red-500 @enderror" placeholder="08xxxxxxxxxx">
                        @error('phone')
                            <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                <i class="ti ti-alert-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                            Jenis Kelamin
                        </label>
                        <div class="relative">
                            <select name="gender" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 appearance-none @error('gender') border-red-500 @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="male" {{ old('gender', $person->gender) === 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $person->gender) === 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                <iconify-icon icon="lucide:chevron-down" class="text-xs"></iconify-icon>
                            </div>
                        </div>
                        @error('gender')
                            <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                <i class="ti ti-alert-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                            Tanggal Lahir
                        </label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $person->birth_date) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('birth_date') border-red-500 @enderror">
                        @error('birth_date')
                            <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                <i class="ti ti-alert-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                            Tempat Lahir
                        </label>
                        <input type="text" name="birth_place" value="{{ old('birth_place', $person->birth_place) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('birth_place') border-red-500 @enderror" placeholder="Kota kelahiran">
                        @error('birth_place')
                            <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                <i class="ti ti-alert-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-slate-100">
                        <div>
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                                Kota
                            </label>
                            <input type="text" name="city" value="{{ old('city', $person->city) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('city') border-red-500 @enderror" placeholder="Kota">
                            @error('city')
                                <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                    <i class="ti ti-alert-circle"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                                Provinsi
                            </label>
                            <input type="text" name="province" value="{{ old('province', $person->province) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('province') border-red-500 @enderror" placeholder="Provinsi">
                            @error('province')
                                <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                    <i class="ti ti-alert-circle"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                                Kode Pos
                            </label>
                            <input type="text" name="postal_code" value="{{ old('postal_code', $person->postal_code) }}" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 @error('postal_code') border-red-500 @enderror" placeholder="12345">
                            @error('postal_code')
                                <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                    <i class="ti ti-alert-circle"></i>{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-wider mb-2">
                            Alamat Lengkap
                        </label>
                        <textarea name="address" class="w-full text-sm border border-slate-200 rounded-lg focus:border-green-800 focus:ring-4 focus:ring-green-800/10 transition-all duration-200 outline-none text-slate-700 font-medium px-4 py-3 bg-white hover:border-slate-300 resize-none @error('address') border-red-500 @enderror" placeholder="Tulis alamat rumah lengkap di sini..." rows="3">{{ old('address', $person->address) }}</textarea>
                        @error('address')
                            <p class="text-red-650 text-[10px] mt-1.5 font-bold flex items-center gap-1">
                                <i class="ti ti-alert-circle"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $person->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300 transition-all">
                            <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Status Aktif</span>
                        </label>
                    </div>

                </div>

                <div class="flex items-center gap-3 mt-8 pt-6 border-t border-slate-100">
                    <button style="background-color: #3b82f6" type="submit" class="inline-flex items-center gap-2 rounded-xl px-6 py-2.5 text-xs font-bold text-white transition-all shadow-sm hover:brightness-105">
                        <iconify-icon icon="lucide:check" class="text-sm"></iconify-icon>
                        Simpan
                    </button>
                    <a href="{{ route('persons.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-100 hover:bg-slate-200 px-6 py-2.5 text-xs font-bold text-slate-700 transition-all">
                        <iconify-icon icon="lucide:x" class="text-sm"></iconify-icon>
                        Batal
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
                    document.getElementById('photoPreview').classList.remove('border-slate-200');
                    document.getElementById('photoPreview').classList.add('border-emerald-800');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
    @include('components.confirm-toastr')
@endpush
