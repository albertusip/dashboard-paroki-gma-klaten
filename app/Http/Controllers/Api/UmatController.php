<?php

namespace App\Http\Controllers\Api;

use App\Models\Umat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UmatController extends Controller 
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataUmat = Umat::where('id_wilayah', $request->id)->get();
        return response()->json([
            'response'=> $dataUmat
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
     * @param  \App\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function show(Umat $umat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function edit(Umat $umat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Umat $umat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Umat $umat)
    {
        //
    }
}
