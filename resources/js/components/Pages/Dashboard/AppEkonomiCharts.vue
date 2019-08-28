<template>
    <v-layout row wrap>

        <v-flex xs12 md6 v-if="statusPieEkonomiCurrentWilayah" class="text-center">
            <div class="headline my-3">Prosentase Ekonomi</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <apexchart 
            type=pie 
            :options="chartOptionsProsentasePieEkonomiWilayah" 
            :series="seriesProsentasePieEkonomiWilayah" />
        </v-flex>
        <v-flex xs12 md6 class="text-center" v-else>
            <div class="headline my-3">Prosentase Ekonomi Wilayah</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text mt-5">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> {{ this.selectedNameWilayah }} </h2>
            </div>
        </v-flex>

        <v-flex xs12 md6 class="text-center" v-if="statusPieEkonomiAllWilayah">
            <div class="headline my-3">Prosentase Ekonomi</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <apexchart 
            type=pie
            :options="chartOptionsProsentasePieEkonomiKeseluruhanWilayah" 
            :series="seriesProsentasePieEkonomiKeseluruhanWilayah" />
        </v-flex>
        <v-flex xs12 md6 class="text-center" v-else>
            <div class="headline my-3">Prosentase Ekonomi</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text mt-5">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> Keseluruhan Wilayah</h2>
            </div>
        </v-flex>

        <v-flex xs12>
            <div class="headline my-3">Ekonomi per Bulan {{ this.selectedNameWilayah }} </div>
            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsEkonomiPerBulan"
            :series="seriesEkonomiPerBulan"
            />
        </v-flex>
        <v-flex xs12>
            <div class="headline my-3">Ekonomi per Tahun {{ this.selectedNameWilayah }} </div>
            <div>
                Range Tahun
                
            </div>
            <apexchart
            type=bar
            height= "350px"
            :options="chartOptionsEkonomiPerTahun"
            :series="seriesEkonomiPerTahun"
            />
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
            default: 0,
            required: true,
        }
    },
    data() {
        return {
            statusPieEkonomiCurrentWilayah: false,
            statusPieEkonomiAllWilayah: true,
            dataPieEkonomi: [],
            dataMonthlyEkonomi: [],
            dataYearlyEkonomi: [],
            tempDataYearlyEkonomi: [{
                    data: [], // BisaMembantu
                },{
                    data: [], // Biasa
                },{
                    data: [], // PerluDibantu
                }],
            tempDataMonthlyEkonomi: [{
                    data: [], // BisaMembantu
                },{
                    data: [], // Biasa
                },{
                    data: [], // PerluDibantu
                }],
            seriesEkonomiPerBulan: [{
                name: "Bisa Membantu",
                data: [13, 15, 12, 20, 18, 15, 16, 13, 14]
                },{
                name: "Biasa",
                data: [61, 57, 63, 55, 58, 54, 55, 61, 65]
                },{
                name: 'Perlu Dibantu',
                data: [15, 17, 14, 14, 13, 20, 18, 15, 14]
            }],
            seriesEkonomiPerTahun: [{
                name: "Bisa Membantu",
                data: [13, 15, 12, 20, 18, 15, 16, 13, 14]
                },{
                name: "Biasa",
                data: [61, 57, 63, 55, 58, 54, 55, 61, 65]
                },{
                name: 'Perlu Dibantu',
                data: [15, 17, 14, 14, 13, 20, 18, 15, 14]
            }],
            seriesProsentasePieEkonomiWilayah: [1,1,1],
            seriesProsentasePieEkonomiKeseluruhanWilayah: [1,1,1],
            chartOptionsProsentasePieEkonomiWilayah: {
                labels: ['Bisa Membantu', 'Biasa', 'Perlu Dibantu'],
                decimalsInFloat: 4,
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
            chartOptionsProsentasePieEkonomiKeseluruhanWilayah: {
                labels: ['Bisa Membantu', 'Biasa', 'Perlu Dibantu'],
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
            chartOptionsEkonomiPerBulan: {
                chart: {
                    type: 'line',
                    toolbar: {
                        show: true
                    },
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
                    categories: [
                    ]
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
            chartOptionsEkonomiPerTahun: {
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
            },
        }
    },
    methods: {
        async init() {
            try {
                let resDataPieEkonomi = await this.fetchPieEkonomi();
                let resDataGraphEkonomi = await this.fetchGraphEkonomi();
                this.dataMonthlyEkonomi = resDataGraphEkonomi.data.monthly_chart
                this.dataYearlyEkonomi = resDataGraphEkonomi.data.yearly_chart
                
                if (resDataPieEkonomi.data.current_wilayah.length != 0) {
                    this.statusPieEkonomiCurrentWilayah = true

                    this.seriesProsentasePieEkonomiWilayah = [
                        resDataPieEkonomi.data.current_wilayah.bisa_membantu, 
                        resDataPieEkonomi.data.current_wilayah.biasa, 
                        resDataPieEkonomi.data.current_wilayah.perlu_dibantu
                    ]
                } else {
                    this.statusPieEkonomiCurrentWilayah = false
                }

                if (resDataPieEkonomi.data.all_wilayah.length != 0) {
                    this.statusPieEkonomiAllWilayah = true

                    this.seriesProsentasePieEkonomiKeseluruhanWilayah = [
                        resDataPieEkonomi.data.all_wilayah.bisa_membantu, 
                        resDataPieEkonomi.data.all_wilayah.biasa, 
                        resDataPieEkonomi.data.all_wilayah.perlu_dibantu
                    ]
                } else {
                    this.statusPieEkonomiAllWilayah = false
                }
                
                let tempXaxisMonthlyEkonomi = []
                let tempXaxisYearlyEkonomi = []
                this.clearGraph()

                this.chartOptionsEkonomiPerBulan.xaxis.categories = []
                this.chartOptionsEkonomiPerTahun.xaxis.categories = []
                
                this.dataYearlyEkonomi.map((item, index) => {
                    tempXaxisYearlyEkonomi.push(item.year)
                    this.tempDataYearlyEkonomi[0].data.push(item.data.bisa_membantu)
                    this.tempDataYearlyEkonomi[1].data.push(item.data.biasa)
                    this.tempDataYearlyEkonomi[2].data.push(item.data.perlu_dibantu)
                });

                console.log(this.dataMonthlyEkonomi);
                

                this.dataMonthlyEkonomi.map((item, index) => {
                    tempXaxisMonthlyEkonomi.push(item.month)
                    this.tempDataMonthlyEkonomi[0].data.push(item.data.bisa_membantu)
                    this.tempDataMonthlyEkonomi[1].data.push(item.data.biasa)
                    this.tempDataMonthlyEkonomi[2].data.push(item.data.perlu_dibantu)
                });

                for (let i = 0; i < 3; i++) {
                    this.seriesEkonomiPerTahun[i] = {...this.seriesEkonomiPerTahun[i], ...{
                                                            data: this.tempDataYearlyEkonomi[i].data
                                                        }}
                    this.seriesEkonomiPerBulan[i] = {...this.seriesEkonomiPerBulan[i], ...{
                                                            data: this.tempDataMonthlyEkonomi[i].data
                                                        }}
                }
                
                this.chartOptionsEkonomiPerBulan = {...this.chartOptionsEkonomiPerBulan, ...{
                                                        xaxis: {
                                                            categories: tempXaxisMonthlyEkonomi
                                                        }
                                                    }}
                
                this.chartOptionsEkonomiPerTahun = {...this.chartOptionsEkonomiPerTahun, ...{
                                                        xaxis: {
                                                            categories: tempXaxisYearlyEkonomi
                                                        }
                                                    }}
                                                    
            } catch (error) {
                console.log(error);
            }
        },
        clearGraph() {
            this.tempDataYearlyEkonomi[0].data = []
            this.tempDataMonthlyEkonomi[0].data = []
            this.tempDataYearlyEkonomi[1].data = []
            this.tempDataMonthlyEkonomi[1].data = []
            this.tempDataYearlyEkonomi[2].data = []
            this.tempDataMonthlyEkonomi[2].data = []
        },
        fetchGraphEkonomi() {
            return axios.get('/api/ekonomi?mode=graphEkonomi', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'id_wilayah': this.selectedWilayah
                    }
                })
        },
        fetchPieEkonomi() {
            return axios.get('/api/ekonomi?mode=pieEkonomi', {
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
        if (this.activeTab == 0) {
            this.init();
        }
    },
    watch: {
        selectedWilayah() {
            if (this.activeTab == 0) {
            this.init();
            }
        }
    },
}
</script>

<style>
    .v-icon {
        font-size: 100px;
    }

    .apexcharts-canvas {
        width: 100%!important;
    }
</style>