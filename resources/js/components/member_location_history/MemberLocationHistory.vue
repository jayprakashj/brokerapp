<template>
    <page-header :title="pageTitle" >
        <template v-slot:actionContainer >
            <div class="flex self-end sm:items-center space-x-2">
                <input-tom-select
                        class="h-full !w-[13rem]"
                        v-model="selected.user"
                        form-label=""
                        placeholder=""
                        value-field="id"
                        display-field="name"
                        :options="users"
                        :selected-item="selected.user"
                        @onChange="onUserChange"
                    />

            </div>
        </template>
    </page-header>

    <div class="mt-4 grid grid-cols-12 gap-4 transition-all duration-[.25s] sm:mt-5 sm:gap-5 lg:gap-6" v-show="markerData?.length">
        <div class="col-span-3">
            <div class="card mt-3">
                <div class="">
                    <h2 class="text-lg p-3 font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        {{ selectedUserInfo?.name }}'s History
                    </h2>
                </div>
                <div class="pt-2">
                    <div class="px-4 pt-2 pb-4 max-h-[65vh] overflow-y-scroll">

                        <div class="border-b border-slate-150 py-3 dark:border-navy-500 hover:border-navy-500 hover:bg-gray-100 p-2 cursor-pointer" v-for="(item, index) in markerData" :key="'location_history_'+index" @click="hightPointOnMap(item.id)">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <h2 class="cursor-pointer text-slate-600 line-clamp-1 dark:text-navy-100">
                                    {{ item.location_time }}
                                </h2>
                            </div>
                            <p class="mt-1"><pre class="whitespace-pre-wrap break-words"><i class="fa fa-location-dot pr-2"></i> {{ item.address }}</pre> </p>
                            <div class="mt-1 flex items-end justify-between">
                                <div class="flex flex-wrap items-center font-inter text-xs">
                                    <span class="flex items-center space-x-1">
                                        <i class="fa fa-building"></i>
                                        <span>{{ item.locality }}</span>
                                    </span>
                                    <div class="m-1.5 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                                    <span class="flex items-center space-x-1">
                                        <i class="fa fa-city"></i>
                                        <span>{{ item.city }}</span>
                                    </span>
                                    <div class="m-1.5 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                                    <span class="flex items-center space-x-1">
                                        <i class="fa fa-earth-asia"></i>
                                        <span>{{ item.country }}</span>
                                    </span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <button type="button" class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25" @click="hightPointOnMap(item.id)">
                                        <i class="fa fa-map-pin text-primary"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-9">
            <LocationSelector class="h-[70vh]" :enable-map-click="false" :markers-list="mapMarkers" :highlight-marker="highlightMapPoint"/>
        </div>
    </div>
    <no-data-found v-show="!markerData || markerData?.length == 0" />

</template>

<script>
import { mapGetters } from 'vuex' ;
import LocationSelector from '@/components/site_visits/LocationSelector.vue'

export default {
    components:{
        LocationSelector
    },
    data(){
        return {
            pageTitle: 'Members Location History',
            inProcess: false,
            users:[],
            selected:{
                user: null
            },
            markerData: [],
            highlightMapPoint: null

        }
    },
    created(){
        this.init();

    },
    computed:{

        ...mapGetters([
            'globalPermissions',
            'userPermissions'
        ]),

        selectedUserInfo(){
            let user = this.users.find( d => d.id == this.selected.user ) ;
            if( user && user.id ){
                return user
            }
            return null;
        },
        mapMarkers(){
            let data = [];
            if( this.markerData?.length ){
                data = this.markerData.map( d => {
                    return {
                        id: d.id,
                        marker_points: {
                            lat: d.latitude,
                            lng: d.longitude
                        },
                        marker_label: d.location_time,
                        marker_content: d.formatted_address
                    }
                })
            }

            return data;
        }
    },
    methods:{
        init(){
            this.loadUsersData();
        },
        loadUsersData(){
            if( this.inProcess ){
                return;
            }
            this.inProcess = true;
            this.$store.commit('setGlobalLoaderOn');
            this.$request.companyMembersSelectList()
                        .then(
                            ( res ) => {
                                if( res.data?.data?.length ){
                                    this.users = res.data.data;
                                    this.selected.user = this.users[0].id;
                                }
                            },
                            (err) => {
                                this.$toast.error('Err! There is something wrong. Please retry.');
                            }
                        ).finally(
                            () => {
                                this.inProcess = false;
                                this.$store.commit('setGlobalLoaderOff');
                            }
                        )
        },
        loadData(){
            this.$store.commit('setGlobalLoaderOn');
            this.inProcess = true;
            this.$request.getMemberLocationHistory( this.selected.user )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.markerData = [];
                                    if( res.data?.locations?.length ){
                                        this.markerData = res.data.locations;

                                    }
                                }
                            },
                            (err) => {
                                this.$toast.error('Err! There is something wrong. Please retry.');
                            }
                        ).finally(
                            () => {
                                this.$store.commit('setGlobalLoaderOff');
                            }
                        )
        },
        onUserChange(){
            this.loadData();
        },
        hightPointOnMap( id ){
            this.highlightMapPoint= id;
        }
    }
}
</script>

<style>

</style>
