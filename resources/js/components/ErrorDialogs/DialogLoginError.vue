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
        <p class="title">Sesi terputus!</p>
        <p class="subheading">Silahkan login kembali.</p>
        </v-card-text>
        <v-card-text>
        <div class="pb-1">
            <v-btn
            dark color="primary" large round
            @click="toLogin"
            block :loading="loading"
            >
            login
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
            toLogin() {
                this.$emit('close');
                this.$router.replace('/logout');
            }
        },
    }
</script>
