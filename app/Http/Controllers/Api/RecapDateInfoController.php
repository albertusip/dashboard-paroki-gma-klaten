<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Recap;

class RecapDateInfoController extends Controller
{
    /**
     * Recap model.
     * 
     * @var Recap
     */
    private $recap;

    public function __construct(Recap $recap) {
        $this->recap = $recap;
    }

    public function dateUpdated(){
        return $this->recap->getDateUpdated();
    }
}
