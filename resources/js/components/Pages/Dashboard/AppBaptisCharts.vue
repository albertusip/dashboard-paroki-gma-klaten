<template>
    <v-layout row wrap>
        <v-flex xs12 md6 v-if="statusPieBaptisCurrentWilayah" class="text-center">
            <div class="headline my-3">Prosentase Baptis</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <apexchart 
            type=pie 
            :options="chartOptionsProsentasePieBaptisWilayah" 
            :series="seriesProsentasePieBaptisWilayah" />
        </v-flex>
        <v-flex xs12 md6 v-else class="text-center">
            <div class="headline my-3">Prosentase Baptis</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text mt-5">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> {{ this.selectedNameWilayah }}</h2>
            </div>
        </v-flex>

        <v-flex xs12 md6 v-if="statusPieBaptisAllWilayah" class="text-center">
            <div class="headline my-3">Prosentase Baptis</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <apexchart 
            type=pie
            :options="chartOptionsProsentasePieBaptisKeseluruhanWilayah" 
            :series="seriesProsentasePieBaptisKeseluruhanWilayah" />
        </v-flex>
        <v-flex xs12 md6 v-else class="text-center">
            <div class="headline my-3">Prosentase Baptis Wilayah</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text mt-5">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> Keseluruhan Wilayah</h2>
            </div>
        </v-flex>

        <v-flex xs12>
            <div class="headline my-3">Baptis per Bulan {{ this.selectedNameWilayah }}</div>
            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsBaptisPerBulan"
            :series="seriesBaptisPerBulan"
            />
        </v-flex>
        <v-flex xs12>
            <div class="headline my-3">Baptis per Tahun {{ this.selectedNameWilayah }}</div>
            <apexchart
            type=bar
            height= "350px"
            :options="chartOptionsBaptisPerTahun"
            :series="seriesBaptisPerTahun"
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
            statusPieBaptisCurrentWilayah: true,
            statusPieBaptisAllWilayah: true,
            dataPieBaptis: [],
            dataMonthlyBaptis: [],
            dataYearlyBaptis: [],
            tempDataYearlyBaptis: [{
                    data: [], // Baptis Bayi
                },{
                    data: [], // Baptis Dewasa
                },{
                    data: [], // Belum Baptis
                }],
            tempDataMonthlyBaptis: [{
                    data: [], // Baptis Bayi
                },{
                    data: [], // Baptis Dewasa
                },{
                    data: [], // Belum Baptis
                }],
            seriesBaptisPerBulan: [{
                name: "Baptis Bayi",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Baptis Dewasa",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Belum Baptis",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
            }],
            seriesBaptisPerTahun: [{
                name: "Baptis Bayi",
                data: [1]
                },{
                name: "Baptis Dewasa",
                data: [1]
                },{
                name: "Belum Baptis",
                data: [1]
            }],
            seriesProsentasePieBaptisWilayah: [1,1],
            seriesProsentasePieBaptisKeseluruhanWilayah: [1,1],
            chartOptionsProsentasePieBaptisWilayah: {
                labels: ['Baptis Bayi', 'Baptis Dewasa', 'Belum Baptis'],
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
            chartOptionsProsentasePieBaptisKeseluruhanWilayah: {
                labels: ['Baptis Bayi', 'Baptis Dewasa', 'Belum Baptis'],
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
            chartOptionsBaptisPerBulan: {
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
            chartOptionsBaptisPerTahun: {
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
                let resDataPieBaptis = await this.fetchPieBaptis();
                let resDataGraphBaptis = await this.fetchGraphBaptis();
                this.dataMonthlyBaptis = resDataGraphBaptis.data.monthly_chart
                this.dataYearlyBaptis = resDataGraphBaptis.data.yearly_chart
                console.log(this.dataMonthlyBaptis);
                
                if (resDataPieBaptis.data.current_wilayah.length != 0) {
                    this.statusPieBaptisCurrentWilayah = true

                    this.seriesProsentasePieBaptisWilayah = [
                        resDataPieBaptis.data.current_wilayah.baptis_bayi, 
                        resDataPieBaptis.data.current_wilayah.baptis_dewasa,
                        resDataPieBaptis.data.current_wilayah.belum_baptis,
                    ]
                } else {
                    this.statusPieBaptisCurrentWilayah = false
                }

                if (resDataPieBaptis.data.all_wilayah.length != 0) {
                    this.statusPieBaptisAllWilayah = true

                    this.seriesProsentasePieBaptisKeseluruhanWilayah = [
                        resDataPieBaptis.data.all_wilayah.baptis_bayi, 
                        resDataPieBaptis.data.all_wilayah.baptis_dewasa,
                        resDataPieBaptis.data.all_wilayah.belum_baptis,
                    ]
                } else {
                    this.statusPieBaptisAllWilayah = false
                }
                
                let tempXaxisMonthlyBaptis = []
                let tempXaxisYearlyBaptis = []
                this.clearGraph()

                this.chartOptionsBaptisPerBulan.xaxis.categories = []
                this.chartOptionsBaptisPerTahun.xaxis.categories = []
                
                this.dataYearlyBaptis.map((item, index) => {
                    tempXaxisYearlyBaptis.push(item.year)
                    this.tempDataYearlyBaptis[0].data.push(item.data.baptis_bayi)
                    this.tempDataYearlyBaptis[1].data.push(item.data.baptis_dewasa)
                    this.tempDataYearlyBaptis[2].data.push(item.data.belum_baptis)
                });

                this.dataMonthlyBaptis.map((item, index) => {
                    tempXaxisMonthlyBaptis.push(item.month)
                    this.tempDataMonthlyBaptis[0].data.push(item.data.baptis_bayi)
                    this.tempDataMonthlyBaptis[1].data.push(item.data.baptis_dewasa)
                    this.tempDataMonthlyBaptis[2].data.push(item.data.belum_baptis)
                });

                for (let i = 0; i < 3; i++) {
                    this.seriesBaptisPerTahun[i] = {...this.seriesBaptisPerTahun[i], ...{
                                                            data: this.tempDataYearlyBaptis[i].data
                                                        }}
                    this.seriesBaptisPerBulan[i] = {...this.seriesBaptisPerBulan[i], ...{
                                                            data: this.tempDataMonthlyBaptis[i].data
                                                        }}
                }
                
                this.chartOptionsBaptisPerBulan = {...this.chartOptionsBaptisPerBulan, ...{
                                                        xaxis: {
                                                            categories: tempXaxisMonthlyBaptis
                                                        }
                                                    }}
                
                this.chartOptionsBaptisPerTahun = {...this.chartOptionsBaptisPerTahun, ...{
                                                        xaxis: {
                                                            categories: tempXaxisYearlyBaptis
                                                        }
                                                    }}
                                                    
            } catch (error) {
                console.log(error);
            }
        },
        clearGraph() {
            this.tempDataYearlyBaptis[0].data = []
            this.tempDataMonthlyBaptis[0].data = []
            this.tempDataYearlyBaptis[1].data = []
            this.tempDataMonthlyBaptis[1].data = []
            this.tempDataYearlyBaptis[2].data = []
            this.tempDataMonthlyBaptis[2].data = []
        },
        fetchGraphBaptis() {
            return axios.get('/api/baptis?mode=graphBaptis', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'id_wilayah': this.selectedWilayah
                    }
                })
        },
        fetchPieBaptis() {
            return axios.get('/api/baptis?mode=pieBaptis', {
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
        if (this.activeTab == 3) {
            this.init();
        }
    },
    watch: {
        selectedWilayah() {
            if (this.activeTab == 3) {
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