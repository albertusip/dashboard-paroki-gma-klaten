<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Umat;
use App\Models\Wilayah;
use App\Models\StatusPerkawinan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getWilayah()
    {
        $dataWilayah = Wilayah::all();
        return response()->json([
            'items' => $dataWilayah
        ]);
    }

    public function index (Request $request) {
        $currentYear = Carbon::now()->format('YYYY');
        $currentDate = Carbon::today()->toDateString();
        $dataUmat = [];
        $barEkonomi = [];
        $pieProsentaseEkonomi = [];
        
        for ($i = 1; $i <= 12; $i++){
            $umatBisaMembantu = Umat::where('id_ekonomi','=','01')
                                        ->whereMonth('tgl_update', '=', $i)
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->get();
            $umatBiasa = Umat::where('id_ekonomi','=','02')
                                        ->whereMonth('tgl_update', '=', $i)
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->get();
            $umatPerluDibantu = Umat::where('id_ekonomi','=','03')
                                        ->whereMonth('tgl_update', '=', $i)
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->get();    
                                        
            $barEkonomi[$i] = [
                'bisa_membantu' => $umatBisaMembantu->count(),
                'biasa' => $umatBiasa->count(),
                'perlu_dibantu' => $umatPerluDibantu->count(),
            ];
        }

        $statusKrisma = Umat::where('status_krisma','=','SDH')
                            // ->whereDate('tgl_update', '=', $currentDate)
                            ->get()->count();
        $statusBaptis = Umat::where('tempat_baptis','!=','TDK')
                            ->orWhere('tempat_baptis','!=','BLM')
                            ->orWhere('tempat_baptis','!=','')
                            ->get()->count();

        $totalUmatBisaMembantu = Umat::where('id_ekonomi', '=', '01')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $totalUmatBiasa = Umat::where('id_ekonomi', '=', '02')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $totalUmatPerluDibantu = Umat::where('id_ekonomi', '=', '03')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        
        $umatBisaMembantu = Umat::where('id_ekonomi','=','01')
                                    ->whereYear('tgl_update', '=', '2018')
                                    ->get()->count();;
        $umatBiasa = Umat::where('id_ekonomi','=','02')
                                    ->whereYear('tgl_update', '=', '2018')
                                    ->get()->count();;
        $umatPerluDibantu = Umat::where('id_ekonomi','=','03')
                                    ->whereYear('tgl_update', '=', '2018')
                                    ->get()->count();; 

        $pieProsentaseEkonomi[] = [
                'bisa_membantu' => $totalUmatBisaMembantu,
                'biasa' => $totalUmatBiasa,
                'perlu_dibantu' => $totalUmatPerluDibantu,
                'total_semua_wilayah_bisa_membantu' => $umatBisaMembantu,
                'total_semua_wilayah_biasa' => $umatBiasa,
                'total_semua_wilayah_perlu_dibantu' => $umatPerluDibantu,
        ];

        $status = Umat::with('statusPerkawinan')
                        ->whereYear('tgl_update', '=', '2018')
                        ->where('id_wilayah', $request->id_wilayah)
                        ->get()
                        ->groupBy('id_sts_kawin')
                        ->toArray();
        $data = [];
        $i = 0;
        foreach ($status as $sts){
            $data[$i]['status'] = $sts[0]['status_perkawinan'];
            // $data[$i]['deskripsi_status'] = $sts[1]['status_perkawinan']['deskripsi_sts_kawin'];
            $data[$i]['jumlah_status'] = count($sts);
            
            $i++;
        }

        $umatsPerMonth = Umat::with('ekonomi')
                        // ->whereYear('tgl_update', '=', Carbon::now()->year)
                        ->whereYear('tgl_update', '=', '2018')
                        ->where('id_wilayah', '=', $request->id_wilayah)
                        ->get()
                        ->groupBy(function ($match){
                            return Carbon::parse($match->tgl_update)->format('m');
                        });
                        
        $data2 = [];
        foreach ($umatsPerMonth as $key => $umats){
            $umatsPerCriteria = $umats->groupBy('ekonomi.id_ekonomi')->toArray();

            if ($umatsPerCriteria['01'] != null) {
                $data2[$key]['bisaMembantu'] = count($umatsPerCriteria['01']);     
            } else {
                $data2[$key]['bisaMembantu'] = 0;
            }

            if ($umatsPerCriteria['02'] != null) {
                $data2[$key]['biasa'] = count($umatsPerCriteria['02']);
            }
                   
            if ($umatsPerCriteria['03'] != null) {
                $data2[$key]['perluDibantu'] = count($umatsPerCriteria['03']);
            }
            
        }

        $perkawinanPerMonth = Umat::with('statusPerkawinan')
                        // ->whereYear('tgl_update', '=', Carbon::now()->year)
                        ->whereYear('tgl_update', '=', '2018')
                        ->where('id_wilayah', '=', $request->id_wilayah)
                        ->get()
                        ->groupBy(function ($match){
                            return Carbon::parse($match->tgl_update)->format('m');
                        });
                        
        $data3 = [];
        // foreach ($perkawinanPerMonth as $key => $umats){
        //     $perkawinanPerCriteria = $umats->groupBy('statusPerkawinan.id_sts_kawin')->toArray();

        //     $data3[$key]['belumNikah'] = count($perkawinanPerCriteria['01']);            
        //     $data3[$key]['sahKatolik'] = count($perkawinanPerCriteria['02']);
        //     $data3[$key]['sahBedaAgama'] = count($perkawinanPerCriteria['03']);
        //     $data3[$key]['sahBedaGreja'] = count($perkawinanPerCriteria['04']);
        //     $data3[$key]['nikahDiLuarGreja'] = count($perkawinanPerCriteria['05']);            
        //     $data3[$key]['ditinggalPasangannya'] = count($perkawinanPerCriteria['06']);
        //     $data3[$key]['krisisBerkepanjangan'] = count($perkawinanPerCriteria['07']);
        //     $data3[$key]['jandaDudaMati'] = count($perkawinanPerCriteria['08']);
        //     $data3[$key]['RmBrSrDariParoki'] = count($perkawinanPerCriteria['09']);            
        //     $data3[$key]['RmBrSrBekerjaDiParoki'] = count($perkawinanPerCriteria['10']);
        //     $data3[$key]['hidupBersamaTanpaIkatan'] = count($perkawinanPerCriteria['11']);
        //     $data3[$key]['nikahAdat'] = count($perkawinanPerCriteria['12']);
        // }
        // dd($data3);

        $sts1 = Umat::where('id_sts_kawin', '=', '01')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $sts2 = Umat::where('id_sts_kawin', '=', '02')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $sts3 = Umat::where('id_sts_kawin', '=', '03')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $sts4 = Umat::where('id_sts_kawin', '=', '04')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $sts5 = Umat::where('id_sts_kawin', '=', '05')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $sts6 = Umat::where('id_sts_kawin', '=', '06')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $sts7 = Umat::where('id_sts_kawin', '=', '07')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $sts8 = Umat::where('id_sts_kawin', '=', '08')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $sts9 = Umat::where('id_sts_kawin', '=', '09')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $sts10 = Umat::where('id_sts_kawin', '=', '10')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $sts11 = Umat::where('id_sts_kawin', '=', '11')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $sts12 = Umat::where('id_sts_kawin', '=', '12')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        
        $namaSts = StatusPerkawinan::all();

        // foreach($namaSts as $sts){
        //     $sts->deskripsi_sts_kawin;
        //     $sts->id_sts_kawin;
        // }


        
        $pieProsentasePerkawinan[] = [
                'ekonomi_perbulan' => $data2,
                'status' => $data,
                'belum_nikah' => $sts1,
                'sah_katolik' => $sts2,
                'sah_beda_agama' => $sts3,
                'sah_beda_gereja' => $sts4,
                'nikah_diluar_gereja' => $sts5,
                'ditinggal_pasangannya' => $sts6,
                'krisis_berkepanjangan' => $sts7,
                'janda_atau_duda_mati' => $sts8,
                'rm_br_sr_dari_paroki' => $sts9,
                'rm_br_sr_bekerja_di_paroki' => $sts10,
                'hidup_bersama_tanpa_ikatan' => $sts11,
                'nikah_adat' => $sts12,
                'nama_status' => $namaSts,
        ];

        $pendidikan1 = Umat::where('id_pendidikan', '=', '00')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan2 = Umat::where('id_pendidikan', '=', '01')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan3 = Umat::where('id_pendidikan', '=', '02')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan4 = Umat::where('id_pendidikan', '=', '03')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan5 = Umat::where('id_pendidikan', '=', '04')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan6 = Umat::where('id_pendidikan', '=', '05')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan7 = Umat::where('id_pendidikan', '=', '06')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan8 = Umat::where('id_pendidikan', '=', '07')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan9 = Umat::where('id_pendidikan', '=', '11')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan10 = Umat::where('id_pendidikan', '=', '12')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan11 = Umat::where('id_pendidikan', '=', '13')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan12 = Umat::where('id_pendidikan', '=', '14')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan13 = Umat::where('id_pendidikan', '=', '15')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan14 = Umat::where('id_pendidikan', '=', '16')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan15 = Umat::where('id_pendidikan', '=', '17')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan16 = Umat::where('id_pendidikan', '=', '21')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan17 = Umat::where('id_pendidikan', '=', '22')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan18 = Umat::where('id_pendidikan', '=', '23')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan19 = Umat::where('id_pendidikan', '=', '24')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan20 = Umat::where('id_pendidikan', '=', '25')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan21 = Umat::where('id_pendidikan', '=', '26')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan22 = Umat::where('id_pendidikan', '=', '27')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan23 = Umat::where('id_pendidikan', '=', '33')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan24 = Umat::where('id_pendidikan', '=', '44')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        $pendidikan25 = Umat::where('id_pendidikan', '=', '77')
                                        ->whereYear('tgl_update', '=', '2018')
                                        ->where('id_wilayah', $request->id_wilayah)
                                        ->get()->count();
        
        $pieProsentasePendidikan[] = [
                'belum_sekolah' => $pendidikan1,
                'tamat_sd' => $pendidikan2,
                'tamat_sltp' => $pendidikan3,
                'tamat_slta' => $pendidikan4,
                'tamat_d1_d2_d3' => $pendidikan5,
                'tamat_s1_d4' => $pendidikan6,
                'tamat_s2_akta_5' => $pendidikan7,
                'tamat_s3' => $pendidikan8,
                'masih_di_sd_katolik' => $pendidikan9,
                'masih_di_sltp_katolik' => $pendidikan10,
                'masih_di_slta_katolik' => $pendidikan11,
                'masih_di_perguruan_tinggi_katolik_d' => $pendidikan12,
                'masih_di_perguruan_tinggi_katolik_s1' => $pendidikan13,
                'masih_di_perguruan_tinggi_katolik_s2' => $pendidikan14,
                'masih_di_perguruan_tinggi_katolik_s3' => $pendidikan15,
                'masih_di_sd_non_katolik' => $pendidikan16,
                'masih_di_sltp_non_katolik' => $pendidikan17,
                'masih_di_slta_non_katolik' => $pendidikan18,
                'masih_di_perguruan_tinggi_non_katolik_d' => $pendidikan19,
                'masih_di_perguruan_tinggi_non_katolik_s1' => $pendidikan20,
                'masih_di_perguruan_tinggi_non_katolik_s2' => $pendidikan21,
                'masih_di_perguruan_tinggi_non_katolik_s3' => $pendidikan22,
                'usia_7_sampai_12_tidak_sekolah' => $pendidikan23,
                'usia_13_sampai_15_tidak_sekolah' => $pendidikan24,
                'buta_aksara' => $pendidikan25,
        ];

        //Request lagi yang lain
        $dataUmat['bar_ekonomi'] = $barEkonomi;
        $dataUmat['status_krisma'] = $statusKrisma;
        $dataUmat['status_baptis'] = $statusBaptis;
        $dataUmat['pie_prosentase_ekonomi'] = $pieProsentaseEkonomi;
        $dataUmat['pie_prosentase_perkawinan'] = $pieProsentasePerkawinan;
        $dataUmat['pie_prosentase_pendidikan'] = $pieProsentasePendidikan;

        return response()->json([
            'items' => $dataUmat,
        ]);
    }
}
