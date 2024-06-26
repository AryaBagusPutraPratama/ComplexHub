<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaians'; // Nama tabel dalam basis data

    protected $fillable = [
        'alternative_id',
        'criteria_id',
        'nilai',
    ];

    // Atau Anda juga bisa mendefinisikan relasi ke model Alternatif dan Kriteria jika diperlukan
    public function alternatif()
    {
        return $this->belongsTo(Alternative::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
 