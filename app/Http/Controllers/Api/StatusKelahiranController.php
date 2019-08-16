<?php

namespace App\Http\Controllers\Api;

use App\Models\Umat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusKelahiranController extends Controller
{
    /**
     * Umat model.
     * 
     * @var Umat
     */
    private $statusKelahiran;

    public function __construct(Umat $umat) {
        $this->umat = $umat;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataKelahiran = $this->umat->where('id_wilayah', $request->id)->get();
        return response()->json([
            'response'=> $dataKelahiran
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
     * @param  \App\StatusKelahiran  $statusKelahiran
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StatusKelahiran  $statusKelahiran
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
     * @param  \App\StatusKelahiran  $statusKelahiran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StatusKelahiran  $statusKelahiran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajax(Request $request)
    { 
        switch ($request->mode) {
            case 'graphKelahiran':
                return [
                    'current_wilayah_chart' => $this->umat->getKelahiranChartWilayahByYear($request->id_wilayah),
                    'all_wilayah_chart' => $this->umat->getKelahiranChartAllWilayahByYear($request->id_wilayah),
                ];
                break;
        }
    }
}
