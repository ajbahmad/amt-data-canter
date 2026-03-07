<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migration: Data Center (Master Data Sekolah)
     *
     * Tujuan:
     * - Menjadi pusat data master sekolah (bukan transaksi)
     * - Semua aplikasi lain (PPDB, Absensi, Perpus, Kantin) hanya menyimpan ID referensi
     *
     * Konsep utama:
     * - persons = semua manusia (siswa, guru, staff, admin, kantin, pustakawan, orang tua)
     * - person_types = kategori role (student, teacher, staff, dll)
     * - id_cards = mapping RFID card_uid ke person_id
     * - students/teachers/staffs = detail khusus berdasarkan tipe person
     * - class_rooms, schedules, assignments = struktur akademik master
     */

    public function up(): void
    {
        /**
         * ============================================================
         * A. MASTER SEKOLAH
         * ============================================================
         */

        // Daftar sekolah/institusi (misal: SMPN 1, SDN 2, SMAN 5)
        Schema::create('school_institutions', function (Blueprint $table) {
            $table->id();

            // kode internal unik sekolah (misal: SMPN1_BDG)
            $table->string('code', 50)->unique();

            // nama sekolah
            $table->string('name');

            // NPSN sekolah (opsional)
            $table->string('npsn', 20)->nullable();

            $table->text('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();

            // menandakan sekolah aktif atau tidak
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        // Daftar level sekolah (SD/SMP/SMA/SMK)
        Schema::create('school_levels', function (Blueprint $table) {
            $table->id();

            // kode unik level (sd, smp, sma, smk)
            $table->string('code', 20)->unique();

            // nama level (SD, SMP, SMA, SMK)
            $table->string('name', 50);

            $table->timestamps();
        });

        // Relasi: sekolah punya level apa saja
        // contoh: satu institusi bisa punya SD dan SMP sekaligus
        Schema::create('school_institution_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();
            $table->foreignId('school_level_id')->constrained('school_levels')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['school_institution_id', 'school_level_id']);
        });

        /**
         * ============================================================
         * B. TAHUN AJARAN & SEMESTER
         * ============================================================
         */

        // Tahun ajaran per sekolah (misal: 2025/2026)
        Schema::create('school_years', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();

            // nama tahun ajaran (format bebas, rekomendasi: 2025/2026)
            $table->string('name', 20);

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // hanya satu tahun ajaran yang aktif per sekolah
            $table->boolean('is_active')->default(false);

            $table->timestamps();

            $table->unique(['school_institution_id', 'name']);
        });

        // Semester dalam satu tahun ajaran (ganjil / genap)
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_year_id')->constrained('school_years')->cascadeOnDelete();

            // Ganjil / Genap
            $table->string('name', 20);

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // semester aktif (umumnya satu semester aktif)
            $table->boolean('is_active')->default(false);

            $table->timestamps();
        });

        /**
         * ============================================================
         * C. STRUKTUR AKADEMIK (GRADE, ROMBEL, MAPEL)
         * ============================================================
         */

        // Tingkat kelas berdasarkan level sekolah
        // contoh SMP: Kelas 7, 8, 9
        // contoh SD: Kelas 1,2,3,4,5,6
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_level_id')->constrained('school_levels')->cascadeOnDelete();

            $table->string('name', 50); // contoh: Kelas 7
            $table->unsignedInteger('order_no')->default(0); // urutan tampilan

            $table->timestamps();

            $table->unique(['school_level_id', 'name']);
        });

        // Rombongan belajar (Rombel / Kelas nyata: 7A, 7B)
        Schema::create('class_rooms', function (Blueprint $table) {
            $table->id();

            // rombel ini milik sekolah tertentu
            $table->foreignId('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();

            // rombel berlaku untuk tahun ajaran tertentu
            $table->foreignId('school_year_id')->constrained('school_years')->cascadeOnDelete();

            // rombel berada di grade tertentu
            $table->foreignId('grade_id')->constrained('grades')->cascadeOnDelete();

            $table->string('name', 50); // contoh: 7A
            $table->unsignedInteger('capacity')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // unik dalam tahun ajaran yang sama
            $table->unique(['school_year_id', 'name']);
        });

        // Mata pelajaran per level sekolah
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_level_id')->constrained('school_levels')->cascadeOnDelete();

            // kode mapel internal (opsional)
            $table->string('code', 50)->nullable();

            $table->string('name', 100);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['school_level_id', 'name']);
        });

        /**
         * ============================================================
         * D. PERSON & IDENTITY (INTI SISTEM)
         * ============================================================
         */

        // Semua manusia yang terdaftar di sekolah
        // Bisa siswa, guru, staff, admin, kantin, pustakawan, orang tua, dll
        Schema::create('persons', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('full_name');
            $table->string('gender', 10)->nullable(); // male/female
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();

            $table->text('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('photo_url')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        // Master jenis person (role/tipe)
        Schema::create('person_types', function (Blueprint $table) {
            $table->id();

            // kode unik: student, teacher, staff, admin, canteen, librarian, parent
            $table->string('code', 50)->unique();

            // nama tampil: Siswa, Guru, Staff, dll
            $table->string('name', 100);
            $table->boolean('is_active')->default(true);


            $table->timestamps();
        });

        // Relasi banyak ke banyak antara persons dan person_types
        // karena satu orang bisa memiliki beberapa role
        Schema::create('person_type_memberships', function (Blueprint $table) {
            $table->id();

            $table->uuid('person_id');
            $table->foreignId('person_type_id')->constrained('person_types')->cascadeOnDelete();

            // periode aktif role
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('persons')->cascadeOnDelete();
            

            // mencegah duplikasi role yang sama untuk person yang sama
            $table->unique(['person_id', 'person_type_id']);
        });

        /**
         * ============================================================
         * E. DETAIL KHUSUS (STUDENTS / TEACHERS / STAFFS)
         * ============================================================
         */

        // Data siswa (khusus untuk person yang berperan sebagai siswa)
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // relasi ke persons
            $table->uuid('person_id');

            // sekolah tempat siswa terdaftar
            $table->foreignId('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();

            // nomor induk siswa (wajib unik)
            $table->string('nis', 30)->unique();

            // NISN (opsional)
            $table->string('nisn', 30)->nullable();

            // tahun masuk
            $table->string('entry_year', 10)->nullable();

            // status siswa
            $table->string('status', 20)->default('active'); // active, graduated, moved, inactive

            $table->boolean('is_active')->default(true);
            
            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('persons')->cascadeOnDelete();
        });

        // Data guru
        Schema::create('teachers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('person_id');
            $table->foreignId('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();

            // NIP jika ada
            $table->string('nip', 50)->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('persons')->cascadeOnDelete();
        });

        // Data staff (TU, operator, security, kantin, pustakawan jika dianggap staff)
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();

            $table->uuid('person_id');
            $table->foreignId('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();

            $table->string('staff_code', 50)->nullable();
            $table->boolean('is_active')->default(true);
            

            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('persons')->cascadeOnDelete();
        });

        /**
         * ============================================================
         * F. PENEMPATAN SISWA & WALI KELAS
         * ============================================================
         */

        // Mapping siswa masuk rombel tertentu
        Schema::create('class_room_students', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_room_id')->constrained('class_rooms')->cascadeOnDelete();
            $table->uuid('student_id');

            // apakah siswa masih aktif di rombel ini
            $table->boolean('is_active')->default(true);

            $table->dateTime('joined_at')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();

            $table->unique(['class_room_id', 'student_id']);
        });

        // Mapping wali kelas pada rombel
        Schema::create('class_room_homeroom_teachers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('class_room_id')->constrained('class_rooms')->cascadeOnDelete();
            $table->uuid('teacher_id');

            $table->dateTime('assigned_at')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();
            $table->unique(['class_room_id', 'teacher_id']);
        });

        /**
         * ============================================================
         * G. PENUGASAN GURU MENGAJAR MAPEL
         * ============================================================
         */

        // Guru mengajar mapel tertentu di kelas tertentu pada semester tertentu
        Schema::create('teacher_subject_assignments', function (Blueprint $table) {
            $table->id();

            $table->uuid('teacher_id');
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('class_room_id')->constrained('class_rooms')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();

            $table->dateTime('assigned_at')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();

            $table->unique(
                ['teacher_id', 'subject_id', 'class_room_id', 'semester_id'],
                'teacher_subject_unique'
            );
        });

        /**
         * ============================================================
         * H. JAM PELAJARAN & JADWAL
         * ============================================================
         */

        // Jam pelajaran (Jam 1, Jam 2, dst)
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();

            $table->string('name', 50); // Jam 1
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedInteger('order_no')->default(0);

            $table->timestamps();

            $table->unique(['school_institution_id', 'name']);
        });

        // Jadwal pelajaran rombel (hari + jam + mapel + guru)
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('school_institution_id')->constrained('school_institutions')->cascadeOnDelete();
            $table->foreignId('school_level_id')->constrained('school_levels')->cascadeOnDelete();
            $table->foreignId('class_room_id')->constrained('class_rooms')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');
            $table->foreignId('start_time_slot_id')->constrained('time_slots')->cascadeOnDelete();
            $table->foreignId('end_time_slot_id')->constrained('time_slots')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(
                ['class_room_id', 'semester_id', 'day_of_week', 'start_time_slot_id', 'end_time_slot_id'],
                'schedule_unique'
            );
        });

        /**
         * ============================================================
         * I. RFID / ID CARD
         * ============================================================
         */

        // Kartu RFID yang dipakai untuk absensi/kantin/perpustakaan
        Schema::create('id_cards', function (Blueprint $table) {
            $table->id();

            // UID unik dari RFID reader
            $table->string('card_uid', 100)->unique();

            // nomor kartu tercetak (opsional)
            $table->string('card_number', 100)->nullable();

            // kartu dimiliki oleh person tertentu
            $table->uuid('person_id');

            // status kartu
            $table->string('status', 20)->default('active'); // active, lost, blocked, expired

            $table->dateTime('issued_at')->nullable();
            $table->dateTime('expired_at')->nullable();

            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('persons')->cascadeOnDelete();
        });

        // Riwayat kartu (jika kartu hilang, diganti, diblokir)
        Schema::create('card_history', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_card_id')->constrained('id_cards')->cascadeOnDelete();
            $table->uuid('person_id');

            // issued, blocked, lost, replaced
            $table->string('action', 50);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('persons')->cascadeOnDelete();
        });

        /**
         * ============================================================
         * J. MAPPING AUTH USER (Jika Auth DB Terpisah)
         * ============================================================
         */

        // Mapping person ke auth user (db_auth.users)
        Schema::create('person_accounts', function (Blueprint $table) {
            $table->id();

            $table->uuid('person_id');

            // id dari auth database (bukan foreign key langsung karena beda database)
            $table->uuid('auth_user_id');

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('person_id')->references('id')->on('persons')->cascadeOnDelete();
            $table->unique(['person_id', 'auth_user_id']);
        });

        /**
         * ============================================================
         * K. ORANG TUA / WALI (Opsional)
         * ============================================================
         */

        // Mapping siswa dengan orang tua/wali
        Schema::create('student_guardians', function (Blueprint $table) {
            $table->id();

            $table->uuid('student_id');

            // orang tua juga dicatat sebagai person
            $table->uuid('person_id');

            // father/mother/guardian
            $table->string('relationship', 30)->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();
            $table->foreign('person_id')->references('id')->on('persons')->cascadeOnDelete();

            $table->unique(['student_id', 'person_id']);
        });

        /**
         * ============================================================
         * L. SYSTEM SETTINGS & AUDIT LOGS
         * ============================================================
         */

        // Konfigurasi global aplikasi data center
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();

            // key setting (unique)
            $table->string('key', 150)->unique();

            // value setting (json/text)
            $table->text('value')->nullable();

            $table->timestamps();
        });

        // Audit log aktivitas perubahan master data
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // aksi: create/update/delete/login/etc
            $table->string('action', 100);

            // nama entity: persons, students, id_cards, dll
            $table->string('entity_name', 100)->nullable();

            // id entity yang berubah
            $table->string('entity_id', 100)->nullable();

            // person_id pelaku perubahan
            $table->uuid('performed_by')->nullable();

            $table->text('description')->nullable();

            $table->timestamps();

            $table->foreign('performed_by')->references('id')->on('persons')->nullOnDelete();
        });




        /**
         * ============================================================
         * M. MENU SIDEBAR (DYNAMIC MENU CONFIGURATION)
         * ============================================================
         *
         * Tujuan:
         * - Menyimpan konfigurasi menu sidebar secara dinamis di database
         * - Mendukung menu dropdown (accordion) dan menu item biasa
         * - Mendukung role/permission per menu item
         *
         * Konsep:
         * - menus menggunakan struktur parent_id (self relation)
         * - menu_permissions menentukan siapa yang boleh melihat menu
         */

        // Tabel menu utama (hierarchical menu)
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            /**
             * parent_id:
             * - null = menu root
             * - not null = child dari dropdown tertentu
             */
            $table->foreignId('parent_id')->nullable()->constrained('menus')->nullOnDelete();

            /**
             * type:
             * - item = menu biasa
             * - dropdown = menu accordion yang punya children
             */
            $table->string('type', 20)->default('item');

            // title yang ditampilkan pada sidebar
            $table->string('title', 150);

            // icon (contoh: solar:book-bookmark-line-duotone)
            $table->string('icon', 150)->nullable();

            // warna (info, warning, success, primary, dll)
            $table->string('color', 30)->nullable();

            /**
             * menu_key:
             * id unik untuk dropdown accordion
             * contoh: studies-accordion
             */
            $table->string('menu_key', 150)->nullable();

            /**
             * route:
             * nama route Laravel
             * contoh: admin.studies.index
             * route ini hanya digunakan jika type=item
             */
            $table->string('route', 200)->nullable();

            // url manual (opsional, jika tidak pakai route)
            $table->string('url', 255)->nullable();

            /**
             * order_no:
             * untuk sorting menu pada sidebar
             */
            $table->unsignedInteger('order_no')->default(0);

            /**
             * is_active:
             * menu aktif/tidak
             */
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // menu_key harus unik jika diisi
            $table->unique('menu_key');
        });

        // Permission akses menu berdasarkan role
        Schema::create('menu_permissions', function (Blueprint $table) {
            $table->id();

            // relasi menu
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();

            /**
             * role_code:
             * role yang boleh akses menu
             * contoh: admin, teacher, student
             *
             * (role ini sebaiknya sama dengan sistem role di auth service)
             */
            $table->string('role_code', 50);

            $table->timestamps();

            // mencegah duplikasi role yang sama pada menu yang sama
            $table->unique(['menu_id', 'role_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('system_settings');

        Schema::dropIfExists('student_guardians');
        Schema::dropIfExists('person_accounts');

        Schema::dropIfExists('card_history');
        Schema::dropIfExists('id_cards');

        Schema::dropIfExists('class_schedules');
        Schema::dropIfExists('time_slots');

        Schema::dropIfExists('teacher_subject_assignments');

        Schema::dropIfExists('class_room_homeroom_teachers');
        Schema::dropIfExists('class_room_students');

        Schema::dropIfExists('staffs');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('students');

        Schema::dropIfExists('person_type_memberships');
        Schema::dropIfExists('person_types');
        Schema::dropIfExists('persons');

        Schema::dropIfExists('subjects');
        Schema::dropIfExists('class_rooms');
        Schema::dropIfExists('grades');

        Schema::dropIfExists('semesters');
        Schema::dropIfExists('school_years');

        Schema::dropIfExists('school_institution_levels');
        Schema::dropIfExists('school_levels');
        Schema::dropIfExists('school_institutions');

        Schema::dropIfExists('menu_permissions');
        Schema::dropIfExists('menus');
    }
};
