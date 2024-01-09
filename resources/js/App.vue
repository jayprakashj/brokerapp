<template>
    <AppBlockMessage message="You can not access or use the application as location permission is required to access the app. Please allow the permission." v-if="!getIsLocationAllowed" :is-location-denied="isLocationDenied" />
    <template v-else>
        <PreLoader v-if="$store.state.default.globalLoader" />
        <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900" x-cloak v-if="$route.name=='customer_enquiry'">
            <main class="main-content w-full px-[var(--margin-x)] pb-8">
                <router-view :key="$route.fullPath"></router-view>
            </main>
        </div>

        <AppLayoutVue v-else></AppLayoutVue>
    </template>
</template>

<script>
import { mapGetters } from 'vuex' ;
import PreLoader from '@/components/layout/app/partials/PreLoader.vue';
import AppBlockMessage from '@/components/layout/app/partials/AppBlock.vue';
import AppLayoutVue from './components/layout/app/AppLayout.vue'
export default {

    components:{
        AppLayoutVue,
        PreLoader,
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
