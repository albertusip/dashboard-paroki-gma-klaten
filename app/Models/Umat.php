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

    public function wilayah () {
        return $this->belongsTo(Wilayah::class,'id_wilayah', 'id_wilayah');
    }

    public function getCard() {
        $krisma = $this->with('wilayah')
                            ->where(function($query){
                                $query->where('status_krisma', '=', 'SDH');
                            })
                            ->get()->count();
        $baptis = $this->with('wilayah')
                        ->whereHas('wilayah')
                            ->where(function($query){
                                $query->where('id_wkt_baptis', '!=', '09')
                                ->where('id_wkt_baptis', '!=','10');
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

    public function getEkonomiChartByYear($id_wilayah){
        $results = $this->with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', '>=', date('Y') - 10)
                        ->whereYear('tgl_update', '<=', date('Y'))
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

    public function getCurrentYearEkonomiChart($id_wilayah){
        $results = $this->with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%M') month"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
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

    public function getCurrentWilayahEkonomiChart($id_wilayah){
        $results = $this->with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
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

    public function getAllWilayahEkonomiChart($id_wilayah){
        $results = $this->with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
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


    public function statusPerkawinan () {
        return $this->belongsTo(StatusPerkawinan::class,'id_sts_kawin', 'id_sts_kawin');
    }

    public function getPerkawinanChartByYear($id_wilayah){
        $results = $this->with('statusPerkawinan')
                        ->whereHas('statusPerkawinan')
                        ->select('id_sts_kawin', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', '>=', date('Y') - 10)
                        ->whereYear('tgl_update', '<=', date('Y'))
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

    public function getCurrentWilayahPerkawinanChart($id_wilayah){

        $results = $this->with('statusPerkawinan')
                        ->whereHas('statusPerkawinan')
                        ->select('id_sts_kawin', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        // ->whereYear('tgl_update', date('Y'))
                        ->whereYear('tgl_update', '2018')
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
                        // ->whereYear('tgl_update', date('Y'))
                        ->whereYear('tgl_update', '2018')
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


    public function kesehatan () {
        return $this->belongsTo(StatusKesehatan::class,'id_sts_sehat', 'id_sts_sehat');
    }

    public function getKesehatanChartByYear($id_wilayah){
        $results = $this->with('kesehatan')
                        ->whereHas('kesehatan')
                        ->select('id_sts_sehat', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', '>=', date('Y') - 10)
                        ->whereYear('tgl_update', '<=', date('Y'))
                        ->where('id_wilayah', $id_wilayah)
                        ->groupBy('year', 'id_sts_sehat')
                        ->get();
                        
        $dataKesehatan = [];
        foreach ($results as $key => $value) {
            
            if ($value->id_sts_sehat != '99') {
                $dataKesehatan[$value->year][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['status_hidup'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->year][$value->id_sts_sehat]['total'] = $value->total;
            } else {
                $dataKesehatan[$value->year][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['status_mati'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->year][$value->id_sts_sehat]['total'] = $value->total;
            }
                
        }
        
        $filteredData = [];
        $statusKesehatan = ['status_hidup'];
        foreach ($dataKesehatan as $key => $value) {
            $temp = [];
            $tempTotalHidup = 0;
            $tempTotalMati = 0;
            
            foreach ($value as $item) {
                if ($item['id'] != '99') {
                    $tempTotalHidup += $item['total'];
                } else {
                    $tempTotalMati += $item['total'];
                }

                $temp['status_hidup'] = $tempTotalHidup;
                $temp['status_mati'] = $tempTotalMati;
            }

            foreach ($statusKesehatan as $status) {
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

    public function getCurrentYearKesehatanChart($id_wilayah){
        $results = $this->with('kesehatan')
                        ->whereHas('kesehatan')
                        ->select('id_sts_sehat', DB::raw("DATE_FORMAT(tgl_update, '%M') month"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        ->whereYear('tgl_update', '2018')
                        ->orderBy('tgl_update', 'asc')
                        ->groupBy('month', 'id_sts_sehat')
                        ->get();
        
        $dataKesehatan = [];
        
        foreach($results as $value){
            
            if ($value->id_sts_sehat != '99') {
                $dataKesehatan[$value->month][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->month][$value->id_sts_sehat]['status_hidup'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->month][$value->id_sts_sehat]['total'] = $value->total;
            } else {
                $dataKesehatan[$value->month][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->month][$value->id_sts_sehat]['status_mati'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->month][$value->id_sts_sehat]['total'] = $value->total;
            }
        } 
        
        $response = [];
        $statusKesehatan = ['status_hidup'];
        foreach ($dataKesehatan as $key => $value) {
            $temp = [];
            $tempTotalHidup = 0;
            $tempTotalMati = 0;
            
            foreach ($value as $item) {
                if ($item['id'] != '99') {
                    $tempTotalHidup += $item['total'];
                } else {
                    $tempTotalMati += $item['total'];
                }

                $temp['status_hidup'] = $tempTotalHidup;
                $temp['status_mati'] = $tempTotalMati;
            }
            
            foreach ($statusKesehatan as $status) {
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

    public function getCurrentWilayahKesehatanChart($id_wilayah){
        $results = $this->with('kesehatan')
                        ->whereHas('kesehatan')
                        ->select('id_sts_sehat', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        // ->whereYear('tgl_update', date('Y'))
                        ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_sts_sehat')
                        ->get();
        $dataEkonomi = [];
        
        foreach($results as $value){
                if ($value->id_sts_sehat != '99') {
                $dataKesehatan[$value->year][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['status_hidup'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->year][$value->id_sts_sehat]['total'] = $value->total;
            } else {
                $dataKesehatan[$value->year][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['status_mati'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->year][$value->id_sts_sehat]['total'] = $value->total;
            }
            
        } 
        
        $response = [];
        $statusKesehatan = ['status_hidup'];
        
        foreach ($dataKesehatan as $key => $value) {
            $temp = [];
            $tempTotalHidup = 0;
            $tempTotalMati = 0;
            
            foreach ($value as $item) {
                if ($item['id'] != '99') {
                    $tempTotalHidup += $item['total'];
                } else {
                    $tempTotalMati += $item['total'];
                }

                $temp['status_hidup'] = $tempTotalHidup;
                $temp['status_mati'] = $tempTotalMati;
            }
            
            foreach ($statusKesehatan as $status) {
                if(empty($temp[snake_case($status)])) {
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
                        // ->whereYear('tgl_update', date('Y'))
                        ->whereYear('tgl_update', '2018')
                        ->groupBy('year', 'id_sts_sehat')
                        ->get();
        $dataEkonomi = [];
        
        foreach($results as $value){
                if ($value->id_sts_sehat != '99') {
                $dataKesehatan[$value->year][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['status_hidup'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->year][$value->id_sts_sehat]['total'] = $value->total;
            } else {
                $dataKesehatan[$value->year][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['status_mati'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->year][$value->id_sts_sehat]['total'] = $value->total;
            }
        } 

        $response = [];
        $statusKesehatan = ['status_hidup'];
        
        foreach ($dataKesehatan as $key => $value) {
            $temp = [];
            $tempTotalHidup = 0;
            $tempTotalMati = 0;
            
            foreach ($value as $item) {
                if ($item['id'] != '99') {
                    $tempTotalHidup += $item['total'];
                } else {
                    $tempTotalMati += $item['total'];
                }

                $temp['status_hidup'] = $tempTotalHidup;
                $temp['status_mati'] = $tempTotalMati;
            }
            
            foreach ($statusKesehatan as $status) {
                if(empty($temp[snake_case($status)])) {
                    $temp[snake_case($status)] = 0;
                }
            }
            
            $response = $temp;
        }
        
        return $response;
    }

    public function getAllDataKesehatanChartByYear($id_wilayah){
        $results = $this->with('kesehatan')
                        ->whereHas('kesehatan')
                        ->select('id_sts_sehat', 'id_wilayah', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', '>=', date('Y') - 10)
                        ->whereYear('tgl_update', '<=', date('Y'))
                        ->groupBy('year', 'id_sts_sehat', 'id_wilayah')
                        ->get();
                        
        $dataKesehatan = [];
        foreach ($results as $key => $value) {
            
            if ($value->id_sts_sehat != '99') {
                $dataKesehatan[$value->year][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['wilayah'] = $value->id_wilayah;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['status_hidup'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->year][$value->id_sts_sehat]['total'] = $value->total;
            } else {
                $dataKesehatan[$value->year][$value->id_sts_sehat]['id'] = $value->id_sts_sehat;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['wilayah'] = $value->id_wilayah;
                $dataKesehatan[$value->year][$value->id_sts_sehat]['status_mati'] = str_replace('/',' ', $value->kesehatan->deskripsi_sts_sehat);
                $dataKesehatan[$value->year][$value->id_sts_sehat]['total'] = $value->total;
            }
                
        }
        
        $filteredData = [];
        $statusKesehatan = ['status_hidup'];
        foreach ($dataKesehatan as $key => $value) {
            $temp = [];
            $tempTotalHidup = 0;
            $tempTotalMati = 0;
            
            foreach ($value as $item) {
                if ($item['id'] != '99') {
                    $tempTotalHidup += $item['total'];
                } else {
                    $tempTotalMati += $item['total'];
                }

                $temp['status_hidup'] = $tempTotalHidup;
                $temp['status_mati'] = $tempTotalMati;
                $temp['wilayah'] = $item['wilayah'];
            }

            foreach ($statusKesehatan as $status) {
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

    public function baptis () {
        return $this->belongsTo(StatusBaptis::class,'id_wkt_baptis', 'id_wkt_baptis');
    }

    public function getBaptisChartByYear($id_wilayah){
        $results = $this->with('baptis')
                        ->whereHas('baptis')
                        ->select('id_wkt_baptis', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', '>=', date('Y') - 10)
                        ->whereYear('tgl_update', '<=', date('Y'))
                        ->where('id_wilayah', $id_wilayah)
                        ->groupBy('year', 'id_wkt_baptis')
                        ->get();
                        
        $dataBaptis = [];
        foreach ($results as $key => $value) {
            
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
        
        $filteredData = [];
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
            $filteredData[] = [
                'year' => $key,
                'data' => $temp
            ];
            
        }
            
        return $filteredData;
    }

    public function getCurrentYearBaptisChart($id_wilayah){
        $results = $this->with('baptis')
                        ->whereHas('baptis')
                        ->select('id_wkt_baptis', DB::raw("DATE_FORMAT(tgl_update, '%M') month"), DB::raw('count(*) as total'))
                        ->where('id_wilayah', $id_wilayah)
                        ->whereYear('tgl_update', '2018')
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
                        // ->whereYear('tgl_update', date('Y'))
                        ->whereYear('tgl_update', '2018')
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
                        // ->whereYear('tgl_update', date('Y'))
                        ->whereYear('tgl_update', '2018')
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

    public function getKelahiranChartWilayahByYear($id_wilayah){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('jen_kel', DB::raw("DATE_FORMAT(tgl_lahir, '%Y') yearBase"),DB::raw("DATE_FORMAT(tgl_lahir, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_lahir', '>=', date('Y') - 10)
                        ->whereYear('tgl_lahir', '<=', date('Y'))
                        ->where('id_wilayah', $id_wilayah)
                        ->groupBy('year', 'yearBase', 'jen_kel')
                        ->get();
                        
        $dataKelahiran = [];
        foreach ($results as $key => $value) {
            
            if ($value->jen_kel == 1) {
                $dataKelahiran[$value->year][$value->jen_kel]['jen_kel'] = 'laki_laki';
                $dataKelahiran[$value->year][$value->jen_kel]['total'] = $value->total;
            } else if ($value->jen_kel == 2) {
                $dataKelahiran[$value->year][$value->jen_kel]['jen_kel'] = 'perempuan';
                $dataKelahiran[$value->year][$value->jen_kel]['total'] = $value->total;
            } else {
                $dataKelahiran[$value->year][$value->jen_kel]['jen_kel'] = 'lain_lain';
                $dataKelahiran[$value->year][$value->jen_kel]['total'] = $value->total;
            }
                
        }
        
        $filteredData = [];
        $jenisKelamin = [
                        'laki_laki',
                        'perempuan',
                        'lain_lain'
                    ];
        foreach ($dataKelahiran as $key => $value) {
            $temp = [];

            foreach ($value as $item) {
                $temp[snake_case($item['jen_kel'])] = $item['total'];
                
            }

            foreach ($jenisKelamin as $jk) {
                if(empty($temp[snake_case($jk)])) {
                    $temp[snake_case($jk)] = 0;
                }
            }

            $filteredData[] = [
                'year' => $key,
                'data' => $temp
            ];
            
        }
        return $filteredData;
    }

    public function getKelahiranChartAllWilayahByYear($id_wilayah){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('jen_kel', DB::raw("DATE_FORMAT(tgl_lahir, '%Y') yearBase"),DB::raw("DATE_FORMAT(tgl_lahir, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_lahir', '>=', date('Y') - 10)
                        ->whereYear('tgl_lahir', '<=', date('Y'))
                        ->groupBy('year', 'yearBase', 'jen_kel')
                        ->get();
                        
        $dataKelahiran = [];
        foreach ($results as $key => $value) {
            
            if ($value->jen_kel == 1) {
                $dataKelahiran[$value->year][$value->jen_kel]['jen_kel'] = 'laki_laki';
                $dataKelahiran[$value->year][$value->jen_kel]['total'] = $value->total;
            } else if ($value->jen_kel == 2) {
                $dataKelahiran[$value->year][$value->jen_kel]['jen_kel'] = 'perempuan';
                $dataKelahiran[$value->year][$value->jen_kel]['total'] = $value->total;
            } else {
                $dataKelahiran[$value->year][$value->jen_kel]['jen_kel'] = 'lain_lain';
                $dataKelahiran[$value->year][$value->jen_kel]['total'] = $value->total;
            }
                
        }
        
        $filteredData = [];
        $jenisKelamin = [
                        'laki_laki',
                        'perempuan',
                        'lain_lain'
                    ];
        foreach ($dataKelahiran as $key => $value) {
            $temp = [];

            foreach ($value as $item) {
                $temp[snake_case($item['jen_kel'])] = $item['total'];
                
            }

            foreach ($jenisKelamin as $jk) {
                if(empty($temp[snake_case($jk)])) {
                    $temp[snake_case($jk)] = 0;
                }
            }

            $filteredData[] = [
                'year' => $key,
                'data' => $temp
            ];
            
        }
        
        return $filteredData;
    }
}
