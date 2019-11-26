<template>
    <v-layout row wrap>
        <v-flex xs12 md6 v-if="statusPieBaptisCurrentWilayah" class="text-center">
            <div class="headline my-3">Persentase Baptis</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <apexchart 
            type=pie 
            :options="chartOptionsPersentasePieBaptisWilayah" 
            :series="seriesPersentasePieBaptisWilayah" />
        </v-flex>
        <v-flex xs12 md6 v-else class="text-center">
            <div class="headline my-3">Persentase Baptis</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text mt-5">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> {{ this.selectedNameWilayah }}</h2>
            </div>
        </v-flex>

        <v-flex xs12 md6 v-if="statusPieBaptisAllWilayah" class="text-center">
            <div class="headline my-3">Persentase Baptis</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <apexchart 
            type=pie
            :options="chartOptionsPersentasePieBaptisKeseluruhanWilayah" 
            :series="seriesPersentasePieBaptisKeseluruhanWilayah" />
        </v-flex>
        <v-flex xs12 md6 v-else class="text-center">
            <div class="headline my-3">Persentase Baptis Wilayah</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text mt-5">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> Keseluruhan Wilayah</h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphByMonth">
            <div class="headline my-3">Baptis per Bulan {{ this.selectedNameWilayah }}</div>
            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsBaptisPerBulan"
            :series="seriesBaptisPerBulan"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <div class="headline my-3">Baptis per Bulan {{ this.selectedNameWilayah }} </div>
            <div class="text-xs-center orange--text mb-3">
                <v-icon class="orange--text custom-font-size-icon">report</v-icon>
                <h2 class="">Tidak ada data per bulan pada</h2>
                <h2 class="">{{ this.selectedNameWilayah }} </h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphByYearCurrentWilayah">
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Baptis per {{ this.selectedTahunCurrentWilayah }} {{ this.selectedNameWilayah }} </div>
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
            :options="chartOptionsBaptisPerTahunCurrentWilayah"
            :series="seriesBaptisPerTahunCurrentWilayah"
            />
        </v-flex>
         <v-flex xs12 v-else>
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Baptis per {{ this.selectedTahunCurrentWilayah }} {{ this.selectedNameWilayah }} </div>
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
                <h2 class="">Tidak ada data per Tahun pada</h2>
                <h2 class="">{{ this.selectedNameWilayah }} </h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphByYearAllWilayah">
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Baptis per {{ this.selectedTahunAllWilayah }} Keseluruhan Wilayah </div>
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
            :options="chartOptionsBaptisPerTahunAllWilayah"
            :series="seriesBaptisPerTahunAllWilayah"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Baptis per {{ this.selectedTahunAllWilayah }} Keseluruhan Wilayah </div>
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
            dataSelectedTahunCurrentWilayah: [10,''],
            dataSelectedTahunAllWilayah: [10,''],
            statusGraphByMonth: true,
            statusGraphByYearCurrentWilayah: true,
            statusGraphByYearAllWilayah: true,
            statusPieBaptisCurrentWilayah: true,
            statusPieBaptisAllWilayah: true,
            dataMonthlyBaptis: [],
            dataYearlyBaptisCurrentWilayah: [],
            dataYearlyBaptisAllWilayah: [],
            tempDataYearlyBaptisCurrentWilayah: [{
                    data: [], // Baptis Bayi
                },{
                    data: [], // Baptis Dewasa
                },{
                    data: [], // Belum Baptis
            }],
            tempDataYearlyBaptisAllWilayah: [{
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
                data: [1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Baptis Dewasa",
                data: [1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Belum Baptis",
                data: [1,1,1,1,1,1,1,1,1,1]
            }],
            seriesBaptisPerTahunCurrentWilayah: [{
                name: "Baptis Bayi",
                data: [1]
                },{
                name: "Baptis Dewasa",
                data: [1]
                },{
                name: "Belum Baptis",
                data: [1]
            }],
            seriesBaptisPerTahunAllWilayah: [{
                name: "Baptis Bayi",
                data: [1]
                },{
                name: "Baptis Dewasa",
                data: [1]
                },{
                name: "Belum Baptis",
                data: [1]
            }],
            seriesPersentasePieBaptisWilayah: [1,1],
            seriesPersentasePieBaptisKeseluruhanWilayah: [1,1],
            chartOptionsPersentasePieBaptisWilayah: {
                labels: ['Baptis Bayi', 'Baptis Dewasa', 'Belum Baptis'],
                decimalsInFloat: 4,
                responsive: [{
                    breakpoint: 400,
                    options: {
                        chart: {
                            width: 250,
                            height: 300,
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                },
                {
                    breakpoint: 500,
                    options: {
                        chart: {
                            width: 300,
                            height: 350,
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                },
                {
                    breakpoint: 1500,
                    options: {
                        chart: {
                            width: 350,
                            height: 400,
                            left: 400
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                },
                {
                    breakpoint: 2700,
                    options: {
                        chart: {
                            width: 450,
                            height: 500,
                            left: 400
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                },]
            },
            chartOptionsPersentasePieBaptisKeseluruhanWilayah: {
                labels: ['Baptis Bayi', 'Baptis Dewasa', 'Belum Baptis'],
                responsive: [{
                    breakpoint: 400,
                    options: {
                        chart: {
                            width: 250,
                            height: 300,
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                },
                {
                    breakpoint: 500,
                    options: {
                        chart: {
                            width: 300,
                            height: 350,
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                },
                {
                    breakpoint: 1500,
                    options: {
                        chart: {
                            width: 350,
                            height: 400,
                            left: 400
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                },
                {
                    breakpoint: 2700,
                    options: {
                        chart: {
                            width: 450,
                            height: 500,
                            left: 400
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                },]
            },
            chartOptionsBaptisPerBulan: {
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
            chartOptionsBaptisPerTahunCurrentWilayah: {
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
                    categories: [1100],
                },
                legend: {
                    position: 'bottom',
                },
                fill: {
                    opacity: 1
                }
            },
            chartOptionsBaptisPerTahunAllWilayah: {
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
        async initAll() {
            try {
                this.selectedTahunCurrentWilayah = this.itemsTahunCurrentWilayah[this.itemsTahunCurrentWilayah.length - 1]
                this.selectedTahunAllWilayah = this.itemsTahunAllWilayah[this.itemsTahunAllWilayah.length - 1]
            } catch (error) {
                console.log(error);
                
            }
        },
        async initPie() {
            try {
                let resDataPieBaptis = await this.fetchPieBaptis();
                
                if (resDataPieBaptis.data.current_wilayah.length != 0) {
                    this.statusPieBaptisCurrentWilayah = true

                    this.seriesPersentasePieBaptisWilayah = [
                        resDataPieBaptis.data.current_wilayah.baptis_bayi, 
                        resDataPieBaptis.data.current_wilayah.baptis_dewasa,
                        resDataPieBaptis.data.current_wilayah.belum_baptis,
                    ]
                } else {
                    this.statusPieBaptisCurrentWilayah = false
                }

                if (resDataPieBaptis.data.all_wilayah.length != 0) {
                    this.statusPieBaptisAllWilayah = true

                    this.seriesPersentasePieBaptisKeseluruhanWilayah = [
                        resDataPieBaptis.data.all_wilayah.baptis_bayi, 
                        resDataPieBaptis.data.all_wilayah.baptis_dewasa,
                        resDataPieBaptis.data.all_wilayah.belum_baptis,
                    ]
                } else {
                    this.statusPieBaptisAllWilayah = false
                }
                                  
            } catch (error) {
                console.log(error);
            }
        },
        async initGraphByYearCurrentWilayah() {
            try {
                this.dataSelectedTahunCurrentWilayah = this.selectedTahunCurrentWilayah.split(" ");
                
                let resDataGraphBaptisByYearCurrentWilayah = await this.fetchGraphBaptisByYearCurrentWilayah();
                
                this.dataYearlyBaptisCurrentWilayah = resDataGraphBaptisByYearCurrentWilayah.data.yearly_chart       

                if (this.dataYearlyBaptisCurrentWilayah.length > 0) {
                    this.statusGraphByYearCurrentWilayah = true

                    let tempXaxisYearlyBaptis = []
                    this.clearGraphYearlyCurrentWilayah()

                    this.chartOptionsBaptisPerTahunCurrentWilayah.xaxis.categories = []
                    
                    this.dataYearlyBaptisCurrentWilayah.map((item, index) => {
                        tempXaxisYearlyBaptis.push(item.year)
                        this.tempDataYearlyBaptisCurrentWilayah[0].data.push(item.data.baptis_bayi)
                        this.tempDataYearlyBaptisCurrentWilayah[1].data.push(item.data.baptis_dewasa)
                        this.tempDataYearlyBaptisCurrentWilayah[2].data.push(item.data.belum_baptis)
                    });

                    for (let i = 0; i < 3; i++) {
                        this.seriesBaptisPerTahunCurrentWilayah[i] = {...this.seriesBaptisPerTahunCurrentWilayah[i], ...{
                                                                data: this.tempDataYearlyBaptisCurrentWilayah[i].data
                                                            }}
                    }

                    this.chartOptionsBaptisPerTahunCurrentWilayah = {...this.chartOptionsBaptisPerTahunCurrentWilayah, ...{
                                                            xaxis: {
                                                                categories: tempXaxisYearlyBaptis
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
                
                let resDataGraphBaptisByYearAllCurrentWilayah = await this.fetchGraphBaptisByYearAllWilayah();
                
                this.dataYearlyBaptisAllWilayah = resDataGraphBaptisByYearAllCurrentWilayah.data.yearly_chart       

                if (this.dataYearlyBaptisAllWilayah.length > 0) {
                    this.statusGraphByYearAllWilayah = true

                    let tempXaxisYearlyBaptis = []
                    this.clearGraphYearlyAllWilayah()

                    this.chartOptionsBaptisPerTahunAllWilayah.xaxis.categories = []
                    
                    this.dataYearlyBaptisAllWilayah.map((item, index) => {
                        tempXaxisYearlyBaptis.push(item.year)
                        this.tempDataYearlyBaptisAllWilayah[0].data.push(item.data.baptis_bayi)
                        this.tempDataYearlyBaptisAllWilayah[1].data.push(item.data.baptis_dewasa)
                        this.tempDataYearlyBaptisAllWilayah[2].data.push(item.data.belum_baptis)
                    });

                    for (let i = 0; i < 3; i++) {
                        this.seriesBaptisPerTahunAllWilayah[i] = {...this.seriesBaptisPerTahunAllWilayah[i], ...{
                                                                data: this.tempDataYearlyBaptisAllWilayah[i].data
                                                            }}
                    }

                    this.chartOptionsBaptisPerTahunAllWilayah = {...this.chartOptionsBaptisPerTahunAllWilayah, ...{
                                                            xaxis: {
                                                                categories: tempXaxisYearlyBaptis
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
                let resDataGraphBaptisByMonth = await this.fetchGraphBaptisByMonth();
                this.dataMonthlyBaptis = resDataGraphBaptisByMonth.data.monthly_chart

                if (this.dataMonthlyBaptis.length > 0) {
                    this.statusGraphByMonth = true
                    let tempXaxisMonthlyBaptis = []
                    this.clearGraphMonthly()

                    this.chartOptionsBaptisPerBulan.xaxis.categories = []

                    this.dataMonthlyBaptis.map((item, index) => {
                        tempXaxisMonthlyBaptis.push(item.month)
                        this.tempDataMonthlyBaptis[0].data.push(item.data.baptis_bayi)
                        this.tempDataMonthlyBaptis[1].data.push(item.data.baptis_dewasa)
                        this.tempDataMonthlyBaptis[2].data.push(item.data.belum_baptis)
                    });

                    for (let i = 0; i < 3; i++) {
                        this.seriesBaptisPerBulan[i] = {...this.seriesBaptisPerBulan[i], ...{
                                                                data: this.tempDataMonthlyBaptis[i].data
                                                            }}
                    }
                    
                    this.chartOptionsBaptisPerBulan = {...this.chartOptionsBaptisPerBulan, ...{
                                                            xaxis: {
                                                                categories: tempXaxisMonthlyBaptis
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
            this.tempDataMonthlyBaptis[0].data = []
            this.tempDataMonthlyBaptis[1].data = []
            this.tempDataMonthlyBaptis[2].data = []
        },
        clearGraphYearlyAllWilayah() {
            this.tempDataYearlyBaptisAllWilayah[0].data = []
            this.tempDataYearlyBaptisAllWilayah[1].data = []
            this.tempDataYearlyBaptisAllWilayah[2].data = []
        },
        clearGraphYearlyCurrentWilayah() {
            this.tempDataYearlyBaptisCurrentWilayah[0].data = []
            this.tempDataYearlyBaptisCurrentWilayah[1].data = []
            this.tempDataYearlyBaptisCurrentWilayah[2].data = []
        },
        fetchGraphBaptisByYearCurrentWilayah() {
            return axios.get('/api/yearly-data?mode=graphBaptisByYearCurrentWilayah', {
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
        fetchGraphBaptisByYearAllWilayah() {
            return axios.get('/api/yearly-data?mode=graphBaptisByYearAllWilayah', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'range_tahun': this.dataSelectedTahunAllWilayah[0],
                    }
                })
        },
        fetchGraphBaptisByMonth() {
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
            this.initAll();
            this.initPie();
            this.initGraphByYearCurrentWilayah();
            this.initGraphByYearAllWilayah();
            this.initGrapByMonth();
        }
    },
    watch: {
        selectedWilayah() {
            if (this.activeTab == 3) {
                this.initPie();
                this.initGraphByYearCurrentWilayah();
                this.initGraphByYearAllWilayah();
                this.initGrapByMonth();
            }
        },
        selectedTahunCurrentWilayah() {
            this.initGraphByYearCurrentWilayah();
        },
        selectedTahunAllWilayah() {
            this.initGraphByYearAllWilayah();
        },
    },
}
</script>

<style scoped>
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