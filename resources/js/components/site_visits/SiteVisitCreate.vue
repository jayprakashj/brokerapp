<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex place-content-center" :class="{'gap-4': formData?.id}">
        <div class="card p-4 w-7/12 sm:p-5 ">

            <form @submit.prevent="submitForm">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ formData?.id ? 'Update Site Visit' : 'Add New Site Visit' }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <router-link to="/site-visit"
                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </router-link>
                            <button type="submit"
                                class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                {{ formData?.id ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.type"
                                        form-label="Type"
                                        placeholder="Select Type"
                                        :options="options.types"
                                        :selected-item="formData.type"
                                        :error-msg="errors?.type"
                                    />
                            <input-tom-select
                                        v-if="formData.type == 'property'"
                                        class="h-full"
                                        v-model="formData.property_id"
                                        form-label="Property"
                                        placeholder="Select Property"
                                        :options="options.properties"
                                        :selected-item="formData.property_id"
                                        :error-msg="errors?.property_id"
                                    />
                            <input-tom-select
                                        v-if="formData.type == 'project'"
                                        class="h-full"
                                        v-model="formData.project_id"
                                        form-label="Project"
                                        placeholder="Select Project"
                                        :options="options.projects"
                                        :selected-item="formData.project_id"
                                        :error-msg="errors?.project_id"
                                    />
                            <label class="block h-full" >
                                <span>Site Name</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Site Name" type="text" name="site_name" v-model="formData.site_name">

                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.site_name?.length">{{ errors.site_name.at(0) }}</span>
                            </label>
                            <label class="block h-full" >
                                <span>Site Owner</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Site Owner" type="text" name="site_owner" v-model="formData.site_owner">

                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.site_owner?.length">{{ errors.site_owner.at(0) }}</span>
                            </label>
                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.company_branch"
                                        form-label="Company Branch"
                                        placeholder="Select Branch"
                                        :is-ajax="true"
                                        request-name="companyBranchSelectList"
                                        :ajax-preload="true"
                                        :selected-item="selected.company_branch_data?.id"
                                        :selected-options="selected.company_branch_data"
                                        :error-msg="errors?.company_branch"
                                    />
                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.visit_type"
                                        form-label="Visit Type"
                                        placeholder="Select Visit Type"
                                        :options="options.visit_types"
                                        :selected-item="formData.visit_type"
                                        :error-msg="errors?.visit_type"
                                    />
                            <label class="block h-full" >
                                <span>Location</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Location" type="text" name="location" v-model="formData.location">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-location-dot text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.location?.length">{{ errors.location.at(0) }}</span>
                            </label>

                            <label class="block h-full" >
                                <span>Time In</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Time in" type="datetime-local" name="time_in" v-model="formData.time_in">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-clock text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.time_in?.length">{{ errors.time_in.at(0) }}</span>
                            </label>
                            <label class="block h-full" >
                                <span>Time Out</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Time out" type="datetime-local" name="time_out" v-model="formData.time_out">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-clock text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.time_out?.length">{{ errors.time_out.at(0) }}</span>
                            </label>

                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.source_manager"
                                        form-label="Source Manager"
                                        placeholder="Select Source Manager"
                                        :options="options.members"
                                        :selected-item="formData.source_manager"
                                        :error-msg="errors?.source_manager"
                                    />
                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.closing_manager"
                                        form-label="Closing Manager"
                                        placeholder="Select Closing Manager"
                                        :options="options.members"
                                        :selected-item="formData.closing_manager"
                                        :error-msg="errors?.closing_manager"
                                    />
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">

                            <label class="block h-full col-span-2">
                                <span>Comments</span>
                                <label class="block">
                                    <textarea
                                    rows="4"
                                    placeholder="Comments"
                                    v-model="formData.comments"
                                    class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    ></textarea>
                                </label>

                                <span class="text-tiny+ text-error" v-if="errors?.comments?.length">{{ errors.comments.at(0) }}</span>
                            </label>


                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.assign_to"
                                        form-label="Assign To"
                                        placeholder="Select Assign User"
                                        :options="options.members"
                                        :selected-item="formData.assign_to"
                                        :error-msg="errors?.assign_to"
                                    />

                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

</template>

<script>
import * as Yup from 'yup';
import { mapGetters } from 'vuex' ;

export default {
    data(){
        return {
            pageTitle: 'Site Visits',
            subTitle: 'Add Site Visit',
            isShowPopper: false,
            errors: {},
            formData:{
                site_name: null,
                site_owner: null,
                location: null,
                type: null,
                time_in: null,
                time_out: null,
                property_id: null,
                project_id: null,
                company_branch: null,
                assign_to: null,
                source_manager: null,
                opening_manager: null,
                visit_type: null,
                comments: null,
            },
            rolesList: [],
            loading:{
                formSubmit: false,
                upload: false
            },
            selected:{
                assign_user_data: {},
                company_branch_data: {},
                property_data: {},
                project_data: {},
            },
            options:{
                'properties': [],
                'projects': [],
                'members': [],
                'visit_types': [],
                'types': [],

            },
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
                            title: (this.formData?.id ? 'Edit': 'Create'),
                        }
                    ];
            return breadcrumbs;
        },
        validationSchema(){
            let fields = {
                site_name: Yup.string()
                            .nullable(true)
                            .required('Required'),
                site_owner: Yup.string()
                            .nullable(true)
                            .required('Required'),
                location: Yup.string()
                            .nullable(true)
                            .required('Required'),
                type: Yup.string()
                            .nullable(true)
                            .required('Required'),
                property_id: Yup.string()
                            .nullable(true)
                            .when("type", (data, schema) => {
                                if( data.at(0) == 'property'){

                                    return schema.required('Required')
                                }
                                return schema;
                            }),
                project_id: Yup.string()
                            .nullable(true)
                            .when("type", (data, schema) => {
                                if( data.at(0) == 'project'){

                                    return schema.required('Required')
                                }
                                return schema;
                            }),
                company_branch: Yup.string()
                            .nullable(true)
                            .required('Required'),


            }
            const yup = Yup.object().shape( fields );

            return yup;
        }
    },
    methods:{
        init () {
            this.loadSelectListData();
            if( this.$route?.params?.id ){
                this.loadEditFormDetail( this.$route.params.id );

            }else{
                this.$store.commit('setGlobalLoaderOff');
            }
        },
        loadEditFormDetail( id ){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getSiteVisitDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.formData = Object.assign( this.formData, res.data.data);
                                    Object.keys( this.selected ).forEach( d => {
                                        if( d in this.formData ){
                                            this.selected[ d ] = this.formData[ d ];
                                        }
                                    })
                                    // this.selected.assigned_to = this.formData.assigned_to_data;
                                    // this.selected.company_branch_data = this.formData.company_branch_data;
                                    // this.selected.property_data = this.formData.property_data;
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
        submitForm () {
            if( this.loading.formSubmit ){
                return;
            }
            this.errors = {};
            this.validationSchema.validate( this.formData, { abortEarly: false })
                                    .then( ( resValidate ) => {
                                        this.loading.formSubmit = true;
                                        this.$store.commit('setGlobalLoaderOn');
                                        this.$request.createSiteVisit( this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! New Site Visit added successfully.';
                                                            if( this.formData?.id ){
                                                                message = 'Success! Site Visit data updated successfully.';
                                                            }
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            this.$router.push({ name: 'site_visit_lists' });
                                                            this.$toast.info( message );
                                                        },
                                                        ( err ) => {
                                                            let message = 'Error! There is error occured while processing request.';
                                                            if( err?.response?.status === 422 && err?.response?.data?.errors ){
                                                                this.errors =  err.response.data.errors ;
                                                            }
                                                            if( err?.response?.data?.message ){
                                                                message = err.response.data.message;
                                                            }
                                                            this.$toast.error( message );
                                                        }
                                                    ).finally(
                                                        () => {
                                                            this.loading.formSubmit = false;
                                                            this.$store.commit('setGlobalLoaderOff');
                                                        }
                                                    );
                                    },
                                    ( e ) => {
                                        const err = {};
                                        if( e.inner?.length ){
                                            e.inner.forEach( ele => {
                                                let keyPath = ele.path;
                                                err[ keyPath ] = [ele.message]
                                            });
                                            this.errors = err;
                                            this.$toast.error("Error! Please correct all the error fields.");
                                        }
                                    });
        },

        loadSelectListData(){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.siteVisitFormDropdownList()
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.options = Object.assign( this.options, res.data);
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
