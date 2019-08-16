<template>
    <v-container class="my-5" grid-list-lg>
        <v-card>
            <v-card-text>
                <v-layout row wrap>
                    <v-flex xs12 sm6 lg4>
                        <v-card color="darkslate darken-2" class="white--text">
                            <v-card-text>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex><span class="subheading font-weight-light">Total Sudah Krisma</span></v-flex>
                                            <v-flex class="text-xs-right"><v-icon medium dark>group</v-icon></v-flex>
                                        </v-layout>
                                        <div class="title font-weight-regular mt-2"> {{ this.dataCard.krisma }} </div>
                                        <div class="body-2 font-weight-light mt-2">
                                            <v-icon class="body-2 font-weight-light" medium dark>refresh</v-icon>
                                            <span>updated today</span>
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 sm6 lg4>
                        <v-card color="darkslate darken-2" class="white--text">
                            <v-card-text>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex><span class="subheading font-weight-light">Total Sudah Baptis</span></v-flex>
                                            <v-flex class="text-xs-right"><v-icon medium dark>group</v-icon></v-flex>
                                        </v-layout>
                                        <div class="title font-weight-regular mt-2">{{ this.dataCard.baptis }}</div>
                                        <div class="body-2 font-weight-light mt-2">
                                            <v-icon class="body-2 font-weight-light" medium dark>refresh</v-icon>
                                            <span>updated today</span>
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                        </v-card>
                    </v-flex>
                    <v-flex xs12 lg4>
                        <v-card color="darkslate darken-2" class="white--text">
                            <v-card-text>
                                <v-layout row wrap>
                                    <v-flex xs12>
                                        <v-layout row wrap>
                                            <v-flex><span class="subheading font-weight-light">Total Panggilan Imam</span></v-flex>
                                            <v-flex class="text-xs-right"><v-icon medium dark>group</v-icon></v-flex>
                                        </v-layout>
                                        <div class="title font-weight-regular mt-2">200</div>
                                        <div class="body-2 font-weight-light mt-2">
                                            <v-icon class="body-2 font-weight-light" medium dark>refresh</v-icon>
                                            <span>updated today</span>
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs12>
                        <v-select
                            v-model="selected"
                            :items="wilayah"
                            item-text="nama_wilayah"
                            item-value="id_wilayah"
                        ></v-select>
                    </v-flex>

                    <v-flex xs12>
                            <v-tabs
                                centered
                                color="cyan"
                                dark
                                icons-and-text
                                v-model="activeTab"
                            >
                                <v-tabs-slider color="yellow"></v-tabs-slider>
                                
                                <v-tab
                                    v-for="data in dataTabs"
                                    :key="data.index"
                                >
                                    {{ data.name }}
                                    <v-icon>{{ data.icon }}</v-icon>
                                </v-tab>

                                <v-tab-item>
                                    <ekonomicharts
                                        :selectedWilayah = 'selected'
                                        :selectedNameWilayah = 'selectedNameWilayah'
                                        :activeTab = 'activeTab'
                                        :key = 'activeTab'
                                    ></ekonomicharts>
                                </v-tab-item>

                                <v-tab-item>
                                    <perkawinancharts
                                        :selectedWilayah = 'selected'
                                        :selectedNameWilayah = 'selectedNameWilayah'
                                        :activeTab = 'activeTab'
                                        :key = 'activeTab'
                                    ></perkawinancharts>
                                </v-tab-item>
                                
                                <v-tab-item>
                                    <kesehatancharts
                                        :selectedWilayah = 'selected'
                                        :selectedNameWilayah = 'selectedNameWilayah'
                                        :activeTab = 'activeTab'
                                        :key = 'activeTab'
                                    ></kesehatancharts>
                                </v-tab-item>
                                
                                <v-tab-item>
                                    <baptischarts
                                        :selectedWilayah = 'selected'
                                        :selectedNameWilayah = 'selectedNameWilayah'
                                        :activeTab = 'activeTab'
                                        :key = 'activeTab'
                                    ></baptischarts>
                                </v-tab-item>

                                <v-tab-item>
                                    <kelahirancharts
                                        :selectedWilayah = 'selected'
                                        :selectedNameWilayah = 'selectedNameWilayah'
                                        :activeTab = 'activeTab'
                                        :key = 'activeTab'
                                    ></kelahirancharts>
                                </v-tab-item>
                            </v-tabs>
                    </v-flex>
                </v-layout>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import EkonomiCharts from './AppEkonomiCharts.vue'
import PerkawinanCharts from './AppPerkawinanCharts.vue'
import KesehatanCharts from './AppKesehatanCharts.vue'
import BaptisCharts from './AppBaptisCharts.vue'
import KelahiranCharts from './AppKelahiranCharts.vue'
import VueApexCharts from 'vue-apexcharts'

export default {
    components: {
        ekonomicharts: EkonomiCharts,
        perkawinancharts: PerkawinanCharts,
        kesehatancharts: KesehatanCharts,
        baptischarts: BaptisCharts,
        kelahirancharts: KelahiranCharts,
        apexchart: VueApexCharts,
    },
    data() {
        return {
            dataTabs: [
                {
                    name: 'Ekonomi Umat',
                    icon: 'local_atm'
                },
                {
                    name: 'Status Perkawinan',
                    icon: 'wc'
                },
                {
                    name: 'Status Kehidupan',
                    icon: 'local_hospital'
                },
                {
                    name: 'Status Baptis',
                    icon: 'pool'
                },
                {
                    name: 'Status Kelahiran',
                    icon: 'pregnant_woman'
                },
                ],
            activeTab: 0,
            labelPiePerkawinan: [],
            dataCard:{},
            selected: '01',
            wilayah: [],
            selectedNameWilayah: 'Wilayah Santa Maria Assumpta Klaten',
            seriesPendidikanPerBulan: [{
                name: "1",
                data: [45, 52, 38, 24, 33, 26, 21, 20, 6]
                },{
                name: "2",
                data: [35, 41, 62, 42, 13, 18, 29, 37, 36]
                },{
                name: '3',
                data: [87, 57, 74, 99, 75, 38, 62, 47, 82]
            }],
            seriesPendidikan: [{
                name: "1",
                data: [45, 52, 38, 24, 33, 26, 21, 20, 6]
                },{
                name: "2",
                data: [35, 41, 62, 42, 13, 18, 29, 37, 36]
                },{
                name: '3',
                data: [87, 57, 74, 99, 75, 38, 62, 47, 82]
            }],
            seriesProsentasePiePendidikan: [44, 55, 13],
            seriesProsentasePiePendidikanWilayah: [44, 55, 13, 43, 22],
            chartOptionsProsentasePiePendidikan: {
                labels: ['1', '2', '3'],
                title: {
                    text: 'Prosentase Pendidikan Keseluruhan',
                    align: 'left',
                    style: {
                    fontSize: "16px",
                    color: '#666'
                    }
                },
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
            chartOptionsProsentasePiePendidikanWilayah: {
                labels: ['1', '2', '3', '4', '5'],
                title: {
                    text: 'Prosentase Pendidikan Berdasarkan Wilayah',
                    align: 'left',
                    style: {
                    fontSize: "16px",
                    color: '#666'
                    }
                },
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
            chartOptionsPendidikanPerBulan: {
                chart: {
                    type: 'line',
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
                    width: 7,
                    curve: 'smooth'
                },

                xaxis: {
                    categories: [2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018
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
                }
            },
            chartOptionsPendidikan: {
                chart: {
                    type: 'line',
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
                    width: 7,
                    curve: 'smooth'
                },

                xaxis: {
                    categories: [2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018
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
                }
            },
        }
    },
    mounted() {
        this.init();
    },
    methods: {
        async init() {
            try {
                let dataWilayah = await this.fetchWilayah();
                this.wilayah = dataWilayah.data.items;
                

                let resCard = await this.fetchCard();
                this.dataCard = resCard.data.data;
                
                for(var i=0; i < this.wilayah.length; i++){

                     /**
                     * Capitalize First Letter Of Each Word In A String
                     *
                     * var splitStr : lowercase string Wilayah and split by white space
                     * 
                     */
                    if( this.wilayah[i].id_wilayah == this.selected){
                        var splitStr = this.wilayah[i].nama_wilayah.toLowerCase().split(' ');
                        for (var i = 0; i < splitStr.length; i++) {
                            splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);     
                        }
                        this.selectedNameWilayah = splitStr.join(' ')
                    }
                }

            } catch (error) {
                console.log(error);
            }
        },
        fetchWilayah() {
            return new Promise((resolve, reject) => {
                axios.get('/api/wilayah', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                })
                .then(res => resolve(res))
                .catch(error => reject(error))
            })
        },
        fetchCard() {
            return new Promise((resolve, reject) => {
                axios.get('/api/current-card', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                })
                .then(res => resolve(res))
                .catch(error => reject(error))
            })
        },
    },
    watch: {
        selected() {
            this.init();
        }
    }
}
</script>
<style>
.apexcharts-toolbar{
    z-index: 1!important;
}
.application a{
    text-decoration: none!important;
}
</style>
