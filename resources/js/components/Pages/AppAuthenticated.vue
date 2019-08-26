<template>
    <v-app>
        <v-toolbar app dense fixed clipped-left color="primary">
            <v-toolbar-side-icon
                @click.stop="drawer = !drawer"
            ></v-toolbar-side-icon>
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
        
        <v-navigation-drawer 
            v-model="drawer"
            app clipped fixed
            class="darkgreen darken-2" dark
        >
            <!-- <v-container fluid>
                <v-img src="/assets/images/logo-white.png" contain class="my-5"> </v-img>
            </v-container> -->
            <v-list>
                <v-list-tile
                    v-for="(item, index) in routes"
                    router
                    :to="item.route"
                    :key="'menu'+index"
                    >
                    <v-list-tile-action>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-tile-action>

                    <v-list-tile-content>
                        <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-navigation-drawer>
        <v-content>
            <router-view></router-view>
        </v-content>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            user: null,
            drawer: false,
            routes: [
                {
                    icon: "dashboard",
                    title: "Dashboard",
                    route: "/",
                },
                {
                    icon: "group",
                    title: "Daftar Umat",
                    route: "/daftar-umat",
                },
                
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
    },
    mounted() {
    },
}
</script>
