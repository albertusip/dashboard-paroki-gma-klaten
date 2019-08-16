<template>
    <v-layout row wrap>

        <v-flex xs12>
            <div class="headline my-3">Kelahiran per Tahun Wilayah {{ this.selectedNameWilayah }}</div>
            <apexchart
            type=bar
            height= "350px"
            :options="chartOptionsKelahiranPerTahunWilayah"
            :series="seriesKelahiranPerTahunWilayah"
            />
        </v-flex>
        <v-flex xs12>
            <div class="headline my-3">Kelahiran per 10 Tahun Keseluruhan Wilayah {{ this.selectedNameWilayah }}</div>
            <apexchart
            type=bar
            height= "350px"
            :options="chartOptionsKelahiranPerTahunKeseluruhanWilayah"
            :series="seriesKelahiranPerTahunKeseluruhanWilayah"
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
            statusPieKelahiranCurrentWilayah: true,
            statusPieKelahiranAllWilayah: true,
            dataPieKelahiran: [],
            dataKelahiranChartCurrentWilayahByYear: [],
            dataKelahiranChartAllWilayahByYear: [],
            tempDataKelahiranChartAllWilayahByYear: [{
                    data: [], // Laki - Laki
                },{
                    data: [], // Perempuan
                },{
                    data: [], // Lain - Lain
                }],
            tempDataKelahiranChartCurrentWilayahByYear: [{
                    data: [], // Laki - Laki
                },{
                    data: [], // Perempuan
                },{
                    data: [], // Lain - Lain
                }],
            seriesKelahiranPerTahunWilayah: [{
                    name: "Laki - Laki",
                    data: [1]
                },{
                    name: "Perempuan",
                    data: [1]
                },{
                    name: "Lain - Lain",
                    data: [1]
            }],
            seriesKelahiranPerTahunKeseluruhanWilayah: [{
                    name: "Laki-Laki",
                    data: [1]
                },{
                    name: "Perempuan",
                    data: [1]
                },{
                    name: "Lain - Lain",
                    data: [1]
            }],
            chartOptionsKelahiranPerTahunWilayah: {
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
            chartOptionsKelahiranPerTahunKeseluruhanWilayah: {
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
                let resDataGraphKelahiran = await this.fetchGraphKelahiran();
                this.dataKelahiranChartCurrentWilayahByYear = resDataGraphKelahiran.data.current_wilayah_chart
                this.dataKelahiranChartAllWilayahByYear = resDataGraphKelahiran.data.all_wilayah_chart
                console.log(resDataGraphKelahiran);
                
                let tempXaxisKelahiranChartCurrentWilayahByYear = []
                let tempXaxisKelahiranChartAllWilayahByYear = []
                this.clearGraph()

                this.chartOptionsKelahiranPerTahunWilayah.xaxis.categories = []
                this.chartOptionsKelahiranPerTahunKeseluruhanWilayah.xaxis.categories = []
                
                this.dataKelahiranChartCurrentWilayahByYear.map((item, index) => {
                    tempXaxisKelahiranChartCurrentWilayahByYear.push(item.year)
                    this.tempDataKelahiranChartCurrentWilayahByYear[0].data.push(item.data.laki_laki)
                    this.tempDataKelahiranChartCurrentWilayahByYear[1].data.push(item.data.perempuan)
                    this.tempDataKelahiranChartCurrentWilayahByYear[2].data.push(item.data.lain_lain)
                });

                this.dataKelahiranChartAllWilayahByYear.map((item, index) => {
                    tempXaxisKelahiranChartAllWilayahByYear.push(item.year)
                    this.tempDataKelahiranChartAllWilayahByYear[0].data.push(item.data.laki_laki)
                    this.tempDataKelahiranChartAllWilayahByYear[1].data.push(item.data.perempuan)
                    this.tempDataKelahiranChartAllWilayahByYear[2].data.push(item.data.lain_lain)
                });

                for (let i = 0; i < 3; i++) {
                    this.seriesKelahiranPerTahunKeseluruhanWilayah[i] = {...this.seriesKelahiranPerTahunKeseluruhanWilayah[i], ...{
                                                            data: this.tempDataKelahiranChartAllWilayahByYear[i].data
                                                        }}
                    this.seriesKelahiranPerTahunWilayah[i] = {...this.seriesKelahiranPerTahunWilayah[i], ...{
                                                            data: this.tempDataKelahiranChartCurrentWilayahByYear[i].data
                                                        }}
                }
                
                this.chartOptionsKelahiranPerTahunWilayah = {...this.chartOptionsKelahiranPerTahunWilayah, ...{
                                                        xaxis: {
                                                            categories: tempXaxisKelahiranChartCurrentWilayahByYear
                                                        }
                                                    }}
                
                this.chartOptionsKelahiranPerTahunKeseluruhanWilayah = {...this.chartOptionsKelahiranPerTahunKeseluruhanWilayah, ...{
                                                        xaxis: {
                                                            categories: tempXaxisKelahiranChartAllWilayahByYear
                                                        }
                                                    }}
                                                    
            } catch (error) {
                console.log(error);
            }
        },
        clearGraph() {
            this.tempDataKelahiranChartAllWilayahByYear[0].data = []
            this.tempDataKelahiranChartCurrentWilayahByYear[0].data = []
            this.tempDataKelahiranChartAllWilayahByYear[1].data = []
            this.tempDataKelahiranChartCurrentWilayahByYear[1].data = []
            this.tempDataKelahiranChartAllWilayahByYear[2].data = []
            this.tempDataKelahiranChartCurrentWilayahByYear[2].data = []
        },
        fetchGraphKelahiran() {
            return axios.get('/api/kelahiran?mode=graphKelahiran', {
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
        if (this.activeTab == 4) {
            this.init();
        }
    },
    watch: {
        selectedWilayah() {
            if (this.activeTab == 4) {
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