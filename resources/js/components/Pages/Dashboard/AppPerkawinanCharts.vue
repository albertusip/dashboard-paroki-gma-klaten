<template>
        <v-layout row wrap>
            <v-flex xs12 md6>
                <div class="title mt-2">Prosentase Perkawinan Wilayah</div>
                <apexchart 
                type=pie 
                :options="chartOptionsProsentasePiePerkawinanWilayah" 
                :series="seriesProsentasePiePerkawinanWilayah" />
            </v-flex>
            
            <v-flex xs12 md6>
                <div class="title mt-2">Prosentase Perkawinan Keseluruhan Wilayah</div>
                <apexchart 
                type=pie
                :options="chartOptionsProsentasePiePerkawinanKeseluruhanWilayah" 
                :series="seriesProsentasePiePerkawinanKeseluruhanWilayah" />
            </v-flex>
            <v-flex xs12>
                <div class="title mt-2">Perkawinan per Bulan</div>
                <apexchart 
                type=line 
                height=350 
                :options="chartOptionsPerkawinanPerBulan" 
                :series="seriesPerkawinanPerBulan" />
            </v-flex>
            <v-flex xs12>
                <div class="title mt-2">Perkawinan per Tahun</div>
                <apexchart 
                type=line 
                height=350 
                :options="chartOptionsPerkawinanPerTahun" 
                :series="seriesPerkawinanPerTahun" />
            </v-flex>
        </v-layout>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

export default {
    components: {
        apexchart: VueApexCharts,
    },
    props: {
        selectedWilayah: {
            type: String,
            default: '01',
            required: true,
        },
        activeTab: {
            type: Number,
            default: 1,
            required: true,
        }
    },
    data() {
        return {
            dataPiePerkawinan: [],
            dataMonthlyPerkawinan: [],
            dataYearlyPerkawinan: [],
            tempDataYearlyPerkawinan: [{
                    data: [], // BelumNikah
                },{
                    data: [], // SahKatolik
                },{
                    data: [], // SahBedaAgama
                },{
                    data: [], // SahBedaGereja
                },{
                    data: [], // NikahDiLuarGreja
                },{
                    data: [], // DitinggalPasangannya
                },{
                    data: [], // KrisisBerkepanjangan
                },{
                    data: [], // JandaAtauDudaMati
                },{
                    data: [], // RmBrSrDariParoki
                },{
                    data: [], // RmBrSrBekerjaDiParoki
                },{
                    data: [], // HidupBersamaTanpaIkatan
                },{
                    data: [], // NikahAdat
            }],
            tempDataMonthlyPerkawinan: [{
                    data: [], // BelumNikah
                },{
                    data: [], // SahKatolik
                },{
                    data: [], // SahBedaAgama
                },{
                    data: [], // SahBedaGereja
                },{
                    data: [], // NikahDiLuarGreja
                },{
                    data: [], // DitinggalPasangannya
                },{
                    data: [], // KrisisBerkepanjangan
                },{
                    data: [], // JandaAtauDudaMati
                },{
                    data: [], // RmBrSrDariParoki
                },{
                    data: [], // RmBrSrBekerjaDiParoki
                },{
                    data: [], // HidupBersamaTanpaIkatan
                },{
                    data: [], // NikahAdat
            }],
            seriesPerkawinanPerBulan: [{
                name: "Belum Nikah",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
                },{
                name: 'Sah Katolik',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
                },{
                name: 'Sah Beda Agama',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
                },{
                name: 'Sah Beda Greja',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
                },{
                name: 'Nikah diluar Greja',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
                },{
                name: "Ditinggal Pasangannya",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
                },{
                name: "Krisis Berkepanjangan",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
                },{
                name: "Janda / Duda Mati",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
                },{
                name: "Rm/Br/Sr dari Paroki",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
                },{
                name: "Rm/Br/Sr bekerja di Paroki",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
                },{
                name: "Hidup Bersama Tanpa Ikatan",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
                },{
                name: 'Nikah Adat',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1]
            }],
            seriesPerkawinanPerTahun: [{
                name: "Belum Nikah",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: 'Sah Katolik',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: 'Sah Beda Agama',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: 'Sah Beda Greja',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: 'Nikah diluar Greja',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: "Ditinggal Pasangannya",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: "Krisis Berkepanjangan",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: "Janda / Duda Mati",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: "Rm/Br/Sr dari Paroki",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: "Rm/Br/Sr bekerja di Paroki",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: "Hidup Bersama Tanpa Ikatan",
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: 'Nikah Adat',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1],
            }],
            seriesProsentasePiePerkawinanWilayah: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
            seriesProsentasePiePerkawinanKeseluruhanWilayah: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
            chartOptionsProsentasePiePerkawinanWilayah: {
                labels: ['Belum Nikah', 
                        'Sah Katolik', 
                        'Sah Beda Agama', 
                        'Sah Beda Gereja', 
                        'Nikah di Luar Gereja', 
                        'Ditinggal pasangannya',
                        'Krisis berkepanjangan',
                        'Janda Duda Mati',
                        'Rm Br Sr dari Paroki',
                        'Rm Br Sr bekerja di Paroki',
                        'Hidup Bersama Tanpa Ikatan',
                        'Nikah Adat'
                        ],
                responsive: [{
                    breakpoint: 2400,
                    options: {
                    chart: {
                        width: 500,
                        height: 500,
                        left: 400
                    },
                    colors: ['#FFA41B', '#008FFB', '#00E396', '#FF4560', '#775DD0', '#A300D6', '#5A2A27', '#011638', '#B0001F', '#024942', '#2B908F', '#2E294E'],
                    legend: {
                        position: 'bottom'
                    }
                    }
                }]
            },
            chartOptionsProsentasePiePerkawinanKeseluruhanWilayah: {
                labels: ['Belum Nikah', 
                        'Sah Katolik', 
                        'Sah Beda Agama', 
                        'Sah Beda Gereja', 
                        'Nikah di Luar Gereja', 
                        'Ditinggal pasangannya',
                        'Krisis berkepanjangan',
                        'Janda Duda Mati',
                        'Rm Br Sr dari Paroki',
                        'Rm Br Sr bekerja di Paroki',
                        'Hidup Bersama Tanpa Ikatan',
                        'Nikah Adat'
                        ],
                responsive: [{
                    breakpoint: 2400,
                    options: {
                    chart: {
                        width: 500,
                        height: 500,
                        left: 400
                    },
                    colors: ['#FFA41B', '#008FFB', '#00E396', '#FF4560', '#775DD0', '#A300D6', '#5A2A27', '#011638', '#B0001F', '#024942', '#2B908F', '#2E294E'],
                    legend: {
                        position: 'bottom'
                    }
                    }
                }]
            },
            chartOptionsPerkawinanPerBulan: {
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
                    width: 3,
                    curve: 'smooth'
                },
                colors: ['#FFA41B', '#008FFB', '#00E396', '#FF4560', '#775DD0', '#A300D6', '#5A2A27', '#011638', '#B0001F', '#024942', '#2B908F', '#2E294E'],
                xaxis: {
                    categories: ['Januari', 'Febuari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
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
                },
                legend: {
                    show: true,
                    showForNullSeries: false,
                    showForZeroSeries: false,
                }
            },
            chartOptionsPerkawinanPerTahun: {
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
                colors: ['#FFA41B', '#008FFB', '#00E396', '#FF4560', '#775DD0', '#A300D6', '#5A2A27', '#011638', '#B0001F', '#024942', '#2B908F', '#2E294E'],
                stroke: {
                    width: 3,
                    curve: 'smooth',
                },
                xaxis: {
                    categories: [2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018],
                },
                markers: {
                    size: 4,
                    opacity: 0.9,
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
                },
                legend: {
                    labels: {
                        useSeriesColors: true,
                    },
                    show: true,
                    showForNullSeries: false,
                    showForZeroSeries: false,
                }
            },
        }
    },
    methods: {
        async init() {
            
            
            let resDataGraphPerkawinan = await this.fetchGraphPerkawinan();
            let resDataPiePerkawinan = await this.fetchPiePerkawinan();
            console.log(resDataPiePerkawinan);
            
            this.seriesProsentasePiePerkawinanWilayah = [
                resDataPiePerkawinan.data.data.belum_nikah,
                resDataPiePerkawinan.data.data.sah_katolik,
                resDataPiePerkawinan.data.data.sah_beda_agama,
                resDataPiePerkawinan.data.data.sah_beda_gereja,
                resDataPiePerkawinan.data.data.nikah_di_luar_gereja,
                resDataPiePerkawinan.data.data.ditinggal_pasangannya,
                resDataPiePerkawinan.data.data.krisis_berkepanjangan,
                resDataPiePerkawinan.data.data.janda_duda_mati,
                resDataPiePerkawinan.data.data.rm_br_sr_dari_paroki,
                resDataPiePerkawinan.data.data.rm_br_sr_bekerja_di_paroki,
                resDataPiePerkawinan.data.data.hidup_bersama_tanpa_ikatan,
                resDataPiePerkawinan.data.data.nikah_adat,
            ]

            this.seriesProsentasePiePerkawinanKeseluruhanWilayah = [
                resDataPiePerkawinan.data.data.total_semua_wilayah_belum_nikah,
                resDataPiePerkawinan.data.data.total_semua_wilayah_sah_katolik,
                resDataPiePerkawinan.data.data.total_semua_wilayah_sah_beda_agama,
                resDataPiePerkawinan.data.data.total_semua_wilayah_sah_beda_gereja,
                resDataPiePerkawinan.data.data.total_semua_wilayah_nikah_di_luar_gereja,
                resDataPiePerkawinan.data.data.total_semua_wilayah_ditinggal_pasangannya,
                resDataPiePerkawinan.data.data.total_semua_wilayah_krisis_berkepanjangan,
                resDataPiePerkawinan.data.data.total_semua_wilayah_janda_duda_mati,
                resDataPiePerkawinan.data.data.total_semua_wilayah_rm_br_sr_dari_paroki,
                resDataPiePerkawinan.data.data.total_semua_wilayah_rm_br_sr_bekerja_di_paroki,
                resDataPiePerkawinan.data.data.total_semua_wilayah_hidup_bersama_tanpa_ikatan,
                resDataPiePerkawinan.data.data.total_semua_wilayah_nikah_adat,
            ]

            this.dataYearlyPerkawinan = resDataGraphPerkawinan.data.yearly_chart
            this.dataMonthlyPerkawinan = resDataGraphPerkawinan.data.monthly_chart

            let tempXaxisYearlyPerkawinan = []
            let tempXaxisMonthlyPerkawinan = []
            
            this.dataYearlyPerkawinan.map((item, index) => {
                tempXaxisYearlyPerkawinan.push(item.year)
                this.tempDataYearlyPerkawinan[0].data.push(item.data.belum_nikah)
                this.tempDataYearlyPerkawinan[1].data.push(item.data.sah_katolik)
                this.tempDataYearlyPerkawinan[2].data.push(item.data.sah_beda_agama)
                this.tempDataYearlyPerkawinan[3].data.push(item.data.sah_beda_gereja)
                this.tempDataYearlyPerkawinan[4].data.push(item.data.nikah_di_luar_gereja)
                this.tempDataYearlyPerkawinan[5].data.push(item.data.ditinggal_pasangannya)
                this.tempDataYearlyPerkawinan[6].data.push(item.data.krisis_berkepanjangan)
                this.tempDataYearlyPerkawinan[7].data.push(item.data.janda_duda_mati)
                this.tempDataYearlyPerkawinan[8].data.push(item.data.rm_br_sr_dari_paroki)
                this.tempDataYearlyPerkawinan[9].data.push(item.data.rm_br_sr_bekerja_di_paroki)
                this.tempDataYearlyPerkawinan[10].data.push(item.data.hidup_bersama_tanpa_ikatan)
                this.tempDataYearlyPerkawinan[11].data.push(item.data.nikah_adat)
            })

            this.dataMonthlyPerkawinan.map((item, index) => {
                tempXaxisMonthlyPerkawinan.push(item.month)
                this.tempDataMonthlyPerkawinan[0].data.push(item.data.belum_nikah)
                this.tempDataMonthlyPerkawinan[1].data.push(item.data.sah_katolik)
                this.tempDataMonthlyPerkawinan[2].data.push(item.data.sah_beda_agama)
                this.tempDataMonthlyPerkawinan[3].data.push(item.data.sah_beda_gereja)
                this.tempDataMonthlyPerkawinan[4].data.push(item.data.nikah_di_luar_gereja)
                this.tempDataMonthlyPerkawinan[5].data.push(item.data.ditinggal_pasangannya)
                this.tempDataMonthlyPerkawinan[6].data.push(item.data.krisis_berkepanjangan)
                this.tempDataMonthlyPerkawinan[7].data.push(item.data.janda_duda_mati)
                this.tempDataMonthlyPerkawinan[8].data.push(item.data.rm_br_sr_dari_paroki)
                this.tempDataMonthlyPerkawinan[9].data.push(item.data.rm_br_sr_bekerja_di_paroki)
                this.tempDataMonthlyPerkawinan[10].data.push(item.data.hidup_bersama_tanpa_ikatan)
                this.tempDataMonthlyPerkawinan[11].data.push(item.data.nikah_adat)
            })

            console.log(resDataGraphPerkawinan);
            

            for (let i = 0; i < 12; i++) {
                this.seriesPerkawinanPerTahun[i] = {...this.seriesPerkawinanPerTahun[i], ...{
                                                        data: this.tempDataYearlyPerkawinan[i].data
                                                    }}
                this.seriesPerkawinanPerBulan[i] = {...this.seriesPerkawinanPerTahun[i], ...{
                                                        data: this.tempDataMonthlyPerkawinan[i].data
                                                    }}
            }
            this.chartOptionsPerkawinanPerTahun = {...this.chartOptionsPerkawinanPerTahun, ...{
                                                    xaxis: {
                                                        categories: tempXaxisYearlyPerkawinan
                                                    }
                                                }}
            this.chartOptionsPerkawinanPerBulan = {...this.chartOptionsPerkawinanPerBulan, ...{
                                                    xaxis: {
                                                        categories: tempXaxisMonthlyPerkawinan
                                                    }
                                                }}
        },
        fetchGraphPerkawinan() {
            return axios.get('/api/perkawinan?mode=perkawinan', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'id_wilayah': this.selectedWilayah
                    }
                })
        },
        fetchPiePerkawinan() {
            return axios.get('/api/current-perkawinan', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'id_wilayah': this.selectedWilayah
                    }
                })
        },
    },
    mounted() {
        if (this.activeTab == 1) {
            this.init();
            console.log(this.activeTab);
        }
    },
    watch: {
        selectedWilayah() {
            if (this.activeTab == 1) {
            this.init();
            }
        }
    },
}
</script>
