<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex">
        <div class="p-4 sm:p-5 w-full">

            <div class="">
                <div class=" grid grid-cols-12 gap-2">
                    <div
                        class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ formData.title || 'N/A' }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <router-link to="/project"
                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </router-link>

                            <router-link :to="'/project/edit/' + formData.id"
                                v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_PROJECT ] )"
                                class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <i class="fa fa-pencil mr-2"></i> Edit
                            </router-link>
                        </div>
                    </div>
                    <div class="card mt-2 p-4 sm:p-5 col-span-7">

                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block h-full" >
                                <span>Title</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.title }}
                                </p>

                            </label>
                            <label class="block h-full" >
                                <span>RERA Reg. No.</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.rera_reg_no }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Project No.</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.project_no }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Company Branch</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.company_branch }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Commencement Certificate</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.commencement_certificate }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Occupancy Certificate</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.occupancy_certificate }}
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block h-full" >
                                <span>Total Unit</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.total_unit }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Launch Date</span>


                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.launch_date }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Completion Date</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.completion_date }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Project Area</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.project_area }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Developer Name</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.developer_name }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Approved By</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.approved_by }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Open Space</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.open_space }}
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">

                            <label class="block h-full" >
                                <span>Availability</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.availability }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Availability Date</span>

                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.availability_date }}
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 items-center">
                            <label class="block h-full">
                                <span>Specification</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre class="whitespace-pre-wrap break-words">{{ formData.specification }}</pre>
                                </p>
                            </label>
                            <label class="block h-full">
                                <span>Description</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre class="whitespace-pre-wrap break-words">{{ formData.specification }}</pre>
                                </p>
                            </label>
                            <label class="block h-full">
                                <span>Remark</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre class="whitespace-pre-wrap break-words">{{ formData.remark }}</pre>
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block h-full col-span-2">
                                <span>Address</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre class="whitespace-pre-wrap break-words">{{ formData.address }}</pre>
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>City</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.city }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Locality</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.locality }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Landmark</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.landmark }}
                                </p>
                            </label>
                            <label class="block h-full" >
                                <span>Building</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.building }}
                                </p>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-12 gap-4 sm:grid-cols-12 items-center">

                            <label class="block h-full col-span-12" >
                                <span>Walk Through Link</span>
                                <div class="w-full" v-if="formData.walk_through_link">
                                    <iframe :src="formData.walk_through_link" frameborder="0"></iframe>
                                </div>
                                <p v-else class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    Not Available
                                </p>
                            </label>
                            <label class="block h-full col-span-12" >
                                <span>Virtual Tour Link</span>
                                <div class="w-full" v-if="formData.virtual_tour">
                                    <iframe :src="formData.virtual_tour" frameborder="0"></iframe>
                                </div>
                                <p v-else class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    Not Available
                                </p>
                            </label>

                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-12 gap-4 sm:grid-cols-12 items-center">

                            <label class="block h-full col-span-12 mt-2">
                                <span>Amenities</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    <pre class="whitespace-pre-wrap break-words">{{ formData.address }}</pre>
                                </p>
                            </label>

                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">

                            <label class="block" >
                                <span>Assign To</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.assign_user }}
                                </p>
                            </label>
                            <label class="block" >
                                <span>Assign Date</span>
                                <p class="text-xs+ text-slate-400 dark:text-navy-300" >
                                    {{ formData.assign_date }}
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

                    <div class="card mt-2 p-4 sm:p-5 col-span-5">
                        <h5 class="text-xl font-medium text-gray-900 dark:text-white">Site Visits</h5>
                        <!-- <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div> -->
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
                    <div class="card mt-2 p-4 sm:p-5 col-span-12">
                        <div
                            class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Project Tower
                            </h2>
                        </div>
                        <div class="is-scrollbar-hidden min-w-full overflow-x-auto mt-2">
                            <table class="is-hoverable w-full text-left">
                                <thead>
                                    <tr>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            Tower Name
                                        </th>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            Completion Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="formData.project_towers?.length">
                                    <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in formData.project_towers" :key="'project_towers_' + idx">
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{ item.tower_name }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{ item.completion_date }}
                                        </td>
                                    </tr>
                                </tbody>

                            </table>

                            <no-data-found v-if="!formData?.project_towers?.length" />
                        </div>
                    </div>
                    <div class="card mt-2 p-4 sm:p-5 col-span-12">
                        <div
                            class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Project Plan
                            </h2>
                        </div>
                        <div class="is-scrollbar-hidden min-w-full overflow-x-auto mt-2">
                            <table class="is-hoverable w-full text-left">
                                <thead>
                                    <tr>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            Tower
                                        </th>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            Type
                                        </th>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            BHK
                                        </th>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            Area
                                        </th>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            Price
                                        </th>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            Basic Price
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="formData?.project_plans?.length">
                                    <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in formData.project_plans" :key="'project_plans_' + idx">
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{item.tower}}

                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{item.type}}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{item.bhk}}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{item.area}}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{item.price}}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{item.basic_price}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <no-data-found v-if="!formData?.project_plans?.length" />
                        </div>
                    </div>
                    <div class="card mt-2 p-4 sm:p-5 col-span-12">
                        <div
                            class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Project Charges
                            </h2>
                        </div>
                        <div class="is-scrollbar-hidden min-w-full overflow-x-auto mt-2">
                            <table class="is-hoverable w-full text-left">
                                <thead>
                                    <tr>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            Charges
                                        </th>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            Description
                                        </th>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            Price
                                        </th>
                                        <th
                                            class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                        >
                                            Escalation From
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="formData?.project_charges?.length">
                                    <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in formData.project_charges" :key="'project_charges_' + idx">
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{item.charges}}

                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            <pre class="whitespace-pre-wrap break-words">{{ item.description }}</pre>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{item.price}}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            {{item.escalation_from}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <no-data-found v-if="!formData?.project_charges?.length" />
                        </div>
                    </div>
                    <div class="card mt-2 p-4 sm:p-5 col-span-12">
                        <div
                            class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                Images
                                <button
                                    v-if="formData.images?.length"
                                    type="button"
                                    class="btn h-9 w-9 rounded-full bg-info/10 p-0 font-medium text-info hover:bg-info/20 focus:bg-info/20 active:bg-info/25"
                                    @click="openModal"
                                >
                                   <i class="fa fa-external-link"></i>
                                </button>
                            </h2>
                        </div>
                        <div class="grid grid-cols-8 gap-4 mt-2" v-if="formData.images?.length">
                            <div class="card" v-for="(imgData, index) in formData.images" :key="'image_list_container_' + index">
                                <img class="w-full rounded-lg object-cover" :src="(imgData.url)" alt="image">
                            </div>
                        </div>
                        <div
                            v-else
                            class="alert flex rounded-lg border border-error px-4 py-4 text-error sm:px-5"
                        >
                            No images found.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <Teleport to="#teleport-target" v-if="show.modal">

            <property-image-modal-vue v-if="show.modal" :images="formData.images" @close="closeModal"/>
        </Teleport>
    </div>

</template>

<script>

import Swiper from 'swiper'
import {Navigation} from 'swiper/modules'
import { mapGetters } from 'vuex' ;
import PropertyImageModalVue from '@/components/property/PropertyImageModal.vue';

export default {
    components:{
        PropertyImageModalVue
    },

    data(){
        return {
            pageTitle: 'Project Management',
            subTitle: 'View Project',
            isShowPopper: false,
            errors: {},
            options:{
                'property_img_types': [],
            },
            formData:{
                title: null,
                rera_reg_no: null,
                project_no: null,
                launch_date: null,
                completion_date: null,
                company_branch: null,
                project_area: null,
                developer_name: null,
                approved_by: null,
                open_space: null,
                total_unit: null,
                availability: null,
                availability_date: null,
                commencement_certificate: null,
                occupancy_certificate: null,
                specification: null,
                description: null,
                remark: null,
                landmark: null,
                city: null,
                locality: null,
                building: null,
                address: null,
                amenities: null,
                owner_name: null,
                owner_email: null,
                owner_phone: null,
                assign_user: null,
                assign_date: null,
                owner_name: null,
                owner_email: null,
                owner_phone: null,
                walk_through_link: null,
                images: {},
                project_towers: [],
                project_plans: [],
                project_charges: [],
            },
            show:{
                modal: false
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
                            title: 'Project Management',
                            link: '/project'
                        },
                        {
                            title: 'View',
                        }
                    ];
            return breadcrumbs;
        },
        formDataImagesKeys () {
            return Object.keys( this.formData.images );
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
            this.$request.getProjectViewDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.formData = Object.assign( this.formData, res.data.data);
                                    setTimeout(() => {

                                        this.$nextTick( () => {
                                            new Swiper( this.$refs['swiper'],{
                                                modules:[ Navigation ],
                                                    navigation: {
                                                        prevEl: this.$refs['swiperPrevBtn'],
                                                        nextEl: this.$refs['swiperNextBtn']}
                                                    }
                                                )
                                        }, 500)
                                    })
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

        openModal () {
            this.show.modal = true;
        },
        closeModal () {
            this.show.modal = false;
        }
    }
}
</script>

<style>

</style>
