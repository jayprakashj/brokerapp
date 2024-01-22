<template>

    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900" x-cloak>
        <!-- Sidebar -->
        <div class="sidebar print:hidden">
            <MainSidebar />
        </div>

        <Header />

        <MobileSearchBar />
        <RightSidebar />

        <main class="main-content w-full px-[var(--margin-x)] pb-8">
            <router-view :key="$route.fullPath"></router-view>
        </main>
    </div>

</template>

<script>

import { mapGetters } from 'vuex' ;
import MainSidebar from '@/components/layout/app/partials/MainSidebar.vue';
import Header from '@/components/layout/app/partials/Header.vue';
import MobileSearchBar from '@/components/layout/app/partials/MobileSearchBar.vue';
import RightSidebar from '@/components/layout/app/partials/RightSidebar.vue';
import AppBlockMessage from '@/components/layout/app/partials/AppBlock.vue';

export default {
    components:{
        MainSidebar,
        Header,
        MobileSearchBar,
        RightSidebar,
        AppBlockMessage
    },
    mounted(){
        if( navigator.geolocation ){
            this.handleGeoLocation()
        }
    },
    data(){
        return {
            isLocationDenied: false
        }
    },
    computed:{

        ...mapGetters([
            'getIsLocationAllowed'
        ]),
    },
    methods:{
        handleGeoLocation(){
            navigator.permissions.query({
                name:'geolocation'
            }).then(
                ( res ) => {
                    res.onchange = () => {
                        this.handleLocationPermissionState( res.state );
                    }
                    this.handleLocationPermissionState( res.state );
                }
            )
            navigator.geolocation.getCurrentPosition(
                ( position ) => {
                    this.$store.commit('setIsLocationAllowed', true);
                },
                ( err ) => {
                    if( err.code == 1 ){
                        this.isLocationDenied = true;
                    }
                },
                ( position ) => {
                },
            )
        },
        handleLocationPermissionState( state ){
            this.$store.commit('setIsLocationAllowed', (state == 'granted'));
        }
    }
}
</script>

<style>

</style>
