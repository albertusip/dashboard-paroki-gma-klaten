<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Umat extends Model
{
    protected $table = 'umat';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_umat',
        'id_keuskupan',
        'id_paroki',
        'id_wilayah',
        'id_lingkungan',
        'alamat',
        'tempat_nikah',
        'tgl_nikah',
        'liber_matrimonium',
        'id_ekonomi',
        'id_jenis_rt',
        'np',
        'no_urut',
        'no_ktp',
        'nama_anggota_rt',
        'id_agama',
        'tempat_lahir',
        'tgl_lahir',
        'jen_kel',
        'id_hub_kk',
        'id_suku',
        'id_pendidikan',
        'id_bidstudi',
        'id_pekerjaan',
        'id_goldar',
        'id_sts_sehat',
        'tgl_upd_sts_sehat',
        'id_wkt_baptis',
        'tempat_baptis',
        'tgl_baptis',
        'status_krisma',
        'tempat_krisma',
        'tgl_krisma',
        'id_sts_kawin',
        'id_jbt_sosial',
        'tmp_tinggal',
        'tahun_mulai_tinggal',
        'status_komuni',
        'id_sts_gerejawi',
        'id_keterlibatan',
        'liberbap',
        'notum',
        'tgl_update'
    ];

    public function getCard()
    {
        $krisma = $this->with('ekonomi')
                            ->where(function($query){
                                $query->where('status_krisma', '=', 'SDH');
                            })
                            ->get()->count();
        $baptis = $this->with('ekonomi')
                            ->where(function($query){
                                $query->where('tempat_baptis', '!=', 'TDK')
                                ->where('tempat_baptis', '!=','BLM')
                                ->where('tempat_baptis','!=','');
                            })
                            ->get()->count();
        // $panggilanImam = $this->with('ekonomi')
        //                     ->where('status_krisma', '=', 'SDH')
        //                     ->get()->count();

        return [
            'data' => [
                'krisma' => $krisma,
                'baptis' => $baptis,
            ]
        ];
    }

    public function ekonomi () {
        return $this->belongsTo(Ekonomi::class,'id_ekonomi', 'id_ekonomi');
    }

    public function getEconomyChartByYear($id_wilayah)
    {
        $results = $this->with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', '>=', date('Y') - 10)
                        ->where('id_wilayah', $id_wilayah)
                        ->groupBy('year', 'id_ekonomi')
                        ->get();
        $dataEkonomi = [];
        foreach ($results as $key => $value) {
            
            $dataEkonomi[$value->year][$value->id_ekonomi]['kriteria'] = $value->ekonomi->kriteria_ekonomi;
            $dataEkonomi[$value->year][$value->id_ekonomi]['total'] = $value->total;
        }
        
        $filteredData = [];
        $kriteriaEkonomi = ['Bisa Membantu', 'Biasa', 'Perlu Dibantu'];
        foreach ($dataEkonomi as $key => $value) {
            $temp = [];
            foreach ($value as $item) {
                $temp[snake_case($item['kriteria'])] = $item['total']; 
            }

            foreach ($kriteriaEkonomi as $kriteria) {
                if(empty($temp[snake_case($kriteria)])) {
                    $temp[snake_case($kriteria)] = 0;
                }
            }
            $filteredData[] = [
                'year' => $key,
                'data' => $temp
            ];
        }
        return $filteredData;
    }

    public function getCurrentYearChart($id_wilayah){
        $results = $this->with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%M') month"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        ->whereYear('tgl_update', '2018')
                        ->orderBy('tgl_update', 'asc')
                        ->groupBy('month', 'id_ekonomi')
                        ->get();
        // dd($results);
        $dataEkonomi = [];
        
        foreach($results as $result){
            
            $dataEkonomi[$result->month][$result->id_ekonomi]['kriteria'] = $result->ekonomi->kriteria_ekonomi;
            $dataEkonomi[$result->month][$result->id_ekonomi]['total'] = $result->total;
        } 
        
        $response = [];
        $kriteriaEkonomi = ['Bisa Membantu', 'Biasa', 'Perlu Dibantu'];

        foreach($dataEkonomi as $key => $value){
            $temp = [];

            foreach ($value as $item){
                $temp[snake_case($item['kriteria'])] = $item['total'];
            }

            foreach($kriteriaEkonomi as $kriteria){
                if (empty($temp[snake_case($kriteria)])){
                    $temp[snake_case($kriteria)] = 0;
                }
            }

            $response[] = [
                'month' => $key,
                'data' => $temp
            ];
        }

        return $response;
    }

    public function getCurrentEconomyChart($id_wilayah){
        $constraintResults = $this->with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        // ->whereYear('tgl_update', date('Y'))
                        ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_ekonomi')
                        ->get()
                        ->groupBy('year')
                        ->toArray();
        $results = $this->with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        // ->whereYear('tgl_update', date('Y'))
                        ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_ekonomi')
                        ->get()
                        ->groupBy('year')
                        ->toArray();

        return [
            // 'year' => date('Y'),
            'year' => '2018',
            'data' => [
                // 'biasa' => $constraintResults[date('Y')][1]['total'],
                // 'bisa_membantu' => $constraintResults[date('Y')][0]['total'],
                // 'perlu_dibantu' => $constraintResults[date('Y')][2]['total'],
                // 'total_semua_wilayah_bisa_membantu' => $results[date('Y')][0]['total'],
                // 'total_semua_wilayah_biasa' => $results[date('Y')][1]['total'],
                // 'total_semua_wilayah_perlu_dibantu' => $results[date('Y')][2]['total'],
                
                'bisa_membantu' => $constraintResults['2018'][0]['total'],
                'biasa' => $constraintResults['2018'][1]['total'],
                'perlu_dibantu' => $constraintResults['2018'][2]['total'],
                'total_semua_wilayah_bisa_membantu' => $results['2018'][0]['total'],
                'total_semua_wilayah_biasa' => $results['2018'][1]['total'],
                'total_semua_wilayah_perlu_dibantu' => $results['2018'][2]['total'],
            ]
        ];
    }

    public function statusPerkawinan () {
        return $this->belongsTo(StatusPerkawinan::class,'id_sts_kawin', 'id_sts_kawin');
    }

    public function getPerkawinanChartByYear($id_wilayah)
    {
        $results = $this->with('statusPerkawinan')
                        ->whereHas('statusPerkawinan')
                        ->select('id_sts_kawin', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', '>=', date('Y') - 10)
                        ->where('id_wilayah', $id_wilayah)
                        ->groupBy('year', 'id_sts_kawin')
                        ->get();
        $dataPerkawinan = [];
        foreach ($results as $key => $value) {
            $dataPerkawinan[$value->year][$value->id_sts_kawin]['status_perkawinan'] = str_replace('/',' ', $value->statusPerkawinan->deskripsi_sts_kawin);

            
            $dataPerkawinan[$value->year][$value->id_sts_kawin]['total'] = $value->total;
        }
        
        $filteredData = [];
        $statusPerkawinan = ['Belum Nikah', 
                            'Sah Katolik', 
                            'Sah Beda Agama', 
                            'Sah Beda Gereja', 
                            'Nikah di Luar Gereja', 
                            'Ditinggal pasangannya',
                            'Krisis berkepanjangan',
                            'Janda Duda Mati',
                            'Rm Br Sr dari Paroki',
                            'Rm Br Sr bekerja di Paroki',
                            'Hidup Bersama Tanpa Ikatan',
                            'Nikah Adat'
                            ];
        foreach ($dataPerkawinan as $key => $value) {
            $temp = [];
            foreach ($value as $item) {
                $temp[snake_case($item['status_perkawinan'])] = $item['total']; 
            }

            foreach ($statusPerkawinan as $status) {
                
                if(empty($temp[snake_case($status)])) {
                    $temp[snake_case($status)] = 0;
                }
            }
            $filteredData[] = [
                'year' => $key,
                'data' => $temp
            ];
        }
        
        return $filteredData;
    }

    public function getPerkawinanCurrentYearChart($id_wilayah){
        $results = $this->with('statusPerkawinan')
                        ->whereHas('statusPerkawinan')
                        ->select('id_sts_kawin', DB::raw("DATE_FORMAT(tgl_update, '%M') month"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        ->whereYear('tgl_update', '2018')
                        ->orderBy('tgl_update', 'asc')
                        ->groupBy('month', 'id_sts_kawin')
                        ->get();
        // dd($results);
        $dataPerkawinan = [];

        foreach($results as $result){
            $dataPerkawinan[$result->month][$result->id_sts_kawin]['status_perkawinan'] = str_replace('/',' ', $result->statusPerkawinan->deskripsi_sts_kawin);
            $dataPerkawinan[$result->month][$result->id_sts_kawin]['total'] = $result->total;
        } 

        $response = [];
        $statusPerkawinan = ['Belum Nikah', 
                            'Sah Katolik', 
                            'Sah Beda Agama', 
                            'Sah Beda Gereja', 
                            'Nikah di Luar Gereja', 
                            'Ditinggal pasangannya',
                            'Krisis berkepanjangan',
                            'Janda Duda Mati',
                            'Rm Br Sr dari Paroki',
                            'Rm Br Sr bekerja di Paroki',
                            'Hidup Bersama Tanpa Ikatan',
                            'Nikah Adat'
                            ];

        foreach($dataPerkawinan as $key => $value){
            $temp = [];

            foreach ($value as $item){
                $temp[snake_case($item['status_perkawinan'])] = $item['total'];
            }

            foreach($statusPerkawinan as $status){
                if (empty($temp[snake_case($status)])){
                    $temp[snake_case($status)] = 0;
                }
            }

            $response[] = [
                'month' => $key,
                'data' => $temp
            ];
        }

        return $response;
    }

    public function getCurrentPerkawinanChart($id_wilayah){
        $constraintResults = $this->with('statusPerkawinan')
                        ->whereHas('statusPerkawinan')
                        ->select('id_sts_kawin', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        // ->whereYear('tgl_update', date('Y'))
                        ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_sts_kawin')
                        ->get()
                        ->groupBy('year')
                        ->toArray();

        $results = $this->with('statusPerkawinan')
                        ->whereHas('statusPerkawinan')
                        ->select('id_sts_kawin', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        // ->whereYear('tgl_update', date('Y'))
                        ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_sts_kawin')
                        ->get()
                        ->groupBy('year')
                        ->toArray();

        // $dataPerkawinan = [];

        // foreach($results as $result){
        //     $dataPerkawinan[$result->month][$result->id_sts_kawin]['status_perkawinan'] = str_replace('/',' ', $result->statusPerkawinan->deskripsi_sts_kawin);
        //     $dataPerkawinan[$result->month][$result->id_sts_kawin]['total'] = $result->total;
        // } 

        // $response = [];
        // $statusPerkawinan = ['Belum Nikah', 
        //                     'Sah Katolik', 
        //                     'Sah Beda Agama', 
        //                     'Sah Beda Gereja', 
        //                     'Nikah di Luar Gereja', 
        //                     'Ditinggal pasangannya',
        //                     'Krisis berkepanjangan',
        //                     'Janda Duda Mati',
        //                     'Rm Br Sr dari Paroki',
        //                     'Rm Br Sr bekerja di Paroki',
        //                     'Hidup Bersama Tanpa Ikatan',
        //                     'Nikah Adat'
        //                     ];

        // foreach($dataPerkawinan as $key => $value){
        //     $temp = [];

        //     foreach ($value as $item){
        //         $temp[snake_case($item['status_perkawinan'])] = $item['total'];
        //     }

        //     foreach($statusPerkawinan as $status){
        //         if (empty($temp[snake_case($status)])){
        //             $temp[snake_case($status)] = 0;
        //         }
        //     }

        //     $response[] = [
        //         'month' => $key,
        //         'data' => $temp
        //     ];
        // }

        return [
            // 'year' => date('Y'),
            'year' => '2018',
            'data' => [
                // 'belum_nikah' => $constraintResults['Y'][0]['total'], 
                // 'sah_katolik' => $constraintResults['Y'][1]['total'], 
                // 'sah_beda_agama' => $constraintResults['Y'][2]['total'], 
                // 'sah_beda_gereja' => $constraintResults['Y'][3]['total'], 
                // 'nikah_di_luar_gereja' => $constraintResults['Y'][4]['total'], 
                // 'ditinggal_pasangannya' => $constraintResults['Y'][5]['total'],
                // 'krisis_berkepanjangan' => $constraintResults['Y'][6]['total'],
                // 'janda_duda_mati' => $constraintResults['Y'][7]['total'],
                // 'rm_br_sr_dari_paroki' => $constraintResults['Y'][8]['total'],
                // 'rm_br_sr_bekerja_di_paroki' => $constraintResults['Y'][9]['total'],
                // 'hidup_bersama_tanpa_ikatan' => $constraintResults['Y'][10]['total'],
                // 'nikah_adat' => $constraintResults['Y'][11]['total'],

                // 'total_semua_wilayah_belum_nikah' => $results['Y'][0]['total'], 
                // 'total_semua_wilayah_sah_katolik' => $results['Y'][1]['total'], 
                // 'total_semua_wilayah_sah_beda_agama' => $results['Y'][2]['total'], 
                // 'total_semua_wilayah_sah_beda_gereja' => $results['Y'][3]['total'], 
                // 'total_semua_wilayah_nikah_di_luar_gereja' => $results['Y'][4]['total'], 
                // 'total_semua_wilayah_ditinggal_pasangannya' => $results['Y'][5]['total'],
                // 'total_semua_wilayah_krisis_berkepanjangan' => $results['Y'][6]['total'],
                // 'total_semua_wilayah_janda_duda_mati' => $results['Y'][7]['total'],
                // 'total_semua_wilayah_rm_br_sr_dari_paroki' => $results['Y'][8]['total'],
                // 'total_semua_wilayah_rm_br_sr_bekerja_di_paroki' => $results['Y'][9]['total'],
                // 'total_semua_wilayah_hidup_bersama_tanpa_ikatan' => $results['Y'][10]['total'],
                // 'total_semua_wilayah_nikah_adat' => $results['Y'][11]['total'],

                'belum_nikah' => $constraintResults['2018'][0]['total'], 
                'sah_katolik' => $constraintResults['2018'][1]['total'], 
                'sah_beda_agama' => $constraintResults['2018'][2]['total'], 
                'sah_beda_gereja' => $constraintResults['2018'][3]['total'], 
                'nikah_di_luar_gereja' => $constraintResults['2018'][4]['total'], 
                'ditinggal_pasangannya' => $constraintResults['2018'][5]['total'],
                'krisis_berkepanjangan' => $constraintResults['2018'][6]['total'],
                'janda_duda_mati' => $constraintResults['2018'][7]['total'],
                'rm_br_sr_dari_paroki' => $constraintResults['2018'][8]['total'],
                'rm_br_sr_bekerja_di_paroki' => $constraintResults['2018'][9]['total'],
                'hidup_bersama_tanpa_ikatan' => $constraintResults['2018'][10]['total'],
                'nikah_adat' => $constraintResults['2018'][11]['total'],

                'total_semua_wilayah_belum_nikah' => $results['2018'][0]['total'], 
                'total_semua_wilayah_sah_katolik' => $results['2018'][1]['total'], 
                'total_semua_wilayah_sah_beda_agama' => $results['2018'][2]['total'], 
                'total_semua_wilayah_sah_beda_gereja' => $results['2018'][3]['total'], 
                'total_semua_wilayah_nikah_di_luar_gereja' => $results['2018'][4]['total'], 
                'total_semua_wilayah_ditinggal_pasangannya' => $results['2018'][5]['total'],
                'total_semua_wilayah_krisis_berkepanjangan' => $results['2018'][6]['total'],
                'total_semua_wilayah_janda_duda_mati' => $results['2018'][7]['total'],
                'total_semua_wilayah_rm_br_sr_dari_paroki' => $results['2018'][8]['total'],
                'total_semua_wilayah_rm_br_sr_bekerja_di_paroki' => $results['2018'][9]['total'],
                'total_semua_wilayah_hidup_bersama_tanpa_ikatan' => $results['2018'][10]['total'],
                'total_semua_wilayah_nikah_adat' => $results['2018'][11]['total'],
            ]
        ];
    }

    public function pendidikan () {
        return $this->belongsTo(Pendidikan::class,'id_pendidikan', 'id_pendidikan');
    }

    

    
}
