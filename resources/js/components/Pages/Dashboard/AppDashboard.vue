<template>
    <v-container class="my-5" grid-list-lg>
        <v-card>
            <v-card-text>
                <v-layout row wrap>
                    <v-flex xs12 sm6 lg4>
                        <v-card color="darkslate darken-2" class="white--text">
                            <v-card-text>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex><span class="subheading font-weight-light">Total Sudah Krisma</span></v-flex>
                                            <v-flex class="text-xs-right"><v-icon medium dark>group</v-icon></v-flex>
                                        </v-layout>
                                        <div class="title font-weight-regular mt-2"> {{ this.dataCard.krisma }} </div>
                                        <div class="body-2 font-weight-light mt-2">
                                            <v-icon class="body-2 font-weight-light" medium dark>refresh</v-icon>
                                            <span>updated today</span>
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 sm6 lg4>
                        <v-card color="darkslate darken-2" class="white--text">
                            <v-card-text>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex><span class="subheading font-weight-light">Total Sudah Baptis</span></v-flex>
                                            <v-flex class="text-xs-right"><v-icon medium dark>group</v-icon></v-flex>
                                        </v-layout>
                                        <div class="title font-weight-regular mt-2">{{ this.dataCard.baptis }}</div>
                                        <div class="body-2 font-weight-light mt-2">
                                            <v-icon class="body-2 font-weight-light" medium dark>refresh</v-icon>
                                            <span>updated today</span>
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 lg4>
                        <v-card color="darkslate darken-2" class="white--text">
                            <v-card-text>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex><span class="subheading font-weight-light">Total Panggilan Imam</span></v-flex>
                                            <v-flex class="text-xs-right"><v-icon medium dark>group</v-icon></v-flex>
                                        </v-layout>
                                        <div class="title font-weight-regular mt-2">200</div>
                                        <div class="body-2 font-weight-light mt-2">
                                            <v-icon class="body-2 font-weight-light" medium dark>refresh</v-icon>
                                            <span>updated today</span>
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs12>
                        <v-select
                            v-model="selected"
                            :items="wilayah"
                            item-text="nama_wilayah"
                            item-value="id_wilayah"
                        ></v-select>
                    </v-flex>

                    <v-flex xs12>
                            <v-tabs
                                centered
                                color="cyan"
                                dark
                                icons-and-text
                                v-model="activeTab"
                            >
                                <v-tabs-slider color="yellow"></v-tabs-slider>
                                
                                <v-tab
                                    v-for="data in dataTabs"
                                    :key="data.index"
                                >
                                    {{ data.name }}
                                    <v-icon>{{ data.icon }}</v-icon>
                                </v-tab>

                                <v-tab-item>
                                    <ekonomicharts
                                        :selectedWilayah = 'selected'
                                        :activeTab = 'activeTab'
                                        :key = 'activeTab'
                                    ></ekonomicharts>
                                </v-tab-item>

                                <v-tab-item>
                                    <perkawinancharts
                                        :selectedWilayah = 'selected'
                                        :activeTab = 'activeTab'
                                        :key = 'activeTab'
                                    ></perkawinancharts>
                                </v-tab-item>
                                
                                <v-tab-item>
                                    <pendidikancharts
                                        :seriesPendidikanPerBulan = 'seriesPendidikanPerBulan'
                                        :seriesPendidikan = 'seriesPendidikan'
                                        :seriesProsentasePiePendidikan = 'seriesProsentasePiePendidikan'
                                        :seriesProsentasePiePendidikanWilayah = 'seriesProsentasePiePendidikanWilayah'
                                        :chartOptionsProsentasePiePendidikan = 'chartOptionsProsentasePiePendidikan'
                                        :chartOptionsPendidikan = 'chartOptionsPendidikan'
                                        :chartOptionsProsentasePiePendidikanWilayah = 'chartOptionsProsentasePiePendidikanWilayah'
                                        :chartOptionsPendidikanPerBulan = 'chartOptionsPendidikanPerBulan'
                                    ></pendidikancharts>
                                </v-tab-item>
                                
                            </v-tabs>
                    </v-flex>
                </v-layout>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import EkonomiCharts from './AppEkonomiCharts.vue'
import PerkawinanCharts from './AppPerkawinanCharts.vue'
import PendidikanCharts from './AppPendidikanCharts.vue'
import VueApexCharts from 'vue-apexcharts'

export default {
    components: {
        ekonomicharts: EkonomiCharts,
        perkawinancharts: PerkawinanCharts,
        pendidikancharts: PendidikanCharts,
        apexchart: VueApexCharts,
    },
    data() {
        return {
            dataTabs: [
                {
                    name: 'Ekonomi Umat',
                    icon: 'local_atm'
                },
                {
                    name: 'Status Perkawinan',
                    icon: 'wc'
                },
                {
                    name: 'Status Pendidikan',
                    icon: 'school'
                }
                ],
            activeTab: 1,
            labelPiePerkawinan: [],
            dataCard:{},
            selected: '01',
            wilayah: [],
            
            seriesPendidikanPerBulan: [{
                name: "1",
                data: [45, 52, 38, 24, 33, 26, 21, 20, 6]
                },{
                name: "2",
                data: [35, 41, 62, 42, 13, 18, 29, 37, 36]
                },{
                name: '3',
                data: [87, 57, 74, 99, 75, 38, 62, 47, 82]
            }],
            seriesPendidikan: [{
                name: "1",
                data: [45, 52, 38, 24, 33, 26, 21, 20, 6]
                },{
                name: "2",
                data: [35, 41, 62, 42, 13, 18, 29, 37, 36]
                },{
                name: '3',
                data: [87, 57, 74, 99, 75, 38, 62, 47, 82]
            }],
            seriesProsentasePiePendidikan: [44, 55, 13],
            seriesProsentasePiePendidikanWilayah: [44, 55, 13, 43, 22],
            chartOptionsProsentasePiePendidikan: {
                labels: ['1', '2', '3'],
                title: {
                    text: 'Prosentase Pendidikan Keseluruhan',
                    align: 'left',
                    style: {
                    fontSize: "16px",
                    color: '#666'
                    }
                },
                responsive: [{
                    breakpoint: 2400,
                    options: {
                    chart: {
                        width: 400
                    },
                    legend: {
                        position: 'bottom'
                    }
                    }
                }]
            },
            chartOptionsProsentasePiePendidikanWilayah: {
                labels: ['1', '2', '3', '4', '5'],
                title: {
                    text: 'Prosentase Pendidikan Berdasarkan Wilayah',
                    align: 'left',
                    style: {
                    fontSize: "16px",
                    color: '#666'
                    }
                },
                responsive: [{
                    breakpoint: 2400,
                    options: {
                    chart: {
                        width: 400
                    },
                    legend: {
                        position: 'bottom'
                    }
                    }
                }]
            },
            chartOptionsPendidikanPerBulan: {
                chart: {
                    type: 'line',
                    shadow: {
                    enabled: false,
                    color: '#bbb',
                    top: 3,
                    left: 2,
                    blur: 3,
                    opacity: 1
                    },
                },
                stroke: {
                    width: 7,
                    curve: 'smooth'
                },

                xaxis: {
                    categories: [2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018
                    ],
                },
                markers: {
                    size: 4,
                    opacity: 0.9,
                    colors: ["#FFA41B"],
                    strokeColor: "#fff",
                    strokeWidth: 2,
                    
                    hover: {
                    size: 7,
                    }
                },
                yaxis: {
                    title: {
                    text: 'Jumlah',
                    },
                }
            },
            chartOptionsPendidikan: {
                chart: {
                    type: 'line',
                    shadow: {
                    enabled: false,
                    color: '#bbb',
                    top: 3,
                    left: 2,
                    blur: 3,
                    opacity: 1
                    },
                },
                stroke: {
                    width: 7,
                    curve: 'smooth'
                },

                xaxis: {
                    categories: [2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018
                    ],
                },
                markers: {
                    size: 4,
                    opacity: 0.9,
                    colors: ["#FFA41B"],
                    strokeColor: "#fff",
                    strokeWidth: 2,
                    
                    hover: {
                    size: 7,
                    }
                },
                yaxis: {
                    title: {
                    text: 'Jumlah',
                    },
                }
            },
        }
    },
    mounted() {
        this.init();
    },
    methods: {
        changeTab() {

        },
        async init() {
            try {
                let dataWilayah = await this.fetchWilayah();
                this.wilayah = dataWilayah.data.items;
                

                let resCard = await this.fetchCard();
                this.dataCard = resCard.data.data;



                // let dataPieEkonomi = this.dataCharts.pie_prosentase_ekonomi

                
                
                // let res = await this.fetchDashboard();
                // this.dataCharts = res.data.items

                
                    

                // let umatEkonomi = this.dataCharts.pie_prosentase_ekonomi
                // let umatPerkawinan  = this.dataCharts.pie_prosentase_perkawinan
                // let umatPendidikan  = this.dataCharts.pie_prosentase_pendidikan

                // let temp
                
                
                // this.seriesProsentasePieEkonomi.push(umatEkonomi)
                // this.seriesProsentasePiePerkawinan.push(umatPerkawinan)
                // this.seriesProsentasePiePendidikan.push(umatPendidikan)

                
                // this.seriesProsentasePieEkonomi = [umatEkonomi[0].bisa_membantu, umatEkonomi[0].biasa, umatEkonomi[0].perlu_dibantu]
                // this.seriesProsentasePieEkonomiWilayah = [umatEkonomi[0].total_semua_wilayah_bisa_membantu, umatEkonomi[0].total_semua_wilayah_biasa, umatEkonomi[0].total_semua_wilayah_perlu_dibantu]
                // this.seriesProsentasePiePerkawinan =    [umatPerkawinan[0].belum_nikah,
                //                                         umatPerkawinan[0].ditinggal_pasangannya,
                //                                         umatPerkawinan[0].hidup_bersama_tanpa_ikatan,
                //                                         umatPerkawinan[0].janda_atau_duda_mati,
                //                                         umatPerkawinan[0].krisis_berkepanjangan,
                //                                         umatPerkawinan[0].nikah_adat,
                //                                         umatPerkawinan[0].nikah_diluar_gereja,
                //                                         umatPerkawinan[0].rm_br_sr_bekerja_di_paroki,
                //                                         umatPerkawinan[0].rm_br_sr_dari_paroki,
                //                                         umatPerkawinan[0].sah_beda_agama,
                //                                         umatPerkawinan[0].sah_beda_gereja,
                //                                         umatPerkawinan[0].sah_katolik]
                // this.seriesProsentasePiePendidikan =    [umatPendidikan[0].belum_sekolah,
                //                                         umatPendidikan[0].tamat_sd,
                //                                         umatPendidikan[0].tamat_sltp,
                //                                         umatPendidikan[0].tamat_slta,
                //                                         umatPendidikan[0].tamat_d1_d2_d3,
                //                                         umatPendidikan[0].tamat_s1_d4,
                //                                         umatPendidikan[0].tamat_s2_akta_5,
                //                                         umatPendidikan[0].tamat_s3,
                //                                         umatPendidikan[0].masih_di_sd_katolik,
                //                                         umatPendidikan[0].masih_di_sltp_katolik,
                //                                         umatPendidikan[0].masih_di_slta_katolik,
                //                                         umatPendidikan[0].masih_di_perguruan_tinggi_katolik_d,
                //                                         umatPendidikan[0].masih_di_perguruan_tinggi_katolik_s1,
                //                                         umatPendidikan[0].masih_di_perguruan_tinggi_katolik_s2,
                //                                         umatPendidikan[0].masih_di_perguruan_tinggi_katolik_s3,
                //                                         umatPendidikan[0].masih_di_sd_non_katolik,
                //                                         umatPendidikan[0].masih_di_sltp_non_katolik,
                //                                         umatPendidikan[0].masih_di_slta_non_katolik,
                //                                         umatPendidikan[0].masih_di_perguruan_tinggi_non_katolik_d,
                //                                         umatPendidikan[0].masih_di_perguruan_tinggi_non_katolik_s1,
                //                                         umatPendidikan[0].masih_di_perguruan_tinggi_non_katolik_s2,
                //                                         umatPendidikan[0].masih_di_perguruan_tinggi_non_katolik_s3,
                //                                         umatPendidikan[0].usia_7_sampai_12_tidak_sekolah,
                //                                         umatPendidikan[0].usia_13_sampai_15_tidak_sekolah,
                //                                         umatPendidikan[0].buta_aksara]

                // this.seriesProsentasePiePerkawinan.splice(0)
                // umatPerkawinan[0].status.forEach(item =>
                //     this.seriesProsentasePiePerkawinan.push(item.jumlah_status)
                // );
                
                // this.chartOptionsProsentasePiePerkawinan.labels.splice(0)
                // umatPerkawinan[0].status.forEach(item =>
                //     this.chartOptionsProsentasePiePerkawinan.labels.push(item.status.deskripsi_sts_kawin)
                // );
                // this.labelPiePerkawinan = umatPerkawinan[0].status.map((item) => item.status);
                // this.chartOptionsProsentasePiePerkawinan.labels = this.labelPiePerkawinan;
            } catch (error) {
                console.log(error);
            }
        },
        // fetchDashboard() {
        //     return new Promise((resolve, reject) => {
        //         axios.get('/api/dashboard', {
        //             headers: {
        //                 'Accept': 'application/json',
        //                 'Content-type': 'application/json'
        //             },
        //             params: {
        //                 'id_wilayah': this.selected
        //             }
        //         })
        //         .then(res => resolve(res))
        //         .catch(error => reject(error))
        //     })
        // },
        fetchWilayah() {
            return new Promise((resolve, reject) => {
                axios.get('/api/wilayah', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                })
                .then(res => resolve(res))
                .catch(error => reject(error))
            })
        },
        fetchCard() {
            return new Promise((resolve, reject) => {
                axios.get('/api/current-card', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                })
                .then(res => resolve(res))
                .catch(error => reject(error))
            })
        },
    },
    watch: {
        selected() {
            this.init();
        }
    }
}
</script>
<style>
.apexcharts-toolbar{
    z-index: 1!important;
}
.application a{
    text-decoration: none!important;
}
</style>
