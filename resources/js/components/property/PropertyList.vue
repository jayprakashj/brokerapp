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
                            <span>Property name:</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter Property Name" type="text" v-model="filter.name">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-home text-base"></i>
                                    </span>
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
                        <label class="block">
                            <span>Locality:</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter Locality" type="text" v-model="filter.locality">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-location-crosshairs text-base"></i>
                                    </span>
                            </div>
                        </label>
                        <input-tom-select
                                class="h-full"
                                v-model="filter.property_type"
                                form-label="Property Type:"
                                placeholder="Select Property Type"
                                :tomOptions="propertyTypeTomOptions"
                                :selected-item="filter.property_type"
                                :options="filterOptions.property_sub_types"
                            />
                        <input-tom-select
                                class="h-full"
                                v-model="filter.property_transaction"
                                form-label="Property Transaction:"
                                placeholder="Select Property Transaction"
                                :options="filterOptions.property_transactions"
                                :selected-item="filter.property_transaction"
                            />
                        <input-tom-select
                                class="h-full"
                                v-model="filter.is_verified"
                                form-label="Is Verified:"
                                placeholder="Select"
                                display-field="title"
                                :options="filterOptions.is_verified_list"
                                :selected-item="filter.is_verified"
                            />
                        <input-tom-select
                                class="h-full"
                                v-model="filter.assign_to"
                                form-label="Assign To:"
                                placeholder="Select"
                                :options="filterOptions.members"
                                :selected-item="filter.assign_to"
                            />
                        <input-tom-select
                                class="h-full"
                                v-model="filter.updated_by"
                                form-label="Updated By:"
                                placeholder="Select"
                                :options="filterOptions.members"
                                :selected-item="filter.updated_by"
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
                                <!-- <input
                                    v-model="filter.updated_at"
                                    ref="updatedAtDateRange"
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Choose date..."
                                    type="text"
                                /> -->
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
            <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                <table class="is-hoverable w-full text-left">
                    <thead>
                        <tr>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('name')">
                                <div class="flex gap-3 items-center">
                                    Property Name
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
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('locality')">
                                <div class="flex gap-3 items-center">
                                    Locality
                                    <template v-if="sortColumn == 'locality'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('property_type')">
                                <div class="flex gap-3 items-center">
                                    Property Type
                                    <template v-if="sortColumn == 'property_type'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('property_transaction')">
                                <div class="flex gap-3 items-center">
                                    Property Transaction
                                    <template v-if="sortColumn == 'property_transaction'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('is_verified')">
                                <div class="flex gap-3 items-center">
                                    Is Verified?
                                    <template v-if="sortColumn == 'is_verified'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>

                                </div>
                            </th>
                            <th
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('assign_to')">
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
                                v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_PROPERTY, $permissions.VIEW_PROPERTY, $permissions.REMOVE_PROPERTY, $permissions.DOCUMENT_ATTACH_TO_PROPERTY ] )"
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-if="lists?.data?.length">
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in lists.data" :key="'property_'+idx">
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.name }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.company_name }}
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.company_branch }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.city }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.locality }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.property_type }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.property_transaction }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <div class="flex gap-2 items-center" :class="{'text-red-500': !item.is_verified, 'text-success': item.is_verified}">

                                        <template v-if="item.is_verified">
                                            <div

                                                class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-sucess dark:bg-accent-light/10 dark:text-accent-light">
                                                <i class="fa fa-check text-xs"></i>
                                            </div>
                                            <p> Verified </p>

                                        </template>
                                        <template v-else>
                                            <div

                                                class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-red-500 dark:bg-accent-light/10 dark:text-accent-light">
                                                <i class="fa fa-close text-xs"></i>
                                            </div>
                                            <p> Not Verified </p>

                                        </template>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.assign_to }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.updated_by }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.updated_at_time }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5" v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_PROPERTY, $permissions.VIEW_PROPERTY, $permissions.REMOVE_PROPERTY, $permissions.DOCUMENT_ATTACH_TO_PROPERTY ] )">
                                    <div class="flex gap-2">

                                        <router-link :to="'/property/edit/' + item.id"
                                            v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_PROPERTY ] )"
                                            class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-primary hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                            <i class="fa fa-pencil"></i>

                                        </router-link>
                                        <router-link v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_PROPERTY ] )" :to="'/property/view/' + item.id" class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                            <i class="far fa-eye"></i>
                                        </router-link>
                                        <button v-if="false && userPermissions.isPermissionsAllowed([ $permissions.REMOVE_PROPERTY ] )"
                                                @click="removeItem( item.id )"
                                            class="btn rounded-full bg-error font-medium text-red-500 hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <router-link v-if="userPermissions.isPermissionsAllowed([ $permissions.DOCUMENT_ATTACH_TO_PROPERTY ] )" :to="'/property/' + item.id + '/documents'" class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                                <i class="fa fa-folder"></i>
                                        </router-link>
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
import flatPickr from 'vue-flatpickr-component';
import sortFilterMethodsMixin from '@/mixin/FilterSortMethodsMixin.js';

export default {
    mixins:[
        sortFilterMethodsMixin
    ],
    components:{
        flatPickr
    },
    data(){
        return {
            pageTitle: 'Property Management',
            isShowPopper: false,
            page: 1,
            lists:{},
            showFilter: false,
            sortColumn: 'updated_at',
            sortOrder: 'desc',
            filterOptions: {},
            filter: {
                name: null,
                company_branch: null,
                city: null,
                locality: null,
                property_type: null,
                property_transaction: null,
                is_verified: null,
                assign_to: null,
                updated_by: null,
                updated_at: null,
            },
            updateDateFlatickr: null
        }
    },
    created(){
    },
    mounted(){
        this.init();
        this.$nextTick( () => {
            // this.updateDateFlatickr = flatpickr(this.$refs.updatedAtDateRange, { mode: 'range', dateFormat: 'Y-m-d' });
        })
    },
    computed:{
        ...mapGetters([
            'globalPermissions',
            'userPermissions'
        ]),
        menus(){
            var menus = [];
            if( userPermissions.isPermissionsAllowed( this.$permissions.ADD_PROPERTY ) ){
                menus.push(
                        {
                            title: 'Add new',
                            icon_class: 'fa-plus',
                            link: '/property/create'
                        }
                    )
            }

            return menus;
        },
        propertyTypeTomOptions () {
            let options = {
                    optgroups: this.filterOptions.property_types,
                    optgroupField: 'property_type_id',
                    render:{
                        optgroup_header: ( data, escape ) => {
                            return '<div class="border-gray-700 p-2 font-bold text-primary border-b mb-1">' + escape(data.label) + '</div>';
                        }
                    }
                };
            return options;
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
        },
        loadfilterOptionsData(){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.propertyFilterData()
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
                name: null,
                company_branch: null,
                city: null,
                locality: null,
                property_type: null,
                property_transaction: null,
                is_verified: null,
                assign_to: null,
                updated_by: null,
                updated_at: null,
            };
            this.resetAndLoadList();
        }
    }
}
</script>

<style>

</style>
