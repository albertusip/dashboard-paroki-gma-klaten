<template>
        <v-layout row wrap>
            <!-- <v-flex xs12 md6>
                <apexchart 
                type=pie 
                :options="chartOptionsProsentasePiePendidikan" 
                :series="seriesProsentasePiePendidikan" />
            </v-flex>
            <v-flex xs12 md6>
                <apexchart 
                type=pie
                :options="chartOptionsProsentasePiePendidikanWilayah" 
                :series="seriesProsentasePiePendidikanWilayah" />
            </v-flex> -->
             <v-flex xs12>
                 <div class="title mt-2">Pendidikan Wilayah</div>
                <apexchart 
                type=line 
                height=350 
                :options="chartOptionsPendidikan" 
                :series="seriesPendidikan" />
            </v-flex>
            <v-flex xs12>
                <div class="title mt-2">Pendidikan per Tahun</div>
                <apexchart 
                type=line 
                height=350 
                :options="chartOptionsPendidikanPerBulan" 
                :series="seriesPendidikanPerBulan" />
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
        seriesPendidikanPerBulan: {
            type: Array,
            default: [],
            required: true,
        },
        seriesProsentasePiePendidikan: {
            type: Array,
            default: [],
            required: true,
        },
        seriesProsentasePiePendidikanWilayah: {
            type: Array,
            default: [],
            required: true,
        },
        seriesPendidikan: {
            type: Array,
            default: [],
            required: true,
        },
        chartOptionsProsentasePiePendidikan: {
            type: Object,
            default: {},
            required: true,
        },
        chartOptionsProsentasePiePendidikanWilayah: {
            type: Object,
            default: {},
            required: true,
        },
        chartOptionsPendidikanPerBulan: {
            type: Object,
            default: {},
            required: true,
        },
        chartOptionsPendidikan: {
            type: Object,
            default: {},
            required: true,
        }
    },
    data() {
        return {
            
        }
    }
}
</script>
