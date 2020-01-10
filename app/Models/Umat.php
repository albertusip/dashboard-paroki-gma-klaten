<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
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

    public function wilayah () {
        return $this->belongsTo(Wilayah::class,'id_wilayah', 'id_wilayah');
    }
    public function kesehatan () {
        return $this->belongsTo(StatusKesehatan::class,'id_sts_sehat', 'id_sts_sehat');
    }

    public function getCard() {
        $umatHidup = $this->whereNotIn('id_sts_sehat', ['99', ''])
                            ->get()->count();
        $baptis = $this->whereNotIn('id_wkt_baptis', ['09', '10'])
                            ->get()->count();
        $krisma = $this->whereIn('status_krisma', ['SDH'])
                            ->get()->count();
        $panggilanImam = $this->whereIn('id_sts_kawin', ['09', '10'])
                                ->get()->count();
        
        return [
            'data' => [
                'umatHidup'      => ['Total Umat Hidup', $umatHidup],
                'baptis'         => ['Umat Sudah Baptis', $baptis],
                'krisma'         => ['Umat Sudah Krisma', $krisma],
                'panggilan_imam' => ['Panggilan Imam', $panggilanImam]
            ]
        ];
    }


    public function ekonomi () {
        return $this->belongsTo(Ekonomi::class,'id_ekonomi', 'id_ekonomi');
    }

    public function getCurrentYearEkonomiChart($id_wilayah){
        $results = $this->with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%M') month"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        ->where('no_urut', 1)
                        ->whereYear('tgl_update', '2018')
                        ->orderBy('tgl_update', 'asc')
                        ->groupBy('month', 'id_ekonomi')
                        ->get();
        
        $dataEkonomi = [];
        foreach($results as $result){
            $dataEkonomi[$result->month][$result->id_ekonomi]['kriteria'] = $result->ekonomi->kriteria_ekonomi;
            $dataEkonomi[$result->month][$result->id_ekonomi]['total'] = $result->total;
        } 
        
        $response = [];
        $kriteriaEkonomi = ['Bisa Membantu', 'Biasa', 'Perlu Dibantu'];

        $dataEkonomi = array_map(function($item){
                $kriteria = [
                    'Bisa Membantu',
                    'Biasa',
                    'Perlu Dibantu'
                ];

                for($i = 1; $i<=3; $i++){
                    $key = '0'.$i;
                    
                    if(!array_key_exists($key,$item)){

                        $tmp = [
                            $key => [
                                'kriteria' => $kriteria[$i-1],
                                'total' => 0
                            ]
                        ];

                         $item = array_merge($item, $tmp);
                    }
                };
               
                return $item;
            },$dataEkonomi);

        $i = 0;
        $keys = array_keys($dataEkonomi);
 
        foreach($dataEkonomi as $key => $value){
            $temp = [];
            $selisih = [];
            
            foreach ($value as $key2 => $item){
                
                $temp[snake_case($item['kriteria'])] = $item['total'];
                if($i == 0){
                    $selisih[snake_case($item['kriteria'])] = 0;
                } else {
                    $comp = $dataEkonomi[$keys[$i - 1]];
                    $selisih[snake_case($item['kriteria'])] = $item['total'] - $comp[$key2]['total'];
                }     
            }

            foreach($kriteriaEkonomi as $kriteria){
                if (empty($temp[snake_case($kriteria)])){
                    $temp[snake_case($kriteria)] = 0;
                }
            }
            
            $response[] = [
                'month' => $key,
                'data' => $temp,
                'selisih' => $selisih
            ];
            $i++;
        }

        return $response;
    }

    public function getCurrentWilayahEkonomiChart($id_wilayah){
        $results = $this->with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi',
                                DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), 
                                DB::raw('count(*) as total')
                                )
                        ->where('id_wilayah', $id_wilayah)
                        ->where('no_urut', 1)
                        // ->whereYear('tgl_update', date('Y'))
                        ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_ekonomi')
                        ->get();
        $dataEkonomi = [];
        foreach($results as $result){
            
                $dataEkonomi[$result->year][$result->id_ekonomi]['kriteria'] = $result->ekonomi->kriteria_ekonomi;
                $dataEkonomi[$result->year][$result->id_ekonomi]['total'] = $result->total;
        } 
        
        $response = [];
        $kriteriaEkonomi = [ 
                            'Bisa Membantu', 
                            'Biasa', 
                            'Perlu Dibantu'
                            ];

        foreach($dataEkonomi as $key => $value){
            $temp = [];

            foreach ($value as $item){
                $temp[snake_case($item['kriteria'])] = $item['total'];
            }
            
            foreach($kriteriaEkonomi as $status){
                if (empty($temp[snake_case($status)])){
                    $temp[snake_case($status)] = 0;
                }
            }

            $response = $temp;
        }
        
        return $response;
    }

    public function getCurrentWilayahEkonomiChartDetail($id_wilayah, $id_ekonomi){
        $results = $this->with('ekonomi')
                        ->with('kesehatan')
                        ->whereHas('ekonomi')
                        ->whereHas('kesehatan')
                        ->select('id_ekonomi',
                                DB::raw("nama_anggota_rt nama"), 
                                DB::raw("tgl_lahir tgl_lahir"), 
                                "id_sts_sehat",
                                )
                        ->where('id_ekonomi', $id_ekonomi)
                        ->where('id_wilayah', $id_wilayah)
                        ->where('no_urut', 1)
                        ->whereYear('tgl_update', '2018')
                        ->get();
        
        return $results;
    }

    public function getAllWilayahEkonomiChart($id_wilayah){
        $results = $this->with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', date('Y'))
                        ->where('no_urut', 1)
                        ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_ekonomi')
                        ->get();
        $dataEkonomi = [];
        
        foreach($results as $result){
                $dataEkonomi[$result->year][$result->id_ekonomi]['kriteria'] = $result->ekonomi->kriteria_ekonomi;
                $dataEkonomi[$result->year][$result->id_ekonomi]['total'] = $result->total;
        } 

        $response = [];
        $kriteriaEkonomi = [ 
                            'Bisa Membantu', 
                            'Biasa', 
                            'Perlu Dibantu'
                            ];

        foreach($dataEkonomi as $key => $value){
            $temp = [];

            foreach ($value as $item){
                $temp[snake_case($item['kriteria'])] = $item['total'];
            }

            foreach($kriteriaEkonomi as $status){
                if (empty($temp[snake_case($status)])){
                    $temp[snake_case($status)] = 0;
                }
            }
            
            $response = $temp;
        }
        
        return $response;
    }


    public function statusPerkawinan () {
        return $this->belongsTo(StatusPerkawinan::class,'id_sts_kawin', 'id_sts_kawin');
    }

    public function getPerkawinanCurrentYearChart($id_wilayah){
        $results = $this->with('statusPerkawinan')
                        ->whereHas('statusPerkawinan')
                        ->select('id_sts_kawin', DB::raw("DATE_FORMAT(tgl_update, '%M') month"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        // ->whereYear('tgl_update', '2018')
                        ->whereYear('tgl_update', date('Y'))
                        ->orderBy('tgl_update', 'asc')
                        ->groupBy('month', 'id_sts_kawin')
                        ->get();
        
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
            // dd($key);
            $response[] = [
                'month' => $key,
                'data' => $temp
            ];
        }

        return $response;
    }

    public function getCurrentWilayahPerkawinanChart($id_wilayah){

        $results = $this->with('statusPerkawinan')
                        ->whereHas('statusPerkawinan')
                        ->select('id_sts_kawin', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        ->whereYear('tgl_update', date('Y'))
                        // ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_sts_kawin')
                        ->get();
        $dataPerkawinan = [];
        
        foreach($results as $result){
            if ($result->id_sts_kawin == '02' || $result->id_sts_kawin == '03' || $result->id_sts_kawin == '04') {
                $dataPerkawinan[$result->year][$result->id_sts_kawin]['status_perkawinan'] = str_replace('/',' ', $result->statusPerkawinan->deskripsi_sts_kawin);
                $dataPerkawinan[$result->year][$result->id_sts_kawin]['total'] = $result->total;
            }
        } 
        
        $response = [];
        $statusPerkawinan = [ 
                            'Sah Katolik', 
                            'Sah Beda Agama', 
                            'Sah Beda Gereja',
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
            
            $response = $temp;
        }
        
        return $response;
    }

    public function getAllWilayahPerkawinanChart($id_wilayah){
        $results = $this->with('statusPerkawinan')
                        ->whereHas('statusPerkawinan')
                        ->select('id_sts_kawin', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', date('Y'))
                        // ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_sts_kawin')
                        ->get();
        
        $dataPerkawinan = [];
        
        foreach($results as $result){
            if ($result->id_sts_kawin == '02' || $result->id_sts_kawin == '03' || $result->id_sts_kawin == '04') {
                $dataPerkawinan[$result->year][$result->id_sts_kawin]['deskripsi_perkawinan'] = $result->statusPerkawinan->deskripsi_sts_kawin;
                $dataPerkawinan[$result->year][$result->id_sts_kawin]['status_perkawinan'] = str_replace('/',' ', $result->statusPerkawinan->deskripsi_sts_kawin);
                $dataPerkawinan[$result->year][$result->id_sts_kawin]['total'] = $result->total;
            }
        } 

        $response = [];
        $statusPerkawinan = [ 
                            'Sah Katolik', 
                            'Sah Beda Agama', 
                            'Sah Beda Gereja',
                            ];

        foreach($dataPerkawinan as $key => $value){
            $temp = [];

            foreach ($value as $item){
                $temp[snake_case($item['deskripsi_perkawinan'])] = $item['deskripsi_perkawinan'];
                $temp[snake_case($item['status_perkawinan'])] = $item['total'];
            }

            foreach($statusPerkawinan as $status){
                if (empty($temp[snake_case($status)])){
                    $temp[snake_case($status)] = 0;
                }
            }

            $response = $temp;
        }
        return $response;
    }


    

    public function getCurrentYearKesehatanChart($id_wilayah){
        $results = $this->with('kesehatan')
                        ->whereHas('kesehatan')
                        ->select('id_sts_sehat', DB::raw("DATE_FORMAT(tgl_update, '%M') month"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        // ->whereYear('tgl_update', '2018')
                        ->whereYear('tgl_update', date('Y'))
                        ->orderBy('tgl_update', 'asc')
                        ->groupBy('month', 'id_sts_sehat')
                        ->get();
        
        $dataKesehatan = [];
        
        foreach($results as $value){
            
            if ($value->id_sts_sehat != '99') {
                $dataKesehatan[$value->month][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->month][$value->id_sts_sehat]['status_kesehatan'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->month][$value->id_sts_sehat]['total'] = $value->total;
            }
        } 
        
        $response = [];
        $statusKesehatan = ['Normal', 
                            'Cacat Fisik', 
                            'Buta', 
                            'Bisu Tuli', 
                            'Sulit Mengurus Diri', 
                            'Kesulitan Mengingat',
                            'Penyakit kronis',
                            'Pikun'
                            ];

        foreach ($dataKesehatan as $key => $value) {
            $temp = [];

            foreach ($value as $item){
                $temp[snake_case($item['status_kesehatan'])] = $item['total'];
            }

            foreach($statusKesehatan as $status){
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

    public function getCurrentWilayahKesehatanChart($id_wilayah){
        $results = $this->with('kesehatan')
                        ->whereHas('kesehatan')
                        ->select('id_sts_sehat', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        ->whereYear('tgl_update', date('Y'))
                        // ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_sts_sehat')
                        ->get();
        $dataKesehatan = [];
        
        foreach($results as $value){
            if ($value->id_sts_sehat != '99') {
                $dataKesehatan[$value->year][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['status_kesehatan'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->year][$value->id_sts_sehat]['total'] = $value->total;
            }
            
        } 
        
        $response = [];
        $statusKesehatan = ['Normal', 
                            'Cacat Fisik', 
                            'Buta', 
                            'Bisu Tuli', 
                            'Sulit Mengurus Diri', 
                            'Kesulitan Mengingat',
                            'Penyakit kronis',
                            'Pikun'
                            ];

        foreach ($dataKesehatan as $key => $value) {
            $temp = [];

            foreach ($value as $item){
                $temp[snake_case($item['status_kesehatan'])] = $item['total'];
            }

            foreach($statusKesehatan as $status){
                if (empty($temp[snake_case($status)])){
                    $temp[snake_case($status)] = 0;
                }
            }
            
            $response = $temp;
        }
        
        return $response;
    }

    public function getAllWilayahKesehatanChart($id_wilayah){
        $results = $this->with('kesehatan')
                        ->whereHas('kesehatan')
                        ->select('id_sts_sehat', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', date('Y'))
                        // ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_sts_sehat')
                        ->get();
        $dataKesehatan = [];
        
        foreach($results as $value){
            if ($value->id_sts_sehat != '99') {
                $dataKesehatan[$value->year][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['status_kesehatan'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->year][$value->id_sts_sehat]['total'] = $value->total;
            }
            
        } 
        
        $response = [];
        $statusKesehatan = ['Normal', 
                            'Cacat Fisik', 
                            'Buta', 
                            'Bisu Tuli', 
                            'Sulit Mengurus Diri', 
                            'Kesulitan Mengingat',
                            'Penyakit kronis',
                            'Pikun'
                            ];

        foreach ($dataKesehatan as $key => $value) {
            $temp = [];

            foreach ($value as $item){
                $temp[snake_case($item['status_kesehatan'])] = $item['total'];
            }

            foreach($statusKesehatan as $status){
                if (empty($temp[snake_case($status)])){
                    $temp[snake_case($status)] = 0;
                }
            }
            
            $response = $temp;
        }
        
        return $response;
    }

    public function baptis () {
        return $this->belongsTo(StatusBaptis::class,'id_wkt_baptis', 'id_wkt_baptis');
    }

    public function getCurrentYearBaptisChart($id_wilayah){
        $results = $this->with('baptis')
                        ->whereHas('baptis')
                        ->select('id_wkt_baptis', DB::raw("DATE_FORMAT(tgl_update, '%M') month"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        // ->whereYear('tgl_update', '2018')
                        ->whereYear('tgl_update', date('Y'))
                        ->orderBy('tgl_update', 'asc')
                        ->groupBy('month', 'id_wkt_baptis')
                        ->get();
        
        $dataBaptis = [];
        
        foreach($results as $value){
            
            if ($value->id_wkt_baptis == '01') {
                $dataBaptis[$value->month][$value->id_wkt_baptis]['id'] = $value->id_wkt_baptis;
                $dataBaptis[$value->month][$value->id_wkt_baptis]['baptis_bayi'] = str_replace('/',' ', $value->baptis->deskripsi_wkt_baptis);
                $dataBaptis[$value->month][$value->id_wkt_baptis]['total'] = $value->total;
            } else if ($value->id_wkt_baptis != '01' && $value->id_wkt_baptis != '09' && $value->id_wkt_baptis != '10') {
                $dataBaptis[$value->month][$value->id_wkt_baptis]['id'] = $value->id_wkt_baptis;
                $dataBaptis[$value->month][$value->id_wkt_baptis]['baptis_dewasa'] = str_replace('/',' ', $value->baptis->deskripsi_wkt_baptis);
                $dataBaptis[$value->month][$value->id_wkt_baptis]['total'] = $value->total;
            } else {
                $dataBaptis[$value->month][$value->id_wkt_baptis]['id'] = $value->id_wkt_baptis;
                $dataBaptis[$value->month][$value->id_wkt_baptis]['belum_baptis'] = str_replace('/',' ', $value->baptis->deskripsi_wkt_baptis);
                $dataBaptis[$value->month][$value->id_wkt_baptis]['total'] = $value->total;
            }
        } 
        
        $response = [];
        $statusBaptis = [
                        'baptis_bayi',
                        'baptis_dewasa',
                        'belum_baptis'
                    ];
        foreach ($dataBaptis as $key => $value) {
            $temp = [];
            $tempTotalBaptisBayi = 0;
            $tempTotalBaptisDewasa = 0;
            $tempTotalBelumBaptis = 0;
            
            foreach ($value as $item) {
                if ($item['id'] == '01') {
                    $tempTotalBaptisBayi += $item['total'];
                } else if ($item['id'] != '01' && $item['id'] != '09' && $item['id'] != '10') {
                    $tempTotalBaptisDewasa += $item['total'];
                } else {
                    $tempTotalBelumBaptis += $item['total'];
                }

                $temp['baptis_bayi'] = $tempTotalBaptisBayi;
                $temp['baptis_dewasa'] = $tempTotalBaptisDewasa;
                $temp['belum_baptis'] = $tempTotalBelumBaptis;
            }

            foreach ($statusBaptis as $status) {
                if(empty($temp[snake_case($status)])) {
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

    public function getCurrentWilayahBaptisChart($id_wilayah){
        $results = $this->with('baptis')
                        ->whereHas('baptis')
                        ->select('id_wkt_baptis', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        ->whereYear('tgl_update', date('Y'))
                        // ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_wkt_baptis')
                        ->get();
        $dataBaptis = [];
        
        foreach($results as $value){

            if ($value->id_wkt_baptis == '01') {
                $dataBaptis[$value->year][$value->id_wkt_baptis]['id'] = $value->id_wkt_baptis;
                $dataBaptis[$value->year][$value->id_wkt_baptis]['baptis_bayi'] = str_replace('/',' ', $value->baptis->deskripsi_wkt_baptis);
                $dataBaptis[$value->year][$value->id_wkt_baptis]['total'] = $value->total;
            } else if ($value->id_wkt_baptis != '01' && $value->id_wkt_baptis != '09' && $value->id_wkt_baptis != '10') {
                $dataBaptis[$value->year][$value->id_wkt_baptis]['id'] = $value->id_wkt_baptis;
                $dataBaptis[$value->year][$value->id_wkt_baptis]['baptis_dewasa'] = str_replace('/',' ', $value->baptis->deskripsi_wkt_baptis);
                $dataBaptis[$value->year][$value->id_wkt_baptis]['total'] = $value->total;
            } else {
                $dataBaptis[$value->year][$value->id_wkt_baptis]['id'] = $value->id_wkt_baptis;
                $dataBaptis[$value->year][$value->id_wkt_baptis]['belum_baptis'] = str_replace('/',' ', $value->baptis->deskripsi_wkt_baptis);
                $dataBaptis[$value->year][$value->id_wkt_baptis]['total'] = $value->total;
            }
            
        } 
        
        $response = [];
        $statusBaptis = [
                        'baptis_bayi',
                        'baptis_dewasa',
                        'belum_baptis'
                    ];
        
        foreach ($dataBaptis as $key => $value) {
            $temp = [];
            $tempTotalBaptisBayi = 0;
            $tempTotalBaptisDewasa = 0;
            $tempTotalBelumBaptis = 0;
            
            foreach ($value as $item) {
                if ($item['id'] == '01') {
                    $tempTotalBaptisBayi += $item['total'];
                } else if ($item['id'] != '01' && $item['id'] != '09' && $item['id'] != '10') {
                    $tempTotalBaptisDewasa += $item['total'];
                } else {
                    $tempTotalBelumBaptis += $item['total'];
                }

                $temp['baptis_bayi'] = $tempTotalBaptisBayi;
                $temp['baptis_dewasa'] = $tempTotalBaptisDewasa;
                $temp['belum_baptis'] = $tempTotalBelumBaptis;
            }

            foreach ($statusBaptis as $status) {
                if(empty($temp[snake_case($status)])) {
                    $temp[snake_case($status)] = 0;
                }
            }
            
            $response = $temp;
        }
        
        return $response;
    }

    public function getAllWilayahBaptisChart($id_wilayah){
        $results = $this->with('baptis')
                        ->whereHas('baptis')
                        ->select('id_wkt_baptis', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', date('Y'))
                        // ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_wkt_baptis')
                        ->get();
        $dataBaptis = [];
        
        foreach($results as $value){
            if ($value->id_wkt_baptis == '01') {
                $dataBaptis[$value->year][$value->id_wkt_baptis]['id'] = $value->id_wkt_baptis;
                $dataBaptis[$value->year][$value->id_wkt_baptis]['baptis_bayi'] = str_replace('/',' ', $value->baptis->deskripsi_wkt_baptis);
                $dataBaptis[$value->year][$value->id_wkt_baptis]['total'] = $value->total;
            } else if ($value->id_wkt_baptis != '01' && $value->id_wkt_baptis != '09' && $value->id_wkt_baptis != '10') {
                $dataBaptis[$value->year][$value->id_wkt_baptis]['id'] = $value->id_wkt_baptis;
                $dataBaptis[$value->year][$value->id_wkt_baptis]['baptis_dewasa'] = str_replace('/',' ', $value->baptis->deskripsi_wkt_baptis);
                $dataBaptis[$value->year][$value->id_wkt_baptis]['total'] = $value->total;
            } else {
                $dataBaptis[$value->year][$value->id_wkt_baptis]['id'] = $value->id_wkt_baptis;
                $dataBaptis[$value->year][$value->id_wkt_baptis]['belum_baptis'] = str_replace('/',' ', $value->baptis->deskripsi_wkt_baptis);
                $dataBaptis[$value->year][$value->id_wkt_baptis]['total'] = $value->total;
            }
        } 

        $response = [];
        $statusBaptis = [
                        'baptis_bayi',
                        'baptis_dewasa',
                        'belum_baptis'
                    ];
        foreach ($dataBaptis as $key => $value) {
            $temp = [];
            $tempTotalBaptisBayi = 0;
            $tempTotalBaptisDewasa = 0;
            $tempTotalBelumBaptis = 0;
            
            foreach ($value as $item) {
                if ($item['id'] == '01') {
                    $tempTotalBaptisBayi += $item['total'];
                } else if ($item['id'] != '01' && $item['id'] != '09' && $item['id'] != '10') {
                    $tempTotalBaptisDewasa += $item['total'];
                } else {
                    $tempTotalBelumBaptis += $item['total'];
                }

                $temp['baptis_bayi'] = $tempTotalBaptisBayi;
                $temp['baptis_dewasa'] = $tempTotalBaptisDewasa;
                $temp['belum_baptis'] = $tempTotalBelumBaptis;
            }

            foreach ($statusBaptis as $status) {
                if(empty($temp[snake_case($status)])) {
                    $temp[snake_case($status)] = 0;
                }
            }
            
            $response = $temp;
        }
        
        return $response;
    }

    public function getKelahiranKematianChartAllWilayahByMonth($id_wilayah){
        $resultsKelahiran = $this->with('wilayah')
                                ->whereHas('wilayah')
                                ->select(DB::raw("DATE_FORMAT(tgl_lahir, '%M') monthBase"),DB::raw("DATE_FORMAT(tgl_lahir, '%M') month"), DB::raw('count(*) as total'))
                                // ->whereYear('tgl_lahir', '2018')
                                ->whereYear('tgl_lahir', date('Y'))
                                ->orderBy('tgl_lahir', 'asc')
                                ->groupBy('month', 'monthBase')
                                ->get();

        $resultsKematian = $this->with('kesehatan')
                                ->whereHas('kesehatan')
                                ->select('id_sts_sehat', DB::raw("DATE_FORMAT(tgl_update, '%M') month"), DB::raw('count(*) as total'))
                                // ->whereYear('tgl_update', '2018')
                                ->whereYear('tgl_update', date('Y'))
                                ->orderBy('tgl_update', 'asc')
                                ->groupBy('month', 'id_sts_sehat')
                                ->get();
                        
        $dataKelahiranKematian = [];

        foreach ($resultsKelahiran as $key => $value) {

            $dataKelahiranKematian[$value->month]['0']['status'] = 'total_lahir';
            $dataKelahiranKematian[$value->month]['0']['total_lahir'] = $value->total;
                
        }
        
        foreach ($resultsKematian as $key => $value) {
            
            if ($value->id_sts_sehat == '99') {
                $dataKelahiranKematian[$value->month]['1']['status'] = 'total_mati';
                $dataKelahiranKematian[$value->month]['1']['total_mati'] = $value->total;
            }
                
        }
        
        $response = [];
        $statusData = [
                        'total_lahir',
                        'total_mati'
                    ];
        foreach ($dataKelahiranKematian as $key => $value) {
            $temp = [];

            foreach ($value as $item) {
                
                if ($item['status'] == 'total_lahir') {
                    $temp[snake_case($item['status'])] = $item['total_lahir'];
                } else {
                    $temp[snake_case($item['status'])] = $item['total_mati'];
                }

            }
            
            foreach ($statusData as $stat) {
                if(empty($temp[snake_case($stat)])) {
                    $temp[snake_case($stat)] = 0;
                }
            }

            $response[] = [
                'year' => $key,
                'data' => $temp
            ];
            
        }
        
        return $response;
    }

}
