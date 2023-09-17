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
                                <label class="block" >
                                    <span>Name</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Name" type="text" name="name" v-model="formData.name">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-home text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.name?.length">{{ errors.name.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Building Name</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Building Name" type="text" name="building_name" v-model="formData.building_name">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-building text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.building_name?.length">{{ errors.building_name.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Unit No.</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Unit No" type="text" name="unit_no" v-model="formData.unit_no">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.unit_no?.length">{{ errors.unit_no.at(0) }}</span>
                                </label>
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
                                <input-tom-select
                                            v-model="formData.property_type"
                                            form-label="Property Type"
                                            placeholder="Select Property Type"
                                            :options="options.property_types"
                                            :selected-item="selected.property_type"
                                            :error-msg="errors?.property_type"
                                        />
                                <input-tom-select
                                            v-model="formData.property_transaction"
                                            form-label="Property Transaction"
                                            placeholder="Select Property Transactions"
                                            :options="options.property_transactions"
                                            :selected-item="selected.property_transaction"
                                            :error-msg="errors?.property_transaction"
                                        />
                                <input-tom-select
                                            v-model="formData.property_furnishing"
                                            form-label="Property Furnishing"
                                            placeholder="Select Property Furnishing"
                                            :options="options.property_furnishes"
                                            :selected-item="selected.property_furnishing"
                                            :error-msg="errors?.property_furnishing"
                                        />
                                <input-tom-select
                                            v-model="formData.property_facing"
                                            form-label="Property Facing"
                                            placeholder="Select Property Facing"
                                            :options="options.property_facing_list"
                                            :selected-item="selected.property_facing"
                                            :error-msg="errors?.property_facing"
                                        />

                                <label class="block" >
                                    <span>Suitable For</span>
                                    <span class="relative flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Suitable For" type="text" name="suitable_for" v-model="formData.suitable_for">

                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.suitable_for?.length">{{ errors.suitable_for.at(0) }}</span>
                                </label>
                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                                <label class="block col-span-2">
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
                                <label class="block" >
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
                                <label class="block" >
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
                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-4 gap-4 sm:grid-cols-4 items-center">
                                <label class="block" >
                                    <span>Bedrooms</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Bedrooms" type="text" name="bedrooms" v-model="formData.bedrooms">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-bed text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.bedrooms?.length">{{ errors.bedrooms.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Master Bedrooms</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Master Bedrooms" type="text" name="master_bedrooms" v-model="formData.master_bedrooms">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-bed text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.master_bedrooms?.length">{{ errors.master_bedrooms.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Guest Bedrooms</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Guest Bedrooms" type="text" name="guest_room" v-model="formData.guest_room">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-bed text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.guest_room?.length">{{ errors.guest_room.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Child Bedrooms</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Child Bedrooms" type="text" name="child_room" v-model="formData.child_room">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-bed text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.child_room?.length">{{ errors.child_room.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Other Rooms</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Other Rooms" type="text" name="other_room" v-model="formData.other_room">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-bed text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.other_room?.length">{{ errors.other_room.at(0) }}</span>
                                </label>
                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 items-center">

                                <label class="block" >
                                    <span>Bathrooms</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Bathrooms" type="text" name="bathrooms" v-model="formData.bathrooms">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-bath text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.bathrooms?.length">{{ errors.bathrooms.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Common Bathrooms</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Common Bathrooms" type="text" name="common_bathrooms" v-model="formData.common_bathrooms">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-bath text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.common_bathrooms?.length">{{ errors.common_bathrooms.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Ensult Bathrooms</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Ensult Bathrooms" type="text" name="ensult_bathrooms" v-model="formData.ensult_bathrooms">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-bath text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.ensult_bathrooms?.length">{{ errors.ensult_bathrooms.at(0) }}</span>
                                </label>

                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-4 gap-4 sm:grid-cols-4 items-center">

                                <label class="block" >
                                    <span>Sellable Area</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Sellable Area" type="text" name="sellable_area" v-model="formData.sellable_area">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.sellable_area?.length">{{ errors.sellable_area.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Builtup Area</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Builtup Area" type="text" name="builtup_area" v-model="formData.builtup_area">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.builtup_area?.length">{{ errors.builtup_area.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Carpet Area</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Carpet Area" type="text" name="carpet_area" v-model="formData.carpet_area">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.carpet_area?.length">{{ errors.carpet_area.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Plot Area</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Plot Area" type="text" name="plot_area" v-model="formData.plot_area">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.plot_area?.length">{{ errors.plot_area.at(0) }}</span>
                                </label>

                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 items-center">

                                <label class="block" >
                                    <span>Price</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Price" type="text" name="price" v-model="formData.price">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-inr text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.price?.length">{{ errors.price.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Negotiable Amount</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Negotiable Amount" type="text" name="negotiable_amount" v-model="formData.negotiable_amount">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-inr text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.negotiable_amount?.length">{{ errors.negotiable_amount.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Security Deposit</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Security Deposit" type="text" name="security_deposit" v-model="formData.security_deposit">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-inr text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.security_deposit?.length">{{ errors.security_deposit.at(0) }}</span>
                                </label>

                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 items-center">

                                <label class="block" >
                                    <span>Property Floor</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Property Floor" type="text" name="property_floor" v-model="formData.property_floor">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.property_floor?.length">{{ errors.property_floor.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Total Floor</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Total Floor" type="text" name="total_floor" v-model="formData.total_floor">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.total_floor?.length">{{ errors.total_floor.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>No of Parking</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="No of Parking" type="text" name="no_of_parking" v-model="formData.no_of_parking">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.no_of_parking?.length">{{ errors.no_of_parking.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>No of Lift</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2  placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="No of Lift" type="text" name="no_of_lift" v-model="formData.no_of_lift">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.no_of_lift?.length">{{ errors.no_of_lift.at(0) }}</span>
                                </label>

                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 items-center">

                                <label class="block" >
                                    <span>Lease Period</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Lease Period" type="text" name="lease_period" v-model="formData.lease_period">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.lease_period?.length">{{ errors.lease_period.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Lease Expiry Date</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Lease Expiry Date" type="date" name="lease_expiry_date" v-model="formData.lease_expiry_date">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-calendar text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.lease_expiry_date?.length">{{ errors.lease_expiry_date.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Availability</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Availability" type="text" name="availability" v-model="formData.availability">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.availability?.length">{{ errors.availability.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Ownership</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Ownership" type="text" name="ownership" v-model="formData.ownership">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.ownership?.length">{{ errors.ownership.at(0) }}</span>
                                </label>

                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-3 gap-4 sm:grid-cols-3 items-center">

                                <input-tom-select
                                            v-model="formData.property_obligation"
                                            form-label="Property Obligation"
                                            placeholder="Select Property Obligation"
                                            :options="options.property_obligations"
                                            :selected-options="selected.property_obligation"
                                            :error-msg="errors?.property_obligation"
                                        />
                                <label class="block" >
                                    <span>Age of Property</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Age of Property" type="text" name="age_of_property" v-model="formData.age_of_property">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.age_of_property?.length">{{ errors.age_of_property.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Workstation</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Workstation" type="text" name="workstation" v-model="formData.workstation">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.workstation?.length">{{ errors.workstation.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Conference Room</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Conference Room" type="text" name="conference_room" v-model="formData.conference_room">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.conference_room?.length">{{ errors.conference_room.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Reception</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Reception" type="text" name="reception" v-model="formData.reception">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.reception?.length">{{ errors.reception.at(0) }}</span>
                                </label>

                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-12 gap-4 sm:grid-cols-12 items-center">

                                <label class="block col-span-12" >
                                    <span>Walk Through Link</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Walk Through Link" type="text" name="walk_through_link" v-model="formData.walk_through_link">
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.walk_through_link?.length">{{ errors.walk_through_link.at(0) }}</span>
                                </label>

                            </div>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                            <div class="grid grid-cols-12 gap-4 sm:grid-cols-12 items-center">

                                <label class="block col-span-6 mt-2">
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
                                <label class="block col-span-6 mt-2">
                                    <span>Unique Feature</span>
                                    <label class="block">
                                        <textarea
                                        rows="4"
                                        placeholder="Unique Feature"
                                        v-model="formData.unique_feature"
                                        class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        ></textarea>
                                    </label>

                                    <span class="text-tiny+ text-error" v-if="errors?.unique_feature?.length">{{ errors.unique_feature.at(0) }}</span>
                                </label>

                            </div>
                        </div>
                        <div class="card mt-2 p-4 sm:p-5 col-span-4">

                            <!-- <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div> -->
                            <div class="  items-center">

                                <div class="flex-wrap items-start space-y-2 pt-2 sm:flex sm:space-x-5 sm:space-y-0" >
                                    <label class="inline-flex items-center space-x-2">
                                        <input
                                            name="is_verified"
                                            class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                            type="checkbox"
                                            :value="1"
                                            v-model="formData.is_verified"
                                            >
                                        <span>Is Verified?</span>
                                    </label>
                                </div>
                                <div class="flex-wrap items-start space-y-2 pt-2 sm:flex sm:space-x-5 sm:space-y-0 mb-3" >
                                    <label class="inline-flex items-center space-x-2">
                                        <input
                                            name="is_document_verified"
                                            class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                            type="checkbox"
                                            :value="1"
                                            v-model="formData.is_document_verified"
                                            >
                                        <span>Is Document Verified?</span>
                                    </label>
                                </div>

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

                                <label class="block col-span-2 mt-2">
                                    <span>Description</span>
                                    <label class="block">
                                        <textarea
                                        rows="4"
                                        placeholder="Description"
                                        v-model="formData.description"
                                        class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        ></textarea>
                                    </label>

                                    <span class="text-tiny+ text-error" v-if="errors?.description?.length">{{ errors.description.at(0) }}</span>
                                </label>
                                <label class="block col-span-2 mt-2">
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
                                <label class="block col-span-2 mt-2">
                                    <span>Internal Note</span>
                                    <label class="block">
                                        <textarea
                                        rows="4"
                                        placeholder="Internal Note"
                                        v-model="formData.internal_note"
                                        class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        ></textarea>
                                    </label>

                                    <span class="text-tiny+ text-error" v-if="errors?.internal_note?.length">{{ errors.internal_note.at(0) }}</span>
                                </label>
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
                                <label class="block" >
                                    <span>Refer By Name</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Refer By Name" type="text" name="refer_by_name" v-model="formData.refer_by_name">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-user text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.refer_by_name?.length">{{ errors.refer_by_name.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Refer By Phone</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Refer By Phone" type="text" name="refer_by_phone" v-model="formData.refer_by_phone">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-phone text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.refer_by_phone?.length">{{ errors.refer_by_phone.at(0) }}</span>
                                </label>
                                <label class="block" >
                                    <span>Refer By Email</span>
                                    <span class="relative mt-1.5 flex">
                                        <input
                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Refer By Email" type="text" name="refer_by_email" v-model="formData.refer_by_email">
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <i class="fa fa-envelope text-base"></i>
                                        </span>
                                    </span>

                                    <span class="text-tiny+ text-error" v-if="errors?.refer_by_email?.length">{{ errors.refer_by_email.at(0) }}</span>
                                </label>
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

export default {
    data(){
        return {
            pageTitle: 'Project Management',
            subTitle: 'Add Project',
            isShowPopper: false,
            errors: {},
            options:{
                'property_types': [],
                'property_transactions': [],
                'oroperty_furnishes': [],
                'property_facing_list': [],
                'property_obligations': [],
                'property_img_types': [],
            },
            formData:{
                name: '',
                building_name: null,
                unit_no: null,
                company_branch: null,
                assign_to: null,
                property_type: null,
                property_transaction: null,
                property_furnishing: null,
                is_verified: 0,
                is_document_verified: 0,
                address: null,
                city: null,
                locality: null,
                description: null,
                remark: null,
                internal_note: null,
                unique_feature: null,
                suitable_for: null,
                bedrooms: null,
                master_bedrooms: null,
                guest_room: null,
                child_room: null,
                other_room: null,
                bathrooms: null,
                common_bathrooms: null,
                ensult_bathrooms: null,
                sellable_area: null,
                builtup_area: null,
                carpet_area: null,
                plot_area: null,
                terrace_area: null,
                area_range: null,
                price: null,
                negotiable_amount: null,
                security_deposit: null,
                property_floor: null,
                total_floor: null,
                property_facing: null,
                lease_period: null,
                lease_expiry_date: null,
                availability: null,
                ownership: null,
                no_of_parking: null,
                no_of_lift: null,
                property_obligation: null,
                age_of_property: null,
                workstation: null,
                conference_room: null,
                reception: null,
                walk_through_link: null,
                amenities: null,
                owner_name: null,
                owner_email: null,
                owner_phone: null,
                refer_by_name: null,
                refer_by_email: null,
                refer_by_phone: null,
                images: {}
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
                assign_user_data: {},
                property_type: null,
                property_transaction: null,
                property_furnishing: null,
                property_facing: null,
                property_obligation: null,
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
                name: Yup.string()
                            .nullable(true)
                            .required('Required'),
                company_branch: Yup.string()
                                .nullable(true)
                                .required('Required'),
                property_type: Yup.string()
                                .nullable(true)
                                .required('Required'),
                property_transaction: Yup.string()
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
                price: Yup.string()
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
            this.$request.propertyFormDropdownList()
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
                                            if( !(refKey in this.formData.images) ){
                                                this.formData.images[ refKey ] = [];
                                            }
                                            this.formData.images[refKey] = this.formData.images[refKey].concat( tmpFile );
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
        }
    }
}
</script>

<style>

</style>
