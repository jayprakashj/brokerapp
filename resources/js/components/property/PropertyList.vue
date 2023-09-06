<template>
    <page-header :title="pageTitle" :menus="menus" />
    <list-container>
        <template v-if="lists?.data?.length">
            <div class="card grow items-center p-4 sm:p-5 " v-for="(item, idx) in lists.data" :key="'property_'+idx">
                <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                    {{ item.name }}
                </h3>
                <p class="text-xs+">{{ item.company_name }} </p>
                <div class="my-4 h-px w-full bg-slate-200 dark:bg-navy-500"></div>
                <div class="grow space-y-4">
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-network-wired text-xs"></i>
                        </div>
                        <p>{{ item.company_branch }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-building text-xs"></i>
                        </div>
                        <p>{{ item.city }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-location-dot text-xs"></i>
                        </div>
                        <p>{{ item.locality }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-city text-xs"></i>
                        </div>
                        <p>{{ item.property_type }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-bookmark text-xs"></i>
                        </div>
                        <p>{{ item.property_transaction }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <template v-if="item.is_verified">
                            <div

                                class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                                <i class="fa fa-check text-xs"></i>
                            </div>
                            <p> Verified </p>

                        </template>
                        <template v-else>
                            <div

                                class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                                <i class="fa fa-close text-xs"></i>
                            </div>
                            <p> Not Verified </p>

                        </template>
                    </div>
                </div>
                <div class="mt-5 space-x-2">

                    <router-link :to="'/property/edit/' + item.id"
                        v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_PROPERTY ] )"
                        class="btn mt-5 space-x-2 rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <i class="fa fa-pencil"></i>
                        <span> Edit </span>
                    </router-link>
                    <button v-if="false && userPermissions.isPermissionsAllowed([ $permissions.REMOVE_PROPERTY ] )"
                            @click="removeItem( item.id )"
                        class="btn rounded-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </template>
        <no-data-found v-else />
    </list-container>
    <pagination :total-records="lists?.total_records" :per-page="lists?.per_page" :current-page="page" @pageChange="updatePage"></pagination>
</template>

<script>
import { mapGetters } from 'vuex' ;

export default {
    data(){
        return {
            pageTitle: 'Property Management',
            isShowPopper: false,
            page: 1,
            lists:{}
        }
    },
    created(){
    },
    mounted(){
        this.init();
    },
    computed:{
        ...mapGetters([
            'globalPermissions',
            'userPermissions'
        ]),
        menus(){
            var menus = [];
            if( userPermissions.isPermissionsAllowed( this.$permissions.ADD_CONTACT ) ){
                menus.push(
                        {
                            title: 'Add new',
                            icon_class: 'fa-plus',
                            link: '/property/create'
                        }
                    )
            }

            return menus;
        }
    },
    methods:{
        init () {
            this.loadListsData();
        },
        loadListsData(){
            this.$store.commit('setGlobalLoaderOn')
            const params = {
                per_page: this.$perPage,
                page: this.page
            }
            this.$request.getPropertyList( params )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.lists = res.data;
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
		updatePage( pageNum ){
			this.page = pageNum;
            this.loadListsData();
		},
        removeItem ( id ){


            this.$swal.fire({
                    title: 'Are you sure you want to remove?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete.',
                }).then(
                    ( res ) =>{
                        if( res.isConfirmed ){
                            this.$store.commit('setGlobalLoaderOn')
                            this.$request
                                .deleteProperty( id )
                                .then(
                                    ( res ) => {
                                        let message = 'Success! Property removed successfully.';

                                        if( res.data?.message ){
                                            message = res.data.message;
                                        }
                                        this.loadListsData();
                                        this.$toast.info( message );
                                    },
                                    ( err ) => {
                                        let message = 'Error! There is error occured while processing request.';
                                        if( err?.response?.data?.message ){
                                            message = err.response.data.message;
                                        }
                                        this.$toast.error( message );
                                    }
                                )
                                .finally(
                                    () => {
                                        this.$store.commit('setGlobalLoaderOff');
                                    }
                                )

                        }
                    }
                );
        }
    }
}
</script>

<style>

</style>
