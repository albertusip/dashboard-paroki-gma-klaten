<template>
    <v-layout row wrap>
        <v-flex xs12 md6 v-if="statusPieKehidupanCurrentWilayah">
            <div class="title mt-2">Prosentase Kehidupan Wilayah</div>
            <apexchart 
            type=pie 
            :options="chartOptionsProsentasePieKehidupanWilayah" 
            :series="seriesProsentasePieKehidupanWilayah" />
        </v-flex>
        <v-flex xs12 md6 v-else>
            <div class="title mt-2">Prosentase Kehidupan Wilayah</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text mt-5">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> {{ this.selectedNameWilayah }}</h2>
            </div>
        </v-flex>

        <v-flex xs12 md6 v-if="statusPieKehidupanAllWilayah">
            <div class="title mt-2">Prosentase Kehidupan Keseluruhan Wilayah</div>
            <apexchart 
            type=pie
            :options="chartOptionsProsentasePieKehidupanKeseluruhanWilayah" 
            :series="seriesProsentasePieKehidupanKeseluruhanWilayah" />
        </v-flex>
        <v-flex xs12 md6 v-else>
            <div class="title mt-2">Prosentase Kehidupan Wilayah</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text mt-5">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> Keseluruhan Wilayah</h2>
            </div>
        </v-flex>

        <v-flex xs12>
            <div class="title mt-2">Kehidupan per Bulan</div>
            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsKehidupanPerBulan"
            :series="seriesKehidupanPerBulan"
            />
        </v-flex>
        <v-flex xs12>
            <div class="title mt-2">Kehidupan per Tahun</div>
            <apexchart
            type=bar
            height= "350px"
            :options="chartOptionsKehidupanPerTahun"
            :series="seriesKehidupanPerTahun"
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
            statusPieKehidupanCurrentWilayah: true,
            statusPieKehidupanAllWilayah: true,
            dataPieKehidupan: [],
            dataMonthlyKehidupan: [],
            dataYearlyKehidupan: [],
            tempDataYearlyKehidupan: [{
                    data: [], // Hidup
                },{
                    data: [], // RIP
                }],
            tempDataMonthlyKehidupan: [{
                    data: [], // Hidup
                },{
                    data: [], // RIP
                }],
            seriesKehidupanPerBulan: [{
                name: "Hidup",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "RIP",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
            }],
            seriesKehidupanPerTahun: [{
                name: "Hidup",
                data: [1]
                },{
                name: "RIP",
                data: [1]
            }],
            seriesProsentasePieKehidupanWilayah: [1,1],
            seriesProsentasePieKehidupanKeseluruhanWilayah: [1,1],
            chartOptionsProsentasePieKehidupanWilayah: {
                labels: ['Hidup', 'RIP'],
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
            chartOptionsProsentasePieKehidupanKeseluruhanWilayah: {
                labels: ['Hidup', 'RIP'],
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
            chartOptionsKehidupanPerBulan: {
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
            chartOptionsKehidupanPerTahun: {
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
                    categories: [1100],
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
                let resDataPieKehidupan = await this.fetchPieKehidupan();
                let resDataGraphKehidupan = await this.fetchGraphKehidupan();
                this.dataMonthlyKehidupan = resDataGraphKehidupan.data.monthly_chart
                this.dataYearlyKehidupan = resDataGraphKehidupan.data.yearly_chart
                console.log(this.dataMonthlyKehidupan);
                
                if (resDataPieKehidupan.data.current_wilayah.length != 0) {
                    this.statusPieKehidupanCurrentWilayah = true

                    this.seriesProsentasePieKehidupanWilayah = [
                        resDataPieKehidupan.data.current_wilayah.status_hidup, 
                        resDataPieKehidupan.data.current_wilayah.status_mati
                    ]
                } else {
                    this.statusPieKehidupanCurrentWilayah = false
                }

                if (resDataPieKehidupan.data.all_wilayah.length != 0) {
                    this.statusPieKehidupanAllWilayah = true

                    this.seriesProsentasePieKehidupanKeseluruhanWilayah = [
                        resDataPieKehidupan.data.all_wilayah.status_hidup, 
                        resDataPieKehidupan.data.all_wilayah.status_mati
                    ]
                } else {
                    this.statusPieKehidupanAllWilayah = false
                }
                
                let tempXaxisMonthlyKehidupan = []
                let tempXaxisYearlyKehidupan = []
                this.clearGraph()

                this.chartOptionsKehidupanPerBulan.xaxis.categories = []
                this.chartOptionsKehidupanPerTahun.xaxis.categories = []
                
                this.dataYearlyKehidupan.map((item, index) => {
                    tempXaxisYearlyKehidupan.push(item.year)
                    this.tempDataYearlyKehidupan[0].data.push(item.data.status_hidup)
                    this.tempDataYearlyKehidupan[1].data.push(item.data.status_mati)
                });

                console.log(this.dataMonthlyKehidupan);
                

                this.dataMonthlyKehidupan.map((item, index) => {
                    tempXaxisMonthlyKehidupan.push(item.month)
                    this.tempDataMonthlyKehidupan[0].data.push(item.data.status_hidup)
                    this.tempDataMonthlyKehidupan[1].data.push(item.data.status_mati)
                });

                for (let i = 0; i < 2; i++) {
                    this.seriesKehidupanPerTahun[i] = {...this.seriesKehidupanPerTahun[i], ...{
                                                            data: this.tempDataYearlyKehidupan[i].data
                                                        }}
                    this.seriesKehidupanPerBulan[i] = {...this.seriesKehidupanPerBulan[i], ...{
                                                            data: this.tempDataMonthlyKehidupan[i].data
                                                        }}
                }
                
                this.chartOptionsKehidupanPerBulan = {...this.chartOptionsKehidupanPerBulan, ...{
                                                        xaxis: {
                                                            categories: tempXaxisMonthlyKehidupan
                                                        }
                                                    }}
                
                this.chartOptionsKehidupanPerTahun = {...this.chartOptionsKehidupanPerTahun, ...{
                                                        xaxis: {
                                                            categories: tempXaxisYearlyKehidupan
                                                        }
                                                    }}
                                                    
            } catch (error) {
                console.log(error);
            }
        },
        clearGraph() {
            this.tempDataYearlyKehidupan[0].data = []
            this.tempDataMonthlyKehidupan[0].data = []
            this.tempDataYearlyKehidupan[1].data = []
            this.tempDataMonthlyKehidupan[1].data = []
        },
        fetchGraphKehidupan() {
            return axios.get('/api/kesehatan?mode=graphUmatHidup', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'id_wilayah': this.selectedWilayah
                    }
                })
        },
        fetchPieKehidupan() {
            return axios.get('/api/kesehatan?mode=pieUmatHidup', {
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
        if (this.activeTab == 2) {
            this.init();
        }
    },
    watch: {
        selectedWilayah() {
            if (this.activeTab == 2) {
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