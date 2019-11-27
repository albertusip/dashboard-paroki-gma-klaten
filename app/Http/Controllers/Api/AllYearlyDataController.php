<?php

namespace App\Http\Controllers\Api;

use App\Models\Recap;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AllYearlyDataController extends Controller
{
    public function __construct(Recap $recap) {
        $this->recap = $recap;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataRecap = $this->recap->where('id_wilayah', $request->id)->get();
        return response()->json([
            'response'=> $dataRecap
        ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajax(Request $request)
    { 
        switch ($request->mode) {
            case 'graphEkonomiByYearCurrentWilayah':
                return [
                    'yearly_chart' => $this->recap->getEkonomiChartByYearCurrentWilayah($request->id_wilayah, $request->range_tahun),
                ];
                break;
            case 'graphEkonomiByYearAllWilayah':
                return [
                    'yearly_chart' => $this->recap->getEkonomiChartByYearAllWilayah($request->range_tahun),
                ];
                break;
            case 'graphPerkawinanByYearCurrentWilayah':
                return [
                    'yearly_chart' => $this->recap->getPerkawinanChartByYearCurrentWilayah($request->id_wilayah, $request->range_tahun),
                ];
                break;
            case 'graphPerkawinanByYearAllWilayah':
                return [
                    'yearly_chart' => $this->recap->getPerkawinanChartByYearAllWilayah($request->range_tahun),
                ];
                break;
            case 'graphKesehatanByYearCurrentWilayah':
                return [
                    'yearly_chart' => $this->recap->getKesehatanChartByYearCurrentWilayah($request->id_wilayah, $request->range_tahun),
                ];
                break;
            case 'graphKesehatanByYearAllWilayah':
                return [
                    'yearly_chart' => $this->recap->getKesehatanChartByYearAllWilayah($request->range_tahun),
                ];
                break;
            case 'graphBaptisByYearCurrentWilayah':
                return [
                    'yearly_chart' => $this->recap->getBaptisChartByYearCurrentWilayah($request->id_wilayah, $request->range_tahun),
                ];
                break;
            case 'graphBaptisByYearAllWilayah':
                return [
                    'yearly_chart' => $this->recap->getBaptisChartByYearAllWilayah($request->range_tahun),
                ];
                break;
            case 'graphNatalitasMortalitasByYearCurrentWilayah':
                return [
                    'yearly_chart' => $this->recap->getKelahiranKematianChartByYearCurrentWilayah($request->id_wilayah, $request->range_tahun),
                ];
                break;
            case 'graphNatalitasMortalitasByYearAllWilayah':
                return [
                    'yearly_chart' => $this->recap->getKelahiranKematianChartByYearAllWilayah($request->range_tahun),
                ];
                break;
        }
    }
}
