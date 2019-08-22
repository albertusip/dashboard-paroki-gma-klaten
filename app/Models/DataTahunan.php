<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataTahunan extends Model
{
    protected $table = 'rekap';
    
    protected $fillable = [
        'id_wilayah',
        'kategori',
        'jumlah',
        'tahun'
    ];
}
