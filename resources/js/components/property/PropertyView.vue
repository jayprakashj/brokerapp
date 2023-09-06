<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex gap-4">
        <div class="card p-4 w-7/12 sm:p-5 ">
            <div class="card">
                <div
                    class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                       {{ formData.title }}
                    </h2>
                    <div class="flex justify-center space-x-2">

                        <router-link to="/property"
                            class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            Cancel
                        </router-link>
                        <router-link :to="'/property/edit/' + formData.id"
                            v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_PROPERTY ] )"
                            class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <i class="fa fa-pencil mr-2"></i> Edit
                        </router-link>
                    </div>
                </div>
                <div class="p-4 sm:p-5">
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                        <label class="block col-span-2" >
                            <span>Title</span>
                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.title }}
                            </p>
                        </label>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500 col-span-2"></div>
                        <label class="block" >
                            <span>Name</span>
                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.name }}
                            </p>
                        </label>
                        <label class="block" >
                            <span>Mobile</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.mobile }}
                            </p>
                        </label>

                        <label class="block" >
                            <span>Email</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.email }}
                            </p>
                        </label>

                        <label class="block" >
                            <span>City</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.city }}
                            </p>
                        </label>
                        <label class="block" >
                            <span>Company Branch</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.company_branch }}
                            </p>
                        </label>

                    </div>
                    <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                        <label class="block" >
                            <span>Interest In</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.interest_in }}
                            </p>
                        </label>
                        <label class="block" >
                            <span>Purpose</span>
                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.purpose }}
                            </p>
                        </label>
                        <label class="block" >
                            <span>Budget</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.budget }}
                            </p>
                        </label>
                        <label class="block" >
                            <span>Lead Source</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.lead_source }}
                            </p>
                        </label>

                        <label class="block col-span-2">
                            <span>Keywords</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                <pre>{{ formData.keywords }}</pre>
                            </p>
                        </label>
                        <label class="block col-span-2">
                            <span>Remark</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                <pre>{{ formData.remark }}</pre>
                            </p>

                            <span class="text-tiny+ text-error" v-if="errors?.remark?.length">{{ errors.remark.at(0) }}</span>
                        </label>

                        <label class="block" >
                            <span>Lead Status</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.lead_status }}
                            </p>
                        </label>

                        <label class="block" >
                            <span>Followup Date </span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.followup_date }}
                            </p>
                        </label>
                        <label class="block" >
                            <span>Is Private? </span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                <i class="fa fa-lock text-red-500" v-if="formData.is_private"></i>
                                <i class="fa fa-unlock-alt text-green-700" v-else></i>
                            </p>
                        </label>
                        <label class="block" >
                            <span>Is Protected? </span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                <i class="fa fa-lock text-red-500" v-if="formData.is_protected"></i>
                                <i class="fa fa-unlock-alt text-green-700" v-else></i>
                            </p>
                        </label>
                        <label class="block" >
                            <span>Is Confidential? </span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                <i class="fa fa-lock text-red-500" v-if="formData.is_confidential"></i>
                                <i class="fa fa-unlock-alt text-green-700" v-else></i>
                            </p>
                        </label>

                    </div>
                    <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">

                        <label class="block" >
                            <span>Assigned To</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.assigned_user }}
                            </p>
                        </label>
                        <label class="block" >
                            <span>Assigned Date</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.assigned_date }}
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
        </div>
    </div>

</template>

<script>
import { mapGetters } from 'vuex' ;

export default {
    data(){
        return {
            pageTitle: 'Property Management',
            subTitle: 'View Property',
            isShowPopper: false,
            errors: {},
            formData:{
                title: '',
                name: '',
                mobile: null,
                email: null,
                city: null,
                budget: null,
                purpose: null,
                assigned_to: null,
                followup_date: null,
                interest_in: null,
                lead_source: null,
                lead_status: null,
                remark: null,
                keywords: null,
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
                            title: 'Property Management',
                            link: '/property'
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
            this.$request.getPropertyViewDetail( id )
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
        },
    }
}
</script>

<style>

</style>
