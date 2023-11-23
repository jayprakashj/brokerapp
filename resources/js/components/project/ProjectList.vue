<template>
    <page-header :title="pageTitle" >
        <template v-slot:actionContainer >
            <div class="flex self-end sm:items-center space-x-2 max-sm:mt-4">

                <router-link to="/project/create"
                    class="btn space-x-2 rounded-full bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                    <i class="fa fa-plus"></i>
                    <span>Add New</span>
                </router-link>
                <div class="flex">

                    <button
                        @click="showFilter = !showFilter"
                        class="btn h-9 w-9 rounded-full bg-primary p-0 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </template>
    </page-header>

    <div class="col-span-12">
        <div >
            <div class="card p-3 py-3" v-show="showFilter">
                <form @submit.prevent="applyfilter">
                    <div class="grid xs:grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 sm:gap-5 lg:gap-6">
                        <label class="block">
                            <span>Title:</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter Title" type="text" v-model="filter.title">
                            </div>
                        </label>
                        <input-tom-select
                            class="h-full"
                            v-model="filter.company_branch"
                            form-label="Company Branch:"
                            placeholder="Select Branch"
                            :options="filterOptions.company_branches"
                            :selected-item="filter.company_branch"
                        />
                        <label class="block">
                            <span>City:</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter City" type="text" v-model="filter.city">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-building text-base"></i>
                                    </span>
                            </div>
                        </label>
                        <input-tom-select
                                class="h-full"
                                v-model="filter.assign_to"
                                form-label="Assign To:"
                                placeholder="Select"
                                :options="filterOptions.members"
                                :selected-item="filter.assign_to"
                            />
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
            <div class="min-w-full overflow-x-auto">
                <table class="is-hoverable w-full text-left">
                    <thead>
                        <tr>
                            <th
                                v-if="userPermissions.isPermissionsAllowed([  $permissions.REMOVE_PROJECT, $permissions.UPDATE_PROJECT ] )"
                                class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Action
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('title')">
                                <div class="flex gap-3 items-center">
                                    Title
                                    <template v-if="sortColumn == 'title'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('company_branch')">
                                <div class="flex gap-3 items-center">
                                    Company Branch
                                    <template v-if="sortColumn == 'company_branch'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('project_no')">
                                <div class="flex gap-3 items-center">
                                    Project No.
                                    <template v-if="sortColumn == 'project_no'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>

                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('city')">
                                <div class="flex gap-3 items-center">
                                    City
                                    <template v-if="sortColumn == 'city'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('assign_to')">
                                <div class="flex gap-3 items-center">
                                    Assign To
                                    <template v-if="sortColumn == 'assign_to'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('updated_at')" :class="{'rounded-tr-lg': !userPermissions.isPermissionsAllowed([  $permissions.REMOVE_PROJECT, $permissions.UPDATE_PROJECT ] )}">
                                <div class="flex gap-3 items-center">
                                    Updated At
                                    <template v-if="sortColumn == 'updated_at'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="lists?.data?.length">

                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in lists.data" :key="'project_'+idx">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5" v-if="userPermissions.isPermissionsAllowed([  $permissions.REMOVE_PROJECT, $permissions.UPDATE_PROJECT ] )">
                                    <div class="flex gap-2">

                                        <router-link :to="'/project/edit/' + item.id"
                                            v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_PROJECT ] )"
                                            class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-primary hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                            <i class="fa fa-pencil"></i>

                                        </router-link>
                                        <button v-if="false && userPermissions.isPermissionsAllowed([ $permissions.REMOVE_PROJECT ] )"
                                                @click="removeItem( item.id )"
                                            class="btn rounded-full bg-error font-medium text-red-500 hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <a
                                            :href="item.walk_through_link"
                                            target="_blank"
                                            v-if="item.walk_through_link"
                                            class="btn h-7 w-7 rounded-full bg-info/10 p-0 font-medium text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25"
                                            title="Walk Through Link"
                                            >
                                            <i class="fa fa-video"></i>
                                        </a>
                                        <a
                                            :href="item.virtual_tour"
                                            target="_blank"
                                            v-if="item.virtual_tour"
                                            class="btn h-7 w-7 border border-warning/30 bg-warning/10 p-0 font-medium text-warning hover:bg-warning/20 hover:shadow-lg hover:shadow-warning/50 focus:bg-warning/20 focus:shadow-lg focus:shadow-warning/50 active:bg-warning/25"
                                            title="Virtual Tour"
                                            >
                                            <i class="fa fa-vr-cardboard"></i>
                                        </a>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.title }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.company_branch }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.project_no }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.city }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.assigned_to }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.updated_at_time }}
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
import flatPickr from 'vue-flatpickr-component';

export default {
    mixins:[
        sortFilterMethodsMixin
    ],
    components:{
        flatPickr
    },

    data(){
        return {
            pageTitle: 'Project Management',
            isShowPopper: false,
            page: 1,
            lists:{},
            showFilter: false,
            sortColumn: 'updated_at',
            sortOrder: 'desc',
            filterOptions: {},
            filter: {
                title: null,
                company_branch: null,
                city: null,
                assign_to: null,
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
            if( userPermissions.isPermissionsAllowed( this.$permissions.ADD_PROJECT ) ){
                menus.push(
                        {
                            title: 'Add new',
                            icon_class: 'fa-plus',
                            link: '/project/create'
                        }
                    )
            }

            return menus;
        }
    },
    methods:{
        init () {
            this.loadListsData();
            this.loadfilterOptionsData();
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
            this.$request.getProjectList( params )
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
                                .deleteProject( id )
                                .then(
                                    ( res ) => {
                                        let message = 'Success! Project removed successfully.';

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

        loadfilterOptionsData(){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.projectFilterData()
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.filterOptions = Object.assign( {}, res.data);
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
        resetFilter(){
            this.filter = {
                title: null,
                company_branch: null,
                city: null,
                assign_to: null,
            };
            this.resetAndLoadList();
        }
    }
}
</script>

<style>

</style>
