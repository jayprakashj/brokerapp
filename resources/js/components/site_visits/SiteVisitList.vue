<template>
    <page-header :title="pageTitle" >
        <template v-slot:actionContainer >
            <div class="flex self-end sm:items-center space-x-2 max-sm:mt-4">
                <router-link to="/site-visit/create"
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
                            <span>Site Name:</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter Site Name" type="text" v-model="filter.site_name">
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

                        <input-tom-select
                                class="h-full"
                                v-model="filter.properties"
                                form-label="Property:"
                                placeholder="Select Property"
                                :is-multiple="true"
                                :options="filterOptions.properties"
                                :selected-item="filter.properties?.map(d => d.id)"
                            />
                        <input-tom-select
                                class="h-full"
                                v-model="filter.projects"
                                form-label="Project:"
                                placeholder="Select Project"
                                :is-multiple="true"
                                :options="filterOptions.projects"
                                :selected-item="filter.projects?.map(d => d.id)"
                            />
                        <input-tom-select
                                class="h-full"
                                v-model="filter.visit_type"
                                form-label="Visit Type:"
                                placeholder="Select Visit Type"
                                :options="filterOptions.visit_types"
                                :selected-item="filter.visit_type"
                            />
                        <label class="block">
                            <span>Location:</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter Location" type="text" v-model="filter.location">
                            </div>
                        </label>
                        <input-tom-select
                                key="source_manager"
                                class="h-full"
                                v-model="filter.source_manager"
                                form-label="Source Manager:"
                                placeholder="Select"
                                :options="filterOptions.members"
                                :selected-item="filter.source_manager"
                            />
                        <input-tom-select
                                key="closing_manager"
                                class="h-full"
                                v-model="filter.closing_manager"
                                form-label="Closing Manager:"
                                placeholder="Select"
                                :options="filterOptions.members"
                                :selected-item="filter.closing_manager"
                            />
                        <input-tom-select
                                class="h-full"
                                v-model="filter.assign_to"
                                form-label="Assign To:"
                                placeholder="Select"
                                :options="filterOptions.members"
                                :selected-item="filter.assign_to"
                            />
                        <label class="block">
                            <span>Updated At:</span>
                            <div class="relative mt-1.5 flex">
                                <flat-pickr
                                    v-model="filter.updated_at"
                                    :config="{ mode: 'range', dateFormat: 'Y-m-d' }"
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Choose date...">
                                </flat-pickr>
                                <span
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
                                >
                                    <i class="fa fa-calendar"></i>
                                </span>
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
            <div class="min-w-full overflow-x-auto">
                <table class="is-hoverable w-full text-left">
                    <thead>
                        <tr>
                            <th
                                v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_SITE_VISIT, $permissions.REMOVE_SITE_VISIT, $permissions.VIEW_SITE_VISIT ] )"
                                class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Action
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('site_name')">
                                <div class="flex gap-3 items-center">
                                    Site Name
                                    <template v-if="sortColumn == 'site_name'">
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
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('project')">
                                <div class="flex gap-3 items-center">
                                    Project
                                    <template v-if="sortColumn == 'project'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>

                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('property')">
                                <div class="flex gap-3 items-center">
                                    Property
                                    <template v-if="sortColumn == 'property'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('leads_count')">
                                <div class="flex gap-3 items-center">
                                    Total Linked Leads
                                    <template v-if="sortColumn == 'leads_count'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>

                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('visit_type')">
                                <div class="flex gap-3 items-center">
                                    Visit Type
                                    <template v-if="sortColumn == 'visit_type'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('location')">
                                <div class="flex gap-3 items-center">
                                    Location
                                    <template v-if="sortColumn == 'location'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('time_in')">
                                <div class="flex gap-3 items-center">
                                    Time In
                                    <template v-if="sortColumn == 'time_in'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('time_out')">
                                <div class="flex gap-3 items-center">
                                    Time Out
                                    <template v-if="sortColumn == 'time_out'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('source_manager')">
                                <div class="flex gap-3 items-center">
                                    Source Manager
                                    <template v-if="sortColumn == 'source_manager'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('closing_manager')">
                                <div class="flex gap-3 items-center">
                                    Closing Manager
                                    <template v-if="sortColumn == 'closing_manager'">
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
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('updated_at')" :class="{'rounded-tr-lg': !userPermissions.isPermissionsAllowed([ $permissions.UPDATE_SITE_VISIT, $permissions.REMOVE_SITE_VISIT, $permissions.VIEW_SITE_VISIT ] )}">
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

                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in lists.data" :key="'property_'+idx">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5" v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_SITE_VISIT, $permissions.REMOVE_SITE_VISIT, $permissions.VIEW_SITE_VISIT ] )">
                                    <div class="flex gap-2">

                                        <router-link :to="'/site-visit/edit/' + item.id"
                                            v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_SITE_VISIT ] )"
                                            class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-primary hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                            <i class="fa fa-pencil"></i>

                                        </router-link>

                                        <router-link v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_SITE_VISIT ] )" :to="'/site-visit/view/' + item.id" class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                            <i class="far fa-eye"></i>
                                        </router-link>
                                        <button v-if="false && userPermissions.isPermissionsAllowed([ $permissions.REMOVE_SITE_VISIT ] )"
                                                @click="removeItem( item.id )"
                                            class="btn rounded-full bg-error font-medium text-red-500 hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.site_name }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.company_branch }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.project }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.property }}
                                </td>
                                <td class="whitespace-nowrap text-center px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    <span class="badge rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        {{ item.leads_count }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.visit_type }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.location }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.time_in ?? 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.time_out }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.source_manager }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.closing_manager }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.assign_user }}
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
import SetQueryStringFilter from '@/mixin/SetQueryStringFilter.js';
import flatPickr from 'vue-flatpickr-component';


export default {
    mixins:[
        sortFilterMethodsMixin,
        SetQueryStringFilter
    ],
    components:{
        flatPickr
    },

    data(){
        return {
            pageTitle: 'Site Visits',
            isShowPopper: false,
            page: 1,
            lists:{},
            showFilter: false,
            sortColumn: 'updated_at',
            sortOrder: 'desc',
            filterOptions: {},
            filter: {
                site_name: null,
                properties: [],
                projects: [],
                company_branch: null,
                visit_type: null,
                location: null,
                source_manager: null,
                closing_manager: null,
                assign_to: null,
                updated_at: null
            },
        }
    },
    created(){
    },
    mounted(){
        this.readQueryAndSetFilter();
        this.init();
    },
    computed:{
        ...mapGetters([
            'globalPermissions',
            'userPermissions'
        ]),
        menus(){
            var menus = [];
            if( userPermissions.isPermissionsAllowed( this.$permissions.ADD_SITE_VISIT ) ){
                menus.push(
                        {
                            title: 'Add new',
                            icon_class: 'fa-plus',
                            link: '/site-visit/create'
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
            this.$request.getSiteVisitList( params )
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
                                .deleteSiteVisit( id )
                                .then(
                                    ( res ) => {
                                        let message = 'Success! Site Visit removed successfully.';

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
            this.$request.taskFilterData()
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
                site_name: null,
                properties: [],
                projects: [],
                company_branch: null,
                visit_type: null,
                location: null,
                source_manager: null,
                closing_manager: null,
                assign_to: null,
                updated_at: null
            };
            this.resetAndLoadList();
        }
    }
}
</script>

<style>

</style>
