<template>
    <v-layout row wrap>

        <v-flex xs12 v-if="statusGraphNatalitasMortalitasCurrentWilayah">
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Natalitas Mortalitas per {{ this.selectedTahunNatalitasMortalitasCurrentWilayah }} {{ this.selectedNameWilayah }} </div>
                </v-flex>
        
                <v-flex xs12 md2>
                    <v-select
                    :items="itemsTahunNatalitasMortalitasCurrentWilayah"
                    v-model="selectedTahunNatalitasMortalitasCurrentWilayah"
                    label='Rentang Tahun'
                    outlined
                    ></v-select>
                </v-flex>
            </v-layout>

            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsNatalitasMortalitasCurrentWilayah"
            :series="seriesNatalitasMortalitasCurrentWilayah"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Natalitas Mortalitas per {{ this.selectedTahunNatalitasMortalitasCurrentWilayah }} {{ this.selectedNameWilayah }} </div>
                </v-flex>
        
                <v-flex xs12 md2>
                    <v-select
                    :items="itemsTahunNatalitasMortalitasCurrentWilayah"
                    v-model="selectedTahunNatalitasMortalitasCurrentWilayah"
                    label='Rentang Tahun'
                    outlined
                    ></v-select>
                </v-flex>
            </v-layout>

            <div class="text-xs-center orange--text mb-3">
                <v-icon class="orange--text custom-font-size-icon">report</v-icon>
                <h2 class="">Tidak ada data per {{ this.selectedTahunNatalitasMortalitasCurrentWilayah }} pada</h2>
                <h2 class="">{{ this.selectedNameWilayah }} </h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphNatalitasMortalitasAllWilayah">
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Natalitas Mortalitas per {{ this.selectedTahunNatalitasMortalitasAllWilayah }} Keseluruhan Wilayah </div>
                </v-flex>
        
                <v-flex xs12 md2>
                    <v-select
                    :items="itemsTahunNatalitasMortalitasAllWilayah"
                    v-model="selectedTahunNatalitasMortalitasAllWilayah"
                    label='Rentang Tahun'
                    outlined
                    ></v-select>
                </v-flex>
            </v-layout>

            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsNatalitasMortalitasAllWilayah"
            :series="seriesNatalitasMortalitasAllWilayah"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Natalitas Mortalitas per {{ this.selectedTahunNatalitasMortalitasAllWilayah }} {{ this.selectedNameWilayah }} </div>
                </v-flex>
        
                <v-flex xs12 md2>
                    <v-select
                    :items="itemsTahunNatalitasMortalitasAllWilayah"
                    v-model="selectedTahunNatalitasMortalitasAllWilayah"
                    label='Rentang Tahun'
                    outlined
                    ></v-select>
                </v-flex>
            </v-layout>

            <div class="text-xs-center orange--text mb-3">
                <v-icon class="orange--text custom-font-size-icon">report</v-icon>
                <h2 class="">Tidak ada data per {{ this.selectedTahunNatalitasMortalitasAllWilayah }} pada</h2>
                <h2 class="">{{ this.selectedNameWilayah }} </h2>
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
        }
    },
    data() {
        return {
            itemsTahunNatalitasMortalitasCurrentWilayah: [  
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
            itemsTahunNatalitasMortalitasAllWilayah: [  
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
            selectedTahunNatalitasMortalitasCurrentWilayah: '10 Tahun',
            selectedTahunNatalitasMortalitasAllWilayah: '10 Tahun',
            dataSelectedTahunNatalitasMortalitasCurrentWilayah: [10,''],
            dataSelectedTahunNatalitasMortalitasAllWilayah: [10,''],
            statusGraphNatalitasMortalitasCurrentWilayah: true,
            statusGraphNatalitasMortalitasAllWilayah: true,
            dataNatalitasMortalitasCurrentWilayah: [],
            dataNatalitasMortalitasAllWilayah: [],
            tempDataNatalitasMortalitasCurrentWilayah: [{
                    data: [], // BisaMembantu
                },{
                    data: [], // Biasa
            }],
            tempDataNatalitasMortalitasAllWilayah: [{
                    data: [], // BisaMembantu
                },{
                    data: [], // Biasa
            }],
            seriesNatalitasMortalitasCurrentWilayah: [{
                name: "Kelahiran",
                data: [13, 15, 12, 20, 18, 15, 16, 13, 14]
                },{
                name: "Kematian",
                data: [61, 57, 63, 55, 58, 54, 55, 61, 65]
            }],
            seriesNatalitasMortalitasAllWilayah: [{
                name: "Kelahiran",
                data: [13, 15, 12, 20, 18, 15, 16, 13, 14]
                },{
                name: "Kematian",
                data: [61, 57, 63, 55, 58, 54, 55, 61, 65]
            }],
            chartOptionsNatalitasMortalitasCurrentWilayah: {
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
            chartOptionsNatalitasMortalitasAllWilayah: {
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
        async initAll() {
            try {
                this.selectedTahunNatalitasMortalitasCurrentWilayah = this.itemsTahunNatalitasMortalitasCurrentWilayah[this.itemsTahunNatalitasMortalitasCurrentWilayah.length - 1]
                this.selectedTahunNatalitasMortalitasAllWilayah = this.itemsTahunNatalitasMortalitasAllWilayah[this.itemsTahunNatalitasMortalitasAllWilayah.length - 1]
            } catch (error) {
                console.log(error);
                
            }
        },
        async initGraphNatalitasMortalitasCurrentWilayah() {
            try {
                this.dataSelectedTahunNatalitasMortalitasCurrentWilayah = this.selectedTahunNatalitasMortalitasCurrentWilayah.split(" ");
                
                let resDataGraphNatalitasMortalitasCurrentWilayah = await this.fetchGraphNatalitasMortalitasCurrentWilayah();
                
                this.dataNatalitasMortalitasCurrentWilayah = resDataGraphNatalitasMortalitasCurrentWilayah.data.yearly_chart       

                if (this.dataNatalitasMortalitasCurrentWilayah.length > 0) {
                    this.statusGraphNatalitasMortalitasCurrentWilayah = true   

                    let tempXaxisNatalitasMortalitasCurrentWilayah = []
                    this.clearGraphNatalitasMortalitasCurrentWilayah()

                    this.chartOptionsNatalitasMortalitasCurrentWilayah.xaxis.categories = []
                    
                    this.dataNatalitasMortalitasCurrentWilayah.map((item, index) => {
                        tempXaxisNatalitasMortalitasCurrentWilayah.push(item.year)
                        this.tempDataNatalitasMortalitasCurrentWilayah[0].data.push(item.data.total_lahir)
                        this.tempDataNatalitasMortalitasCurrentWilayah[1].data.push(item.data.total_mati)
                    });

                    for (let i = 0; i < 2; i++) {
                        this.seriesNatalitasMortalitasCurrentWilayah[i] = {...this.seriesNatalitasMortalitasCurrentWilayah[i], ...{
                                                                data: this.tempDataNatalitasMortalitasCurrentWilayah[i].data
                                                            }}
                    }

                    this.chartOptionsNatalitasMortalitasCurrentWilayah = {...this.chartOptionsNatalitasMortalitasCurrentWilayah, ...{
                                                            xaxis: {
                                                                categories: tempXaxisNatalitasMortalitasCurrentWilayah
                                                            }
                                                        }}
                } else {
                    this.statusGraphNatalitasMortalitasCurrentWilayah = false
                    this.selectedTahunNatalitasMortalitasCurrentWilayah = '1 Tahun'
                }

            } catch (error) {
                console.log(error);
            }
        },
        async initGraphNatalitasMortalitasAllWilayah() {
            try {
                this.dataSelectedTahunNatalitasMortalitasAllWilayah = this.selectedTahunNatalitasMortalitasAllWilayah.split(" ");
                
                let resDataGraphNatalitasMortalitasAllWilayah = await this.fetchGraphNatalitasMortalitasAllWilayah();
                
                this.dataNatalitasMortalitasAllWilayah = resDataGraphNatalitasMortalitasAllWilayah.data.yearly_chart       

                if (this.dataNatalitasMortalitasAllWilayah.length > 0) {
                    this.statusGraphNatalitasMortalitasAllWilayah = true
                    
                    

                    let tempXaxisNatalitasMortalitasAllWilayah = []
                    this.clearGraphNatalitasMortalitasAllWilayah()

                    this.chartOptionsNatalitasMortalitasAllWilayah.xaxis.categories = []
                    
                    this.dataNatalitasMortalitasAllWilayah.map((item, index) => {
                        tempXaxisNatalitasMortalitasAllWilayah.push(item.year)
                        this.tempDataNatalitasMortalitasAllWilayah[0].data.push(item.data.total_lahir)
                        this.tempDataNatalitasMortalitasAllWilayah[1].data.push(item.data.total_mati)
                    });

                    for (let i = 0; i < 2; i++) {
                        this.seriesNatalitasMortalitasAllWilayah[i] = {...this.seriesNatalitasMortalitasAllWilayah[i], ...{
                                                                data: this.tempDataNatalitasMortalitasAllWilayah[i].data
                                                            }}
                    }

                    this.chartOptionsNatalitasMortalitasAllWilayah = {...this.chartOptionsNatalitasMortalitasAllWilayah, ...{
                                                            xaxis: {
                                                                categories: tempXaxisNatalitasMortalitasAllWilayah
                                                            }
                                                        }}
                } else {
                    this.statusGraphNatalitasMortalitasAllWilayah = false
                    this.selectedTahunNatalitasMortalitasAllWilayah = '1 Tahun'
                }

            } catch (error) {
                console.log(error);
            }
        },
        clearGraphNatalitasMortalitasAllWilayah() {
            this.tempDataNatalitasMortalitasAllWilayah[0].data = []
            this.tempDataNatalitasMortalitasAllWilayah[1].data = []
        },
        clearGraphNatalitasMortalitasCurrentWilayah() {
            this.tempDataNatalitasMortalitasCurrentWilayah[0].data = []
            this.tempDataNatalitasMortalitasCurrentWilayah[1].data = []
        },
        fetchGraphNatalitasMortalitasCurrentWilayah() {
            return axios.get('/api/yearly-data?mode=graphNatalitasMortalitasByYearCurrentWilayah', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'id_wilayah': this.selectedWilayah,
                        'range_tahun': this.dataSelectedTahunNatalitasMortalitasCurrentWilayah[0],
                    }
                })
        },
        fetchGraphNatalitasMortalitasAllWilayah() {
            return axios.get('/api/yearly-data?mode=graphNatalitasMortalitasByYearAllWilayah', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'range_tahun': this.dataSelectedTahunNatalitasMortalitasAllWilayah[0],
                    }
                })
        },
    },
    mounted() {
        if (this.activeTab == 4) {
            this.initAll();
            this.initGraphNatalitasMortalitasCurrentWilayah();
            this.initGraphNatalitasMortalitasAllWilayah();
        }
    },
    watch: {
        selectedWilayah() {
            if (this.activeTab == 4) {
                this.initGraphNatalitasMortalitasCurrentWilayah();
                this.initGraphNatalitasMortalitasAllWilayah();
            }
        },
        selectedTahunNatalitasMortalitasCurrentWilayah() {
                this.initGraphNatalitasMortalitasCurrentWilayah();
        },
        selectedTahunNatalitasMortalitasAllWilayah() {
                this.initGraphNatalitasMortalitasAllWilayah();
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