<template>
    <v-layout row wrap>
        <v-flex xs12 md6>
            <div class="title mt-2">Prosentase Ekonomi Wilayah</div>
            <apexchart 
            type=pie 
            :options="chartOptionsProsentasePieEkonomiWilayah" 
            :series="seriesProsentasePieEkonomiWilayah" />
        </v-flex>
        <v-flex xs12 md6>
            <div class="title mt-2">Prosentase Ekonomi Keseluruhan Wilayah</div>
            <apexchart 
            type=pie
            :options="chartOptionsProsentasePieEkonomiKeseluruhanWilayah" 
            :series="seriesProsentasePieEkonomiKeseluruhanWilayah" />
        </v-flex>
        <v-flex xs12>
            <div class="title mt-2">Ekonomi per Bulan</div>
            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsEkonomiPerBulan"
            :series="seriesEkonomiPerBulan"
            />
        </v-flex>
        <v-flex xs12>
            <div class="title mt-2">Ekonomi per Tahun</div>
            <apexchart
            type=line
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
        activeTab: {
            type: Number,
            default: 0,
            required: true,
        }
    },
    data() {
        return {
            dataPieEkonomi: [],
            dataMonthlyEkonomi: [],
            dataYearlyEkonomi: [],
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
                        width: 400
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
                        width: 400
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
                    categories: [],
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
    methods: {
        async init() {
            try {
                let resDataPieEkonomi = await this.fetchPieEkonomi();
                let resDataGraphEkonomi = await this.fetchGraphEkonomi();
                this.dataMonthlyEkonomi = resDataGraphEkonomi.data.monthly_chart
                this.dataYearlyEkonomi = resDataGraphEkonomi.data.yearly_chart
                console.log('ekonomi');
                
                let tempXaxisMonthlyEkonomi = []
                let tempMonthlyEkonomiBisaMembantu = []
                let tempMonthlyEkonomiBiasa = []
                let tempMonthlyEkonomiPerluDibantu = []

                this.dataMonthlyEkonomi.map((item, index) => {
                    tempXaxisMonthlyEkonomi.push(item.month)
                    tempMonthlyEkonomiBisaMembantu.push(item.data.bisa_membantu)
                    tempMonthlyEkonomiBiasa.push(item.data.biasa)
                    tempMonthlyEkonomiPerluDibantu.push(item.data.perlu_dibantu)
                });

                this.seriesEkonomiPerBulan[0] = {...this.seriesEkonomiPerBulan[0], ...{
                                                    name: "Bisa Membantu",
                                                    data: tempMonthlyEkonomiBisaMembantu
                                                    
                }}

                this.seriesEkonomiPerBulan[1] = {...this.seriesEkonomiPerBulan[0], ...{
                                                    name: "Biasa",
                                                    data: tempMonthlyEkonomiBiasa
                                                    
                }}

                this.seriesEkonomiPerBulan[2] = {...this.seriesEkonomiPerBulan[0], ...{
                                                    name: 'Perlu Dibantu',
                                                    data: tempMonthlyEkonomiPerluDibantu
                                                    
                }}
                
                this.chartOptionsEkonomiPerBulan = {...this.chartOptionsEkonomiPerBulan, ...{
                                                        xaxis: {
                                                            categories: tempXaxisMonthlyEkonomi
                                                        }
                                                    }}

                let tempXaxisYearlyEkonomi = []
                let tempYearlyEkonomiBisaMembantu = []
                let tempYearlyEkonomiBiasa = []
                let tempYearlyEkonomiPerluDibantu = []
                
                this.dataYearlyEkonomi.map((item, index) => {
                    tempXaxisYearlyEkonomi.push(item.year)
                    tempYearlyEkonomiBisaMembantu.push(item.data.bisa_membantu)
                    tempYearlyEkonomiBiasa.push(item.data.biasa)
                    tempYearlyEkonomiPerluDibantu.push(item.data.perlu_dibantu)
                });
                
                this.seriesEkonomiPerTahun[0].data = tempYearlyEkonomiBisaMembantu
                this.seriesEkonomiPerTahun[1].data = tempYearlyEkonomiBiasa
                this.seriesEkonomiPerTahun[2].data = tempYearlyEkonomiPerluDibantu
                
                this.chartOptionsEkonomiPerTahun = {...this.chartOptionsEkonomiPerTahun, ...{
                                                        xaxis: {
                                                            categories: tempXaxisYearlyEkonomi
                                                        }
                                                    }}
                this.seriesEkonomiPerTahun[0] = {...this.seriesEkonomiPerTahun[0], ...{
                                                    data: tempYearlyEkonomiBisaMembantu
                                                    
                }}

                this.seriesEkonomiPerTahun[1] = {...this.seriesEkonomiPerTahun[0], ...{
                                                    data: tempYearlyEkonomiBiasa
                                                    
                }}

                this.seriesEkonomiPerTahun[2] = {...this.seriesEkonomiPerTahun[0], ...{
                                                    data: tempYearlyEkonomiPerluDibantu
                                                    
                }}
                
                this.seriesProsentasePieEkonomiWilayah = [resDataPieEkonomi.data.data.bisa_membantu, resDataPieEkonomi.data.data.biasa, resDataPieEkonomi.data.data.perlu_dibantu]
                this.seriesProsentasePieEkonomiKeseluruhanWilayah = [resDataPieEkonomi.data.data.total_semua_wilayah_bisa_membantu, resDataPieEkonomi.data.data.total_semua_wilayah_biasa, resDataPieEkonomi.data.data.total_semua_wilayah_perlu_dibantu]
            } catch (error) {
                console.log(error);
            }
        },
        fetchGraphEkonomi() {
            return axios.get('/api/ekonomi?mode=ekonomi', {
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
            return axios.get('/api/current-ekonomi', {
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
