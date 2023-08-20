<template>
    <page-header :title="pageTitle" :menus="menus" />
    <list-container>
        <template v-if="lists?.data?.length">
            <div class="card grow items-center p-4 sm:p-5 " :class="{'bg-amber-300 text-gray-700': !item.is_accepted}" v-for="(item, idx) in lists.data" :key="'member_'+idx">
                <div class="avatar h-20 w-20">
                    <img class="rounded-full" :src="item.logo_url" alt="avatar">
                </div>
                <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                    {{ item.member_name || item.email }}
                </h3>
                <p class="text-xs+">{{ item.is_company_owner ? 'Admin' : item.role_name }} </p>
                <div class="my-4 h-px w-full bg-slate-200 dark:bg-navy-500"></div>
                <div class="grow space-y-4">
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-phone text-xs"></i>
                        </div>
                        <p>{{ item.member_phone }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-envelope text-xs"></i>
                        </div>
                        <p>{{ item.email }}</p>
                    </div>
                    <div class="flex items-center space-x-4" v-if="item.is_accepted">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-check text-xs"></i>
                        </div>
                        <p>Accepted</p>
                    </div>
                    <div class="flex items-center space-x-4" v-else>
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-clock text-xs"></i>
                        </div>
                        <p>Pending</p>
                    </div>
                </div>
                <div class="mt-5 space-x-2">

                    <router-link :to="'member/edit/' + item.id"
                        v-if="!item.is_company_owner && userPermissions.isPermissionsAllowed([ $permissions.UPDATE_MEMBER ] )"
                        class="btn mt-5 space-x-2 rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <i class="fa fa-pencil"></i>
                        <span> Edit </span>
                    </router-link>
                    <button v-if="!item.is_company_owner && !item.is_self && userPermissions.isPermissionsAllowed([ $permissions.REMOVE_MEMBER ] )"
                            @click="removeMember( item.id )"
                        class="btn rounded-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </template>
    </list-container>
    <pagination :total-records="lists?.total_records" :per-page="lists?.per_page" :current-page="page" @pageChange="updatePage"></pagination>
</template>

<script>
import { mapGetters } from 'vuex' ;

export default {
    data(){
        return {
            pageTitle: 'Member Management',
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
            if( userPermissions.isPermissionsAllowed( this.$permissions.ADD_MEMBER ) ){
                menus.push(
                        {
                            title: 'Add new',
                            icon_class: 'fa-plus',
                            link: '/member/create'
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
            this.$request.getMemberList( params )
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
        removeMember ( id ){


            this.$swal.fire({
                    title: 'Are you sure you want to remove?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete.',
                }).then(
                    ( res ) =>{
                        if( res.isConfirmed ){
                            this.$store.commit('setGlobalLoaderOn')
                            this.$request
                                .deleteMember( id )
                                .then(
                                    ( res ) => {
                                        let message = 'Success! Member removed successfully.';

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
