<template>
    <v-container class="my-5" grid-list-lg>
        <v-card>
            <v-card-text>
                <v-layout row wrap>
                    <v-flex xs12 md6 lg3 
                    v-for="item in dataCard"
                    :key="item.index">
                        <v-card color="darkslate darken-2" class="white--text">
                            <v-card-text>
                                <v-layout row wrap>
                                    <v-flex xs9>
                                        <span class="subheading font-weight-light">{{ item.name }}</span>
                                    </v-flex>
                                    <v-flex xs3 class="text-xs-right">
                                        <v-icon medium dark>fas fa-user-friends</v-icon>
                                    </v-flex>
                                    <v-flex xs12>
                                        <span class="title font-weight-regular">{{ item.value }}</span>
                                    </v-flex>
                                    <v-flex xs12>
                                        <span class="body-2 font-weight-light">updated today</span>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs12 sm6>
                        <v-select
                            v-model="selected"
                            :items="wilayah"
                            item-text="nama_wilayah"
                            item-value="id_wilayah"
                        ></v-select>
                    </v-flex>

                    <v-flex xs12 sm6>
                        <div class="vld-parent text-right">
                            <loading 
                            :active.sync="isLoading" 
                            :can-cancel="false"
                            :is-full-page="fullPage"></loading>
                            <v-btn 
                            color="warning"
                            @click.prevent="syncData"
                            
                            >
                                <v-icon class="mr-2">fas fa-sync</v-icon>    
                                Sinkronasi Data
                            </v-btn>
                        </div>
                    </v-flex>

                    <v-flex xs12>
                        <v-tabs
                            centered
                            color="cyan"
                            dark
                            icons-and-text
                            v-model="activeTab"
                            show-arrows
                        >
                            <v-tabs-slider color="yellow"></v-tabs-slider>
                            
                            <v-tab
                                v-for="data in dataTabs"
                                :key="data.index"
                            >
                                {{ data.name }}
                                <div>
                                    <v-icon>{{ data.icon }}</v-icon>
                                    <v-icon>{{ data.icon2 }}</v-icon>
                                </div>
                                
                            </v-tab>

                            <v-tab-item>
                                <ekonomicharts
                                    :selectedWilayah = 'selected'
                                    :selectedNameWilayah = 'selectedNameWilayah'
                                    :activeTab = 'activeTab'
                                    :isSync = 'isSync'
                                    :key = 'activeTab'
                                ></ekonomicharts>
                            </v-tab-item>

                            <v-tab-item>
                                <perkawinancharts
                                    :selectedWilayah = 'selected'
                                    :selectedNameWilayah = 'selectedNameWilayah'
                                    :activeTab = 'activeTab'
                                    :isSync = 'isSync'
                                    :key = 'activeTab'
                                ></perkawinancharts>
                            </v-tab-item>
                            
                            <v-tab-item>
                                <kesehatancharts
                                    :selectedWilayah = 'selected'
                                    :selectedNameWilayah = 'selectedNameWilayah'
                                    :activeTab = 'activeTab'
                                    :isSync = 'isSync'
                                    :key = 'activeTab'
                                ></kesehatancharts>
                            </v-tab-item>
                            
                            <v-tab-item>
                                <baptischarts
                                    :selectedWilayah = 'selected'
                                    :selectedNameWilayah = 'selectedNameWilayah'
                                    :activeTab = 'activeTab'
                                    :isSync = 'isSync'
                                    :key = 'activeTab'
                                ></baptischarts>
                            </v-tab-item>

                            <v-tab-item>
                                <kelahirancharts
                                    :selectedWilayah = 'selected'
                                    :selectedNameWilayah = 'selectedNameWilayah'
                                    :activeTab = 'activeTab'
                                    :isSync = 'isSync'
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
// Import component
import VueLoading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

import EkonomiCharts from './AppEkonomiCharts.vue'
import PerkawinanCharts from './AppPerkawinanCharts.vue'
import KesehatanCharts from './AppKesehatanCharts.vue'
import BaptisCharts from './AppBaptisCharts.vue'
import KelahiranCharts from './AppKelahiranCharts.vue'
import VueApexCharts from 'vue-apexcharts'

export default {
    components: {
        loading: VueLoading,
        ekonomicharts: EkonomiCharts,
        perkawinancharts: PerkawinanCharts,
        kesehatancharts: KesehatanCharts,
        baptischarts: BaptisCharts,
        kelahirancharts: KelahiranCharts,
        apexchart: VueApexCharts,
    },
    data() {
        return {
            isLoading: false,
            fullPage: true,
            updatedDate: "",
            dataTabs: [
                {
                    name: 'Ekonomi Umat',
                    icon: 'fas fa-dollar-sign'
                },
                {
                    name: 'Status Perkawinan',
                    icon: 'fas fa-male',
                    icon2: 'fas fa-female'
                },
                {
                    name: 'Status Kesehatan',
                    icon: 'fas fa-briefcase-medical'
                },
                {
                    name: 'Status Baptis',
                    icon: 'fas fa-church'
                },
                {
                    name: 'Natalitas / Mortalitas',
                    icon: 'fas fa-baby',
                    icon2: 'fas fa-cross'
                },
            ],
            activeTab: 0,
            isSync: 0,
            labelPiePerkawinan: [],
            dataCard:[],
            selected: '01',
            wilayah: [],
            selectedNameWilayah: 'Wilayah Santa Maria Assumpta Klaten',
        }
    },
    mounted() {
        this.initCard();
        this.initWilayah();
    },
    methods: {
        async initCard() {
            try {
                let resCard = await this.fetchCard();
                let toArray = Object.values(resCard.data.data);

                if(this.dataCard.length > 3){
                    
                    toArray.map((item,index) => {
                        let temp = {
                            name: item[0],
                            value: item[1]
                        }
                        
                        this.dataCard.push(temp);
                    })
                    this.dataCard.splice(0,4);
                } else {
                    toArray.map((item,index) => {
                        let temp = {
                            name: item[0],
                            value: item[1]
                        }
                        
                        this.dataCard.push(temp);
                    })
                }

            } catch (error) {
                console.log(error);
            }
        },
        async initWilayah() {
            try {
                let self = this


                let dataWilayah = await this.fetchWilayah();
                this.wilayah = dataWilayah.data.items;

                this.wilayah.find(function (value) {

                    /**
                    * Capitalize First Letter Of Each Word In A String
                    *
                    * var splitStr : lowercase string Wilayah and split by white space
                    * 
                    */

                    if( value.id_wilayah == self.selected  ){
                        let splitStr = value.nama_wilayah.toLowerCase().split(' ');
                        let temp = []
                        let upperCase = splitStr.map((item, index) => {
                            temp[index] = item.charAt(0).toUpperCase() + item.substring(1);
                        });

                        self.selectedNameWilayah = temp.join(' ')
                    }
                });
                
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
                axios.get('/api/card-total-info', {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    },
                })
                .then(res => resolve(res))
                .catch(error => reject(error))
            })
        },
        syncData() {
            this.isLoading = true
            return axios.get('/api/recap', {
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                },
                params: {
                    'id_wilayah': this.selected
                }
            })
            .then(res => {
                if (res.status == 200) {
                    this.isLoading = false

                    swal({
                        title: "Berhasil Sinkronisasi Data!",
                        icon: "success",
                        button: "Tutup",
                    })
                    .then((value) => {
                        this.isSync = 1;
                        location.reload();
                    });
                }
            })
        },
    },
    watch: {
        selected() {
            this.initCard();
            this.initWilayah();
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

.apexcharts-canvas {
        width: 100%!important;
    }

.v-menu__content.theme--light.menuable__content__active {
    z-index:3!important;
}

.v-menu__content.theme--light.v-menu__content--auto.v-menu__content--fixed.menuable__content__active {
    z-index:204!important;
}

.custom-font-size-icon {
    font-size: 100px!important;
}
</style>
