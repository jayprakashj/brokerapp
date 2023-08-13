<template>
    <page-header :title="pageTitle" :menus="menus" />
    <list-container>
        <template v-if="lists?.data?.length">
            <div class="card" v-for="(item, idx) in lists.data" :key="'role_'+idx">
                <div class="p-2 text-right" >
                    <popper-dropdown>
                        <div
                            class="absolute top-12 right-2 popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                            <ul>
                                <li >
                                    <router-link :to="'role/edit/' + item.id"
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
                        {{ item.name }}
                    </h3>
                    <div class="mt-6 grid w-full grid-cols-2 gap-2">

                        <button
                            class="btn space-x-2 bg-primary px-0 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa fa-trash text-red-500"></i>
                            <span class="ml-2">
                                Delete
                            </span>
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
            pageTitle: 'Role Management',
            isShowPopper: false,
            menus:[
                {
                    title: 'Create',
                    link: '/role/create'
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
		}
    }
}
</script>

<style>

</style>
