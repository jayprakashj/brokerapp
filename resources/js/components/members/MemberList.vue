<template>
    <page-header :title="pageTitle" :menus="menus" />
    <list-container>
        <template v-if="lists?.data?.length">
            <div class="card" v-for="(item, idx) in lists.data" :key="'member_'+idx">
                <div class="p-2 text-right" >
                    <popper-dropdown>
                        <div
                            class="absolute top-12 right-2 popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                            <ul>
                                <li >
                                    <router-link :to="'member/edit/' + item.id"
                                        class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                        <i class="fa fa-pencil mr-2"></i> Edit
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </popper-dropdown>
                </div>
                <div class="flex grow flex-col items-center px-4 pb-5 sm:px-5">
                    <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                        {{ item.member_name || 'N/A' }}
                    </h3>
                    <p class="text-xs+"><b>{{ item.email }}</b></p>
                    <p class="text-xs+">Creator: <b> {{ item.creator }}</b></p>
                    <div class="inline-space mt-3 flex grow flex-wrap items-start">

                        <span v-if="!item.is_owned"
                            class="tag rounded-full bg-success/10 text-success hover:bg-success/20 focus:bg-success/20 active:bg-success/25">
                            {{ item.role_name }}
                        </span>
                        <span v-if="item.is_accepted"
                            class="tag rounded-full bg-success/10 text-success hover:bg-success/20 focus:bg-success/20 active:bg-success/25">
                            Accepted
                        </span>
                        <span v-else
                            class="tag rounded-full badge rounded-full bg-error text-white">
                            Pending
                        </span>
                    </div>
                    <div class="mt-6 grid w-full grid-cols-2 gap-2" >
                        <button v-if="!item.is_company_owner && !item.is_self"
                            @click="removeMember( item.id )"
                            class="btn space-x-2 bg-primary px-0 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa fa-trash" ></i>
                            <span>Remove</span>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </list-container>
    <pagination :total-records="lists?.total_records" :per-page="lists?.per_page" :current-page="page" @pageChange="updatePage"></pagination>
</template>

<script>
export default {
    data(){
        return {
            pageTitle: 'Member Management',
            isShowPopper: false,
            menus:[
                {
                    title: 'Create',
                    link: '/member/create'
                }
            ],
            page: 1,
            lists:{}
        }
    },
    created(){
    },
    mounted(){
        this.init();
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
