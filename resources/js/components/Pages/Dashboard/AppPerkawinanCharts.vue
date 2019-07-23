<template>
        <v-layout row wrap>
            <v-flex xs12>
                <div class="title mt-2">Prosentase Perkawinan Wilayah</div>
            </v-flex>
            <v-flex xs12 md6 offset-md3>
                <apexchart 
                type=pie 
                :options="chartOptionsProsentasePiePerkawinan" 
                :series="seriesProsentasePiePerkawinan" />
            </v-flex>
            <!-- <v-flex xs12 md6>
                <apexchart 
                type=pie
                :options="chartOptionsProsentasePiePerkawinanWilayah" 
                :series="seriesProsentasePiePerkawinanWilayah" />
            </v-flex> -->
            <v-flex xs12>
                <div class="title mt-2">Perkawinan per Tahun</div>
                <apexchart 
                type=line 
                height=350 
                :options="chartOptionsPerkawinanPerBulan" 
                :series="seriesPerkawinanPerBulan" />
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
        seriesPerkawinanPerBulan: {
            type: Array,
            default: [],
            required: true,
        },
        seriesProsentasePiePerkawinan: {
            type: Array,
            default: [],
            required: true,
        },
        // seriesProsentasePiePerkawinanWilayah: {
        //     type: Array,
        //     default: [],
        //     required: true,
        // },
        chartOptionsProsentasePiePerkawinan: {
            type: Object,
            default: {},
            required: true,
        },
        chartOptionsProsentasePiePerkawinanWilayah: {
            type: Object,
            default: {},
            required: true,
        },
        chartOptionsPerkawinanPerBulan: {
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
