<template>
    <v-layout row wrap>

        <v-flex xs12 md6 v-if="statusPieEkonomiCurrentWilayah" class="text-center">
            <div class="headline my-3">Persentase Ekonomi</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <apexchart 
            type=pie 
            :options="chartOptionsPersentasePieEkonomiWilayah" 
            :series="seriesPersentasePieEkonomiWilayah" />
        </v-flex>
        <v-flex xs12 md6 class="text-center" v-else>
            <div class="headline my-3">Persentase Ekonomi Wilayah</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text custom-font-size-icon">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> {{ this.selectedNameWilayah }} </h2>
            </div>
        </v-flex>

        <v-flex xs12 md6 class="text-center" v-if="statusPieEkonomiAllWilayah">
            <div class="headline my-3">Persentase Ekonomi</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <apexchart 
            type=pie
            :options="chartOptionsPersentasePieEkonomiKeseluruhanWilayah" 
            :series="seriesPersentasePieEkonomiKeseluruhanWilayah" />
        </v-flex>
        <v-flex xs12 md6 class="text-center" v-else>
            <div class="headline my-3">Persentase Ekonomi</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text custom-font-size-icon">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> Keseluruhan Wilayah</h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphByMonth">
            <div class="headline my-3">Ekonomi per Bulan {{ this.selectedNameWilayah }} </div>
            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsEkonomiPerBulan"
            :series="seriesEkonomiPerBulan"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <div class="headline my-3">Ekonomi per Bulan {{ this.selectedNameWilayah }} </div>
            <div class="text-xs-center orange--text mb-3">
                <v-icon class="orange--text custom-font-size-icon">report</v-icon>
                <h2 class="">Tidak ada data per bulan pada</h2>
                <h2 class="">{{ this.selectedNameWilayah }} </h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphByYearCurrentWilayah">
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Ekonomi per {{ this.selectedTahunCurrentWilayah }} {{ this.selectedNameWilayah }} </div>
                </v-flex>
        
                <v-flex xs12 md2>
                    <v-select
                    :items="itemsTahunCurrentWilayah"
                    v-model="selectedTahunCurrentWilayah"
                    label='Rentang Tahun'
                    outlined
                    ></v-select>
                </v-flex>
            </v-layout>

            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsEkonomiPerTahunCurrentWilayah"
            :series="seriesEkonomiPerTahunCurrentWilayah"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Ekonomi per {{ this.selectedTahunCurrentWilayah }} {{ this.selectedNameWilayah }} </div>
                </v-flex>
        
                <v-flex xs12 md2>
                    <v-select
                    :items="itemsTahunCurrentWilayah"
                    v-model="selectedTahunCurrentWilayah"
                    label='Rentang Tahun'
                    outlined
                    ></v-select>
                </v-flex>
            </v-layout>

            <div class="text-xs-center orange--text mb-3">
                <v-icon class="orange--text custom-font-size-icon">report</v-icon>
                <h2 class="">Tidak ada data per {{ this.selectedTahunCurrentWilayah }} pada</h2>
                <h2 class="">{{ this.selectedNameWilayah }} </h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphByYearAllWilayah">
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Ekonomi per {{ this.selectedTahunAllWilayah }} Keseluruhan Wilayah </div>
                </v-flex>
        
                <v-flex xs12 md2>
                    <v-select
                    :items="itemsTahunAllWilayah"
                    v-model="selectedTahunAllWilayah"
                    label='Rentang Tahun'
                    outlined
                    ></v-select>
                </v-flex>
            </v-layout>

            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsEkonomiPerTahunAllWilayah"
            :series="seriesEkonomiPerTahunAllWilayah"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Ekonomi per {{ this.selectedTahunAllWilayah }} Keseluruhan Wilayah </div>
                </v-flex>
        
                <v-flex xs12 md2>
                    <v-select
                    :items="itemsTahunAllWilayah"
                    v-model="selectedTahunAllWilayah"
                    label='Rentang Tahun'
                    outlined
                    ></v-select>
                </v-flex>
            </v-layout>

            <div class="text-xs-center orange--text mb-3">
                <v-icon class="orange--text custom-font-size-icon">report</v-icon>
                <h2 class="">Tidak ada data per {{ this.selectedTahunAllWilayah }} pada</h2>
                <h2 class=""> Keseluruhan Wilayah </h2>
            </div>
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
        },
        isSync: {
            type: Number,
            default: 0,
            required: true,
        }
    },
    data() {
        return {
            itemsTahunCurrentWilayah: [  
                '1 Tahun', 
                '2 Tahun', 
                '3 Tahun',
                '4 Tahun',
                '5 Tahun',
                '6 Tahun',
                '7 Tahun',
                '8 Tahun',
                '9 Tahun',
                '10 Tahun'],
            itemsTahunAllWilayah: [  
                '1 Tahun', 
                '2 Tahun', 
                '3 Tahun',
                '4 Tahun',
                '5 Tahun',
                '6 Tahun',
                '7 Tahun',
                '8 Tahun',
                '9 Tahun',
                '10 Tahun'],
            selectedTahunCurrentWilayah: '10 Tahun',
            selectedTahunAllWilayah: '10 Tahun',
            nameWilayah: [],
            dataSelectedTahunCurrentWilayah: [10,''],
            dataSelectedTahunAllWilayah: [10,''],
            statusGraphByMonth: true,
            statusGraphByYearCurrentWilayah: true,
            statusGraphByYearAllWilayah: true,
            statusPieEkonomiCurrentWilayah: true,
            statusPieEkonomiAllWilayah: true,
            dataMonthlyEkonomi: [],
            dataYearlyEkonomiCurrentWilayah: [],
            dataYearlyEkonomiAllWilayah: [],
            tempDataYearlyEkonomiCurrentWilayah: [{
                    data: [], // BisaMembantu
                },{
                    data: [], // Biasa
                },{
                    data: [], // PerluDibantu
            }],
            tempDataYearlyEkonomiAllWilayah: [{
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
            seriesEkonomiPerTahunCurrentWilayah: [{
                name: "Bisa Membantu",
                data: [13, 15, 12, 20, 18, 15, 16, 13, 14]
                },{
                name: "Biasa",
                data: [61, 57, 63, 55, 58, 54, 55, 61, 65]
                },{
                name: 'Perlu Dibantu',
                data: [15, 17, 14, 14, 13, 20, 18, 15, 14]
            }],
            seriesEkonomiPerTahunAllWilayah: [{
                name: "Bisa Membantu",
                data: [13, 15, 12, 20, 18, 15, 16, 13, 14]
                },{
                name: "Biasa",
                data: [61, 57, 63, 55, 58, 54, 55, 61, 65]
                },{
                name: 'Perlu Dibantu',
                data: [15, 17, 14, 14, 13, 20, 18, 15, 14]
            }],
            seriesPersentasePieEkonomiWilayah: [1,1,1],
            seriesPersentasePieEkonomiKeseluruhanWilayah: [1,1,1],
            chartOptionsPersentasePieEkonomiWilayah: {
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
            chartOptionsPersentasePieEkonomiKeseluruhanWilayah: {
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
                        show: false
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
            chartOptionsEkonomiPerTahunCurrentWilayah: {
                chart: {
                    type: 'line',
                    toolbar: {
                        show: false
                    },
                    shadow: {
                        enabled: false,
                        color: '#bbb',
                        top: 3,
                        left: 2,
                        blur: 3,
                        opacity: 1
                    },
                    zoom: {
                        enabled: false
                    }
                },
                stroke: {
                    width: 3,
                    curve: 'smooth'
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
                    categories: [2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019],
                },
                legend: {
                    position: 'bottom',
                },
                fill: {
                    opacity: 1
                }
            },
            chartOptionsEkonomiPerTahunAllWilayah: {
                chart: {
                    type: 'line',
                    toolbar: {
                        show: false
                    },
                    shadow: {
                        enabled: false,
                        color: '#bbb',
                        top: 3,
                        left: 2,
                        blur: 3,
                        opacity: 1
                    },
                    zoom: {
                        enabled: false
                    }
                },
                stroke: {
                    width: 3,
                    curve: 'smooth'
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
                    categories: [2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019],
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
        initAll() {
            this.selectedTahunCurrentWilayah = this.itemsTahunCurrentWilayah[this.itemsTahunCurrentWilayah.length - 1]
            this.selectedTahunAllWilayah = this.itemsTahunAllWilayah[this.itemsTahunAllWilayah.length - 1]
        },
        async initPie() {
            try {
            
                let resDataPieEkonomi = await this.fetchPieEkonomi();
                
                if (resDataPieEkonomi.data.current_wilayah.length != 0) {
                    this.statusPieEkonomiCurrentWilayah = true

                    this.seriesPersentasePieEkonomiWilayah = [
                        resDataPieEkonomi.data.current_wilayah.bisa_membantu, 
                        resDataPieEkonomi.data.current_wilayah.biasa, 
                        resDataPieEkonomi.data.current_wilayah.perlu_dibantu
                    ]
                } else {
                    this.statusPieEkonomiCurrentWilayah = false
                }

                if (resDataPieEkonomi.data.all_wilayah.length != 0) {
                    this.statusPieEkonomiAllWilayah = true

                    this.seriesPersentasePieEkonomiKeseluruhanWilayah = [
                        resDataPieEkonomi.data.all_wilayah.bisa_membantu, 
                        resDataPieEkonomi.data.all_wilayah.biasa, 
                        resDataPieEkonomi.data.all_wilayah.perlu_dibantu
                    ]
                } else {
                    this.statusPieEkonomiAllWilayah = false
                }                                 
            } catch (error) {
                console.log(error);
            }
        },
        async initGraphByYearCurrentWilayah() {
            try {
                this.dataSelectedTahunCurrentWilayah = this.selectedTahunCurrentWilayah.split(" ");
                
                let resDataGraphEkonomiByYearCurrentWilayah = await this.fetchGraphEkonomiByYearCurrentWilayah();
                
                this.dataYearlyEkonomiCurrentWilayah = resDataGraphEkonomiByYearCurrentWilayah.data.yearly_chart       

                if (this.dataYearlyEkonomiCurrentWilayah.length > 0) {
                    this.statusGraphByYearCurrentWilayah = true

                    let tempXaxisYearlyEkonomi = []
                    this.clearGraphYearlyCurrentWilayah()

                    this.chartOptionsEkonomiPerTahunCurrentWilayah.xaxis.categories = []
                    
                    this.dataYearlyEkonomiCurrentWilayah.map((item, index) => {
                        tempXaxisYearlyEkonomi.push(item.year)
                        this.tempDataYearlyEkonomiCurrentWilayah[0].data.push(item.data.bisa_membantu)
                        this.tempDataYearlyEkonomiCurrentWilayah[1].data.push(item.data.biasa)
                        this.tempDataYearlyEkonomiCurrentWilayah[2].data.push(item.data.perlu_dibantu)
                    });

                    for (let i = 0; i < 3; i++) {
                        this.seriesEkonomiPerTahunCurrentWilayah[i] = {...this.seriesEkonomiPerTahunCurrentWilayah[i], ...{
                                                                data: this.tempDataYearlyEkonomiCurrentWilayah[i].data
                                                            }}
                    }

                    this.chartOptionsEkonomiPerTahunCurrentWilayah = {...this.chartOptionsEkonomiPerTahunCurrentWilayah, ...{
                                                            xaxis: {
                                                                categories: tempXaxisYearlyEkonomi
                                                            }
                                                        }}
                } else {
                    this.statusGraphByYearCurrentWilayah = false
                    this.selectedTahunCurrentWilayah = '1 Tahun'
                }

            } catch (error) {
                console.log(error);
            }
        },
        async initGraphByYearAllWilayah() {
            try {
                this.dataSelectedTahunAllWilayah = this.selectedTahunAllWilayah.split(" ");
                
                let resDataGraphEkonomiByYearAllCurrentWilayah = await this.fetchGraphEkonomiByYearAllWilayah();
                
                this.dataYearlyEkonomiAllWilayah = resDataGraphEkonomiByYearAllCurrentWilayah.data.yearly_chart       

                if (this.dataYearlyEkonomiAllWilayah.length > 0) {
                    this.statusGraphByYearAllWilayah = true

                    let tempXaxisYearlyEkonomi = []
                    this.clearGraphYearlyAllWilayah()

                    this.chartOptionsEkonomiPerTahunAllWilayah.xaxis.categories = []
                    
                    this.dataYearlyEkonomiAllWilayah.map((item, index) => {
                        tempXaxisYearlyEkonomi.push(item.year)
                        this.tempDataYearlyEkonomiAllWilayah[0].data.push(item.data.bisa_membantu)
                        this.tempDataYearlyEkonomiAllWilayah[1].data.push(item.data.biasa)
                        this.tempDataYearlyEkonomiAllWilayah[2].data.push(item.data.perlu_dibantu)
                    });

                    for (let i = 0; i < 3; i++) {
                        this.seriesEkonomiPerTahunAllWilayah[i] = {...this.seriesEkonomiPerTahunAllWilayah[i], ...{
                                                                data: this.tempDataYearlyEkonomiAllWilayah[i].data
                                                            }}
                    }

                    this.chartOptionsEkonomiPerTahunAllWilayah = {...this.chartOptionsEkonomiPerTahunAllWilayah, ...{
                                                            xaxis: {
                                                                categories: tempXaxisYearlyEkonomi
                                                            }
                                                        }}
                } else {
                    this.statusGraphByYearAllWilayah = false
                    this.selectedTahunAllWilayah = '1 Tahun'
                }

            } catch (error) {
                console.log(error);
            }
        },
        async initGrapByMonth() {
            try {
                let resDataGraphEkonomiByMonth = await this.fetchGraphEkonomiByMonth();
                this.dataMonthlyEkonomi = resDataGraphEkonomiByMonth.data.monthly_chart

                if (this.dataMonthlyEkonomi.length > 0) {
                    this.statusGraphByMonth = true
                    let tempXaxisMonthlyEkonomi = []
                    this.clearGraphMonthly()

                    this.chartOptionsEkonomiPerBulan.xaxis.categories = []

                    this.dataMonthlyEkonomi.map((item, index) => {
                        tempXaxisMonthlyEkonomi.push(item.month)
                        this.tempDataMonthlyEkonomi[0].data.push(item.data.bisa_membantu)
                        this.tempDataMonthlyEkonomi[1].data.push(item.data.biasa)
                        this.tempDataMonthlyEkonomi[2].data.push(item.data.perlu_dibantu)
                    });

                    for (let i = 0; i < 3; i++) {
                        this.seriesEkonomiPerBulan[i] = {...this.seriesEkonomiPerBulan[i], ...{
                                                                data: this.tempDataMonthlyEkonomi[i].data
                                                            }}
                    }
                    
                    this.chartOptionsEkonomiPerBulan = {...this.chartOptionsEkonomiPerBulan, ...{
                                                            xaxis: {
                                                                categories: tempXaxisMonthlyEkonomi
                                                            }
                                                        }}
                } else {
                    this.statusGraphByMonth = false
                }

            } catch (error) {
                console.log(error);
            }
        },
        clearGraphMonthly() {
            this.tempDataMonthlyEkonomi[0].data = []
            this.tempDataMonthlyEkonomi[1].data = []
            this.tempDataMonthlyEkonomi[2].data = []
        },
        clearGraphYearlyCurrentWilayah() {
            this.tempDataYearlyEkonomiCurrentWilayah[0].data = []
            this.tempDataYearlyEkonomiCurrentWilayah[1].data = []
            this.tempDataYearlyEkonomiCurrentWilayah[2].data = []
        },
        clearGraphYearlyAllWilayah() {
            this.tempDataYearlyEkonomiAllWilayah[0].data = []
            this.tempDataYearlyEkonomiAllWilayah[1].data = []
            this.tempDataYearlyEkonomiAllWilayah[2].data = []
        },
        fetchGraphEkonomiByYearCurrentWilayah() {
            return axios.get('/api/yearly-data?mode=graphEkonomiByYearCurrentWilayah', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'id_wilayah': this.selectedWilayah,
                        'range_tahun': this.dataSelectedTahunCurrentWilayah[0],
                    }
                })
        },
        fetchGraphEkonomiByYearAllWilayah() {
            return axios.get('/api/yearly-data?mode=graphEkonomiByYearAllWilayah', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'range_tahun': this.dataSelectedTahunAllWilayah[0],
                    }
                })
        },
        fetchGraphEkonomiByMonth() {
            return axios.get('/api/ekonomi?mode=graphEkonomi', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'id_wilayah': this.selectedWilayah,
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
            this.initAll();
            this.initPie();
            this.initGraphByYearCurrentWilayah();
            this.initGraphByYearAllWilayah();
            this.initGrapByMonth();
        }
    },
    watch: {
        // isSync() {
        //     if (this.isSync == 1 && this.activeTab == 0) {
        //         this.initPie();
        //         this.initGraphByYearCurrentWilayah();
        //         this.initGraphByYearAllWilayah()
        //         this.initGrapByMonth();
        //         console.log('notSync');
        //         console.log(this.isSync);
        //         this.$emit('isSync', 0)
        //         console.log(this.isSync);
        //         console.log('Sync');
        //     }
        // },
        selectedWilayah() {
            if (this.activeTab == 0) {
                this.initPie();
                this.initGraphByYearCurrentWilayah();
                this.initGraphByYearAllWilayah();
                this.initGrapByMonth();
            }
        },
        selectedTahunCurrentWilayah() {
            this.initGraphByYearCurrentWilayah();
            this.initGraphByYearAllWilayah();
        },
        selectedTahunAllWilayah() {
            this.initGraphByYearAllWilayah();
            this.initGraphByYearAllWilayah();
        }
    },
    computed: {
        toUpperCase: function () {
            
            return this.nameWilayah.join(' ')
        }
    },
}
</script>

<style>
    .apexcharts-canvas {
        width: 100%!important;
    }

    .v-menu__content.theme--light.menuable__content__active {
        z-index:3!important;
    }

    .custom-font-size-icon {
        font-size: 100px!important;
    }
</style>