<template>
    <v-layout row wrap>
        <v-flex xs12 md6>
            <div class="title mt-2">Prosentase Ekonomi Wilayah</div>
            <apexchart 
            type=pie 
            :options="chartOptionsProsentasePieEkonomi" 
            :series="seriesProsentasePieEkonomi" />
        </v-flex>
        <v-flex xs12 md6>
            <div class="title mt-2">Prosentase Ekonomi Keseluruhan Wilayah</div>
            <apexchart 
            type=pie
            :options="chartOptionsProsentasePieEkonomiWilayah" 
            :series="seriesProsentasePieEkonomiWilayah" />
        </v-flex>
        <v-flex xs12>
            <div class="title mt-2">Ekonomi per Tahun</div>
            <apexchart
            type=line
            height= "350px"
            :options="chartOptionsEkonomiPerBulan"
            :series="seriesEkonomiPerBulan"
            />
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
        seriesEkonomiPerBulan: {
            type: Array,
            default: [],
            required: true,
        },
        seriesProsentasePieEkonomi: {
            type: Array,
            default: [],
            required: true,
        },
        seriesProsentasePieEkonomiWilayah: {
            type: Array,
            default: [],
            required: true,
        },
        chartOptionsProsentasePieEkonomi: {
            type: Object,
            default: {},
            required: true,
        },
        chartOptionsProsentasePieEkonomiWilayah: {
            type: Object,
            default: {},
            required: true,
        },
        chartOptionsEkonomiPerBulan: {
            type: Object,
            default: {},
            required: true,
        },
    },
    data() {
        return {
            
        }
    },
    watch: {
        
    },
}
</script>
