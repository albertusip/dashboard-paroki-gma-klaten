<?php

namespace App\Http\Controllers\Api;

use App\Models\Umat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusBaptisController extends Controller
{
    /**
     * Umat model.
     * 
     * @var Umat
     */
    private $statusBaptis;

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
        $dataBaptis = $this->umat->where('id_wilayah', $request->id)->get();
        return response()->json([
            'response'=> $dataBaptis
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
     * @param  \App\StatusBaptis  $statusBaptis
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StatusBaptis  $statusBaptis
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
     * @param  \App\StatusBaptis  $statusBaptis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StatusBaptis  $statusBaptis
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function ajax(Request $request)
    { 
        switch ($request->mode) {
            case 'graphBaptis':
                return [
                    'monthly_chart' => $this->umat->getCurrentYearBaptisChart($request->id_wilayah),
                ];
                break;
            case 'pieBaptis':
                return [
                    'current_wilayah' => $this->umat->getCurrentWilayahBaptisChart($request->id_wilayah),
                    'all_wilayah' => $this->umat->getAllWilayahBaptisChart($request->id_wilayah),
                ];
                break;
        }
    }
}
