<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex place-content-center" :class="{'gap-4': formData?.id}">
        <div class="card p-4 w-7/12 sm:p-5 ">

            <form @submit.prevent="submitForm">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ formData?.id ? 'Update Lead' : 'Add New Lead' }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <router-link to="/lead"
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
                        <div v-if="!formData?.id && errors?.__lead_exists?.length" id="alert-2"
                            class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                            role="alert">

                            <i class="fa fa-exclamation-triangle"></i>
                            <span class="sr-only">Duplicate</span>
                            <div class="ml-3 text-sm font-medium">
                                Lead already exists with the given number. If you want to update the lead click here, <router-link :to="'/lead/edit/' + errors.__lead_exists.at(0)" class="font-semibold underline hover:no-underline">Go to Lead</router-link>.

                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block h-full col-span-2" >
                                <span>Title</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Title" type="text" name="title" v-model="formData.title">
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.title?.length">{{ errors.title.at(0) }}</span>
                            </label>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500 col-span-2"></div>
                            <label class="block h-full" >
                                <span>Name</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Name" type="text" name="name" v-model="formData.name">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-user text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.name?.length">{{ errors.name.at(0) }}</span>
                            </label>
                            <label class="block h-full" >
                                <span>Mobile</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Mobile" type="text" name="mobile" v-model="formData.mobile">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-phone text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.mobile?.length">{{ errors.mobile.at(0) }}</span>
                            </label>

                            <label class="block h-full" >
                                <span>Email</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Email" type="email" name="email" v-model="formData.email">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-envelope text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.email?.length">{{ errors.email.at(0) }}</span>
                            </label>

                            <label class="block h-full" >
                                <span>City</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="City" type="text" name="city" v-model="formData.city">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-building text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.city?.length">{{ errors.city.at(0) }}</span>
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
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">

                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.property"
                                        form-label="Property"
                                        placeholder="Select Property"
                                        :is-ajax="true"
                                        request-name="propertySelectList"
                                        :ajax-preload="true"
                                        :selected-item="selected.property_data?.id"
                                        :selected-options="selected.property_data"
                                        :error-msg="errors?.property"
                                    />

                            <label class="block h-full" >
                                <span>Interest In</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Interest" type="text" name="interest_in" v-model="formData.interest_in">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-thumbs-up text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.interest_in?.length">{{ errors.interest_in.at(0) }}</span>
                            </label>
                            <label class="block h-full" >
                                <span>Purpose</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Purpose" type="text" name="purpose" v-model="formData.purpose">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-question text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.purpose?.length">{{ errors.purpose.at(0) }}</span>
                            </label>
                            <label class="block h-full" >
                                <span>Budget</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Budget ( 1 Lacs - 5 Lacs )" type="text" name="budget" v-model="formData.budget">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-inr text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.budget?.length">{{ errors.budget.at(0) }}</span>
                            </label>

                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.lead_source"
                                        form-label="Lead Source"
                                        value-field="name"
                                        placeholder="Select Lead Source"
                                        :is-ajax="true"
                                        request-name="leadSourceSelectList"
                                        :ajax-preload="true"
                                        :selected-item="formData.lead_source"
                                        :selected-options="formData.lead_source"
                                        :error-msg="errors?.lead_source"
                                    />
                            <label class="block h-full col-span-2">
                                <span>Keywords</span>
                                <label class="block">
                                    <textarea
                                    rows="4"
                                    placeholder="Keywords"
                                    v-model="formData.keywords"
                                    class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    ></textarea>
                                </label>

                                <span class="text-tiny+ text-error" v-if="errors?.keywords?.length">{{ errors.keywords.at(0) }}</span>
                            </label>
                            <label class="block h-full col-span-2">
                                <span>Remark</span>
                                <label class="block">
                                    <textarea
                                    rows="4"
                                    placeholder="Remark"
                                    v-model="formData.remark"
                                    class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    ></textarea>
                                </label>

                                <span class="text-tiny+ text-error" v-if="errors?.remark?.length">{{ errors.remark.at(0) }}</span>
                            </label>

                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.lead_status"
                                        value-field="name"
                                        form-label="Lead Status"
                                        placeholder="Select Lead Status"
                                        :is-ajax="true"
                                        request-name="leadStatusSelectList"
                                        :ajax-preload="true"
                                        :selected-item="formData.lead_status"
                                        :selected-options="formData.lead_status"
                                        :error-msg="errors?.lead_status"
                                    />

                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.assigned_to"
                                        form-label="Assign To"
                                        placeholder="Select Assign To"
                                        :is-ajax="true"
                                        request-name="companyMembersSelectList"
                                        :ajax-preload="true"
                                        :selected-item="selected.assigned_to?.id"
                                        :selected-options="selected.assigned_to"
                                        :error-msg="errors?.assigned_to"
                                    />

                            <label class="block h-full" >
                                <span>Followup Date </span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="YYYY-MM-DD" type="date" name="followup_date" v-model="formData.followup_date">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-calendar-alt text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.followup_date?.length">{{ errors.followup_date.at(0) }}</span>
                            </label>
                            <div class="flex-wrap items-start space-y-2 pt-2 sm:flex sm:space-x-5 sm:space-y-0" >
                                <label class="inline-flex items-center space-x-2">
                                    <input
                                        name="is_private"
                                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                        type="checkbox"
                                        :value="1"
                                        v-model="formData.is_private"
                                        >
                                    <span>Is Private?</span>
                                </label>
                            </div>
                            <div class="flex-wrap items-start space-y-2 pt-2 sm:flex sm:space-x-5 sm:space-y-0" >
                                <label class="inline-flex items-center space-x-2">
                                    <input
                                        name="is_protected"
                                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                        type="checkbox"
                                        :value="1"
                                        v-model="formData.is_protected"
                                        >
                                    <span>Is Protected?</span>
                                </label>
                            </div>
                            <div class="flex-wrap items-start space-y-2 pt-2 sm:flex sm:space-x-5 sm:space-y-0" >
                                <label class="inline-flex items-center space-x-2">
                                    <input
                                        name="is_confidential"
                                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                        type="checkbox"
                                        :value="1"
                                        v-model="formData.is_confidential"
                                        >
                                    <span>Is Confidential?</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card p-4 w-7/12 sm:p-5 " v-if="formData?.id">
            <div class="card">
                <div
                    class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                       History
                    </h2>
                    <div class="flex justify-center space-x-2">
                        <button
                            @click="showCommentForm"
                            v-if="userPermissions.isPermissionsAllowed([ $permissions.CAN_COMMENT ] )"
                            class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                            >
                            <i class="fa fa-comments mr-2"></i> Add Comment
                        </button>
                    </div>
                </div>
                <div class="p-4 sm:p-5">
                    <ol class="timeline [--size:1.5rem]" v-if="formData?.comments?.length">
                        <li class="timeline-item" v-for="(item, index) in formData.comments" :key="'comments_'+index">
                            <div class="timeline-item-point rounded-full bg-slate-300 dark:bg-navy-400">
                            </div>

                            <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                                <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                                    <p class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0">
                                        {{ item.created_user }}
                                    </p>
                                    <span class="text-xs text-slate-400 dark:text-navy-300">{{ item.created_time }}</span>
                                </div>
                                <p class="py-1"><pre>{{ item.comment }}</pre></p>
                                <div class="mt-4" >
                                    <span class="font-medium text-slate-600 dark:text-navy-100">
                                        Status:
                                    </span>
                                    <span class="text-xs text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">
                                        {{ item.status }}
                                    </span>
                                </div>
                                <div class="mt-4" v-if="item.followup_date">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">
                                        Followup Date:
                                    </span>
                                    <span class="text-xs text-primary hover:text-primary-focus dark:text-accent-light dark:hover:text-accent">
                                        {{ item.followup_date }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    </ol>
                    <no-data-found message="No history found." v-else />
                </div>
            </div>
        </div>
        <Teleport to="#teleport-target">

            <add-comment-form v-if="userPermissions.isPermissionsAllowed([ $permissions.CAN_COMMENT ] ) && show.commentForm" title="Add Comment" :lead-id="formData.id" @close="hideCommentForm" @onAdded="onCommentAdd" />
        </Teleport>
    </div>

</template>

<script>
import * as Yup from 'yup';
import { mapGetters } from 'vuex' ;
import AddCommentForm from '@/components/leads/AddCommentForm.vue' ;

export default {
    components:{
        AddCommentForm
    },
    data(){
        return {
            pageTitle: 'Lead Management',
            subTitle: 'Add Lead',
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
                property: null,
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
                property_data: {},
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
                            title: 'Lead Management',
                            link: '/lead'
                        },
                        {
                            title: (this.formData?.id ? 'Edit': 'Create'),
                        }
                    ];
            return breadcrumbs;
        },
        validationSchema(){
            let fields = {
                title: Yup.string()
                            .nullable(true)
                            .required('Required'),
                name: Yup.string()
                            .nullable(true)
                            .required('Required'),
                city: Yup.string()
                            .nullable(true)
                            .required('Required'),
                keywords: Yup.string()
                            .nullable(true)
                            .required('Required'),
                interest_in: Yup.string()
                            .nullable(true)
                            .required('Required'),
                purpose: Yup.string()
                            .nullable(true)
                            .required('Required'),
                company_branch: Yup.string()
                            .nullable(true)
                            .required('Required'),
                lead_source: Yup.string()
                            .nullable(true)
                            .required('Required'),
                lead_status: Yup.string()
                            .nullable(true)
                            .required('Required'),
                mobile: Yup.string()
                            .nullable(true)
                            .required('Required')
                            .min( 10, 'Must be 10 digits')
                            .max( 10, 'Must be 10 digits'),
                email: Yup.string()
                            .nullable(true)
                            .email( 'Must be a valid email address'),

            }
            const yup = Yup.object().shape( fields );

            return yup;
        }
    },
    methods:{
        init () {
            if( this.$route?.params?.id ){
                this.loadEditFormDetail( this.$route.params.id );

            }else{
                this.$store.commit('setGlobalLoaderOff');
            }
        },
        loadEditFormDetail( id ){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getLeadDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.formData = Object.assign( this.formData, res.data.data);
                                    this.selected.assigned_to = this.formData.assigned_to_data;
                                    this.selected.company_branch_data = this.formData.company_branch_data;
                                    this.selected.property_data = this.formData.property_data;
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
                                        this.$request.createLead( this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! New Lead added successfully.';
                                                            if( this.formData?.id ){
                                                                message = 'Success! Lead data updated successfully.';
                                                            }
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            this.$router.push({ name: 'lead_lists' });
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
        showCommentForm(){
            this.show.commentForm = true;
        },
        hideCommentForm(){
            this.show.commentForm = false;
        },
        onCommentAdd(){

            this.hideCommentForm();
            this.loadViewDetail( this.$route.params.id );
        },
        loadViewDetail( id ){
            this.$request.getLeadViewDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    if( res?.data?.data?.comments?.length ){

                                        this.formData.comments = res.data.data.comments;
                                    }
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
