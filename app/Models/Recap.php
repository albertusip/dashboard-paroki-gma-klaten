<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Recap extends Model
{
    protected $table = 'rekap';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_wilayah',
        'kategori',
        'jumlah',
        'tahun'
    ];

    public function wilayah () {
        return $this->belongsTo(Wilayah::class,'id_wilayah', 'id_wilayah');
    }

    public function getEkonomiChartByYearCurrentWilayah($id_wilayah, $range_tahun){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('kategori as kriteria', 'tahun as year', 'jumlah as total')
                        ->where('tahun', '>=', date('Y') - ($range_tahun - 1))
                        ->where('tahun', '<=', date('Y'))
                        ->where('id_wilayah', $id_wilayah)
                        ->get();
        
        $dataEkonomi = [];
        foreach ($results as $key => $value) {
            if ($value->kriteria == 'bisa_membantu' || $value->kriteria == 'biasa' || $value->kriteria == 'perlu_dibantu') {
                $dataEkonomi[$value->year][$value->kriteria]['kriteria'] = ucwords(str_replace('_',' ', $value->kriteria));
                $dataEkonomi[$value->year][$value->kriteria]['total'] = $value->total;
                $dataEkonomi[$value->year][$value->kriteria]['year'] = $value->year;
            }
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
                'year' => $key,
                'data' => $temp
            ];
        }
        
        return $response;
    }

    public function getEkonomiChartByYearAllWilayah($range_tahun){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('kategori as kriteria', 'tahun as year', DB::raw('sum(jumlah) as total'))
                        ->where('tahun', '>=', date('Y') - ($range_tahun - 1))
                        ->where('tahun', '<=', date('Y'))
                        ->groupBy('year', 'kategori')
                        ->get();
        
        $dataEkonomi = [];
        foreach ($results as $key => $value) {
            if ($value->kriteria == 'bisa_membantu' || $value->kriteria == 'biasa' || $value->kriteria == 'perlu_dibantu') {
                $dataEkonomi[$value->year][$value->kriteria]['kriteria'] = ucwords(str_replace('_',' ', $value->kriteria));
                $dataEkonomi[$value->year][$value->kriteria]['total'] = (int)$value->total;
                $dataEkonomi[$value->year][$value->kriteria]['year'] = $value->year;
            }
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
                'year' => $key,
                'data' => $temp
            ];
        }
        
        return $response;
    }

    public function getPerkawinanChartByYearCurrentWilayah($id_wilayah, $range_tahun){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('kategori as kriteria', 'tahun as year', 'jumlah as total')
                        ->where('tahun', '>=', date('Y') - ($range_tahun - 1))
                        ->where('tahun', '<=', date('Y'))
                        ->where('id_wilayah', $id_wilayah)
                        ->get();
        
        $dataPerkawinan = [];
        foreach ($results as $key => $value) {
            if ($value->kriteria == 'sah_katolik' || $value->kriteria == 'sah_beda_gereja' || $value->kriteria == 'sah_beda_agama') {
                $dataPerkawinan[$value->year][$value->kriteria]['kriteria'] = ucwords(str_replace('_',' ', $value->kriteria));
                $dataPerkawinan[$value->year][$value->kriteria]['total'] = $value->total;
                $dataPerkawinan[$value->year][$value->kriteria]['year'] = $value->year;
            }
                
        }
        
        $response = [];
        $statusPerkawinan = [
                            'Sah Katolik', 
                            'Sah Beda Agama', 
                            'Sah Beda Gereja'
                            ];

        foreach($dataPerkawinan as $key => $value){
            $temp = [];

            foreach ($value as $item){
                $temp[snake_case($item['kriteria'])] = $item['total'];
            }

            foreach($statusPerkawinan as $status){
                if (empty($temp[snake_case($status)])){
                    $temp[snake_case($status)] = 0;
                }
            }

            $response[] = [
                'year' => $key,
                'data' => $temp
            ];
        }
        
        return $response;
    }

    public function getPerkawinanChartByYearAllWilayah($range_tahun){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('kategori as kriteria', 'tahun as year', DB::raw('sum(jumlah) as total'))
                        ->where('tahun', '>=', date('Y') - ($range_tahun - 1))
                        ->where('tahun', '<=', date('Y'))
                        ->groupBy('year', 'kategori')
                        ->get();
        
        $dataPerkawinan = [];
        foreach ($results as $key => $value) {
            if ($value->kriteria == 'sah_katolik' || $value->kriteria == 'sah_beda_gereja' || $value->kriteria == 'sah_beda_agama') {
                $dataPerkawinan[$value->year][$value->kriteria]['kriteria'] = ucwords(str_replace('_',' ', $value->kriteria));
                $dataPerkawinan[$value->year][$value->kriteria]['total'] = (int)$value->total;
                $dataPerkawinan[$value->year][$value->kriteria]['year'] = $value->year;
            }
                
        }
        
        $response = [];
        $statusPerkawinan = [
                            'Sah Katolik', 
                            'Sah Beda Agama', 
                            'Sah Beda Gereja'
                            ];

        foreach($dataPerkawinan as $key => $value){
            $temp = [];

            foreach ($value as $item){
                $temp[snake_case($item['kriteria'])] = $item['total'];
            }

            foreach($statusPerkawinan as $status){
                if (empty($temp[snake_case($status)])){
                    $temp[snake_case($status)] = 0;
                }
            }

            $response[] = [
                'year' => $key,
                'data' => $temp
            ];
        }
        
        return $response;
    }

    public function getKesehatanChartByYearCurrentWilayah($id_wilayah, $range_tahun){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('kategori as kriteria', 'tahun as year', 'jumlah as total')
                        ->where('tahun', '>=', date('Y') - ($range_tahun - 1))
                        ->where('tahun', '<=', date('Y'))
                        ->where('id_wilayah', $id_wilayah)
                        ->get();
        
        $dataKesehatan = [];
        foreach ($results as $key => $value) {
            
            foreach ($results as $key => $value) {
                if (
                    $value->kriteria == 'normal' || 
                    $value->kriteria == 'cacat_fisik' || 
                    $value->kriteria == 'buta'||
                    $value->kriteria == 'bisu_tuli' || 
                    $value->kriteria == 'sulit_mengurus_diri' || 
                    $value->kriteria == 'kesulitan_mengingat'||
                    $value->kriteria == 'penyakit_kronis' || 
                    $value->kriteria == 'pikun'
                    ) {
                    $dataKesehatan[$value->year][$value->kriteria]['kriteria'] = ucwords(str_replace('_',' ', $value->kriteria));
                    $dataKesehatan[$value->year][$value->kriteria]['total'] = $value->total;
                    $dataKesehatan[$value->year][$value->kriteria]['year'] = $value->year;
                }
                    
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
                $temp[snake_case($item['kriteria'])] = $item['total'];
            }

            foreach($statusKesehatan as $status){
                if (empty($temp[snake_case($status)])){
                    $temp[snake_case($status)] = 0;
                }
            }

            $response[] = [
                'year' => $key,
                'data' => $temp
            ];
        }
        
        return $response;
    }

    public function getKesehatanChartByYearAllWilayah($range_tahun){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('kategori as kriteria', 'tahun as year', DB::raw('sum(jumlah) as total'))
                        ->where('tahun', '>=', date('Y') - ($range_tahun - 1))
                        ->where('tahun', '<=', date('Y'))
                        ->groupBy('year', 'kategori')
                        ->get();
        
        $dataKesehatan = [];
        foreach ($results as $key => $value) {
            
            foreach ($results as $key => $value) {
                if (
                    $value->kriteria == 'normal' || 
                    $value->kriteria == 'cacat_fisik' || 
                    $value->kriteria == 'buta'||
                    $value->kriteria == 'bisu_tuli' || 
                    $value->kriteria == 'sulit_mengurus_diri' || 
                    $value->kriteria == 'kesulitan_mengingat'||
                    $value->kriteria == 'penyakit_kronis' || 
                    $value->kriteria == 'pikun'
                    ) {
                    $dataKesehatan[$value->year][$value->kriteria]['kriteria'] = ucwords(str_replace('_',' ', $value->kriteria));
                    $dataKesehatan[$value->year][$value->kriteria]['total'] = (int)$value->total;
                    $dataKesehatan[$value->year][$value->kriteria]['year'] = $value->year;
                }
                    
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
                $temp[snake_case($item['kriteria'])] = $item['total'];
            }

            foreach($statusKesehatan as $status){
                if (empty($temp[snake_case($status)])){
                    $temp[snake_case($status)] = 0;
                }
            }

            $response[] = [
                'year' => $key,
                'data' => $temp
            ];
        }
        
        return $response;
    }

    public function getBaptisChartByYearCurrentWilayah($id_wilayah, $range_tahun){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('kategori as kriteria', 'tahun as year', 'jumlah as total')
                        ->where('tahun', '>=', date('Y') - ($range_tahun - 1))
                        ->where('tahun', '<=', date('Y'))
                        ->where('id_wilayah', $id_wilayah)
                        ->get();
        
        $dataBaptis = [];
        foreach ($results as $key => $value) {
            
            if ($value->kriteria == 'baptis_bayi' ||
                $value->kriteria == 'baptis_dewasa' ||
                $value->kriteria == 'belum_baptis') {
                    $dataBaptis[$value->year][$value->kriteria]['kriteria'] = ucwords(str_replace('_',' ', $value->kriteria));
                    $dataBaptis[$value->year][$value->kriteria]['total'] = $value->total;
                    $dataBaptis[$value->year][$value->kriteria]['year'] = $value->year;
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
            
            foreach ($value as $item) {
                $temp[snake_case($item['kriteria'])] = $item['total'];
            }

            foreach ($statusBaptis as $status) {
                if(empty($temp[snake_case($status)])) {
                    $temp[snake_case($status)] = 0;
                }
            }
            $response[] = [
                'year' => $key,
                'data' => $temp
            ];
        }
        
        return $response;
    }

    public function getBaptisChartByYearAllWilayah($range_tahun){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('kategori as kriteria', 'tahun as year', DB::raw('sum(jumlah) as total'))
                        ->where('tahun', '>=', date('Y') - ($range_tahun - 1))
                        ->where('tahun', '<=', date('Y'))
                        ->groupBy('year', 'kategori')
                        ->get();
        
        $dataBaptis = [];
        foreach ($results as $key => $value) {
            
            if ($value->kriteria == 'baptis_bayi' ||
                $value->kriteria == 'baptis_dewasa' ||
                $value->kriteria == 'belum_baptis') {
                    $dataBaptis[$value->year][$value->kriteria]['kriteria'] = ucwords(str_replace('_',' ', $value->kriteria));
                    $dataBaptis[$value->year][$value->kriteria]['total'] = (int)$value->total;
                    $dataBaptis[$value->year][$value->kriteria]['year'] = $value->year;
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
            
            foreach ($value as $item) {
                $temp[snake_case($item['kriteria'])] = $item['total'];
            }

            foreach ($statusBaptis as $status) {
                if(empty($temp[snake_case($status)])) {
                    $temp[snake_case($status)] = 0;
                }
            }
            $response[] = [
                'year' => $key,
                'data' => $temp
            ];
        }
        
        return $response;
    }

    public function getKelahiranKematianChartByYearCurrentWilayah($id_wilayah, $range_tahun){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('kategori as kriteria', 'tahun as year', 'jumlah as total')
                        ->where('tahun', '>=', date('Y') - ($range_tahun - 1))
                        ->where('tahun', '<=', date('Y'))
                        ->where('id_wilayah', $id_wilayah)
                        ->get();
        
        $dataKelahiranKematian = [];
        foreach ($results as $key => $value) {
            
            if ($value->kriteria == 'total_mati' ||
                $value->kriteria == 'total_lahir') {
                    $dataKelahiranKematian[$value->year][$value->kriteria]['kriteria'] = ucwords(str_replace('_',' ', $value->kriteria));
                    $dataKelahiranKematian[$value->year][$value->kriteria]['total'] = $value->total;
                    $datadataKelahiranKematianBaptis[$value->year][$value->kriteria]['year'] = $value->year;
            }
                
        }
        
        $response = [];
        $status = [
                        'total_mati',
                        'total_lahir'
                    ];
        foreach ($dataKelahiranKematian as $key => $value) {
            $temp = [];
            
            foreach ($value as $item) {
                $temp[snake_case($item['kriteria'])] = $item['total'];
            }

            foreach ($status as $stat) {
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

    public function getKelahiranKematianChartByYearAllWilayah($range_tahun){
        $results = $this->with('wilayah')
                        ->whereHas('wilayah')
                        ->select('kategori as kriteria', 'tahun as year', DB::raw('sum(jumlah) as total'))
                        ->where('tahun', '>=', date('Y') - ($range_tahun - 1))
                        ->where('tahun', '<=', date('Y'))
                        ->groupBy('year', 'kategori')
                        ->get();
        
        $dataKelahiranKematian = [];
        foreach ($results as $key => $value) {
            
            if ($value->kriteria == 'total_mati' ||
                $value->kriteria == 'total_lahir') {
                    $dataKelahiranKematian[$value->year][$value->kriteria]['kriteria'] = ucwords(str_replace('_',' ', $value->kriteria));
                    $dataKelahiranKematian[$value->year][$value->kriteria]['total'] = (int)$value->total;
                    $datadataKelahiranKematianBaptis[$value->year][$value->kriteria]['year'] = $value->year;
            }
                
        }
        
        $response = [];
        $status = [
                    'total_mati',
                    'total_lahir'
                ];
        foreach ($dataKelahiranKematian as $key => $value) {
            $temp = [];
            
            foreach ($value as $item) {
                $temp[snake_case($item['kriteria'])] = $item['total'];
            }

            foreach ($status as $stat) {
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
