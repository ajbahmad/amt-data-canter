<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add username to users table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->unique()->after('email');
            }
        });

        // 2. Add religion, parent, and address fields to persons table
        Schema::table('persons', function (Blueprint $table) {
            if (!Schema::hasColumn('persons', 'religion')) {
                $table->string('religion')->nullable();
            }
            if (!Schema::hasColumn('persons', 'father_name')) {
                $table->string('father_name')->nullable();
            }
            if (!Schema::hasColumn('persons', 'mother_name')) {
                $table->string('mother_name')->nullable();
            }
            if (!Schema::hasColumn('persons', 'guardian_name')) {
                $table->string('guardian_name')->nullable();
            }
            if (!Schema::hasColumn('persons', 'guardian_phone')) {
                $table->string('guardian_phone')->nullable();
            }
            
            // Additional Address Fields
            if (!Schema::hasColumn('persons', 'rt')) {
                $table->string('rt', 5)->nullable();
            }
            if (!Schema::hasColumn('persons', 'rw')) {
                $table->string('rw', 5)->nullable();
            }
            if (!Schema::hasColumn('persons', 'dusun')) {
                $table->string('dusun')->nullable();
            }
            if (!Schema::hasColumn('persons', 'kelurahan')) {
                $table->string('kelurahan')->nullable();
            }
            if (!Schema::hasColumn('persons', 'kecamatan')) {
                $table->string('kecamatan')->nullable();
            }
            if (!Schema::hasColumn('persons', 'kewarganegaraan')) {
                $table->string('kewarganegaraan')->nullable();
            }

            // Detailed Parent Fields
            if (!Schema::hasColumn('persons', 'father_nik')) {
                $table->string('father_nik', 16)->nullable();
            }
            if (!Schema::hasColumn('persons', 'father_birth_year')) {
                $table->string('father_birth_year', 4)->nullable();
            }
            if (!Schema::hasColumn('persons', 'father_education')) {
                $table->string('father_education')->nullable();
            }
            if (!Schema::hasColumn('persons', 'father_occupation')) {
                $table->string('father_occupation')->nullable();
            }
            if (!Schema::hasColumn('persons', 'father_income')) {
                $table->string('father_income')->nullable();
            }

            if (!Schema::hasColumn('persons', 'mother_nik')) {
                $table->string('mother_nik', 16)->nullable();
            }
            if (!Schema::hasColumn('persons', 'mother_birth_year')) {
                $table->string('mother_birth_year', 4)->nullable();
            }
            if (!Schema::hasColumn('persons', 'mother_education')) {
                $table->string('mother_education')->nullable();
            }
            if (!Schema::hasColumn('persons', 'mother_occupation')) {
                $table->string('mother_occupation')->nullable();
            }
            if (!Schema::hasColumn('persons', 'mother_income')) {
                $table->string('mother_income')->nullable();
            }

            if (!Schema::hasColumn('persons', 'guardian_nik')) {
                $table->string('guardian_nik', 16)->nullable();
            }
            if (!Schema::hasColumn('persons', 'guardian_birth_year')) {
                $table->string('guardian_birth_year', 4)->nullable();
            }
            if (!Schema::hasColumn('persons', 'guardian_education')) {
                $table->string('guardian_education')->nullable();
            }
            if (!Schema::hasColumn('persons', 'guardian_occupation')) {
                $table->string('guardian_occupation')->nullable();
            }
            if (!Schema::hasColumn('persons', 'guardian_income')) {
                $table->string('guardian_income')->nullable();
            }
        });

        // 3. Add academic, welfare, and physical fields to students table
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'student_code')) {
                $table->string('student_code')->nullable()->unique();
            }
            if (!Schema::hasColumn('students', 'major')) {
                $table->string('major')->nullable();
            }
            if (!Schema::hasColumn('students', 'entry_year')) {
                $table->integer('entry_year')->nullable();
            }
            if (!Schema::hasColumn('students', 'school_year')) {
                $table->string('school_year')->nullable();
            }

            // Demographics & Welfare
            if (!Schema::hasColumn('students', 'no_kk')) {
                $table->string('no_kk', 16)->nullable();
            }
            if (!Schema::hasColumn('students', 'no_akta')) {
                $table->string('no_akta')->nullable();
            }
            if (!Schema::hasColumn('students', 'tinggi_badan')) {
                $table->integer('tinggi_badan')->nullable();
            }
            if (!Schema::hasColumn('students', 'berat_badan')) {
                $table->integer('berat_badan')->nullable();
            }
            if (!Schema::hasColumn('students', 'lingkar_kepala')) {
                $table->integer('lingkar_kepala')->nullable();
            }
            if (!Schema::hasColumn('students', 'jarak_sekolah')) {
                $table->decimal('jarak_sekolah', 5, 2)->nullable();
            }
            if (!Schema::hasColumn('students', 'waktu_jam')) {
                $table->integer('waktu_jam')->nullable();
            }
            if (!Schema::hasColumn('students', 'waktu_menit')) {
                $table->integer('waktu_menit')->nullable();
            }
            if (!Schema::hasColumn('students', 'jumlah_saudara')) {
                $table->integer('jumlah_saudara')->nullable();
            }
            if (!Schema::hasColumn('students', 'no_kks')) {
                $table->string('no_kks')->nullable();
            }
            if (!Schema::hasColumn('students', 'no_pkh')) {
                $table->string('no_pkh')->nullable();
            }
            if (!Schema::hasColumn('students', 'no_kip')) {
                $table->string('no_kip')->nullable();
            }

            // Intake details
            if (!Schema::hasColumn('students', 'asal_sekolah')) {
                $table->string('asal_sekolah')->nullable();
            }
            if (!Schema::hasColumn('students', 'no_un')) {
                $table->string('no_un')->nullable();
            }
            if (!Schema::hasColumn('students', 'no_ijazah')) {
                $table->string('no_ijazah')->nullable();
            }
            if (!Schema::hasColumn('students', 'no_skhun')) {
                $table->string('no_skhun')->nullable();
            }

            // Achievements
            if (!Schema::hasColumn('students', 'prestasi_jenis')) {
                $table->string('prestasi_jenis')->nullable();
            }
            if (!Schema::hasColumn('students', 'prestasi_tingkat')) {
                $table->string('prestasi_tingkat')->nullable();
            }
            if (!Schema::hasColumn('students', 'prestasi_nama')) {
                $table->string('prestasi_nama')->nullable();
            }
            if (!Schema::hasColumn('students', 'prestasi_tahun')) {
                $table->string('prestasi_tahun', 4)->nullable();
            }
            if (!Schema::hasColumn('students', 'prestasi_penyelenggara')) {
                $table->string('prestasi_penyelenggara')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                $table->dropColumn('username');
            }
        });

        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn([
                'religion',
                'father_name',
                'mother_name',
                'guardian_name',
                'guardian_phone',
                'rt',
                'rw',
                'dusun',
                'kelurahan',
                'kecamatan',
                'kewarganegaraan',
                'father_nik',
                'father_birth_year',
                'father_education',
                'father_occupation',
                'father_income',
                'mother_nik',
                'mother_birth_year',
                'mother_education',
                'mother_occupation',
                'mother_income',
                'guardian_nik',
                'guardian_birth_year',
                'guardian_education',
                'guardian_occupation',
                'guardian_income',
            ]);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'student_code',
                'major',
                'entry_year',
                'school_year',
                'no_kk',
                'no_akta',
                'tinggi_badan',
                'berat_badan',
                'lingkar_kepala',
                'jarak_sekolah',
                'waktu_jam',
                'waktu_menit',
                'jumlah_saudara',
                'no_kks',
                'no_pkh',
                'no_kip',
                'asal_sekolah',
                'no_un',
                'no_ijazah',
                'no_skhun',
                'prestasi_jenis',
                'prestasi_tingkat',
                'prestasi_nama',
                'prestasi_tahun',
                'prestasi_penyelenggara',
            ]);
        });
    }
};
