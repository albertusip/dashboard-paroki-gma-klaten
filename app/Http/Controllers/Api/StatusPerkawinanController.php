<?php

namespace App\Http\Controllers\Api;

use App\Models\Umat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusPerkawinanController extends Controller
{
    /**
     * Umat model.
     * 
     * @var Umat
     */
    private $statusPerkawinan;

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
        $dataPerkawinan = $this->umat->where('id_wilayah', $request->id)->get();
        return response()->json([
            'response'=> $dataPerkawinan
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
            case 'graphPerkawinan':
                return [
                    'monthly_chart' => $this->umat->getPerkawinanCurrentYearChart($request->id_wilayah),
                ];
                break;
            case 'piePerkawinan':
                return [
                    'current_wilayah' => $this->umat->getCurrentWilayahPerkawinanChart($request->id_wilayah),
                    'all_wilayah' => $this->umat->getAllWilayahPerkawinanChart($request->id_wilayah),
                ];
                break;
        }
    }
}
