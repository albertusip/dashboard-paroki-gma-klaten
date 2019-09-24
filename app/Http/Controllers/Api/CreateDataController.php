<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use App\Models\Ekonomi;
use App\Models\StatusBaptis;
use App\Models\StatusKesehatan;
use App\Models\StatusPerkawinan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DB;


class CreateDataController extends Controller
{
    public function addUmat(Request $request)
    {
        $loop = $request->loop;
        
        $data = json_decode($request->getContent(), true);
        unset($data["loop"]);
        $data["id_keuskupan"] = "999";
        $data["id_paroki"] = "1";
        $data["id_lingkungan"] = "1";
        $data["alamat"] = "1";
        $data["id_jenis_rt"] = "1";
        $data["np"] = '1';
        $data["id_agama"] = "1";
        $data["tempat_lahir"] = "1";
        $data["tgl_lahir"] = Carbon::now()->toDateString();
        $data["jen_kel"] = "1";
        $data["id_hub_kk"] = "1";
        $data["id_suku"] = "1";
        $data["id_pendidikan"] = "1";
        $data["id_bidstudi"] = "1";
        $data["id_pekerjaan"] = "1";
        $data["id_goldar"] = "1";
        $data["id_jbt_sosial"] = "1";
        $data["tmp_tinggal"] = "1";
        $data["status_komuni"] = "1";
        $data["id_sts_gerejawi"] = "1";
        $data["id_keterlibatan"] = "1";
        
        for ($i=0; $i < $loop ; $i++) { 
            DB::table('umat')->insert(
                [$data]
            );
        }
    
        return $data;
    }

    public function getAddData()
    {
        $dataWilayah = Wilayah::all();
        $dataEkonomi = Ekonomi::all();
        $dataStatusBaptis = StatusBaptis::all();
        $dataStatusKesehatan = StatusKesehatan::all();
        $dataStatusPerkawinan = StatusPerkawinan::all();
        return response()->json([
            'itemsWilayah' => $dataWilayah,
            'itemsEkonomi' => $dataEkonomi,
            'itemsBaptis' => $dataStatusBaptis,
            'itemsKesehatan' => $dataStatusKesehatan,
            'itemsPerkawinan' => $dataStatusPerkawinan
        ]);
    }
}
