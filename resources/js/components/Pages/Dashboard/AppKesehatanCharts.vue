<template>
    <v-layout row wrap>
        <v-flex xs12 md6 v-if="statusPieKesehatanCurrentWilayah" class="text-center">
            <div class="headline my-3">Persentase Kesehatan</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <apexchart 
            type=pie 
            :options="chartOptionsPersentasePieKesehatanWilayah" 
            :series="seriesPersentasePieKesehatanWilayah" />
        </v-flex>
        <v-flex xs12 md6 v-else class="text-center">
            <div class="headline my-3">Persentase Kesehatan</div>
            <div class="title my-3"> {{ this.selectedNameWilayah }}</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text custom-font-size-icon">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> {{ this.selectedNameWilayah }}</h2>
            </div>
        </v-flex>

        <v-flex xs12 md6 v-if="statusPieKesehatanAllWilayah" class="text-center">
            <div class="headline my-3">Persentase Kesehatan</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <apexchart 
            type=pie
            :options="chartOptionsPersentasePieKesehatanKeseluruhanWilayah" 
            :series="seriesPersentasePieKesehatanKeseluruhanWilayah" />
        </v-flex>
        <v-flex xs12 md6 v-else class="text-center">
            <div class="headline my-3">Persentase Kesehatan Wilayah</div>
            <div class="title my-3">Keseluruhan Wilayah</div>
            <div class="text-xs-center orange--text">
                <v-icon class="orange--text custom-font-size-icon">report</v-icon>
                <h2 class="">Tidak ada data pada</h2>
                <h2 class=""> Keseluruhan Wilayah</h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphByMonth">
            <div class="headline my-3">Kesehatan per Bulan {{ this.selectedNameWilayah }}</div>
            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsKesehatanPerBulan"
            :series="seriesKesehatanPerBulan"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <div class="headline my-3">Kesehatan per Bulan {{ this.selectedNameWilayah }} </div>
            <div class="text-xs-center orange--text mb-3">
                <v-icon class="orange--text custom-font-size-icon">report</v-icon>
                <h2 class="">Tidak ada data per bulan pada</h2>
                <h2 class="">{{ this.selectedNameWilayah }} </h2>
            </div>
        </v-flex>

        <v-flex xs12 v-if="statusGraphByYearCurrentWilayah">
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Kesehatan per {{ this.selectedTahunCurrentWilayah }} {{ this.selectedNameWilayah }} </div>
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
            :options="chartOptionsKesehatanPerTahunCurrentWilayah"
            :series="seriesKesehatanPerTahunCurrentWilayah"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Kesehatan per {{ this.selectedTahunCurrentWilayah }} {{ this.selectedNameWilayah }} </div>
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
                    <div class="headline my-3">Kesehatan per {{ this.selectedTahunAllWilayah }} Keseluruhan Wilayah </div>
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
            :options="chartOptionsKesehatanPerTahunAllWilayah"
            :series="seriesKesehatanPerTahunAllWilayah"
            />
        </v-flex>
        <v-flex xs12 v-else>
            <v-layout row wrap>
                <v-flex xs12 md10>
                    <div class="headline my-3">Kesehatan per {{ this.selectedTahunAllWilayah }} Keseluruhan Wilayah </div>
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
            statusPieKesehatanCurrentWilayah: true,
            statusPieKesehatanAllWilayah: true,
            dataMonthlyKesehatan: [],
            dataYearlyKesehatanCurrentWilayah: [],
            dataYearlyKesehatanAllWilayah: [],
            tempDataYearlyKesehatanCurrentWilayah: [{
                data: [] // Normal
                },{
                data: [] // Cacat Fisik
                },{
                data: [] // Buta
                },{
                data: [] // Bisu Tuli
                },{
                data: [] // Sulit Mengurus Diri
                },{
                data: [] // Kesulitan Mengingat
                },{
                data: [] // Penyakit kronis
                },{
                data: [] // Pikun
            }],
            tempDataYearlyKesehatanAllWilayah: [{
                data: [] // Normal
                },{
                data: [] // Cacat Fisik
                },{
                data: [] // Buta
                },{
                data: [] // Bisu Tuli
                },{
                data: [] // Sulit Mengurus Diri
                },{
                data: [] // Kesulitan Mengingat
                },{
                data: [] // Penyakit kronis
                },{
                data: [] // Pikun
            }],
            tempDataMonthlyKesehatan: [{
                 data: [] // Normal
                },{
                data: [] // Cacat Fisik
                },{
                data: [] // Buta
                },{
                data: [] // Bisu Tuli
                },{
                data: [] // Sulit Mengurus Diri
                },{
                data: [] // Kesulitan Mengingat
                },{
                data: [] // Penyakit kronis
                },{
                data: [] // Pikun
                }],
            seriesKesehatanPerBulan: [{
                name: "Normal",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Cacat Fisik",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Buta",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Bisu Tuli",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Sulit Mengurus Diri",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Kesulitan Mengingat",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Penyakit kronis",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Pikun",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
            }],
            seriesKesehatanPerTahunCurrentWilayah: [{
                name: "Normal",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Cacat Fisik",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Buta",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Bisu Tuli",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Sulit Mengurus Diri",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Kesulitan Mengingat",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Penyakit kronis",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Pikun",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
            }],
            seriesKesehatanPerTahunAllWilayah: [{
                name: "Normal",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Cacat Fisik",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Buta",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Bisu Tuli",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Sulit Mengurus Diri",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Kesulitan Mengingat",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Penyakit kronis",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
                },{
                name: "Pikun",
                data: [1,1,1,1,1,1,1,1,1,1,1,1]
            }],
            seriesPersentasePieKesehatanWilayah: [1,1],
            seriesPersentasePieKesehatanKeseluruhanWilayah: [1,1],
            chartOptionsPersentasePieKesehatanWilayah: {
                labels: ['Normal', 'Cacat Fisik', 'Buta', 'Bisu Tuli', 'Sulit Mengurus Diri', 'Kesulitan Mengingat', 'Penyakit Kronis', 'Pikun'],
                decimalsInFloat: 4,
                colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#5A2A27', '#F86624', '#1B998B'],
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
            chartOptionsPersentasePieKesehatanKeseluruhanWilayah: {
                labels: ['Normal', 'Cacat Fisik', 'Buta', 'Bisu Tuli', 'Sulit Mengurus Diri', 'Kesulitan Mengingat', 'Penyakit Kronis', 'Pikun'],
                decimalsInFloat: 4,
                colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#5A2A27', '#F86624', '#1B998B'],
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
            chartOptionsKesehatanPerBulan: {
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
                colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#5A2A27', '#F86624', '#1B998B'],
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
            chartOptionsKesehatanPerTahunCurrentWilayah: {
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
                colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#5A2A27', '#F86624', '#1B998B'],
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
            chartOptionsKesehatanPerTahunAllWilayah: {
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
                colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#5A2A27', '#F86624', '#1B998B'],
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
                let resDataPieKesehatan = await this.fetchPieKesehatan();
                
                if (resDataPieKesehatan.data.current_wilayah.length != 0) {
                    this.statusPieKesehatanCurrentWilayah = true

                    this.seriesPersentasePieKesehatanWilayah = [
                        resDataPieKesehatan.data.current_wilayah.normal, 
                        resDataPieKesehatan.data.current_wilayah.cacat_fisik,
                        resDataPieKesehatan.data.current_wilayah.buta, 
                        resDataPieKesehatan.data.current_wilayah.bisu_tuli,
                        resDataPieKesehatan.data.current_wilayah.sulit_mengurus_diri, 
                        resDataPieKesehatan.data.current_wilayah.kesulitan_mengingat,
                        resDataPieKesehatan.data.current_wilayah.penyakit_kronis, 
                        resDataPieKesehatan.data.current_wilayah.pikun,
                    ]
                } else {
                    this.statusPieKesehatanCurrentWilayah = false
                }

                if (resDataPieKesehatan.data.all_wilayah.length != 0) {
                    this.statusPieKesehatanAllWilayah = true

                    this.seriesPersentasePieKesehatanKeseluruhanWilayah = [
                        resDataPieKesehatan.data.all_wilayah.normal, 
                        resDataPieKesehatan.data.all_wilayah.cacat_fisik,
                        resDataPieKesehatan.data.all_wilayah.buta, 
                        resDataPieKesehatan.data.all_wilayah.bisu_tuli,
                        resDataPieKesehatan.data.all_wilayah.sulit_mengurus_diri, 
                        resDataPieKesehatan.data.all_wilayah.kesulitan_mengingat,
                        resDataPieKesehatan.data.all_wilayah.penyakit_kronis, 
                        resDataPieKesehatan.data.all_wilayah.pikun,
                    ]
                } else {
                    this.statusPieKesehatanAllWilayah = false
                }
                                                    
            } catch (error) {
                console.log(error);
            }
        },
        async initGraphByYearCurrentWilayah() {
            try {
                this.dataSelectedTahunCurrentWilayah = this.selectedTahunCurrentWilayah.split(" ");
                
                let resDataGraphKesehatanByYearCurrentWilayah = await this.fetchGraphKesehatanByYearCurrentWilayah();
                
                this.dataYearlyKesehatanCurrentWilayah = resDataGraphKesehatanByYearCurrentWilayah.data.yearly_chart       

                if (this.dataYearlyKesehatanCurrentWilayah.length > 0) {
                    this.statusGraphByYearCurrentWilayah = true

                    let tempXaxisYearlyKesehatan = []
                    this.clearGraphYearlyCurrentWilayah()

                    this.chartOptionsKesehatanPerTahunCurrentWilayah.xaxis.categories = []
                    
                    this.dataYearlyKesehatanCurrentWilayah.map((item, index) => {
                        tempXaxisYearlyKesehatan.push(item.year)
                        this.tempDataYearlyKesehatanCurrentWilayah[0].data.push(item.data.normal)
                        this.tempDataYearlyKesehatanCurrentWilayah[1].data.push(item.data.cacat_fisik)
                        this.tempDataYearlyKesehatanCurrentWilayah[2].data.push(item.data.buta)
                        this.tempDataYearlyKesehatanCurrentWilayah[3].data.push(item.data.bisu_tuli)
                        this.tempDataYearlyKesehatanCurrentWilayah[4].data.push(item.data.sulit_mengurus_diri)
                        this.tempDataYearlyKesehatanCurrentWilayah[5].data.push(item.data.kesulitan_mengingat)
                        this.tempDataYearlyKesehatanCurrentWilayah[6].data.push(item.data.penyakit_kronis)
                        this.tempDataYearlyKesehatanCurrentWilayah[7].data.push(item.data.pikun)
                    });

                    for (let i = 0; i < 8; i++) {
                        this.seriesKesehatanPerTahunCurrentWilayah[i] = {...this.seriesKesehatanPerTahunCurrentWilayah[i], ...{
                                                            data: this.tempDataYearlyKesehatanCurrentWilayah[i].data
                                                        }}
                    }

                    this.chartOptionsKesehatanPerTahunCurrentWilayah = {...this.chartOptionsKesehatanPerTahunCurrentWilayah, ...{
                                                        xaxis: {
                                                            categories: tempXaxisYearlyKesehatan
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
                
                let resDataGraphKesehatanByYearAllWilayah = await this.fetchGraphKesehatanByYearAllWilayah();
                
                this.dataYearlyKesehatanAllWilayah = resDataGraphKesehatanByYearAllWilayah.data.yearly_chart       

                if (this.dataYearlyKesehatanAllWilayah.length > 0) {
                    this.statusGraphByYearAllWilayah = true

                    let tempXaxisYearlyKesehatan = []
                    this.clearGraphYearlyAllWilayah()

                    this.chartOptionsKesehatanPerTahunAllWilayah.xaxis.categories = []
                    
                    this.dataYearlyKesehatanAllWilayah.map((item, index) => {
                        tempXaxisYearlyKesehatan.push(item.year)
                        this.tempDataYearlyKesehatanAllWilayah[0].data.push(item.data.normal)
                        this.tempDataYearlyKesehatanAllWilayah[1].data.push(item.data.cacat_fisik)
                        this.tempDataYearlyKesehatanAllWilayah[2].data.push(item.data.buta)
                        this.tempDataYearlyKesehatanAllWilayah[3].data.push(item.data.bisu_tuli)
                        this.tempDataYearlyKesehatanAllWilayah[4].data.push(item.data.sulit_mengurus_diri)
                        this.tempDataYearlyKesehatanAllWilayah[5].data.push(item.data.kesulitan_mengingat)
                        this.tempDataYearlyKesehatanAllWilayah[6].data.push(item.data.penyakit_kronis)
                        this.tempDataYearlyKesehatanAllWilayah[7].data.push(item.data.pikun)
                    });

                    for (let i = 0; i < 8; i++) {
                        this.seriesKesehatanPerTahunAllWilayah[i] = {...this.seriesKesehatanPerTahunAllWilayah[i], ...{
                                                            data: this.tempDataYearlyKesehatanAllWilayah[i].data
                                                        }}
                    }

                    this.chartOptionsKesehatanPerTahunAllWilayah = {...this.chartOptionsKesehatanPerTahunAllWilayah, ...{
                                                        xaxis: {
                                                            categories: tempXaxisYearlyKesehatan
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
                let resDataGraphKesehatanByMonth = await this.fetchGraphKesehatanByMonth();
                this.dataMonthlyKesehatan = resDataGraphKesehatanByMonth.data.monthly_chart

                if (this.dataMonthlyKesehatan.length > 0) {
                    this.statusGraphByMonth = true
                    let tempXaxisMonthlyKesehatan = []
                    this.clearGraphMonthly()

                    this.chartOptionsKesehatanPerBulan.xaxis.categories = []

                    this.dataMonthlyKesehatan.map((item, index) => {
                        tempXaxisMonthlyKesehatan.push(item.month)
                        this.tempDataMonthlyKesehatan[0].data.push(item.data.normal)
                        this.tempDataMonthlyKesehatan[1].data.push(item.data.cacat_fisik)
                        this.tempDataMonthlyKesehatan[2].data.push(item.data.buta)
                        this.tempDataMonthlyKesehatan[3].data.push(item.data.bisu_tuli)
                        this.tempDataMonthlyKesehatan[4].data.push(item.data.sulit_mengurus_diri)
                        this.tempDataMonthlyKesehatan[5].data.push(item.data.kesulitan_mengingat)
                        this.tempDataMonthlyKesehatan[6].data.push(item.data.penyakit_kronis)
                        this.tempDataMonthlyKesehatan[7].data.push(item.data.pikun)
                    });

                    for (let i = 0; i < 8; i++) {
                        this.seriesKesehatanPerBulan[i] = {...this.seriesKesehatanPerBulan[i], ...{
                                                            data: this.tempDataMonthlyKesehatan[i].data
                                                        }}
                    }
                    
                    this.chartOptionsKesehatanPerBulan = {...this.chartOptionsKesehatanPerBulan, ...{
                                                        xaxis: {
                                                            categories: tempXaxisMonthlyKesehatan
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
            this.tempDataMonthlyKesehatan[0].data = []
            this.tempDataMonthlyKesehatan[1].data = []
            this.tempDataMonthlyKesehatan[2].data = []
            this.tempDataMonthlyKesehatan[3].data = []
            this.tempDataMonthlyKesehatan[4].data = []
            this.tempDataMonthlyKesehatan[5].data = []
            this.tempDataMonthlyKesehatan[6].data = []
            this.tempDataMonthlyKesehatan[7].data = []
        },
        clearGraphYearlyAllWilayah() {
            this.tempDataYearlyKesehatanAllWilayah[0].data = []
            this.tempDataYearlyKesehatanAllWilayah[1].data = []
            this.tempDataYearlyKesehatanAllWilayah[2].data = []
            this.tempDataYearlyKesehatanAllWilayah[3].data = []
            this.tempDataYearlyKesehatanAllWilayah[4].data = []
            this.tempDataYearlyKesehatanAllWilayah[5].data = []
            this.tempDataYearlyKesehatanAllWilayah[6].data = []
            this.tempDataYearlyKesehatanAllWilayah[7].data = []
        },
        clearGraphYearlyCurrentWilayah() {
            this.tempDataYearlyKesehatanCurrentWilayah[0].data = []
            this.tempDataYearlyKesehatanCurrentWilayah[1].data = []
            this.tempDataYearlyKesehatanCurrentWilayah[2].data = []
            this.tempDataYearlyKesehatanCurrentWilayah[3].data = []
            this.tempDataYearlyKesehatanCurrentWilayah[4].data = []
            this.tempDataYearlyKesehatanCurrentWilayah[5].data = []
            this.tempDataYearlyKesehatanCurrentWilayah[6].data = []
            this.tempDataYearlyKesehatanCurrentWilayah[7].data = []
        },
        fetchGraphKesehatanByYearCurrentWilayah() {
            return axios.get('/api/yearly-data?mode=graphKesehatanByYearCurrentWilayah', {
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
        fetchGraphKesehatanByYearAllWilayah() {
            return axios.get('/api/yearly-data?mode=graphKesehatanByYearAllWilayah', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'range_tahun': this.dataSelectedTahunAllWilayah[0],
                    }
                })
        },
        fetchGraphKesehatanByMonth() {
            return axios.get('/api/kesehatan?mode=graphKesehatan', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                    params: {
                        'id_wilayah': this.selectedWilayah
                    }
                })
        },
        fetchPieKesehatan() {
            return axios.get('/api/kesehatan?mode=pieKesehatan', {
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
            this.initAll();
            this.initPie();
            this.initGraphByYearCurrentWilayah();
            this.initGraphByYearAllWilayah();
            this.initGrapByMonth();
        }
    },
    watch: {
        selectedWilayah() {
            if (this.activeTab == 2) {
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