<template>
    <page-header :title="pageTitle" >
        <template v-slot:actionContainer >
            <div class="flex items-center space-x-2">
                <router-link to="/lead/create"
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

            <template v-if="savedSearches?.length">
                <template  v-for="(item, index) in savedSearches" :key="'saved_search_'+ index">
                    <div class="card mt-2 p-3 py-3 pr-6" v-if="item.data?.length">
                        <div class="flex ">

                            <div class="w-[96%] space-y-2">
                                <div
                                    class="badge bg-slate-150 text-slate-800 dark:bg-navy-500 dark:text-navy-100 mr-2"
                                    v-for="(search, idx ) in item.data"
                                    :key="'search_param'+ idx"
                                    >
                                        <b class="mr-1">{{ search.label }}:</b>
                                        <span ><pre class="font-sans text-tiny+">{{ search.values }}</pre></span>
                                    </div>
                            </div>
                            <div class="w-16 flex justify-end items-center gap-2">
                                <button
                                    @click="applySaveFilter(item.filter)"
                                    class="btn h-6 w-6 rounded-full bg-primary p-0 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    <i class="fa fa-check"></i>
                                </button>
                                <button
                                        @click="removeSavedSearch(item.id)"
                                        class="btn h-6 w-6 p-0 font-medium text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25"
                                    >
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
            <div class="card mt-2 p-3 py-3" v-show="showFilter">
                <form @submit.prevent="applyfilter">
                    <div class="grid grid-cols-4 gap-4 sm:grid-cols-4 sm:gap-5 lg:gap-6">
                        <label class="block">
                            <span>Title:</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter Title" type="text" v-model="filter.title">
                            </div>
                        </label>

                        <input-tom-select
                                        class="h-full"
                                        v-model="filter.enquiry_type"
                                        form-label="Enquiry Type"
                                        placeholder="Select Type"
                                        value-field="title"
                                        display-field="title"
                                        :options="filterOptions.enquiry_types"
                                        :selected-item="filter.enquiry_type"
                                    />
                        <input-tom-select
                            class="h-full"
                            v-model="filter.company_branch"
                            form-label="Company Branch:"
                            placeholder="Select Branch"
                            :options="filterOptions.company_branches"
                            :selected-item="filter.company_branch"
                        />
                        <label class="block">
                            <span>Customer Name:</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter Customer Name" type="text" v-model="filter.customer_name">
                            </div>
                        </label>
                        <label class="block">
                            <span>Mobile:</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter Mobile" type="text" v-model="filter.mobile">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-phone text-base"></i>
                                    </span>
                            </div>
                        </label>
                        <label class="block">
                            <span>Email:</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Enter Email" type="text" v-model="filter.email">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-envelope text-base"></i>
                                    </span>
                            </div>
                        </label>
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
                        <input-tom-select
                                class="h-full"
                                v-model="filter.properties"
                                form-label="Property:"
                                placeholder="Select Property"
                                :is-multiple="true"
                                :options="filterOptions.properties"
                                :selected-item="filter.properties?.map(d => d)"
                            />
                        <input-tom-select
                                class="h-full"
                                v-model="filter.projects"
                                form-label="Project:"
                                placeholder="Select Project"
                                :is-multiple="true"
                                :options="filterOptions.projects"
                                :selected-item="filter.projects?.map(d => d)"
                            />
                        <input-tom-select
                                class="h-full"
                                v-model="filter.lead_source"
                                form-label="Lead Source:"
                                placeholder="Select Source"
                                value-field="name"
                                :options="filterOptions.lead_sources"
                                :selected-item="filter.lead_source"
                            />
                        <input-tom-select
                                class="h-full"
                                v-model="filter.lead_status"
                                form-label="Lead Status:"
                                placeholder="Select Status"
                                value-field="name"
                                :options="filterOptions.lead_statuses"
                                :selected-item="filter.lead_status"
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
                            type="button"
                            @click="saveSearch"
                            class="btn border border-primary font-medium text-primary hover:bg-primary hover:text-white focus:bg-primary focus:text-white active:bg-primary/90 dark:border-accent dark:text-accent-light dark:hover:bg-accent dark:hover:text-white dark:focus:bg-accent dark:focus:text-white dark:active:bg-accent/90">
                            Save Search
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
                                v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_LEAD, $permissions.REMOVE_LEAD, $permissions.VIEW_LEAD ] )"
                                class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Action
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('title')">
                                <div class="flex gap-3 items-center">
                                    Title
                                    <template v-if="sortColumn == 'title'">
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
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('customer_name')">
                                <div class="flex gap-3 items-center">
                                    Cutomer Name
                                    <template v-if="sortColumn == 'customer_name'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>

                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('mobile')">
                                <div class="flex gap-3 items-center">
                                    Mobile
                                    <template v-if="sortColumn == 'mobile'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>

                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('email')">
                                <div class="flex gap-3 items-center">
                                    Email
                                    <template v-if="sortColumn == 'email'">
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
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Property
                            </th>

                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer">
                                <div class="flex gap-3 items-center">
                                    Projects
                                </div>
                            </th>

                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('site_visits_count')">
                                <div class="flex gap-3 items-center">
                                    Total Site Visits
                                    <template v-if="sortColumn == 'site_visits_count'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>

                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('lead_source')">
                                <div class="flex gap-3 items-center">
                                    Lead Source
                                    <template v-if="sortColumn == 'lead_source'">
                                        <i class="fa fa-arrow-down-short-wide" v-if="sortOrder == 'asc'"></i>
                                        <i class="fa fa-arrow-up-short-wide" v-else></i>

                                    </template>
                                    <i class="fa fa-sort" v-else></i>
                                </div>
                            </th>

                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('lead_status')">
                                <div class="flex gap-3 items-center">
                                    Lead Status
                                    <template v-if="sortColumn == 'lead_status'">
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
                                class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 cursor-pointer" @click="applySort('updated_at')" :class="{'rounded-tr-lg': !userPermissions.isPermissionsAllowed([ $permissions.UPDATE_LEAD, $permissions.REMOVE_LEAD, $permissions.VIEW_LEAD ])}">
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
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5" v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_LEAD, $permissions.REMOVE_LEAD, $permissions.VIEW_LEAD ] )">
                                    <div class="flex gap-2">

                                        <router-link :to="'/lead/edit/' + item.id"
                                            v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_LEAD ] )"
                                            class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-primary hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                            <i class="fa fa-pencil"></i>

                                        </router-link>

                                        <router-link v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_LEAD ] )" :to="'/lead/view/' + item.id" class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                            <i class="far fa-eye"></i>
                                        </router-link>
                                        <button v-if="false && userPermissions.isPermissionsAllowed([ $permissions.REMOVE_LEAD ] )"
                                                @click="removeItem( item.id )"
                                            class="btn rounded-full bg-error font-medium text-red-500 hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.title }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.branch }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.name }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.mobile }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.email }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ item.city }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5" >

                                    <p v-if="item.property_name?.length" >

                                        <template v-if="item.property_name.length > 1">
                                            <tippy tag="button" >
                                                <template #content >
                                                    <div class="flex space-x-3 rounded-lg bg-slate-150 p-3 dark:bg-navy-500">
                                                        <div>
                                                            <p class="font-medium text-slate-700 dark:text-navy-100" v-for="(data, index) in item.property_name" :key="'tippy_property_'+index">{{ data }}</p>
                                                        </div>
                                                    </div>
                                                </template>
                                                <template #default>
                                                    <span>
                                                        {{ item.property_name.at(0) }} <span class="text-primary">+{{ item.property_name.length-1 }} more</span>

                                                    </span>

                                                </template>

                                            </tippy>

                                        </template>
                                        <template v-else>
                                            {{ item.property_name.at(0) }}
                                        </template>
                                    </p>
                                    <p v-else>
                                        N/A
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <p v-if="item.project_name?.length" >

                                        <template v-if="item.project_name.length > 1">
                                            <tippy tag="button" >
                                                <template #content >
                                                    <div class="flex space-x-3 rounded-lg bg-slate-150 p-3 dark:bg-navy-500">
                                                        <div>
                                                            <p class="font-medium text-slate-700 dark:text-navy-100" v-for="(data, index) in item.project_name" :key="'tippy_property_'+index">{{ data }}</p>
                                                        </div>
                                                    </div>
                                                </template>
                                                <template #default>
                                                    <span>
                                                        {{ item.project_name.at(0) }} <span class="text-primary">+{{ item.project_name.length-1 }} more</span>

                                                    </span>

                                                </template>

                                            </tippy>

                                        </template>
                                        <template v-else>
                                            {{ item.project_name.at(0) }}
                                        </template>
                                    </p>
                                    <p v-else>
                                        N/A
                                    </p>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-center">
                                    <span class="badge rounded-full border border-primary text-primary dark:border-accent-light dark:text-accent-light">
                                        {{ item.site_visits_count }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.lead_source ?? 'N/A' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.status }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ item.assigned_to }}
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
import flatPickr from 'vue-flatpickr-component';

export default {
    mixins:[
        sortFilterMethodsMixin
    ],
    components:{
        flatPickr
    },

    data(){
        return {
            pageTitle: 'Lead Management',
            isShowPopper: false,
            page: 1,
            lists:{},
            showFilter: false,
            sortColumn: 'updated_at',
            sortOrder: 'desc',
            filterOptions: {},
            filter: {
                title: null,
                enquiry_type: null,
                customer_name: null,
                properties: [],
                projects: [],
                company_branch: null,
                mobile: null,
                email: null,
                city: null,
                lead_source: null,
                lead_status: null,
                assign_to: null,
                updated_at: null
            },
            loading:{
                formSubmit: false
            },
            filterLabel: {
                title: 'Title',
                customer_name: 'Customer Name',
                properties: 'Properties',
                projects: 'Projects',
                company_branch: 'Company Branch',
                mobile: 'Mobile',
                email: 'Email',
                city: 'City',
                lead_source: 'Lead Source',
                lead_status: 'Lead Status',
                assign_to: 'Assign To',
                updated_at: 'Updated At',
            },
            savedSearches: []
        }
    },
    created(){
    },
    mounted(){
        this.init();
    },
    computed:{
        ...mapGetters([
            'globalPermissions',
            'userPermissions'
        ]),
        menus(){
            var menus = [];
            if( userPermissions.isPermissionsAllowed( this.$permissions.ADD_LEAD ) ){
                menus.push(
                        {
                            title: 'Add new',
                            icon_class: 'fa-plus',
                            link: '/lead/create'
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
            this.$request.getLeadList( params )
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
                                .deleteLead( id )
                                .then(
                                    ( res ) => {
                                        let message = 'Success! Lead removed successfully.';

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
            this.$request.leadFilterData()
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.filterOptions = Object.assign( {}, res.data);

                                    this.getSavedSearchList();
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
        clearFilter(){
            this.filter = {
                title: null,
                customer_name: null,
                properties: [],
                projects: [],
                company_branch: null,
                mobile: null,
                email: null,
                city: null,
                lead_source: null,
                lead_status: null,
                assign_to: null,
                updated_at: null
            };
        },
        resetFilter(){

            this.clearFilter();
            this.resetAndLoadList();
        },
        saveSearch () {
            if( this.$checkIsObjectEmpty( this.filter) ){
                this.$toast.error("Error! Please select at least one filter option.");
                returnl
            }
            if( this.loading.formSubmit ){
                return;
            }
            this.loading.formSubmit = true;
            this.$store.commit('setGlobalLoaderOn');

            const data = {
                type: 'lead',
                'search_data': this.$transformFilledOnly(this.filter)
            };
            this.$request.createSavedSearch( data )
                        .then(
                            ( res ) => {
                                let message = 'Success! Search criteria has been saved successfully.';
                                if( res.data?.message ){
                                    message = res.data.message;
                                }
                                this.getSavedSearchList();
                                this.$toast.info( message );
                            },
                            ( err ) => {
                                let message = 'Error! There is error occured while processing request.';
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

        getSavedSearchList(){
            this.$store.commit('setGlobalLoaderOn')
            const params = {
                type: 'lead',
            }
            this.$request.getSavedSearchList( params )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.savedSearches = [];
                                    res.data.map( d => {
                                        const data = Object.assign({
                                            id: d.id
                                        }, this.transformSavedSearchData( d.search_data ))
                                        this.savedSearches.push( data );
                                    });
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
        transformSavedSearchData ( obj ) {
            const searchKeys = Object.keys( obj );
            let transformData = [];

            searchKeys.map( d => {

                let searchVal = obj[ d ];

                if( searchVal ){
                    if( ['company_branch', 'properties', 'projects', 'lead_source', 'lead_status', 'assign_to'].includes( d ) ){
                        if( d == 'company_branch' && this.filterOptions?.company_branches?.length ){
                            const findRecord = this.filterOptions.company_branches.find( item => item.id == searchVal );
                            if( findRecord ){
                                searchVal = findRecord.name
                            }
                        }
                        if( d == 'properties' && this.filterOptions?.properties?.length > 0 ){
                            const findRecord = this.filterOptions.properties.map( item => {
                                let id = String( item.id );
                                if( ( Array.isArray( searchVal ) && searchVal.includes( id ) ) || id == searchVal ){
                                    return item.name
                                }
                                return false;
                            } ).filter( Boolean );
                            if( findRecord?.length ){
                                searchVal = findRecord.join(", \r\n");
                            }
                        }
                        if( d == 'projects' && this.filterOptions?.projects?.length ){
                            const findRecord = this.filterOptions.projects.map( item => {
                                let id = String( item.id );
                                if( ( Array.isArray( searchVal ) && searchVal.includes( id ) ) || id == searchVal ){
                                    return item.name
                                }
                                return false;
                            } ).filter( Boolean );
                            if( findRecord?.length ){
                                searchVal = findRecord.join(", \r\n");
                            }
                        }
                        if( d == 'lead_source' && this.filterOptions?.lead_sources?.length ){
                            const findRecord = this.filterOptions.lead_sources.find( item => item.id == searchVal );
                            if( findRecord  ){
                                searchVal = findRecord.name;
                            }
                        }
                        if( d == 'lead_status' && this.filterOptions?.lead_statuses?.length ){
                            const findRecord = this.filterOptions.lead_statuses.find( item => item.id == searchVal );
                            if( findRecord  ){
                                searchVal = findRecord.name;
                            }
                        }
                        if( d == 'assign_to' && this.filterOptions?.members?.length ){
                            const findRecord = this.filterOptions.members.find( item => item.id == searchVal );
                            if( findRecord  ){
                                searchVal = findRecord.name;
                            }
                        }
                    }
                    let label = d;
                    if( d in this.filterLabel ){
                        label = this.filterLabel[d]
                    }
                    const tmpData = {
                        label: label,
                        values: searchVal
                    }
                    transformData.push( tmpData );
                }
            })

            if( transformData && transformData?.length ){

                return {
                    filter: obj,
                    data: transformData
                }
            }
            return false;
        },
        applySaveFilter( filterData ){
            this.clearFilter();
            this.filter = Object.assign( this.filter, filterData );
            this.applyFilter();
        },
        removeSavedSearch ( id ){


            this.$swal.fire({
                    title: 'Are you sure you want to remove the selected saved search?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete.',
                }).then(
                    ( res ) =>{
                        if( res.isConfirmed ){
                            this.$store.commit('setGlobalLoaderOn')
                            this.$request
                                .deleteSavedSearch( id )
                                .then(
                                    ( res ) => {
                                        let message = 'Success! Saved search removed successfully.';

                                        if( res.data?.message ){
                                            message = res.data.message;
                                        }
                                        this.getSavedSearchList();
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
    }
}
</script>

<style>

</style>
