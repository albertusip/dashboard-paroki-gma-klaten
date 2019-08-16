<template>
        <v-layout row wrap>
            <v-flex xs12 md6 v-if="statusPiePerkawinanCurrentWilayah" class="text-center">
                <div class="headline my-3">Prosentase Perkawinan</div>
                <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
                <apexchart 
                type=pie 
                :options="chartOptionsProsentasePiePerkawinanWilayah" 
                :series="seriesProsentasePiePerkawinanWilayah" />
            </v-flex>
            <v-flex xs12 md6 v-else class="text-center">
                <div class="headline my-3">Prosentase Perkawinan</div>
                <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
                <div class="text-xs-center orange--text">
                    <v-icon class="orange--text mt-5">report</v-icon>
                    <h2 class="">Tidak ada data pada</h2>
                    <h2 class=""> {{ this.selectedNameWilayah }}</h2>
                </div>
            </v-flex>
            
            <v-flex xs12 md6 v-if="statusPiePerkawinanAllWilayah" class="text-center">
                <div class="headline my-3">Prosentase Perkawinan</div>
                <div class="title my-3">Keseluruhan Wilayah</div>
                <apexchart 
                type=pie
                :options="chartOptionsProsentasePiePerkawinanKeseluruhanWilayah" 
                :series="seriesProsentasePiePerkawinanKeseluruhanWilayah" />
            </v-flex>
            <v-flex xs12 md6 v-else class="text-center">
                <div class="headline my-3">Prosentase Perkawinan Wilayah</div>
                <div class="title my-3">Keseluruhan Wilayah</div>
                <div class="text-xs-center orange--text">
                    <v-icon class="orange--text mt-5">report</v-icon>
                    <h2 class="">Tidak ada data pada</h2>
                    <h2 class=""> Keseluruhan Wilayah</h2>
                </div>
            </v-flex>

            <v-flex xs12>
                <div class="headline my-3">Perkawinan per Bulan {{ this.selectedNameWilayah }}</div>
                <apexchart 
                type=line 
                height=350 
                :options="chartOptionsPerkawinanPerBulan" 
                :series="seriesPerkawinanPerBulan" />
            </v-flex>
            <v-flex xs12>
                <div class="headline my-3">Perkawinan per Tahun {{ this.selectedNameWilayah }}</div>
                <apexchart 
                type=bar 
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
        selectedNameWilayah: {
            type: String,
            default: '',
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
            statusPiePerkawinanCurrentWilayah: true,
            statusPiePerkawinanAllWilayah: true,
            dataPiePerkawinan: [],
            dataMonthlyPerkawinan: [],
            dataYearlyPerkawinan: [],
            tempDataYearlyPerkawinan: [{
                    data: [], // SahKatolik
                },{
                    data: [], // SahBedaAgama
                },{
                    data: [], // SahBedaGereja
                }],
            tempDataMonthlyPerkawinan: [{
                    data: [], // SahKatolik
                },{
                    data: [], // SahBedaAgama
                },{
                    data: [], // SahBedaGereja
                }],
            seriesPerkawinanPerBulan: [{
                name: 'Sah Katolik',
                data: [1, 1, 1]
                },{
                name: 'Sah Beda Agama',
                data: [1, 1, 1]
                },{
                name: 'Sah Beda Greja',
                data: [1, 1, 1, 1, 1, 1, ]
            }],
            seriesPerkawinanPerTahun: [{
                name: 'Sah Katolik',
                data: [1, 1, 1],
                },{
                name: 'Sah Beda Agama',
                data: [1, 1, 1],
                },{
                name: 'Sah Beda Greja',
                data: [1, 1, 1],
            }],
            seriesProsentasePiePerkawinanWilayah: [1, 1, 1],
            seriesProsentasePiePerkawinanKeseluruhanWilayah: [1, 1, 1],
            chartOptionsProsentasePiePerkawinanWilayah: {
                labels: ['Sah Katolik', 
                        'Sah Beda Agama', 
                        'Sah Beda Gereja',
                        ],
                responsive: [{
                    breakpoint: 2400,
                    options: {
                    chart: {
                        width: 400,
                        height: 450,
                        left: 400
                    },
                    legend: {
                        position: 'bottom'
                    }
                    }
                }]
            },
            chartOptionsProsentasePiePerkawinanKeseluruhanWilayah: {
                labels: ['Sah Katolik', 
                        'Sah Beda Agama', 
                        'Sah Beda Gereja'
                        ],
                responsive: [{
                    breakpoint: 2400,
                    options: {
                    chart: {
                        width: 400,
                        height: 450,
                        left: 400
                    },
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
                    stacked: true,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                    horizontal: false,
                    },
                },

                xaxis: {
                    categories: [2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018],
                },
                legend: {
                    position: 'bottom',
                },
                fill: {
                    opacity: 1
                }
            }
        }
    },
    methods: {
        async init() {
            let resDataGraphPerkawinan = await this.fetchGraphPerkawinan();
            let resDataPiePerkawinan = await this.fetchPiePerkawinan();
            
            if (resDataPiePerkawinan.data.current_wilayah.length != 0) {
                this.statusPiePerkawinanCurrentWilayah = true

                this.seriesProsentasePiePerkawinanWilayah = [
                resDataPiePerkawinan.data.current_wilayah.sah_katolik,
                resDataPiePerkawinan.data.current_wilayah.sah_beda_agama,
                resDataPiePerkawinan.data.current_wilayah.sah_beda_gereja,
                ]
            } else {
                this.statusPiePerkawinanCurrentWilayah = false
            }

            if (resDataPiePerkawinan.data.all_wilayah.length != 0) {
                this.statusPiePerkawinanAllWilayah = true

                this.seriesProsentasePiePerkawinanKeseluruhanWilayah = [
                resDataPiePerkawinan.data.all_wilayah.sah_katolik,
                resDataPiePerkawinan.data.all_wilayah.sah_beda_agama,
                resDataPiePerkawinan.data.all_wilayah.sah_beda_gereja,
                ]
            } else {
                this.statusPiePerkawinanAllWilayah = false
            }

            this.dataYearlyPerkawinan = resDataGraphPerkawinan.data.yearly_chart
            this.dataMonthlyPerkawinan = resDataGraphPerkawinan.data.monthly_chart

            let tempXaxisYearlyPerkawinan = []
            let tempXaxisMonthlyPerkawinan = []
            this.clearGraph()
            
            this.dataYearlyPerkawinan.map((item, index) => {
                tempXaxisYearlyPerkawinan.push(item.year)
                this.tempDataYearlyPerkawinan[0].data.push(item.data.sah_katolik)
                this.tempDataYearlyPerkawinan[1].data.push(item.data.sah_beda_agama)
                this.tempDataYearlyPerkawinan[2].data.push(item.data.sah_beda_gereja)
            })

            this.dataMonthlyPerkawinan.map((item, index) => {
                tempXaxisMonthlyPerkawinan.push(item.month)
                this.tempDataMonthlyPerkawinan[0].data.push(item.data.sah_katolik)
                this.tempDataMonthlyPerkawinan[1].data.push(item.data.sah_beda_agama)
                this.tempDataMonthlyPerkawinan[2].data.push(item.data.sah_beda_gereja)
            })
            

            for (let i = 0; i < 3; i++) {
                this.seriesPerkawinanPerTahun[i] = {...this.seriesPerkawinanPerTahun[i], ...{
                                                        data: this.tempDataYearlyPerkawinan[i].data
                                                    }}
                this.seriesPerkawinanPerBulan[i] = {...this.seriesPerkawinanPerBulan[i], ...{
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
        clearGraph() {
            this.tempDataYearlyPerkawinan[0].data = []
            this.tempDataYearlyPerkawinan[1].data = []
            this.tempDataYearlyPerkawinan[2].data = []
            this.tempDataMonthlyPerkawinan[0].data = []
            this.tempDataMonthlyPerkawinan[1].data = []
            this.tempDataMonthlyPerkawinan[2].data = []
        },
        fetchGraphPerkawinan() {
            return axios.get('/api/perkawinan?mode=graphPerkawinan', {
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
            return axios.get('/api/perkawinan?mode=piePerkawinan', {
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

<style scoped>
    .v-icon {
        font-size: 100px;
    }
</style>
