<template>
    <v-app>
        <v-toolbar app dense fixed clipped-left color="primary">
            <v-img 
                id="img-logo"
                src="/assets/images/gma-logo.jpg" 
                contain 
                max-width="40"
                @click="scrollToTop"
            ></v-img>
            <v-spacer></v-spacer>
            <v-toolbar-items>
            <v-btn 
                flat
                router
                :to="'/logout'"
            > 
                Logout 
            </v-btn>
            </v-toolbar-items>
        </v-toolbar>
        
        <v-snackbar
        v-model="snackbar"
        :timeout="timeout"
        top
        right
        :multi-line= multiLine
        >
            {{ updatedDate }}
            <v-btn
                class="shadow-none text-capitalize"
                color="#323232"
                text
                @click="snackbar = false"
            >
                <span class="red--text" >Tutup</span>
            </v-btn>
        </v-snackbar>
        <v-content>
            <router-view></router-view>
        </v-content>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            timeout: 0,
            snackbar: false,
            multiLine: window.innerWidth > 600 ? false : true,
            updatedDate: " ", //text snackbar
            user: null,
            drawer: false,
            hidden: true,
            routes: [
                {
                    icon: "far fa-chart-bar",
                    title: "Dashboard",
                    route: "/",
                },
                // {
                //     icon: "fas fa-user-plus",
                //     title: "Tambah Umat",
                //     route: "/tambah-umat",
                // },
                
            ],
            toolbarMenu: [
                {
                    icon: "exit_to_app",
                    title: "Logout",
                    route: "/logout"
                }
            ]
        }
    },
    methods: {
        scrollToTop() {
            window.scrollTo(0,0);
        },
        async initUpdatedDate(){
            try {
                this.snackbar = false
                let resUpdatedDate = await this.fetchUpdatedDate();
                this.snackbar = true
                if (resUpdatedDate.data != null) {
                    let splitConvertedUpdatedDate = resUpdatedDate.data.updated_at.split(" ");
                    let convertedUpdatedDate = new Date(splitConvertedUpdatedDate[0])

                    Date.prototype.toShortFormat = function() {

                        var month_names =["Jan","Feb","Mar",
                                        "Apr","May","Jun",
                                        "Jul","Aug","Sep",
                                        "Oct","Nov","Dec"];
                        
                        var day = this.getDate();
                        var month_index = this.getMonth();
                        var year = this.getFullYear();
                        
                        return "" + day + "-" + month_names[month_index] + "-" + year;
                    }

                    splitConvertedUpdatedDate[0] = convertedUpdatedDate.toShortFormat()
                    
                    this.updatedDate = ' Data Tahunan Ditampilkan Sampai Tanggal ' + splitConvertedUpdatedDate.join(" Dan Pada Jam ");
                } else {
                    this.updatedDate = 'Silahkan Lakukan Sinkronasi Data'
                }
                
                
            } catch (error) {
                console.log(error);
            }
        },
        fetchUpdatedDate() {
            return axios.get('/api/dateUpdated', {
                headers: {
                    'Accept': 'application/json',
                    'Content-type': 'application/json'
                }
            })
        }
    },
    watch: {
        hidden() {
            scrollPos = window.pageYOffset || document.documentElement.scrollTop
            if (scrollPos > 200) {
                this.hidden = false 
                console.log('false');
               
            } else {
                this.hidden = true
            }
        },
    },
    mounted() {
        // this.initUpdatedDate();
    },
}
</script>
<style>
    button {
        outline: none;
    }
    .v-btn {
        outline: none;
    }

    .shadow-none {
        box-shadow: 0px 0px 0px 0px!important;
    }

    @media only screen and (min-width: 600px) {
        .v-snack--left.v-snack--top, .v-snack--right.v-snack--top {
            transform: translateY(55px)!important;
        }
    }

</style>