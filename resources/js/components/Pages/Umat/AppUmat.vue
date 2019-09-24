<template>
    <v-form ref="formAdd" @submit.prevent="addUmat" lazy-validation>
        <v-container class="my-5" grid-list-lg>
            <v-card>
                <v-card-text>
                    <v-layout row wrap>
                        
                        <v-flex xs12 class="mb-3">
                            <div class="display-1">
                                Input Data Umat
                            </div>
                        </v-flex>

                        <v-flex xs12 md6>
                            <v-select
                                v-model="selectedWilayah"
                                :items="wilayah"
                                item-text="nama_wilayah"
                                item-value="id_wilayah"
                                label="Pilih Wilayah"
                            ></v-select>
                        </v-flex>
                        
                        <v-flex xs12 md6>
                            <v-select
                                v-model="selectedStatusBaptis"
                                :items="statusBaptis"
                                item-text="deskripsi_wkt_baptis"
                                item-value="id_wkt_baptis"
                                label="Pilih Waktu Baptis"
                            ></v-select>
                        </v-flex>

                        <v-flex xs12 md6>
                            <v-select
                                v-model="selectedEkonomi"
                                :items="ekonomi"
                                item-text="kriteria_ekonomi"
                                item-value="id_ekonomi"
                                label="Pilih Ekonomi Umat"
                            ></v-select>
                        </v-flex>

                        <v-flex xs12 md6>
                            <v-select
                                v-model="selectedStatusKesehatan"
                                :items="statusKesehatan"
                                item-text="deskripsi_sts_sehat"
                                item-value="id_sts_sehat"
                                label="Pilih Status Kesehatan"
                            ></v-select>
                        </v-flex>

                        <v-flex xs12 md6>
                            <v-select
                                v-model="selectedStatusPerkawinan"
                                :items="statusPerkawinan"
                                item-text="deskripsi_sts_kawin"
                                item-value="id_sts_kawin"
                                label="Pilih Status Perkawinan"
                            ></v-select>
                        </v-flex>

                        <v-flex xs12 md6>
                            <v-text-field
                                v-model="jumlah"
                                :rules="jumlahRules"
                                label="Jumlah"
                                required
                            ></v-text-field>
                        </v-flex>
                        
                        <v-flex xs12 class="text-right">
                            <v-btn 
                                class="mr-4"
                                color="warning"
                                v-on:click="addUmat()"
                            >
                                Submit
                            </v-btn>
                        </v-flex>

                    </v-layout>
                </v-card-text>
            </v-card>
        </v-container> 
    </v-form>   
</template>
<script>
export default {
    data () {
        return {
            jumlah: '0',
            selectedWilayah: '01',
            selectedEkonomi: '01',
            selectedStatusBaptis: '01',
            selectedStatusKesehatan: '01',
            selectedStatusPerkawinan: '01',
            wilayah: [],
            ekonomi: [],
            statusBaptis: [],
            statusKesehatan: [],
            statusPerkawinan: [],
            jumlahRules: [
                v => !!v || 'Jumlah is required',
            ],
        }
    },
    methods: {
        async init() {
            try {
                let data = await this.fetchData();
                this.wilayah = data.data.itemsWilayah;
                this.ekonomi = data.data.itemsEkonomi;
                this.statusBaptis = data.data.itemsBaptis;
                this.statusKesehatan = data.data.itemsKesehatan;
                this.statusPerkawinan = data.data.itemsPerkawinan;              
            } catch (error) {
                console.log(error);
            }
        },
        async addUmat() {
            if (this.$refs.formAdd.validate()) {
                
                try {
                    
                    let data = {
                        id_ekonomi: this.selectedEkonomi,
                        id_sts_sehat: this.selectedStatusKesehatan,
                        id_sts_kawin: this.selectedStatusPerkawinan,
                        id_wkt_baptis: this.selectedStatusBaptis,
                        id_wilayah: this.selectedWilayah,
                        loop: this.jumlah,
                    }

                    let response = await this.postNewUmat(data)
                    
                    if (response.status == 200) {
                        swal({
                            title: "Berhasil menambah Umat !!",
                            icon: "success",
                            button: "Tutup",
                        });
                    } else {
                        throw("terjadi masalah dri BE")
                    }
                } catch (error) {
                    
                    swal({
                        title: "Ada masalah !!",
                        icon: "error",
                        button: "Tutup",
                    });
                }
            } else {
                setTimeout(() => {
                    this.$refs.formAdd.resetValidation()
                }, 3000);
            }
        },
        postNewUmat(data) {
            return axios.post('/api/add-umat', data, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-type': 'application/json'
                    }
                })
        },
        fetchData() {
            return new Promise((resolve, reject) => {
                axios.get('/api/select-add-data', {
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
    mounted() {
        this.init();
    },
    watch: {
        selected() {
            this.init();
        }
    }
}
</script>
