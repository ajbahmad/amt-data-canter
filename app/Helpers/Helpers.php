<?php
function rp($nominal) 
{
    if (is_numeric($nominal)) {
        return 'Rp ' . number_format($nominal, 0, ',', '.');    
    } else {
        return $nominal;
    }
}

function nameInitials($name)
{
    // === DAFTAR GELAR AWAL (PREFIXES) ===
    $prefixes = [
        'H', 'H.', 'Hj', 'Hj.', 'Dr', 'Dr.', 'Prof', 'Prof.',
        'Ir', 'Ir.', 'K', 'K.', 'KH', 'KH.', 'Ust', 'Ust.', 'Ustadz', 'Ustadzah'
    ];

    // === DAFTAR GELAR AKHIR (SUFFIXES) ===
    $suffixes = [
        'S.Kom', 'S,Kom', 'S.E', 'S.H', 'S.Pd', 'S.Pd.I', 'S.Ag',
        'M.Pd', 'M.Ag', 'M.Si', 'M.Kom', 'M.M', 'M.T', 'M.Kes',
        'Ph.D', 'PhD', 'Drs', 'Drs.', 'Drh', 'Drh.'
    ];

    // Bersihkan spasi
    $name = trim($name);

    // === Hapus gelar akhir ===
    foreach ($suffixes as $suf) {
        // Hilangkan gelar apapun di akhir kalimat
        $name = preg_replace('/\s*' . preg_quote($suf, '/') . '\s*$/i', '', $name);
    }

    // Pecah nama jadi array
    $parts = preg_split('/\s+/', $name);

    // === Hapus gelar awal ===
    while (!empty($parts)) {
        // Normalisasi (hilangkan titik)
        $clean = str_replace('.', '', $parts[0]);

        // Jika cocok prefix, hapus
        if (in_array(strtolower($clean), array_map('strtolower', array_map(fn($x)=>str_replace('.', '', $x), $prefixes)))) {
            array_shift($parts);
        } else {
            break;
        }
    }

    // Ambil huruf awal setiap kata
    $initials = '';
    foreach ($parts as $p) {
        $initials .= strtoupper($p[0]);
    }

    return $initials;
}