<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Umat;
use App\Models\Wilayah;

class DashboardController extends Controller
{
    /**
     * Umat model.
     * 
     * @var Umat
     */
    private $umat;

    public function __construct(Umat $umat) {
        $this->umat = $umat;
    }

    public function getWilayah()
    {
        $dataWilayah = Wilayah::all();
        return response()->json([
            'items' => $dataWilayah
        ]);
    }

    public function card(Request $request){
        return $this->umat->getCard($request);
    }
}
