<template>
    <v-card class="rounded-card">
        <v-card-title class="pt-5">
        <v-img
            src="/assets/svg/err_login.svg"
            height="130"
            contain
        ></v-img>
        </v-card-title>
        <v-card-text class="text-xs-center">
        <p class="title">Masalah koneksi.</p>
        <p class="subheading">Sepertinya terjadi masalah pada koneksi anda. Periksa koneksi anda dan cobalah beberapa saat lagi.</p>
        </v-card-text>
        <v-card-text>
        <div class="pb-1">
            <v-btn
            dark color="primary" large round
            @click="refresh"
            block :loading="loading"
            >
            muat ulang
            </v-btn>  
        </div>
        <div>
            <v-btn
            large round flat
            @click="$emit('close')"
            block
            >
            kembali
            </v-btn>
        </div>
        </v-card-text>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,      
            }
        },
        methods: {
            refresh() {
                this.loading = true;
                window.location = `${this.$route.path}`;
            }
        },
    }
</script>
