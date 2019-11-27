<?php

use Illuminate\Database\Seeder;
use App\Models\Umat;
use Faker\Factory as Faker;

class UmatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Umat::truncate();
        $faker = Faker::create('id_ID');
        $temp_id_pendidikan = ['00','01','02','03','04','05','06','07','11','12','13','14','15','16','17','21','22','23','24','25','26','27','33','44','77'];
        $temp_tmpat_baptis = ['Bandung', 'Yogyakarta', 'Klaten', 'DIY', 'Solo', 'Jakarta', 'GMA','TDK', 'BLM', '','Boyolali', 'Surabaya'];
        
        $temp_birth = ['2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017', '2018', '2019'];
        $temp_wkt_baptis = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10'];
        $temp_sts_sehat = ['00', '01', '02', '04','08', '16', '32', '55', '99'];
        $temp_sts_kawin = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $temp_tmpat_lahir = ['Bandung', 'Yogyakarta', 'Klaten', 'DIY', 'Solo', 'Jakarta','Boyolali', 'Surabaya'];
        $temp_status_krisma = ['BLM','TDK','SDH',''];
        for ($i=0; $i < 20000; $i++) { 
            Umat::create([
                'id_keuskupan' => '330',
                'id_paroki' => '021',
                'id_lingkungan' => '023',
                'alamat' => 'KLATEN',
                'id_jenis_rt' => '0'. rand(1,3),
                'np' => '3'.rand(0,9).'0010'.rand(0,9).'503'.rand(0,9).'001',
                'id_agama' => '0'. rand(1,3),
                'id_ekonomi' => '0' . rand(1,3),
                'id_hub_kk' => '0' . rand(1,3),
                'id_sts_gerejawi' => '0' . rand(1,3),
                'id_keterlibatan' => '0' . rand(1,6),
                'id_wkt_baptis' => $temp_wkt_baptis[rand(0,9)],
                'id_suku' => rand(0,1) . rand(1,9),
                'id_bidstudi' => '',
                'status_komuni' => '',
                'tmp_tinggal' => 100,
                'id_pekerjaan' => '0' . rand(1,3),
                'id_jbt_sosial' => '0' . rand(1,4),
                'id_goldar' => '0' . rand(1,8),
                'id_sts_sehat' => $temp_sts_sehat[rand(0,8)],
                'jen_kel' => rand(1,2),
                'id_pendidikan' => rand(0,24),
                'tempat_lahir' => $temp_tmpat_lahir[rand(0,7)],
                'tgl_lahir' => $temp_birth[rand(0,9)] . '-12-12',
                'id_wilayah' => rand(0,2) . rand(0,9),
                'tempat_baptis' => $temp_tmpat_baptis[rand(0,9)],
                'status_krisma' => $temp_status_krisma[rand(0,2)],
                'id_sts_kawin' => $temp_sts_kawin[rand(0,11)],
                'tgl_update' => '201' . rand(0,9) . '-0' . rand(1,9) . '-04 00:00:00',
            ]);
        }
    }
}