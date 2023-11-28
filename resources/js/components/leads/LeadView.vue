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

                        <router-link to="/lead"
                            class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            Cancel
                        </router-link>
                        <router-link :to="'/lead/edit/' + formData.id"
                            v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_LEAD ] )"
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
                        <label class="block " >
                            <span>Enquiry Type</span>
                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.enquiry_type }}
                            </p>
                        </label>
                        <label class="block " >
                            <span>Property Type</span>
                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.property_type }}
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
                            <span>Gender</span>
                            <p class="text-xs+ capitalize text-slate-400 dark:text-navy-300" >
                                {{ formData.gender }}
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
                        <label class="block" >
                            <span>Customer Type</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.customer_type ?? 'N/A' }}
                            </p>
                        </label>
                        <label class="block" >
                            <span>Contact Type</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                {{ formData.contact_type ?? 'N/A' }}
                            </p>
                        </label>

                    </div>
                    <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                        <label class="block h-full" >
                            <span>Property</span>

                            <p class="text-xs+ text-slate-400 dark:text-navy-300 gap-2 flex flex-wrap mt-3" v-if="formData?.property_names?.length">
                                <div
                                    v-for="(item, idx) in formData.property_names"
                                    :key="'property_name_' + idx"
                                    class="badge rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light"
                                >
                                    {{ item }}
                                </div>
                            </p>
                            <p class="text-xs+ text-slate-400 dark:text-navy-300 pt-3" v-else>
                                N/A
                            </p>
                        </label>
                        <label class="block h-full" >
                            <span>Project</span>


                            <p class="text-xs+ text-slate-400 dark:text-navy-300 gap-2 flex flex-wrap mt-3" v-if="formData?.project_names?.length">
                                <div
                                    v-for="(item, idx) in formData.project_names"
                                    :key="'project_name_' + idx"
                                    class="badge rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light"
                                >
                                    {{ item }}
                                </div>
                            </p>
                            <p class="text-xs+ text-slate-400 dark:text-navy-300 pt-3" v-else>
                                N/A
                            </p>
                        </label>
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
                                <i class="fa fa-inr"></i> {{ formData.min_budget }} - <i class="fa fa-inr"></i> {{ formData.max_budget }}
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
        <div class="card p-4 w-7/12 sm:p-5 ">
            <div class="tabs flex flex-col">
                <div class="is-scrollbar-hidden overflow-x-auto">
                    <div class="border-b-2 border-slate-150 dark:border-navy-500">
                        <div class="tabs-list flex">
                            <button @click="changeTab('history')"
                                :class="{'border-primary dark:border-accent text-primary dark:text-accent-light': activeTab === 'history', 'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100': (activeTab !== 'history')}"
                                class="btn shrink-0 rounded-none border-b-2 px-3 py-2 font-medium">
                                History
                            </button>
                            <button @click="changeTab('property_references')"
                                :class="{'border-primary dark:border-accent text-primary dark:text-accent-light' : activeTab === 'property_references', 'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100': (activeTab !== 'property_references')}"
                                class="btn shrink-0 rounded-none border-b-2 px-3 py-2 font-medium">
                                Suggested Properties
                            </button>
                            <button @click="changeTab('site_visits')"
                                :class="{'border-primary dark:border-accent text-primary dark:text-accent-light': activeTab === 'site_visits', 'border-transparent hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100': (activeTab !== 'site_visits')}"
                                class="btn shrink-0 rounded-none border-b-2 px-3 py-2 font-medium">
                                Site Visits
                            </button>
                        </div>
                    </div>
                </div>
                <div class="tab-content pt-4">
                    <div v-show="activeTab === 'history'" >
                        <div
                            class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                            <div class="flex justify-end space-x-2">
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
                    <div v-show="activeTab === 'property_references'" >
                        <div v-if="formData?.property_references?.length" class="space-y-4">
                            <div class="card border border-light shadow-none hover:shadow lg:flex-row" v-for="(item, index) in formData.property_references" :key="'site_visit_'+index">
                                <!-- <img class="h-48 w-full shrink-0 rounded-t-lg bg-cover bg-center object-cover object-center lg:h-auto lg:w-48 lg:rounded-t-none lg:rounded-l-lg"
                                    src="/images/object/object-2.jpg" alt="image"> -->
                                <div class="flex w-full grow flex-col px-4 py-3 sm:px-5">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs+ text-info">{{ item.locality }}</span>
                                        <div class="-mr-1.5 flex space-x-1">
                                            <span class="text-2xl text-slate-500 font-bold"><i class="fa fa-inr"></i> {{ item.price }}</span>
                                        </div>
                                    </div>
                                    <div>
                                        <router-link v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_PROPERTY ] )" :to="'/property/view/' + item.id"
                                            class="text-lg font-medium text-slate-700 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">{{ item.name }}</router-link>
                                        <span v-else class="text-lg font-medium text-slate-700 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">{{ item.name }}</span>
                                    </div>
                                    <p class="mt-1 line-clamp-3 mb-2">
                                        <i class="fa fa-building mr-1"></i> {{ item.building_name }}
                                    </p>
                                    <div class="flex justify-between">
                                        <div class="mt-2 flex items-center text-xs">
                                            <span class="flex items-center space-x-2 hover:text-slate-800 dark:hover:text-navy-100">
                                                <div class="avatar h-6 w-6">
                                                    <img class="rounded-full" src="/public/images/user-placeholder.png" alt="avatar">
                                                </div>
                                                <div>

                                                    <span class="line-clamp-1 font-bold">{{ item.owner_name }}</span>
                                                    <div class="line-clamp-1">{{ item.owner_phone }}</div>
                                                </div>
                                            </span>
                                            <div class="mx-3 my-1 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                                            <span class="shrink-0 text-slate-400 dark:text-navy-300">{{ item.city }}
                                            </span>
                                        </div>
                                        <div class="mt-1 flex justify-end">
                                            <router-link v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_PROPERTY ] )" :to="'/property/view/' + item.id"
                                                class="btn px-2.5 py-1.5 font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                                View Detail
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <template v-if="false">
                                <div class="border-b border-slate-150 py-3 dark:border-navy-500" v-for="(item, index) in formData.property_references" :key="'site_visit_'+index">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <h2 class="cursor-pointer text-slate-600 line-clamp-1 dark:text-navy-100">
                                            {{ item.name }}
                                        </h2>
                                    </div>
                                    <p class="mt-1 mb-1"><i class="fa fa-building"></i> {{ item.building_name }}</p>
                                    <p class="mt-1"><i class="fa fa-location-dot"></i> {{ item.address }}</p>
                                    <div class="mt-2 grid grid-col-2 sm:grid-col-1">
                                        <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                            <div class="h-2 w-2 rounded-full bg-primary dark:bg-accent"></div>
                                            <div class="flex space-x-1 text-xs leading-6">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Owner Name</span>
                                                <span>{{ item.owner_name }}</span>
                                            </div>
                                        </div>
                                        <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                            <div class="h-2 w-2 rounded-full bg-primary dark:bg-accent"></div>
                                            <div class="flex space-x-1 text-xs leading-6">
                                                <span class="font-medium text-slate-700 dark:text-navy-100">Owner Mobile</span>
                                                <span>{{ item.owner_phone }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-1 flex items-end justify-between">
                                        <div class="flex flex-wrap items-center font-inter text-xs">
                                            <span class="flex items-center space-x-1">
                                                <i class="fa fa-inr"></i>
                                                <span>{{ item.price }}</span>
                                            </span>
                                            <div class="m-1.5 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                                            <span class="flex items-center space-x-1">
                                                <i class="fa fa-location"></i>
                                                <span>{{ item.locality }}</span>
                                            </span>
                                            <div class="m-1.5 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                                            <span class="flex items-center space-x-1">
                                                <i class="fa fa-city"></i>
                                                <span>{{ item.city }}</span>
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <router-link v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_PROPERTY ] )" :to="'/property/view/' + item.id" class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                                <i class="fa fa-external-link"></i>
                                            </router-link>

                                        </div>
                                    </div>
                                </div>

                            </template>
                        </div>
                        <no-data-found v-else />
                    </div>
                    <div v-show="activeTab === 'site_visits'" >
                        <div class="px-4 pt-2 pb-4" v-if="formData?.site_visits?.length">
                            <div class="border-b border-slate-150 py-3 dark:border-navy-500" v-for="(item, index) in formData.site_visits" :key="'site_visit_'+index">
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <h2 class="cursor-pointer text-slate-600 line-clamp-1 dark:text-navy-100">
                                        {{ item.site_name }}
                                    </h2>
                                </div>
                                <p class="mt-1"><i class="fa fa-location-dot"></i> {{ item.location }}</p>
                                <div class="mt-1 flex items-end justify-between">
                                    <div class="flex flex-wrap items-center font-inter text-xs">
                                        <span class="flex items-center space-x-1">
                                            <i class="fa fa-clock"></i>
                                            <span>{{ item.time_in }}</span>
                                        </span>
                                        <div class="m-1.5 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                                        <span class="flex items-center space-x-1">
                                            <i class="fa fa-clock"></i>
                                            <span>{{ item.time_out }}</span>
                                        </span>
                                        <div class="m-1.5 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                                        <div class="badge space-x-2.5 px-1">
                                            <span>{{ item.visit_type }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <router-link v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_SITE_VISIT ] )" :to="'/site-visit/view/' + item.id" class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <i class="fa fa-external-link"></i>
                                        </router-link>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <no-data-found v-else />
                    </div>
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
            subTitle: 'View Lead',
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
            },
            activeTab: 'history'
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
            this.$request.getLeadViewDetail( id )
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
        changeTab( tabKey ){
            this.activeTab = tabKey;
        }
    }
}
</script>

<style>

</style>
