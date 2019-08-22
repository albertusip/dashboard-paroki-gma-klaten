<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Recap;
use Illuminate\Http\Request;
use App\Models\Wilayah;
use App\Models\Umat;
use App\Models\DataTahunan;
use DB;

class RecapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listWilayah = Wilayah::select('id_wilayah', 'nama_wilayah')->get();
        foreach($listWilayah as $item){
            $idWilayah = $item->id_wilayah;

            $this->ekonomiUmat($idWilayah);
            $this->statusPerkawinan($idWilayah);
            $this->statusKehidupan($idWilayah);
            $this->statusBaptis($idWilayah);
        }
    }

    public function ekonomiUmat($idWilayah)
    {
        $results = Umat::with('ekonomi')
                    ->whereHas('ekonomi')
                    ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                    ->whereYear('tgl_update', '>=', date('Y') - 10)
                    ->whereYear('tgl_update', '<=', date('Y'))
                    ->where('id_wilayah', $idWilayah)
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

        $this->insertData($filteredData, $idWilayah);
    }

    public function statusPerkawinan($idWilayah)
    {
        $results = Umat::with('statusPerkawinan')
                ->whereHas('statusPerkawinan')
                ->select('id_sts_kawin', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                ->whereYear('tgl_update', '>=', date('Y') - 10)
                ->whereYear('tgl_update', '<=', date('Y'))
                ->where('id_wilayah', $idWilayah)
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
        
        $this->insertData($filteredData, $idWilayah);
    }

    public function statusKehidupan($idWilayah)
    {
         $results = Umat::with('kesehatan')
                        ->whereHas('kesehatan')
                        ->select('id_sts_sehat', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', '>=', date('Y') - 10)
                        ->whereYear('tgl_update', '<=', date('Y'))
                        ->where('id_wilayah', $idWilayah)
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

        $this->insertData($filteredData, $idWilayah);
    }

    public function statusBaptis($idWilayah){
        $results = Umat::with('baptis')
                        ->whereHas('baptis')
                        ->select('id_wkt_baptis', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', '>=', date('Y') - 10)
                        ->whereYear('tgl_update', '<=', date('Y'))
                        ->where('id_wilayah', $idWilayah)
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
            
        $this->insertData($filteredData, $idWilayah);
    }

    public function insertData($filteredData, $idWilayah)
    {
        foreach($filteredData as $value){
            $year =  $value["year"];
            foreach($value["data"] as $key => $x){
                $kategori = $key;
                $jumlah = $x;

                DataTahunan::updateOrInsert(
                    ['id_wilayah' => $idWilayah, "tahun" => $year, "kategori" => $kategori],
                    ['jumlah' => $jumlah]
                );
            }
        }
    }
}
