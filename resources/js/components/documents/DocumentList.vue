<template>
    <page-header :title="pageTitle" :menus="menus" >
        <template v-slot:actionContainer >
            <div class="flex items-center space-x-2">

                <div class="flex">

                    <button
                        @click="showFilter = !showFilter"
                        class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                        <i class="fa fa-filter"></i>
                    </button>
                </div>
            </div>
        </template>
    </page-header>

    <div>
        <div >
            <div class=" py-3" v-show="showFilter">
                <form @submit.prevent="applyfilter">
                    <div class="grid grid-cols-4 gap-4 sm:grid-cols-4 sm:gap-5 lg:gap-6">
                        <label class="block">
                            <span>Name:</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter Branch Name" type="text" v-model="filter.name">
                            </div>
                        </label>
                    </div>
                    <div class="mt-4 space-x-2 text-right ">
                        <button
                            type="button"
                            @click="showFilter = false"
                            class="btn font-medium text-slate-700 hover:bg-slate-300/20 active:bg-slate-300/25 dark:text-navy-100 dark:hover:bg-navy-300/20 dark:active:bg-navy-300/25">
                            Close
                        </button>

                        <button
                            type="submit"
                            class="btn bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90" @click="applyFilter">
                            Apply
                        </button>
                        <button
                            type="button"
                            class="btn space-x-2 rounded-full bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90" @click="resetFilter"
                        >
                            <i class="fa fa-refresh"></i>
                            <span>Reset</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mt-3">
            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <table class="is-hoverable w-full text-left">
                    <thead>
                        <tr>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('name')">
                                <div class="flex gap-3 items-center">
                                    Name
                                    <template v-if="sortColumn == 'name'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Company Name
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Description
                            </th>
                            <th
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('updated_by')">
                                <div class="flex gap-3 items-center">
                                    Updated By
                                    <template v-if="sortColumn == 'updated_by'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('updated_at')">
                                <div class="flex gap-3 items-center">
                                    Updated At
                                    <template v-if="sortColumn == 'updated_at'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_DOCUMENT, $permissions.REMOVE_DOCUMENT ] )"
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="lists?.data?.length">

                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in lists.data" :key="'document_'+idx">
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.name }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.company_name }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.description }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.updated_by }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.updated_at_time }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5" v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_DOCUMENT, $permissions.REMOVE_DOCUMENT ] )">
                                    <div class="flex gap-2">

                                        <router-link :to="'/document/edit/' + item.id"
                                            v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_DOCUMENT ] )"
                                            class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-primary hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                            <i class="fa fa-pencil"></i>

                                        </router-link>
                                        <button v-if="false && userPermissions.isPermissionsAllowed([ $permissions.REMOVE_DOCUMENT ] )"
                                                @click="removeItem( item.id )"
                                            class="btn rounded-full bg-error font-medium text-red-500 hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500" v-else``>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 col-span-8">
                                <no-data-found />
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">
                <div class="text-xs+">{{ lists?.first_item ?? 0 }} - {{ lists?.last_item ?? 0 }} of {{ lists?.total_records ?? 0 }} entries</div>
                <pagination :total-records="lists?.total_records" :per-page="lists?.per_page" :current-page="page" @pageChange="updatePage"></pagination>
            </div>
        </div>
    </div>
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
            pageTitle: 'Document Management',
            isShowPopper: false,
            page: 1,
            lists:{},
            showFilter: false,
            sortColumn: 'updated_at',
            sortOrder: 'desc',
            filterOptions: {},
            filter: {
                name: null,
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
        menus(){
            var menus = [];
            if( userPermissions.isPermissionsAllowed( this.$permissions.ADD_DOCUMENT ) ){
                menus.push(
                        {
                            title: 'Add new',
                            icon_class: 'fa-plus',
                            link: '/document/create'
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
                page: this.page,
                filter: this.filter,
                sort_by: this.sortColumn,
                sort_order: this.sortOrder
            }
            this.$request.getDocumentList( params )
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
                                .deleteDocument( id )
                                .then(
                                    ( res ) => {
                                        let message = 'Success! Document removed successfully.';

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
        },

        resetFilter(){
            this.filter = {
                name: null,
            };
            this.resetAndLoadList();
        }
    }
}
</script>

<style>

</style>
