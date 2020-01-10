<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Umat;
use App\Models\Wilayah;
use App\Models\DataTahunan;

class NewYearRecordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $listWilayah = Wilayah::select('id_wilayah', 'nama_wilayah')->get();
            foreach($listWilayah as $item){
                $idWilayah = $item->id_wilayah;

                $this->ekonomiUmat($idWilayah);
                $this->statusPerkawinan($idWilayah);
                $this->statusKesehatan($idWilayah);
                $this->statusBaptis($idWilayah);
                $this->statusKelahiranKematian($idWilayah);
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
            if ($value->id_sts_kawin == '02' || $value->id_sts_kawin == '03' || $value->id_sts_kawin == '04') {
                $dataPerkawinan[$value->year][$value->id_sts_kawin]['status_perkawinan'] = str_replace('/',' ', $value->statusPerkawinan->deskripsi_sts_kawin);
                $dataPerkawinan[$value->year][$value->id_sts_kawin]['total'] = $value->total;
            }
        }
        
        $filteredData = [];
        $statusPerkawinan = ['Sah Katolik', 
                            'Sah Beda Agama', 
                            'Sah Beda Gereja'
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

    public function statusKesehatan($idWilayah)
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

            $response[] = [
                'year' => $key,
                'data' => $temp
            ];
        }

        $this->insertData($response, $idWilayah);
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

    public function statusKelahiranKematian($idWilayah)
    {
        $resultsKelahiran = Umat::with('wilayah')
                                ->whereHas('wilayah')
                                ->select(DB::raw("DATE_FORMAT(tgl_lahir, '%Y') yearBase"),DB::raw("DATE_FORMAT(tgl_lahir, '%Y') year"), DB::raw('count(*) as total'))
                                ->whereYear('tgl_lahir', '>=', date('Y') - 10)
                                ->whereYear('tgl_lahir', '<=', date('Y'))
                                ->where('id_wilayah', $idWilayah)
                                ->groupBy('year', 'yearBase')
                                ->get();

        $resultsKematian = Umat::with('kesehatan')
                                ->whereHas('kesehatan')
                                ->select('id_sts_sehat', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                                ->whereYear('tgl_update', '>=', date('Y') - 10)
                                ->whereYear('tgl_update', '<=', date('Y'))
                                ->where('id_wilayah', $idWilayah)
                                ->groupBy('year', 'id_sts_sehat')
                                ->get();
                        
        $dataKelahiranKematian = [];

        foreach ($resultsKelahiran as $key => $value) {

            $dataKelahiranKematian[$value->year]['0']['status'] = 'total_lahir';
            $dataKelahiranKematian[$value->year]['0']['total_lahir'] = $value->total;
                
        }
        
        foreach ($resultsKematian as $key => $value) {
            
            if ($value->id_sts_sehat == '99') {
                $dataKelahiranKematian[$value->year]['1']['status'] = 'total_mati';
                $dataKelahiranKematian[$value->year]['1']['total_mati'] = $value->total;
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
        $this->insertData($response, $idWilayah);
    }

    public function insertData($filteredData, $idWilayah)
    {
        foreach($filteredData as $value){
            $year =  $value["year"];
            foreach($value["data"] as $key => $x){
                $kategori = $key;
                $jumlah = $x;

                DataTahunan::firstOrNew(
                    ['id_wilayah' => $idWilayah, "tahun" => $year, "kategori" => $kategori],
                    ['jumlah' => $jumlah]
                )->save();
            }
        }
    }
}
