<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex">
        <div class="p-4 sm:p-5 w-full">
            <div class=" grid grid-cols-12 gap-2">
                <div class="card mt-2 p-4 sm:p-5 col-span-7">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                           {{ formData.site_name }}
                        </h2>
                        <div class="flex justify-center space-x-2">

                            <router-link to="/site-visit"
                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </router-link>
                            <router-link :to="'/site-visit/edit/' + formData.id"
                                v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_SITE_VISIT ] )"
                                class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <i class="fa fa-pencil mr-2"></i> Edit
                            </router-link>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block" v-if="formData.project">
                                <span>Project</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.project }}
                                </p>
                            </label>

                            <label class="block" >
                                <span>Site Name</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.site_name }}
                                </p>
                            </label>

                            <label class="block" >
                                <span>Site Owner</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.site_owner }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Company Branch</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.company_branch }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Location</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.location }}
                                </p>
                            </label>

                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block" >
                                <span>Source Manager</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.source_manager_name }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Closing Manager</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.closing_manager_name }}
                                </p>
                            </label>
                            <label class="block col-span-2">
                                <span>Comments</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre class="whitespace-pre-wrap break-words">{{ formData.comments }}</pre>
                                </p>
                            </label>


                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">

                            <label class="block col-span-2" >
                                <span>Assigned To</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.assign_user }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Created By</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.created_user_name }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Created At</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.created_at_time }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Updated By</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.updated_user_name }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Updated At</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.updated_at_time }}
                                </p>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card mt-2 p-4 sm:p-5 col-span-5" v-if="formData.property_data && Object.keys(formData.property_data).length">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                           Property
                        </h2>
                        <div class="flex justify-center space-x-2">

                            <router-link :to="'/property/view/' + formData.property_data.id"
                                v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_PROPERTY ] )"
                                class="btn h-9 w-9 text-center border border-primary p-0 font-medium text-primary hover:bg-primary hover:text-white focus:bg-primary focus:text-white active:bg-primary/90 dark:border-accent dark:text-accent-light dark:hover:bg-accent dark:hover:text-white dark:focus:bg-accent dark:focus:text-white dark:active:bg-accent/90">
                                <i class="fa fa-external-link"></i>
                            </router-link>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block" >
                                <span>Name</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_data.name }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Building Name</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_data.building_name }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Unit No.</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_data.unit_no }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Property Type</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_data.property_type }}
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block col-span-2">
                                <span>Address</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_data.address }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>City</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_data.city }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Locality</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.property_data.locality }}
                                </p>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="card mt-2 p-4 sm:p-5 col-span-5" v-if="formData.project_data && Object.keys(formData.project_data).length">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                           Project
                        </h2>
                        <div class="flex justify-center space-x-2">

                            <router-link :to="'/project/view/' + formData.project_data.id"
                                v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_PROJECT ] )"
                                class="btn h-9 w-9 text-center border border-primary p-0 font-medium text-primary hover:bg-primary hover:text-white focus:bg-primary focus:text-white active:bg-primary/90 dark:border-accent dark:text-accent-light dark:hover:bg-accent dark:hover:text-white dark:focus:bg-accent dark:focus:text-white dark:active:bg-accent/90">
                                <i class="fa fa-external-link"></i>
                            </router-link>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block h-full" >
                                <span>Title</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.project_data.title }}
                                </p>

                            </label>
                            <label class="block h-full" >
                                <span>RERA Reg. No.</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.project_data.rera_reg_no }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Project No.</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.project_data.project_no }}
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block h-full col-span-2">
                                <span>Address</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre class="whitespace-pre-wrap break-words">{{ formData.project_data.address }}</pre>
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>City</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.project_data.city }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Locality</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.project_data.locality }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Landmark</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.project_data.landmark }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Building</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.project_data.building }}
                                </p>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import { mapGetters } from 'vuex' ;

export default {
    data(){
        return {
            pageTitle: 'Site Visits',
            subTitle: 'View Site Visit',
            isShowPopper: false,
            errors: {},
            formData:{
                site_name: null,
                site_owner: null,
                type: null,
                property_data: {},
                project_data: {},
                comments: null,
                assign_user: null,
                time_in: null,
                time_out: null,
                location: null,
                company_branch: null,
                source_manager_name: null,
                closing_manager_name: null,
                created_user_name: null,
                updated_user_name: null,
                created_at_time: null,
                updated_at_time: null,
            },
            rolesList: [],
            loading:{
                formSubmit: false,
                upload: false
            },
            selected:{
                lead_source: {},
                lead_status: {},
                assigned_to: {},
                company_branch_data: {},
            },
            selectedOptions:{
                lead_source: [],
                lead_status: [],
                assigned_to: [],
                company_branch_data: [],

            },
            show:{
                commentForm: false
            }
        }
    },
    mounted(){
        this.init();
    },
    computed:{
        ...mapGetters([
            'globalPermissions',
            'userPermissions'
        ]),
        breadcrumbs(){

            var breadcrumbs = [
                        {
                            title: 'Site Visits',
                            link: '/site-visit'
                        },
                        {
                            title: 'View',
                        }
                    ];
            return breadcrumbs;
        },
    },
    methods:{
        init () {
            if( this.$route?.params?.id ){
                this.loadViewDetail( this.$route.params.id );
            }
        },
        loadViewDetail( id ){
            this.$request.getSiteVisitViewDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.formData = Object.assign( this.formData, res.data.data);
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
        }
    }
}
</script>

<style>

</style>
