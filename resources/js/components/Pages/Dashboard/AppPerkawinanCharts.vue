<template>
    <v-layout row wrap>
        <v-flex xs12 md6 v-if="statusPiePerkawinanCurrentWilayah" class="text-center">
            <div class="headline my-3">Persentase Perkawinan</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <apexchart 
            type=pie 
            :options="chartOptionsPersentasePiePerkawinanWilayah" 
            :series="seriesPersentasePiePerkawinanWilayah" />
        </v-flex>
        <v-flex xs12 md6 v-else class="text-center">
            <div class="headline my-3">Persentase Perkawinan</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text custom-font-size-icon">fas fa-exclamation-triangle</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> {{ this.selectedNameWilayah }}</h2>
            </div>
        </v-flex>
        
        <v-flex xs12 md6 v-if="statusPiePerkawinanAllWilayah" class="text-center">
            <div class="headline my-3">Persentase Perkawinan</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <apexchart 
            type=pie
            :options="chartOptionsPersentasePiePerkawinanKeseluruhanWilayah" 
            :series="seriesPersentasePiePerkawinanKeseluruhanWilayah" />
        </v-flex>
        <v-flex xs12 md6 v-else class="text-center">
            <div class="headline my-3">Persentase Perkawinan Wilayah</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text custom-font-size-icon">fas fa-exclamation-triangle</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> Keseluruhan Wilayah</h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphByMonth">
            <div class="headline my-3">Perkawinan per Bulan {{ this.selectedNameWilayah }}</div>
            <apexchart 
            type=line 
            height=350 
            :options="chartOptionsPerkawinanPerBulan" 
            :series="seriesPerkawinanPerBulan" />
        </v-flex>
        <v-flex xs12 v-else>
            <div class="headline my-3">Perkawinan per Bulan {{ this.selectedNameWilayah }} </div>
            <div class="text-xs-center orange--text mb-3">
                <v-icon class="orange--text custom-font-size-icon">fas fa-exclamation-triangle</v-icon>
                <h2 class="">Tidak ada data per bulan pada</h2>
                <h2 class="">{{ this.selectedNameWilayah }} </h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphByYearCurrentWilayah">
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Perkawinan per {{ this.selectedTahunCurrentWilayah }} {{ this.selectedNameWilayah }} </div>
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
            :options="chartOptionsPerkawinanPerTahunCurrentWilayah"
            :series="seriesPerkawinanPerTahunCurrentWilayah"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Perkawinan per {{ this.selectedTahunCurrentWilayah }} {{ this.selectedNameWilayah }} </div>
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
                <v-icon class="orange--text custom-font-size-icon">fas fa-exclamation-triangle</v-icon>
                <h2 class="">Tidak ada data per {{ this.selectedTahunCurrentWilayah }} pada</h2>
                <h2 class="">{{ this.selectedNameWilayah }} </h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphByYearAllWilayah">
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Perkawinan per {{ this.selectedTahunAllWilayah }} Keseluruhan Wilayah </div>
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
            :options="chartOptionsPerkawinanPerTahunAllWilayah"
            :series="seriesPerkawinanPerTahunAllWilayah"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Perkawinan per {{ this.selectedTahunAllWilayah }} Keseluruhan Wilayah </div>
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
                <v-icon class="orange--text custom-font-size-icon">fas fa-exclamation-triangle</v-icon>
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
            default: 1,
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
            statusPiePerkawinanCurrentWilayah: true,
            statusPiePerkawinanAllWilayah: true,
            dataMonthlyPerkawinan: [],
            dataYearlyPerkawinanCurrentWilayah: [],
            dataYearlyPerkawinanAllWilayah: [],
            tempDataMonthlyPerkawinan: [{
                    data: [], // SahKatolik
                },{
                    data: [], // SahBedaAgama
                },{
                    data: [], // SahBedaGereja
            }],
            tempDataYearlyPerkawinanCurrentWilayah: [{
                    data: [], // SahKatolik
                },{
                    data: [], // SahBedaAgama
                },{
                    data: [], // SahBedaGereja
            }],
            tempDataYearlyPerkawinanAllWilayah: [{
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
            seriesPerkawinanPerTahunCurrentWilayah: [{
                name: 'Sah Katolik',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: 'Sah Beda Agama',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: 'Sah Beda Greja',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
            }],
            seriesPerkawinanPerTahunAllWilayah: [{
                name: 'Sah Katolik',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: 'Sah Beda Agama',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
                },{
                name: 'Sah Beda Greja',
                data: [1, 1, 1, 1, 1, 1, 1, 1, 1, 1],
            }],
            seriesPersentasePiePerkawinanWilayah: [1, 1, 1],
            seriesPersentasePiePerkawinanKeseluruhanWilayah: [1, 1, 1],
            chartOptionsPersentasePiePerkawinanWilayah: {
                labels: ['Sah Katolik', 
                        'Sah Beda Agama', 
                        'Sah Beda Gereja',
                        ],
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
            chartOptionsPersentasePiePerkawinanKeseluruhanWilayah: {
                labels: ['Sah Katolik', 
                        'Sah Beda Agama', 
                        'Sah Beda Gereja'
                        ],
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
            chartOptionsPerkawinanPerBulan: {
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
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    }
                },
            },
            chartOptionsPerkawinanPerTahunCurrentWilayah: {
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
                    categories: [2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018 , 2019],
                },
                legend: {
                    position: 'bottom',
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    }
                },
            },
            chartOptionsPerkawinanPerTahunAllWilayah: {
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
                    categories: [2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018 , 2019],
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
            
            let resDataPiePerkawinan = await this.fetchPiePerkawinan();
            
            if (resDataPiePerkawinan.data.current_wilayah.length != 0) {
                this.statusPiePerkawinanCurrentWilayah = true

                this.seriesPersentasePiePerkawinanWilayah = [
                resDataPiePerkawinan.data.current_wilayah.sah_katolik,
                resDataPiePerkawinan.data.current_wilayah.sah_beda_agama,
                resDataPiePerkawinan.data.current_wilayah.sah_beda_gereja,
                ]
            } else {
                this.statusPiePerkawinanCurrentWilayah = false
            }

            if (resDataPiePerkawinan.data.all_wilayah.length != 0) {
                this.statusPiePerkawinanAllWilayah = true

                this.seriesPersentasePiePerkawinanKeseluruhanWilayah = [
                resDataPiePerkawinan.data.all_wilayah.sah_katolik,
                resDataPiePerkawinan.data.all_wilayah.sah_beda_agama,
                resDataPiePerkawinan.data.all_wilayah.sah_beda_gereja,
                ]
            } else {
                this.statusPiePerkawinanAllWilayah = false
            }

        },
        async initGraphByYearCurrentWilayah() {
            try {
                this.dataSelectedTahunCurrentWilayah = this.selectedTahunCurrentWilayah.split(" ");
                
                let resDataGraphPerkawinanByYearCurrentWilayah = await this.fetchGraphPerkawinanByYearCurrentWilayah();
                
                this.dataYearlyPerkawinanCurrentWilayah = resDataGraphPerkawinanByYearCurrentWilayah.data.yearly_chart
                
                if (this.dataYearlyPerkawinanCurrentWilayah.length > 0) {
                    this.statusGraphByYearCurrentWilayah = true
                    
                    let tempXaxisYearlyPerkawinan = []
                    this.clearGraphYearlyCurrentWilayah()

                    this.chartOptionsPerkawinanPerTahunCurrentWilayah.xaxis.categories = []
                    
                    this.dataYearlyPerkawinanCurrentWilayah.map((item, index) => {
                        
                        tempXaxisYearlyPerkawinan.push(item.year)
                        this.tempDataYearlyPerkawinanCurrentWilayah[0].data.push(item.data.sah_katolik)
                        this.tempDataYearlyPerkawinanCurrentWilayah[1].data.push(item.data.sah_beda_agama)
                        this.tempDataYearlyPerkawinanCurrentWilayah[2].data.push(item.data.sah_beda_gereja)
                    })

                    for (let i = 0; i < 3; i++) {
                        this.seriesPerkawinanPerTahunCurrentWilayah[i] = {...this.seriesPerkawinanPerTahunCurrentWilayah[i], ...{
                                                        data: this.tempDataYearlyPerkawinanCurrentWilayah[i].data
                                                    }}
                    }

                    this.chartOptionsPerkawinanPerTahunCurrentWilayah = {...this.chartOptionsPerkawinanPerTahunCurrentWilayah, ...{
                                                                xaxis: {
                                                                    categories: tempXaxisYearlyPerkawinan
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
                
                let resDataGraphPerkawinanByYearAllCurrentWilayah = await this.fetchGraphPerkawinanByYearAllWilayah();
                
                this.dataYearlyPerkawinanAllWilayah = resDataGraphPerkawinanByYearAllCurrentWilayah.data.yearly_chart       

                if (this.dataYearlyPerkawinanAllWilayah.length > 0) {
                    this.statusGraphByYearAllWilayah = true

                    let tempXaxisYearlyPerkawinan = []
                    this.clearGraphYearlyAllWilayah()

                    this.chartOptionsPerkawinanPerTahunAllWilayah.xaxis.categories = []
                    
                    this.dataYearlyPerkawinanAllWilayah.map((item, index) => {
                        tempXaxisYearlyPerkawinan.push(item.year)
                        this.tempDataYearlyPerkawinanAllWilayah[0].data.push(item.data.sah_katolik)
                        this.tempDataYearlyPerkawinanAllWilayah[1].data.push(item.data.sah_beda_agama)
                        this.tempDataYearlyPerkawinanAllWilayah[2].data.push(item.data.sah_beda_gereja)
                    });

                    for (let i = 0; i < 3; i++) {
                        this.seriesPerkawinanPerTahunAllWilayah[i] = {...this.seriesPerkawinanPerTahunAllWilayah[i], ...{
                                                                data: this.tempDataYearlyPerkawinanAllWilayah[i].data
                                                            }}
                    }

                    this.chartOptionsPerkawinanPerTahunAllWilayah = {...this.chartOptionsPerkawinanPerTahunAllWilayah, ...{
                                                            xaxis: {
                                                                categories: tempXaxisYearlyPerkawinan
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
                let resDataGraphPerkawinanByMonth = await this.fetchGraphPerkawinanByMonth();
                this.dataMonthlyPerkawinan = resDataGraphPerkawinanByMonth.data.monthly_chart

                if (this.dataMonthlyPerkawinan.length > 0) {

                    this.statusGraphByMonth = true
                    let tempXaxisMonthlyPerkawinan = []
                    this.clearGraphMonthly()

                    this.dataMonthlyPerkawinan.map((item, index) => {
                        tempXaxisMonthlyPerkawinan.push(item.month)
                        this.tempDataMonthlyPerkawinan[0].data.push(item.data.sah_katolik)
                        this.tempDataMonthlyPerkawinan[1].data.push(item.data.sah_beda_agama)
                        this.tempDataMonthlyPerkawinan[2].data.push(item.data.sah_beda_gereja)
                    })
                    

                    for (let i = 0; i < 3; i++) {
                        
                        this.seriesPerkawinanPerBulan[i] = {...this.seriesPerkawinanPerBulan[i], ...{
                                                                data: this.tempDataMonthlyPerkawinan[i].data
                                                            }}
                    }

                    
                    this.chartOptionsPerkawinanPerBulan = {...this.chartOptionsPerkawinanPerBulan, ...{
                                                            xaxis: {
                                                                categories: tempXaxisMonthlyPerkawinan
                                                            }
                                                        }}
                } else {
                    this.statusGraphByMonth = false
                }

            } catch (error) {
                console.log(error);
            }
        },
        clearGraphYearlyCurrentWilayah() {
            this.tempDataYearlyPerkawinanCurrentWilayah[0].data = []
            this.tempDataYearlyPerkawinanCurrentWilayah[1].data = []
            this.tempDataYearlyPerkawinanCurrentWilayah[2].data = []
        },
        clearGraphYearlyAllWilayah() {
            this.tempDataYearlyPerkawinanAllWilayah[0].data = []
            this.tempDataYearlyPerkawinanAllWilayah[1].data = []
            this.tempDataYearlyPerkawinanAllWilayah[2].data = []
        },
        clearGraphMonthly() {
            this.tempDataMonthlyPerkawinan[0].data = []
            this.tempDataMonthlyPerkawinan[1].data = []
            this.tempDataMonthlyPerkawinan[2].data = []
        },
        fetchGraphPerkawinanByYearCurrentWilayah() {
            return axios.get('/api/yearly-data?mode=graphPerkawinanByYearCurrentWilayah', {
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
        fetchGraphPerkawinanByYearAllWilayah() {
            return axios.get('/api/yearly-data?mode=graphPerkawinanByYearAllWilayah', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'range_tahun': this.dataSelectedTahunAllWilayah[0],
                    }
                })
        },
        fetchGraphPerkawinanByMonth() {
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
            this.initAll();
            this.initPie();
            this.initGraphByYearCurrentWilayah();
            this.initGraphByYearAllWilayah();
            this.initGrapByMonth();
        }
    },
    watch: {
        selectedWilayah() {
            if (this.activeTab == 1) {
                this.initAll();
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
        }
    },
}
</script>

<style>

</style>
