<?php

namespace App\Http\Controllers\Api;

use App\Models\Umat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusKesehatanController extends Controller
{
    /**
     * Umat model.
     * 
     * @var Umat
     */
    private $statusKesehatan;

    public function __construct(Umat $umat) {
        $this->umat = $umat;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataKesehatan = $this->umat->where('id_wilayah', $request->id)->get();
        return response()->json([
            'response'=> $dataKesehatan
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
     * @param  \App\UmatHidup  $umatHidup
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UmatHidup  $umatHidup
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
     * @param  \App\UmatHidup  $umatHidup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UmatHidup  $umatHidup
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajax(Request $request)
    { 
        switch ($request->mode) {
            case 'graphKesehatan':
                return [
                    'monthly_chart' => $this->umat->getCurrentYearKesehatanChart($request->id_wilayah),
                ];
                break;
            case 'pieKesehatan':
                return [
                    'current_wilayah' => $this->umat->getCurrentWilayahKesehatanChart($request->id_wilayah),
                    'all_wilayah' => $this->umat->getAllWilayahKesehatanChart($request->id_wilayah),
                ];
                break;
        }
    }
}
