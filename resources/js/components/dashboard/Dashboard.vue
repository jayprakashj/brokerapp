<template>
    <page-header :title="pageTitle" >
        <template v-slot:actionContainer >
            <div class="flex items-center space-x-2">
                <input-tom-select
                        class="h-full !w-[13rem]"
                        v-model="filter.date"
                        form-label=""
                        placeholder=""
                        value-field="id"
                        display-field="text"
                        :options="dateFilter"
                        :selected-item="filter.date"
                        @onChange="dateChanged"
                    />

            </div>
        </template>
    </page-header>

    <div
        class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6"
        v-if="userPermissions.isPermissionsAllowed([
                $permissions.LEAD_LIST,
                $permissions.ONLY_ASSIGNED_LEAD_LIST,
                $permissions.SITE_VISIT_LIST,
                $permissions.ONLY_ASSIGNED_SITE_VISIT_LIST,
                $permissions.PROPERTY_LIST,
                $permissions.ONLY_ASSIGNED_PROPERTY_LIST,
                $permissions.PROJECT_LIST,
                $permissions.ONLY_ASSIGNED_PROJECT_LIST,
                $permissions.MEMBER_LIST,
                $permissions.CONTACT_LIST

            ], false )"
    >
        <div class="col-span-3 pb-4 border-r" v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST, $permissions.ONLY_ASSIGNED_LEAD_LIST,$permissions.SITE_VISIT_LIST, $permissions.ONLY_ASSIGNED_SITE_VISIT_LIST ], false )">
            <div class="flex items-center justify-between space-x-2">
                <h2 class="text-base font-medium tracking-wide text-slate-800 line-clamp-1 dark:text-navy-100">
                    This Months Statistics
                </h2>
            </div>
            <div class="flex flex-col sm:flex-row sm:space-x-7">
                <div class="pt-2 pb-4 mt-3 grid grid-cols-1 gap-y-5 items-center">

                    <div class=" card p-8 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST, $permissions.ONLY_ASSIGNED_LEAD_LIST ] )">
                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-4xl font-bold text-slate-900 dark:text-navy-100">
                                    {{ data.month_leads || 0 }}
                                </p>
                                <p class="text-xs+ line-clamp-1">This Month Leads</p>
                            </div>
                            <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-slate-900/10">
                                <i class="fa text-2xl fa-bullseye text-slate-900"></i>
                            </div>
                        </div>
                    </div>
                    <div class=" card p-8 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.SITE_VISIT_LIST, $permissions.ONLY_ASSIGNED_SITE_VISIT_LIST ] )">
                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-4xl font-bold text-red-800 dark:text-navy-100">
                                    {{ data.month_site_visits || 0 }}
                                </p>
                                <p class="text-xs+ line-clamp-1">This Month Site Visits</p>
                            </div>
                            <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-red-800/10">
                                <i class="fa text-2xl fa-building-user text-red-800"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div
            class="col-span-3 pb-4 border-r"
            v-if="userPermissions.isPermissionsAllowed([
                        $permissions.PROPERTY_LIST,
                        $permissions.ONLY_ASSIGNED_PROPERTY_LIST,
                        $permissions.PROJECT_LIST,
                        $permissions.ONLY_ASSIGNED_PROJECT_LIST
                    ], false)"
        >
            <div class="flex flex-col sm:space-x-7 pr-4 pt-6">
                <div class="pt-2 pb-4 mt-3 grid grid-cols-1 gap-y-5 items-center">


                    <div class=" card p-8 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.PROPERTY_LIST, $permissions.ONLY_ASSIGNED_PROPERTY_LIST ] )">
                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-4xl font-bold text-success dark:text-navy-100">
                                    {{ data.property_count || 0}}
                                </p>
                                <p class="text-xs+ line-clamp-1">Properties</p>
                            </div>
                            <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-success/10">
                                <i class="fa text-2xl fa-building text-success"></i>
                            </div>
                        </div>
                    </div>
                    <div class=" card p-8 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.PROJECT_LIST, $permissions.ONLY_ASSIGNED_PROJECT_LIST ] )">
                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-4xl font-bold text-primary dark:text-navy-100">
                                    {{ data.project_count || 0 }}
                                </p>
                                <p class="text-xs+ line-clamp-1">Projects</p>
                            </div>
                            <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-primary/10">
                                <i class="fa text-2xl fa-file-invoice text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div
            class="col-span-6 pb-4"
            v-if="userPermissions.isPermissionsAllowed([
                    $permissions.MEMBER_LIST,
                    $permissions.CONTACT_LIST,
                    $permissions.LEAD_LIST,
                    $permissions.ONLY_ASSIGNED_LEAD_LIST
                ],false )"
        >
            <div class="pt-2 pb-4 mt-3 grid grid-cols-2 gap-3 gap-y-5 items-center">
                <div class=" card p-8 justify-center hidden" v-if="userPermissions.isPermissionsAllowed([ $permissions.MEMBER_LIST] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-4xl font-bold text-info dark:text-navy-100">
                                {{ data.member_count || 0 }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Members</p>
                        </div>
                        <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-info/10">
                            <i class="fa text-2xl fa-users text-info"></i>
                        </div>
                    </div>
                </div>

                <div class=" card p-8 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.CONTACT_LIST] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-4xl font-bold text-warning dark:text-navy-100">
                                {{ data.contact_count || 0 }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Contacts</p>
                        </div>
                        <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-warning/10">
                            <i class="fa text-2xl fa-phone text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class=" card p-8 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST, $permissions.ONLY_ASSIGNED_LEAD_LIST ] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-4xl font-bold text-gray dark:text-navy-100">
                                {{ data.lead_count || 0 }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Leads</p>
                        </div>
                        <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-gray-800/10">
                            <i class="fa text-2xl fa-network-wired text-gray"></i>
                        </div>
                    </div>
                </div>

                <div class=" card p-8 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST, $permissions.ONLY_ASSIGNED_LEAD_LIST ] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-4xl font-bold text-error dark:text-error">
                                {{ data.oppertunity_count || 0 }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Oppertunities</p>
                        </div>
                        <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-error/10">
                            <i class="fa text-2xl fa-network-wired text-error"></i>
                        </div>
                    </div>
                </div>

                <div class=" card p-8 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST, $permissions.ONLY_ASSIGNED_LEAD_LIST ] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-4xl font-bold text-info dark:text-info">
                                {{ data.visited_count || 0 }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Visited</p>
                        </div>
                        <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-info/10">
                            <i class="fa text-2xl fa-network-wired text-info"></i>
                        </div>
                    </div>
                </div>

                <div class=" card p-8 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST, $permissions.ONLY_ASSIGNED_LEAD_LIST ] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-4xl font-bold text-secondary dark:text-secondary">
                                {{ data.won_count || 0 }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Won</p>
                        </div>
                        <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-secondary/10">
                            <i class="fa text-2xl fa-network-wired text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-4 sm:p-5 col-span-7  max-h-[400px] overflow-x-auto" v-if="false && userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST,this.$permissions.ONLY_ASSIGNED_LEAD_LIST ] )">
            <div
                class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                    Today's Leads
                </h2>
            </div>
            <div class="px-4 pt-2 pb-4" v-if="data?.today_leads?.length">
                <div class="border-b border-slate-150 py-3 dark:border-navy-500" v-for="(item, index) in data.today_leads" :key="'today_leads_'+index">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <h2 class="cursor-pointer text-slate-600 line-clamp-1 dark:text-navy-100">
                            {{ item.title }}
                        </h2>
                    </div>
                    <p class="mt-1"><pre class="whitespace-pre-wrap break-words"><i class="fa fa-comment"></i> {{ item.comment }}</pre> </p>
                    <div class="mt-1 flex items-end justify-between">
                        <div class="flex flex-wrap items-center font-inter text-xs">
                            <span class="flex items-center space-x-1">
                                <i class="fa fa-user"></i>
                                <span>{{ item.name }}</span>
                            </span>
                            <div class="m-1.5 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                            <span class="flex items-center space-x-1">
                                <i class="fa fa-phone"></i>
                                <span>{{ item.mobile }}</span>
                            </span>
                            <div class="m-1.5 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                            <span class="flex items-center space-x-1">
                                <i class="fa fa-envelope"></i>
                                <span>{{ item.email }}</span>
                            </span>
                            <div class="m-1.5 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                            <div class="badge space-x-2.5 px-1">
                                <i class="fa fa-clock"></i>
                                <span>{{ item.updated_at }}</span>
                            </div>
                            <div class="m-1.5 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                            <div class="badge space-x-2.5 px-1 text-primary">
                                <span>{{ item.status }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-1">
                            <router-link v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_LEAD ] )" :to="'/lead/view/' + item.id" class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <i class="fa fa-external-link"></i>
                            </router-link>

                        </div>
                    </div>
                </div>
            </div>
            <no-data-found v-else />
        </div>
    </div>
    <template v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST,$permissions.ONLY_ASSIGNED_LEAD_LIST])">

        <div class="mt-4 grid grid-cols-12 gap-4 py-5 dark:bg-navy-800 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6 " >
            <div class="col-span-12 xl:col-span-12">
                <div class="-mt-1 flex items-center justify-between">
                    <h2 class="text-sm+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        Todays' Leads
                    </h2>
                </div>
                <div class="card mt-3">
                    <div class="max-h-[520px] overflow-y-auto pr-1">
                        <table class="is-hoverable w-full text-left max-h-[520px] overflow-y-auto">
                            <thead >
                                <tr>
                                    <th
                                        class="position-sticky whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100">
                                        Title
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Name
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Mobile/Email
                                    </th>

                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Comment
                                    </th>

                                    <th
                                        class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="data?.today_leads?.length">
                                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in data?.today_leads" :key="'today_lead_'+idx">
                                        <td class="whitespace-nowrap px-4 py-3">
                                            <p class=" text-base font-medium text-slate-700 dark:text-navy-100">
                                                {{ item.title }}
                                            </p>
                                        </td>
                                        <td class="min-w-[12rem] ">
                                            {{ item.name }}
                                        </td>
                                        <td class="min-w-[13rem] ">
                                            {{ item.mobile }}
                                            <br>
                                            {{ item.email }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">

                                            <p :title="item.full_comment">{{ item.comment }}</p>
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            <router-link
                                                v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_LEAD ] )"
                                                :to="'/lead/view/' + item.id"
                                                class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                                <i class="far fa-eye"></i>
                                            </router-link>
                                        </td>
                                    </tr>
                                </template>
                                <tr v-else class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td colspan="5 text-center">
                                        <no-data-found />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-12 gap-4 py-5 dark:bg-navy-800 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6 " >
            <div class="col-span-12 xl:col-span-12">
                <div class="-mt-1 flex items-center justify-between">
                    <h2 class="text-sm+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        Todays' Followup Leads
                    </h2>
                </div>
                <div class="card mt-3">
                    <div class="max-h-[520px] overflow-y-auto pr-1">
                        <table class="is-hoverable w-full text-left max-h-[520px] overflow-y-auto">
                            <thead >
                                <tr>
                                    <th
                                        class="position-sticky whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100">
                                        Title
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Name
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Mobile/Email
                                    </th>

                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Comment
                                    </th>

                                    <th
                                        class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="data?.today_followup_leads?.length">
                                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in data?.today_followup_leads" :key="'today_followup_lead_'+idx">
                                        <td class="whitespace-nowrap px-4 py-3">
                                            <p class=" text-base font-medium text-slate-700 dark:text-navy-100">
                                                {{ item.title }}
                                            </p>
                                        </td>
                                        <td class="min-w-[12rem] ">
                                            {{ item.name }}
                                        </td>
                                        <td class="min-w-[13rem] ">
                                            {{ item.mobile }}
                                            <br>
                                            {{ item.email }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">

                                            <p :title="item.full_comment">{{ item.comment }}</p>
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                            <router-link
                                                v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_LEAD ] )"
                                                :to="'/lead/view/' + item.id"
                                                class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                                <i class="far fa-eye"></i>
                                            </router-link>
                                        </td>
                                    </tr>
                                </template>
                                <tr v-else class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td colspan="5 text-center">
                                        <no-data-found />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <div class="grid grid-cols-12 gap-8 mt-2" v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST,$permissions.ONLY_ASSIGNED_LEAD_LIST, $permissions.MEMBER_LIST ], false )">
        <div class="col-span-6 xl:col-span-6" v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST,$permissions.ONLY_ASSIGNED_LEAD_LIST])" >
            <div class="dark:bg-navy-800 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6 " >
                <div class="-mt-1 flex items-center justify-between">
                    <h2 class="text-sm+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        Lead Sources
                    </h2>
                </div>
                <div class="card mt-3">
                    <div class="max-h-[520px] overflow-y-auto pr-1">
                        <table class="is-hoverable w-full text-left max-h-[520px] overflow-y-auto">
                            <thead >
                                <tr>
                                    <th
                                        class="position-sticky whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100">
                                        Lead Sources
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Leads
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Oppertunities
                                    </th>

                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Visited
                                    </th>

                                    <th
                                        class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Won
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="data?.lead_sources_with_count?.length">
                                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in data?.lead_sources_with_count" :key="'lead_sources_with_count_'+idx">
                                        <td class="whitespace-nowrap px-4 py-3">
                                            <p class=" text-base font-medium text-slate-700 dark:text-navy-100">
                                                {{ item.title }}
                                            </p>
                                        </td>
                                        <td class="min-w-[2rem] text-center" :class="{'text-primary': item.leads}">
                                            {{ item.leads }}
                                        </td>
                                        <td class="min-w-[2rem] text-center" :class="{'text-secondary': item.oppertunities}">
                                            {{ item.oppertunities }}
                                        </td>
                                        <td class="min-w-[2rem] text-center" :class="{'text-error': item.visited}">
                                            {{ item.visited }}
                                        </td>
                                        <td class="min-w-[2rem] text-center" :class="{'text-success': item.won}">
                                            {{ item.won }}
                                        </td>
                                    </tr>
                                </template>
                                <tr v-else class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td colspan="5 text-center">
                                        <no-data-found />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-6 xl:col-span-6" v-if="userPermissions.isPermissionsAllowed([$permissions.MEMBER_LIST])">
            <div class="dark:bg-navy-800 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6 "  >
                <div class="-mt-1 flex items-center justify-between">
                    <h2 class="text-sm+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        Staff Users
                    </h2>
                </div>
                <div class="card mt-3">
                    <div class="max-h-[520px] overflow-y-auto pr-1">
                        <table class="is-hoverable w-full text-left max-h-[520px] overflow-y-auto">
                            <thead >
                                <tr>
                                    <th
                                        class="position-sticky whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100">
                                        Name
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Oppertunities
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Qualified
                                    </th>

                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Visited
                                    </th>

                                    <th
                                        class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Won
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-if="data?.users_with_lead_count?.length">
                                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in data?.users_with_lead_count" :key="'users_with_lead_count_'+idx">
                                        <td class="whitespace-nowrap px-4 py-3">
                                            <p class=" text-base font-medium text-slate-700 dark:text-navy-100">
                                                {{ item.name }}
                                            </p>
                                        </td>
                                        <td class="min-w-[2rem] text-center" :class="{'text-primary': item.oppertunities}">
                                            {{ item.oppertunities }}
                                        </td>
                                        <td class="min-w-[2rem] text-center" :class="{'text-secondary': item.qualified}">
                                            {{ item.qualified }}
                                        </td>
                                        <td class="min-w-[2rem] text-center" :class="{'text-error': item.visited}">
                                            {{ item.visited }}
                                        </td>
                                        <td class="min-w-[2rem] text-center" :class="{'text-success': item.won}">
                                            {{ item.won }}
                                        </td>
                                    </tr>
                                </template>
                                <tr v-else class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td colspan="5 text-center">
                                        <no-data-found />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-12 gap-4 py-5 dark:bg-navy-800 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6 " v-if="userPermissions.isPermissionsAllowed([$permissions.PROPERTY_LIST])" >
        <div class="col-span-12 md:col-span-8">
            <div class="-mt-1 flex items-center justify-between">
                <h2 class="text-sm+ font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                    Properties Statistics
                </h2>
            </div>
            <div class="card mt-3">
                <div class="max-h-[520px] overflow-y-auto pr-1">
                    <table class="is-hoverable w-full text-left max-h-[520px] overflow-y-auto">
                        <thead >
                            <tr>
                                <th
                                    class="position-sticky whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 text-right">
                                    Property Type
                                </th>
                                <th
                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 text-center">
                                    Property Transaction Name
                                </th>
                                <th
                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 text-center">
                                    Total
                                </th>

                                <th
                                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5 text-center">
                                    Available
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="data?.property_type_wise_count?.length">
                                <template v-for="(property_types, index) in data?.property_type_wise_count" :key="'property_type_wise_count_'+index">

                                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500" >
                                        <td class="whitespace-nowrap px-4 py-3 border-r text-right" :rowspan="((property_types?.items?.length) || 1) + 1">
                                            <p class=" text-base font-medium text-slate-700 dark:text-navy-100">
                                                {{ property_types.name }}
                                            </p>
                                        </td>
                                    </tr>
                                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500" v-for="(item, idx) in property_types?.items" :key="'property_type_wise_count_item_'+idx">
                                        <td class="text-center text-sm p-1 font-semibold ">
                                            {{ item.property_type_name }}
                                        </td>
                                        <td class="text-center text-sm p-1 font-semibold text-slate-900 ">
                                            {{ item.properties_count }}
                                        </td>
                                        <td class="text-center text-sm p-1 font-semibold text-slate-900">
                                            {{ item.availble_properties_count }}
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <tr v-else class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <td colspan="5 text-center">
                                    <no-data-found />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex' ;
import dayjs from 'dayjs' ;

export default {
    data(){
        return {
            pageTitle: 'Dashboard',
            inProcess: false,
            data:{

            },
            dateFilter:[
                {
                    id: dayjs().format('YYYY-MM-DD'),
                    text: 'Today'
                },
                {
                    id: dayjs().subtract(7, 'd').format('YYYY-MM-DD'),
                    text: '7 Days'
                },
                {
                    id: dayjs().subtract(1, 'M').format('YYYY-MM-DD'),
                    text: '1 Month'
                },
                {
                    id: dayjs().subtract(3, 'M').format('YYYY-MM-DD'),
                    text: '3 Months'
                },
                {
                    id: dayjs().subtract(1, 'y').format('YYYY-MM-DD'),
                    text: '1 Year'
                }
            ],
            filter: {
                date: dayjs().format('YYYY-MM-DD')
            }
        }
    },
    created(){
        this.init();

        this.reconnectPusher();

        if( this.userPermissions.isPermissionsAllowed([ this.$permissions.VIEW_LEAD ] ) ){
            this.registerPusherLeadEvent();
        }
    },
    computed:{

        ...mapGetters([
            'globalPermissions',
            'userPermissions'
        ]),
    },
    beforeUnmount(){
        window.Echo.disconnect();
    },
    methods:{
        init(){
            this.loadData();
        },
        loadData(){
            if( this.inProcess ){
                return;
            }
            this.$store.commit('setGlobalLoaderOn');
            this.inProcess = true;
            const param = this.filter;
            this.$request.getDashboardData( param )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.data = Object.assign( this.data, res.data);
                                }
                            },
                            (err) => {
                                this.$toast.error('Err! There is something wrong. Please retry.');
                            }
                        ).finally(
                            () => {
                                this.inProcess = false;
                                this.$store.commit('setGlobalLoaderOff');
                            }
                        )
        },
        reconnectPusher(){

            if( window.Echo?.connector?.pusher?.connection?.state == 'disconnected' ){
                Echo.connect();
            }
        },
        registerPusherLeadEvent(){
            Echo.private(this.$broadcastChannelName)
                    .listen('.new-lead-generated', (e) => {
                        if( e?.lead?.id){
                            this.showNewLeadToast( e.lead );
                        }
                    });
        },
        showNewLeadToast( item ){
            let $this = this;
            this.$toast.open({
                message: this.getLeadToastMsgHtml( item ),
                type: 'new-lead',
                duration: 0,
                'dismissible': true,
                position: 'top-right',
                onClick: function(e) {
                    if(!(e.target.closest('.trash-btn') || e.target.classList.contains( 'trash-btn'))){
                        $this.$router.push('/lead/view/' + item.id)
                    }
                },
            });
            this.loadData();
        },
        getLeadToastMsgHtml ( item ) {
            return `
                <div class="border-b border-slate-150 py-3 dark:border-navy-500 w-100">
                        <div class="flex items-center space-x-2 sm:space-x-3">
                            <h2 class="cursor-pointer line-clamp-1 dark:text-navy-100">
                                ${ item.title }
                            </h2>
                        </div>
                        <p class="mt-1"><pre class="whitespace-pre-wrap break-words"><i class="fa fa-comment"></i> ${ item.comment }</pre> </p>
                        <div class="mt-1 flex items-end justify-between">
                            <div class="flex flex-wrap items-center font-inter text-xs">
                                <span class="flex items-center space-x-1">
                                    <i class="fa fa-user"></i>
                                    <span>${ item.name }</span>
                                </span>
                                <div class="m-1.5 w-px self-stretch bg-slate-200 dark:bg-navy-500"></div>
                                <span class="flex items-center space-x-1">
                                    <i class="fa fa-phone"></i>
                                    <span>${ item.mobile }</span>
                                </span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <router-link target="blank" v-if="userPermissions.isPermissionsAllowed([ this.$permissions.VIEW_LEAD ] )" :to="'/lead/view/' + ${item.id}" class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 lead-view-link">
                                    <i class="fa fa-external-link"></i>
                                </router-link>

                                <button class="btn h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 trash-btn">
                                    <i class="fa fa-close"></i>
                                </button>


                            </div>
                        </div>
                    </div>
                `;
        },
        dateChanged(){
            this.loadData();
        }
    }
}
</script>

<style>

</style>
