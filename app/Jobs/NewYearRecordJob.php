<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Umat;

class NewYearRecordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $umat;

    private $dataTahunan;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->umat = new Umat();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dataTahunanOld = $this->dataTahunan->latest()->first();
        $this->dataTahunan->create([
            'tahun' => $dataTahunanOld->tahun,
        ]);

    }
}
