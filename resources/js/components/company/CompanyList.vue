<template>
    <page-header :title="pageTitle"  />
    <list-container>
        <template v-if="companies?.data?.length">
            <div class="card grow items-center p-4 sm:p-5 " v-for="(item, idx) in companies.data" :key="'company_'+idx">
                <div class="avatar h-20 w-20">
                    <img class="rounded-full" :src="item.logo_url" alt="avatar">
                    <div
                        v-if="item.is_default"
                        class="absolute right-0 m-1 h-4 w-4 rounded-full border-2 border-white bg-primary dark:border-navy-700 dark:bg-accent">
                    </div>
                </div>
                <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                    {{ item.name }}
                </h3>
                <div class="my-4 h-px w-full bg-slate-200 dark:bg-navy-500"></div>
                <div class="grow space-y-4">
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-phone text-xs"></i>
                        </div>
                        <p>{{ item.mobile }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-envelope text-xs"></i>
                        </div>
                        <p>{{ item.email }}</p>
                    </div>
                    <div class="flex items-center space-x-4" v-if="item.gst_no">

                        <p>{{ item.gst_no }}</p>
                    </div>
                    <div class="flex items-center space-x-4" v-if="item.address">

                        <p>{{ item.address }}</p>
                    </div>
                </div>
                <div class="mt-5 space-x-2">

                    <router-link :to="'/company/edit/' + item.id"
                        v-if="item.is_owned"
                        class="btn mt-5 space-x-2 rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <i class="fa fa-pencil"></i>
                        <span> Edit </span>
                    </router-link>
                    <button v-if="!item.is_default && item.is_active"
                            @click="makeDefaultCompany( item.id )"
                        class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        Set Default
                    </button>
                </div>
            </div>
        </template>
        <no-data-found v-else />
    </list-container>
    <pagination :total-records="companies.total_records" :per-page="companies.per_page" :current-page="page" @pageChange="updatePage"></pagination>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
    data(){
        return {
            pageTitle: 'Company Management',
            isShowPopper: false,
            menus:[
                {
                    title: 'Create',
                    link: '/company/create'
                }
            ],
            page: 1,
            companies:{}
        }
    },
    created(){
    },
    mounted(){
        this.init();
    },
    computed:{
        ...mapGetters([
            'currentUser'
        ])
    },
    methods:{
        init () {
            this.loadCompanies();
        },
        loadCompanies(){
            this.$store.commit('setGlobalLoaderOn')
            const params = {
                per_page: this.$perPage,
                page: this.page
            }
            this.$request.getCompanyList( params )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.companies = res.data;
                                }
                            },
                            (err) => {

                            }
                        ).finally(
                            () => {
                                this.$store.commit('setGlobalLoaderOff')
                            }
                        )
        },
        changeStatus( id ){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.changeCompanyStatus( id )
                        .then(
                            ( res ) => {
                                let message = 'Success! Company status changed successfully.';
                                if( res.data?.message ){
                                    message = res.data.message;
                                }
                                this.loadCompanies();
                                this.$toast.info( message );
                            },
                            ( err ) => {
                                let message = 'Error! There is error occured while processing request.';
                                if( err?.response?.data?.message ){
                                    message = err.response.data.message;
                                }
                                this.$toast.error( message );
                            }
                        ).finally(
                            () => {
                                this.$store.commit('setGlobalLoaderOff');
                            }
                        );
        },
        makeDefaultCompany( id ){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.makeDefaultCompany( id )
                        .then(
                            ( res ) => {
                                let message = 'Success! Default company changed successfully.';
                                if( res.data?.message ){
                                    message = res.data.message;
                                }
                                if( res.data?.new_permissions ){
                                    userPermissions = res.data.new_permissions;
                                    this.$store.commit('changeUserPermissions', res.data.new_permissions);
                                }
                                if( res.data?.company_data && this.currentUser?.current_company?.id && this.currentUser.current_company.id != id){
                                    this.$store.commit('changeDefaultCompany', res.data.company_data);
                                }
                                this.loadCompanies();
                                this.$toast.info( message );
                            },
                            ( err ) => {
                                let message = 'Error! There is error occured while processing request.';
                                if( err?.response?.data?.message ){
                                    message = err.response.data.message;
                                }
                                this.$toast.error( message );
                            }
                        ).finally(
                            () => {
                                this.$store.commit('setGlobalLoaderOff');
                            }
                        );
        },
		updatePage( pageNum ){
			this.page = pageNum;
            this.loadCompanies();
		}
    }
}
</script>

<style>

</style>
