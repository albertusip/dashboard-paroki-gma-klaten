<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Recap;
use Illuminate\Http\Request;
use App\Models\Umat;
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
         $results = Umat::with('ekonomi')
                        ->whereHas('ekonomi')
                        ->select('id_ekonomi', DB::raw("DATE_FORMAT(tgl_update, '%Y') year"), DB::raw('count(*) as total'))
                        ->whereYear('tgl_update', '>=', date('Y') - 10)
                        ->whereYear('tgl_update', '<=', date('Y'))
                        ->where('id_wilayah', 2)
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
        // return $filteredData;
        // $umat = Umat::where()->get();
        Recap::updateOrInsert(
            ['kategori' => $kategori, 'type' => $type, 'tahun' => $tahun],
            ['jumlah' => $jumlah]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recap  $recap
     * @return \Illuminate\Http\Response
     */
    public function show(Recap $recap)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recap  $recap
     * @return \Illuminate\Http\Response
     */
    public function edit(Recap $recap)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recap  $recap
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recap $recap)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recap  $recap
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recap $recap)
    {
        //
    }
}
