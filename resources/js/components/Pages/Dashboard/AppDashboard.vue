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
                                        <div class="title font-weight-regular mt-2">{{ this.dataCard.panggilan_imam }}</div>
                                        <div class="body-2 font-weight-light mt-2">
                                            <v-icon class="body-2 font-weight-light" medium dark>refresh</v-icon>
                                            <span>updated today</span>
                                        </div>
                                    </v-flex>
                                </v-layout>
                            </v-card-text>
                        </v-card>
                    </v-flex>

                    <v-flex xs6>
                        <v-select
                            v-model="selected"
                            :items="wilayah"
                            item-text="nama_wilayah"
                            item-value="id_wilayah"
                        ></v-select>
                    </v-flex>

                    <v-flex xs6>
                        <div class="text-right">
                            
                        </div>
                        <div class="vld-parent text-right">
                            <loading 
                            :active.sync="isLoading" 
                            :can-cancel="false"
                            :is-full-page="fullPage"></loading>
                            <v-btn 
                            color="warning"
                            @click.prevent="syncData"
                            >
                                <v-icon>sync</v-icon>    
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
                                    <v-icon>{{ data.icon }}</v-icon>
                                    
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

// Status kematian digabung dengan status kelahiran. hanya menampilkan RIP
// Status kehidupan diganti status kesehatan dan berisi semua recor di tabl kesehatan
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
                    name: 'Status Kesehatan',
                    icon: 'local_hospital'
                },
                {
                    name: 'Status Baptis',
                    icon: 'pool'
                },
                {
                    name: 'Natalitas / Mortalitas',
                    icon: 'pregnant_woman'
                },
                ],
            activeTab: 0,
            isSync: 0,
            labelPiePerkawinan: [],
            dataCard:{},
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
                this.dataCard = resCard.data.data;
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
                }
                )
            
        }
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
</style>
