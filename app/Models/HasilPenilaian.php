<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPenilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'alternative_id',
        'criteria_id',
        'tiket',
        'fasilitas',
        'kebersihan',
        'keamanan',
        'akomodasi',
    ];

    public function alternative()
    {
        return $this->belongsTo(Alternative::class);
    }
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
