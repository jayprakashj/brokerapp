<template>
    <page-header :title="pageTitle" :menus="menus" />
    <div class="col-span-12 space-y-4 sm:space-y-5">
        <template v-if="lists?.data?.length">

            <div class="rounded-lg  border border-slate-150 dark:border-navy-500" v-for="(item, idx) in lists.data" :key="'role_'+idx" >
                <div @click="expanded = item.id"
                    class="flex cursor-pointer bg-slate-150  items-center justify-between px-4 py-4 text-base font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                    <p>
                        {{ item.name }}
                        <div class="badge bg-primary text-white text-xs dark:bg-accent ml-2" v-if="item.users_count > 0">
                            {{ item.users_count }} Members
                        </div>
                    </p>
                    <div :class="{'-rotate-180': !(expanded == item.id) }"
                        class="text-sm font-normal leading-none text-slate-400 transition-transform duration-300 dark:text-navy-300">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>
                <div v-show="(expanded == item.id )" >
                    <div class="px-4 py-4 sm:px-5">

                        <p class="space-x-1">
                            <span v-for="(permission, index) in item.permissions"
                                :key="'permission_tag_' +index"
                                class="tag rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                {{ permission }}
                            </span>
                        </p>
                        <div class="mt-4 flex space-x-4">
                            <router-link v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_ROLE ] )" :to="'/role/edit/' + item.id"
                                class="btn h-7 w-7 rounded-full bg-slate-150 p-0 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                <i class="fa fa-pencil"></i>
                            </router-link>
                            <button
                                v-if="userPermissions.isPermissionsAllowed( $permissions.REMOVE_ROLE )"
                                @click="removeRole( item )"
                                class="btn h-7 w-7 rounded-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90"
                                :class="{'bg-red-400 cursor-not-allowed': item.users_count > 0 }"
                                >
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </template>
        <no-data-found v-else />
    </div>
    <pagination :total-records="lists?.total_records" :per-page="lists?.per_page" :current-page="page" @pageChange="updatePage"></pagination>
</template>

<script>

import { mapGetters } from 'vuex' ;
import sortFilterMethodsMixin from '@/mixin/FilterSortMethodsMixin.js';

export default {
    mixins:[
        sortFilterMethodsMixin
    ],

    data(){
        return {
            expanded: null,
            pageTitle: 'Role Management',
            isShowPopper: false,
            page: 1,
            lists:{},
            showFilter: false,
            sortColumn: 'updated_at',
            sortOrder: 'desc',
            filterOptions: {},
            filter: {
                name: null,
                mobile: null,
                email: null,
                city: null
            },
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
        menus() {
            var rules = [];
            if( userPermissions.isPermissionsAllowed( this.$permissions.ADD_ROLE ) ){
                rules.push(
                    {
                        title: 'New Role',
                        icon_class: 'fa fa-plus',
                        link: '/role/create'
                    }
                );
            }
            return rules;
        }
    },
    methods:{
        init () {
            this.loadListData();
        },
        loadListData(){
            this.$store.commit('setGlobalLoaderOn')
            const params = {
                per_page: this.$perPage,
                page: this.page
            }
            this.$request.getRoleList( params )
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
            this.loadListData();
		},
        removeRole ( item ){
            if( item.users_count <= 0 ){

                this.$swal.fire({
                        title: 'Are you sure you want to remove?',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete.',
                    }).then(
                        ( res ) =>{
                            if( res.isConfirmed ){
                                this.$store.commit('setGlobalLoaderOn')
                                this.$request
                                    .deleteRole( item.id )
                                    .then(
                                        ( res ) => {
                                            let message = 'Success! Role removed successfully.';

                                            if( res.data?.message ){
                                                message = res.data.message;
                                            }
                                            this.loadListData();
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
}
</script>

<style>

</style>
