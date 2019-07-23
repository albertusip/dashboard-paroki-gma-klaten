<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umat extends Model
{
    protected $table = 'umat';

    public function ekonomi () {
        return $this->belongsTo(Ekonomi::class,'id_ekonomi', 'id_ekonomi');
    }

    public function pendidikan () {
        return $this->belongsTo(Pendidikan::class,'id_pendidikan', 'id_pendidikan');
    }

    public function statusPerkawinan () {
        return $this->belongsTo(StatusPerkawinan::class,'id_sts_kawin', 'id_sts_kawin');
    }
}
