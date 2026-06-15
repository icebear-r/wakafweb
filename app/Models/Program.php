<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';

    const UPDATED_AT = null;

    protected $fillable = [
        'kategori_id',
        'judul',
        'deskripsi',
        'artikel_program',
        'gambar',
        'programkategori_id',
    ];

    public function kategoriId(): int
    {
        return (int) ($this->programkategori_id ?: $this->kategori_id);
    }
}
