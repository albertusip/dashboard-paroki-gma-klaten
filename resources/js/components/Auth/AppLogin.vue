<template>
    <v-content class="primary">
        <v-container grid-list-xl fluid fill-height>
            <v-layout align-center justify-center>
                <v-flex xs12 md9 style="max-width: 1000px">
                    <v-card class="pa-5" elevation="10">
                    <v-layout row wrap justify-center align-center>
                        <v-flex xs12 sd8 md6>
                            <v-img src="/assets/images/gma-logo.jpg" contain max-height="250">
                            </v-img>
                        </v-flex>
                        <v-flex xs12 sm8 md6>
                            <v-form ref="form" @submit.prevent="login" lazy-validation>
                                <v-text-field 
                                    prepend-icon="fas fa-user" 
                                    label="Username" 
                                    v-model="form.username.value"
                                    :rules="form.username.rules"
                                    type="text"
                                    autofocus
                                ></v-text-field>
                                <v-text-field 
                                    prepend-icon="fas fa-lock" 
                                    label="Password"
                                    v-model="form.password.value" 
                                    :rules="form.password.rules" 
                                    :append-icon="form.password.show ? 'fas fa-eye-slash' : 'fas fa-eye'"
                                    @click:append="form.password.show = !form.password.show" 
                                    :type="form.password.show ? 'text' : 'password'"
                                ></v-text-field>

                                <div class="red--text"  style="height: 50px">
                                    <transition name="fade">
                                    <span v-if="wrongCredentials">
                                    Username/password anda salah!
                                    </span>
                                    </transition>
                                </div>

                                <div class="text-xs-center">
                                    <v-btn color="primary" large round :loading="isSubmitted" type="submit">Login</v-btn>
                                </div>
                            </v-form>
                        </v-flex>
                    </v-layout>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-content>
</template>

<script>
export default {
    data() {
        return {
            isSubmitted: false,
            wrongCredentials: false,
            form: {
                username: {
                    value: '',
                    rules: [
                        v => !!v || 'Username harus diisi',
                    ],
                },
                password: {
                    show: false,
                    value: '',
                    rules: [
                        v => !!v || 'Password harus diisi',
                    ]
                }
            },
        }
    },
    methods: {
        async login(){
            if(this.$refs.form.validate()) {
                
                this.isSubmitted = true;
                    const request = {
                    username: this.form.username.value,
                    password: this.form.password.value,
                }
                try {
                    const res1 = await this.$user.login(request)
                    if(res1.data.authenticate == true) {
                        await this.$user.storeSession(res1.data)
                        
                        this.$router.replace("/");                
                    } else {
                        this.wrongCredentials = true
                        setTimeout(() => {
                            this.wrongCredentials = false
                        }, 3000);
                    }
                    
                    
                } catch(err) {
                    console.log(err);
                }
                this.isSubmitted = false;
            }
        },  
    },
}
</script>