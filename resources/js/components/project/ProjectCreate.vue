<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex">
        <div class="p-4 sm:p-5 w-full">

            <form @submit.prevent="submitForm">
                <div class="">
                    <div class=" grid grid-cols-12 gap-2">
                        <div
                            class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                {{ formData?.id ? 'Update Project' : 'Add New Project' }}
                            </h2>
                            <div class="flex justify-center space-x-2">
                                <router-link to="/project"
                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                    Cancel
                                </router-link>
                                <button type="submit"
                                    class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    {{ formData?.id ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                        <div class="card mt-2 p-4 sm:p-5 col-span-8">

                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                                <label class="block h-full" >
                                    <span>Title</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Title" type="text" name="title" v-model="formData.title">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-home text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.title?.length">{{ errors.title.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>RERA Reg. No.</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="RERA Reg No" type="text" name="rera_reg_no" v-model="formData.rera_reg_no">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-building text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.rera_reg_no?.length">{{ errors.rera_reg_no.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>Project No.</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Project No" type="text" name="project_no" v-model="formData.project_no">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.project_no?.length">{{ errors.project_no.at(0) }}</span>
                                </label>
                                <input-tom-select
                                        class="h-full"
                                        v-model="formData.project_type"
                                        form-label="Project Type"
                                        placeholder="Select Project Type"
                                        display-field="title"
                                        :options="options.project_types"
                                        :selected-item="formData.project_type"
                                        :error-msg="errors?.project_type"
                                    />
                                <input-tom-select
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
                                <label class="block h-full" >
                                    <span>Commencement Certificate</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Commencement Certificate" type="text" name="commencement_certificate" v-model="formData.commencement_certificate">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.commencement_certificate?.length">{{ errors.commencement_certificate.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>Occupancy Certificate</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Occupancy Certificate" type="text" name="occupancy_certificate" v-model="formData.occupancy_certificate">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.occupancy_certificate?.length">{{ errors.occupancy_certificate.at(0) }}</span>
                                </label>
                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                                <label class="block h-full" >
                                    <span>Total Unit</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Total Unit" type="text" name="total_unit" v-model="formData.total_unit">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.total_unit?.length">{{ errors.total_unit.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>Launch Date</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="DD/MM/YYYY" type="date" name="launch_date" v-model="formData.launch_date">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.launch_date?.length">{{ errors.launch_date.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>Completion Date</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="DD/MM/YYYY" type="date" name="completion_date" v-model="formData.completion_date">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.completion_date?.length">{{ errors.completion_date.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>Project Area</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Project Area" type="text" name="project_area" v-model="formData.project_area">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.project_area?.length">{{ errors.project_area.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>Developer Name</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Developer Name" type="text" name="developer_name" v-model="formData.developer_name">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.developer_name?.length">{{ errors.developer_name.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>Approved By</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Approved By" type="text" name="approved_by" v-model="formData.approved_by">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.approved_by?.length">{{ errors.approved_by.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>Open Space</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Open Space" type="text" name="open_space" v-model="formData.open_space">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.open_space?.length">{{ errors.open_space.at(0) }}</span>
                                </label>
                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">

                                <label class="block h-full" >
                                    <span>Availability</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Availability" type="text" name="availability" v-model="formData.availability">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.availability?.length">{{ errors.availability.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>Availability Date</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="DD/MM/YYYY" type="date" name="availability_date" v-model="formData.availability_date">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.availability_date?.length">{{ errors.availability_date.at(0) }}</span>
                                </label>
                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 items-center">
                                <label class="block h-full">
                                    <span>Specification</span>
                                    <label class="block">
                                        <textarea
                                        rows="4"
                                        placeholder="Specification"
                                        v-model="formData.specification"
                                        class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        ></textarea>
                                    </label>

                                    <span class="text-tiny+ text-error" v-if="errors?.specification?.length">{{ errors.specification.at(0) }}</span>
                                </label>
                                <label class="block h-full">
                                    <span>Description</span>
                                    <label class="block">
                                        <textarea
                                        rows="4"
                                        placeholder="Description"
                                        v-model="formData.description"
                                        class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        ></textarea>
                                    </label>

                                    <span class="text-tiny+ text-error" v-if="errors?.description?.length">{{ errors.description.at(0) }}</span>
                                </label>
                                <label class="block h-full">
                                    <span>Remark</span>
                                    <label class="block">
                                        <textarea
                                        rows="4"
                                        placeholder="Remark"
                                        v-model="formData.remark"
                                        class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        ></textarea>
                                    </label>

                                    <span class="text-tiny+ text-error" v-if="errors?.remark?.length">{{ errors.remark.at(0) }}</span>
                                </label>
                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                                <label class="block h-full col-span-2">
                                    <span>Address</span>
                                    <label class="block">
                                        <textarea
                                        rows="4"
                                        placeholder="Address"
                                        v-model="formData.address"
                                        class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        ></textarea>
                                    </label>

                                    <span class="text-tiny+ text-error" v-if="errors?.address?.length">{{ errors.address.at(0) }}</span>
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
                                <label class="block h-full" >
                                    <span>Locality</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Locality" type="text" name="locality" v-model="formData.locality">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-location-crosshairs text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.locality?.length">{{ errors.locality.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>Landmark</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Landmark" type="text" name="landmark" v-model="formData.landmark">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-location-dot text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.landmark?.length">{{ errors.landmark.at(0) }}</span>
                                </label>
                                <label class="block h-full" >
                                    <span>Building</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Building" type="text" name="building" v-model="formData.building">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-building text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.building?.length">{{ errors.building.at(0) }}</span>
                                </label>
                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-12 gap-4 sm:grid-cols-12 items-center">
                                <label class="block h-full col-span-12" >
                                    <span>
                                        Pick Location
                                        <span class="text-tiny+ text-error" v-if="errors?.latitude?.length">({{ errors.latitude.at(0) }})</span>
                                        <span class="text-tiny+ text-error" v-else-if="errors?.longitude?.length">({{ errors.longitude.at(0) }})</span>
                                    </span>
                                    <div v-if="!showMapSelector" class="p-4">
                                        <button
                                            type="button"
                                            @click.prevent="showMapSelector = true"
                                            class="btn border border-info font-medium text-info hover:bg-info hover:text-white focus:bg-info focus:text-white active:bg-info/90"
                                            >
                                            Click to Load Map
                                        </button>
                                    </div>
                                    <location-selector
                                        v-else
                                        :address-label="formData.title"
                                        :formatted-address="formData.address"
                                        :marker-position="{lat: formData.latitude,lng: formData.longitude}"
                                        @onLocationChange="onLocationSelect"
                                    />
                                </label>
                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-12 gap-4 sm:grid-cols-12 items-center">

                                <label class="block h-full col-span-12" >
                                    <span>Walk Through Link</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Walk Through Link" type="text" name="walk_through_link" v-model="formData.walk_through_link">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.walk_through_link?.length">{{ errors.walk_through_link.at(0) }}</span>
                                </label>
                                <label class="block h-full col-span-12" >
                                    <span>Virtual Tour Link</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Virtual Tour Link" type="text" name="virtual_tour" v-model="formData.virtual_tour">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.virtual_tour?.length">{{ errors.virtual_tour.at(0) }}</span>
                                </label>

                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-12 gap-4 sm:grid-cols-12 items-center">

                                <label class="block h-full col-span-12 mt-2">
                                    <span>Amenities</span>
                                    <label class="block">
                                        <textarea
                                        rows="4"
                                        placeholder="Amenities"
                                        v-model="formData.amenities"
                                        class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        ></textarea>
                                    </label>

                                    <span class="text-tiny+ text-error" v-if="errors?.amenities?.length">{{ errors.amenities.at(0) }}</span>
                                </label>

                            </div>
                        </div>
                        <div class="card mt-2 p-4 sm:p-5 col-span-4">

                            <!-- <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div> -->
                            <div class="  items-center">

                                <input-tom-select
                                        v-model="formData.assign_to"
                                        form-label="Assign To"
                                        placeholder="Select Assign To"
                                        :is-ajax="true"
                                        request-name="companyMembersSelectList"
                                        :ajax-preload="true"
                                        :selected-item="selected.assign_user_data?.id"
                                        :selected-options="selected.assign_user_data"
                                        :error-msg="errors?.assign_to"
                                    />

                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="space-y-4">
                                <label class="block" >
                                    <span>Owner Name</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Owner Name" type="text" name="owner_name" v-model="formData.owner_name">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-user text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.owner_name?.length">{{ errors.owner_name.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Owner Phone</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Owner Phone" type="text" name="owner_phone" v-model="formData.owner_phone">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-phone text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.owner_phone?.length">{{ errors.owner_phone.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Owner Email</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Owner Email" type="text" name="owner_email" v-model="formData.owner_email">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-envelope text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.owner_email?.length">{{ errors.owner_email.at(0) }}</span>
                                </label>
                            </div>

                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="space-y-4">
                                <label class="block">
                                    <span>Upload Documents</span>
                                    <div class="mt-4">

                                        <label
                                                class="btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                                                @click="openMediaUpload('documents')"
                                                id="document-upload"
                                                key="document_upload_label"
                                            >
                                                <input
                                                    tabindex="-1"
                                                    type="file"
                                                    class="pointer-events-none absolute inset-0 h-full w-full opacity-0"
                                                    ref="documents"
                                                    @change="uploadMedia( $event, 'documents')"
                                                />
                                                <div class="flex items-center space-x-2">
                                                    <i class="fa fa-upload"></i>
                                                    <span>Choose File</span>
                                                </div>
                                        </label>
                                    </div>
                                </label>
                                    <div class="grid grid-cols-3 gap-4 mt-4">
                                        <div class="card" v-for="(item, index) in formData.documents" :key="'document_list_container_' + index">
                                            <!-- <img class="w-full rounded-lg object-cover" :src="(item.url || 'https://picsum.photos/100/100')" alt="image"> -->
                                            <i class="fa fa-file-alt fa-6x m-auto"></i>
                                            <a :href="item.url" class="mt-2 p-2" target="_blank">
                                                <p class="text-tiny ml-1">{{ item.name ?? item.id }}</p>
                                            </a>
                                            <div class="absolute flex h-9 w-9 right-4">
                                                <div class="flex justify-end p-3">
                                                    <button type="button" class="btn h-7 w-7 rounded-full text-white bg-red-500 p-0 hover:bg-red-700 focus:bg--red-700" @click="removeDocument(index, item)">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="card mt-2 p-4 sm:p-5 col-span-12">
                            <div
                                class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                    Project Tower
                                    <button
                                        @click="addProjectTower"
                                        type="button"
                                        class="btn h-6 font-light bg-primary/10 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25"
                                    >
                                    <small class="h6">
                                        <i class="fa fa-plus"></i> Add New

                                    </small>
                                    </button>
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
                                            <th
                                                class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                            >

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in formData.project_towers" :key="'project_towers_' + idx">
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Tower Name" type="text" :name="'project_towers['+idx+'][tower_name]'" v-model="item.tower_name">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="DD/MM/YYYY" type="date" :name="'project_towers['+idx+'][completion_date]'" v-model="item.completion_date">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <button
                                                        type="button"
                                                        @click="removeProjectTower(idx)"
                                                        class="btn h-9 w-9 p-0 font-medium text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25"
                                                    >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mt-2 p-4 sm:p-5 col-span-12">
                            <div
                                class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                    Project Plan
                                    <button
                                        @click="addProjectPlan"
                                        type="button"
                                        class="btn h-6 font-light bg-primary/10 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25"
                                    >
                                    <small class="h6">
                                        <i class="fa fa-plus"></i> Add New

                                    </small>
                                    </button>
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
                                            <th
                                                class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                            >

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in formData.project_plans" :key="'project_plans_' + idx">
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Tower" type="text" :name="'project_plans['+idx+'][tower]'" v-model="item.tower">

                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Type" type="text" :name="'project_plans['+idx+'][type]'" v-model="item.type">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="BHK" type="text" :name="'project_plans['+idx+'][bhk]'" v-model="item.bhk">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Area" type="text" :name="'project_plans['+idx+'][area]'" v-model="item.area">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Price" type="text" :name="'project_plans['+idx+'][price]'" v-model="item.price">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Basic Price" type="text" :name="'project_plans['+idx+'][basic_price]'" v-model="item.basic_price">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <button
                                                        type="button"
                                                        @click="removeProjectPlan(idx)"
                                                        class="btn h-9 w-9 p-0 font-medium text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25"
                                                    >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mt-2 p-4 sm:p-5 col-span-12">
                            <div
                                class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                    Project Charges
                                    <button
                                        @click="addProjectCharge"
                                        type="button"
                                        class="btn h-6 font-light bg-primary/10 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25"
                                    >
                                    <small class="h6">
                                        <i class="fa fa-plus"></i> Add New

                                    </small>
                                    </button>
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
                                            <th
                                                class="whitespace-nowrap rounded-l-lg bg-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5"
                                            >

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="border border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in formData.project_charges" :key="'project_charges_' + idx">
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Charges" type="text" :name="'project_charges['+idx+'][charges]'" v-model="item.charges">

                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <textarea
                                                    rows="4"
                                                    placeholder="Description"
                                                    v-model="item.description"
                                                    class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                ></textarea>
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Price" type="text" :name="'project_charges['+idx+'][price]'" v-model="item.price">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Escalation From" type="text" :name="'project_charges['+idx+'][escalation_from]'" v-model="item.escalation_from">
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                <button
                                                        type="button"
                                                        @click="removeProjectCharge(idx)"
                                                        class="btn h-9 w-9 p-0 font-medium text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25"
                                                    >
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card mt-2 p-4 sm:p-5 col-span-12" v-for="(imgType, idx ) in formDataImagesKeys" :key="'images_'+idx">
                            <div
                                class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                    Select Images for {{ imgType }}
                                </h2>
                            </div>
                            <label
                                class="btn w-1/2 mt-2  bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                                >
                                    <input
                                        tabindex="-1"
                                        type="file"
                                        :name="imgType"
                                        :ref="imgType"
                                        @change="uploadMedia( $event, imgType)"
                                        class="pointer-events-none absolute inset-0 h-full w-full opacity-0"
                                        multiple
                                    />
                                    <div class="flex items-center space-x-2" @click="openMediaUpload( imgType )">
                                        <i class="fa fa-upload"></i>
                                        <span>Choose File</span>
                                    </div>
                            </label>
                            <template v-if="imgType in formData.images">

                                <div class="grid grid-cols-8 gap-4 mt-2">
                                    <div class="card" v-for="(imgData, index) in formData.images[ imgType ]" :key="'image_list_container_' + index">
                                        <img class="w-full rounded-lg object-cover" :src="(imgData.url || 'https://picsum.photos/100/100')" alt="image">
                                        <div class="absolute inset-0 flex h-full w-full flex-col justify-between">
                                            <div class="flex justify-end p-3">
                                                <button type="button" class="btn h-7 w-7 rounded-full text-white bg-red-500 p-0 hover:bg-red-700 focus:bg--red-700" @click="removeMedia(index, imgType)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

</template>

<script>
import * as Yup from 'yup';
import LocationSelector from '@/components/site_visits/LocationSelector.vue'

export default {
    components:{
        LocationSelector
    },

    data(){
        return {
            pageTitle: 'Project Management',
            subTitle: 'Add Project',
            isShowPopper: false,
            showMapSelector: false,
            errors: {},
            options:{
                'property_img_types': [],
                'project_types': [],
            },
            formData:{
                title: null,
                rera_reg_no: null,
                project_no: null,
                launch_date: null,
                completion_date: null,
                company_branch: null,
                project_type: null,
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
                latitude: null,
                longitude: null,
                amenities: null,
                owner_name: null,
                owner_email: null,
                owner_phone: null,
                assign_to: null,
                owner_name: null,
                owner_email: null,
                owner_phone: null,
                walk_through_link: null,
                images: {},
                project_towers: [],
                project_plans: [],
                project_charges: [],
                documents: [],
            },
            rolesList: [],
            loading:{
                formSubmit: false,
                upload: false
            },
            media:{
            },
            selected:{
                company_branch_data: {},
                assign_user_data: {}
            },
        }
    },
    mounted(){
        this.init();
    },
    computed:{
        breadcrumbs(){

            var breadcrumbs = [
                        {
                            title: 'Project Management',
                            link: '/project'
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
                description: Yup.string()
                            .nullable(true)
                            .required('Required'),
                company_branch: Yup.string()
                                .nullable(true)
                                .required('Required'),
                address: Yup.string()
                            .nullable(true)
                            .required('Required'),
                city: Yup.string()
                            .nullable(true)
                            .required('Required'),
                locality: Yup.string()
                            .nullable(true)
                            .required('Required'),
                project_type: Yup.string()
                            .nullable(true)
                            .required('Required'),

            }
            const yup = Yup.object().shape( fields );

            return yup;
        },
        formDataImagesKeys () {
            return Object.keys( this.formData.images );
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
            this.$request.getProjectDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.formData = Object.assign( this.formData, res.data.data);
                                    Object.keys( this.selected ).forEach( d => {
                                        if( d in this.formData ){
                                            this.selected[ d ] = this.formData[ d ];
                                        }
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
        loadSelectListData(){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.projectFormDropdownList()
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.options = Object.assign( this.options, res.data);
                                    if( res.data?.property_img_types?.length ){
                                        if( !this.formData?.id ){
                                            res.data.property_img_types
                                                    .forEach( d => {
                                                        const name = d.name
                                                        if( !(name in this.formData.images) ){
                                                            this.formData.images[ name ] = [];
                                                        }
                                                    })
                                        }
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
        submitForm () {
            if( this.loading.formSubmit ){
                return;
            }
            this.errors = {};
            this.validationSchema.validate( this.formData, { abortEarly: false })
                                    .then( ( resValidate ) => {
                                        this.loading.formSubmit = true;
                                        this.$store.commit('setGlobalLoaderOn');
                                        this.$request.createProject( this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! New Project added successfully.';
                                                            if( this.formData?.id ){
                                                                message = 'Success! Project data updated successfully.';
                                                            }
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            this.$router.push({ name: 'project_lists' });
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
        removeMedia( idx, imgType ){
            if( imgType in this.formData.images ){
                this.$swal.fire({
                    title: 'Are you sure you want to remove?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete.',
                }).then(
                    ( res ) =>{
                        if( res.isConfirmed ){
                            this.formData.images[ imgType ].splice( idx, 1 );
                        }
                    });
            }
        },
        openMediaUpload( refKey ){
            if( refKey in this.$refs ){
                this.$refs[refKey].click();

            }
        },
        uploadMedia ( e, refKey ){
            if( !this.loading.upload ){
                const mediaFiles = e.target.files;
                if( mediaFiles && mediaFiles.length ){
                    this.loading.upload = true;
                    this.$request.uploadMedia( mediaFiles )
                                .then(
                                    ( res ) => {
                                        if( res.data?.files?.length ){
                                            const tmpFile = res.data.files;
                                            if( refKey == 'documents'){
                                                this.formData.documents = this.formData.documents.concat( tmpFile );
                                            }else{
                                                if( !(refKey in this.formData.images) ){
                                                    this.formData.images[ refKey ] = [];
                                                }
                                                this.formData.images[refKey] = this.formData.images[refKey].concat( tmpFile );
                                            }
                                        }else{

                                            this.$toast.error( 'Oops!' );
                                        }
                                    },
                                    ( err ) => {
                                        let message = 'Error! Request failed while uploading.';
                                        if( err?.response?.data?.message ){
                                            message = err.response.data.message;
                                        }
                                        this.$toast.error( message );
                                    }
                                ).finally(
                                    () => {
                                        this.loading.upload = false;
                                    }
                                )

                }
            }
        },
        addProjectTower(){
            const defaultData = {
                tower_name: null,
                completion_date: null,
            }
            this.formData.project_towers.push( defaultData );
        },
        removeProjectTower( id ){
            if( this.formData.project_towers?.length ){
                this.$swal.fire({
                    title: 'Are you sure you want to remove?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete.',
                }).then(
                    ( res ) =>{
                        if( res.isConfirmed ){
                            this.formData.project_towers.splice( id, 1 );
                        }
                    });
            }
        },
        addProjectPlan(){
            const defaultData = {
                tower: null,
                type: null,
                area: null,
                bhk: null,
                price: null,
                basic_price: null,
            }
            this.formData.project_plans.push( defaultData );
        },
        removeProjectPlan( id ){
            if( this.formData.project_plans?.length ){
                this.$swal.fire({
                    title: 'Are you sure you want to remove?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete.',
                }).then(
                    ( res ) =>{
                        if( res.isConfirmed ){
                            this.formData.project_plans.splice( id, 1 );
                        }
                    });
            }
        },
        addProjectCharge(){
            const defaultData = {
                charges: null,
                description: null,
                price: null,
                escalation_from: null,
            }
            this.formData.project_charges.push( defaultData );
        },
        removeProjectCharge( id ){
            if( this.formData.project_charges?.length ){
                this.$swal.fire({
                    title: 'Are you sure you want to remove?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete.',
                }).then(
                    ( res ) =>{
                        if( res.isConfirmed ){
                            this.formData.project_charges.splice( id, 1 );
                        }
                    });
            }
        },

        removeDocument( idx ){
            this.$swal.fire({
                title: 'Are you sure you want to remove?',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete.',
            }).then(
                ( res ) =>{
                    if( res.isConfirmed ){
                        this.formData.documents.splice( idx, 1 );
                    }
                });
        },

        onLocationSelect( data ){
            this.formData.latitude = data.latLng.lat;
            this.formData.longitude = data.latLng.lng;
        }
    }
}
</script>

<style>

</style>
