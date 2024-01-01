<template>
  <div class="main-sidebar">
    <div
        class="flex h-full w-full flex-col items-center border-r border-slate-150 bg-white dark:border-navy-700 dark:bg-navy-800">
        <!-- Application Logo -->
        <div class="flex pt-4">
            <router-link to="/dashboard">
                <img class="h-11 w-11 transition-transform duration-500 ease-in-out "
                    :src="(currentUser?.current_company?.logo_url || '/public/images/app-logo.svg')" alt="logo" />
            </router-link>
        </div>

        <!-- Main Sections Links -->
        <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto pt-6">
            <!-- Dashobards -->
            <template v-for="(item, idx) in routes">
                <router-link
                        :key="'route_' + idx"
                        :to="item.route"
                        v-if="item.ignorePermission || (item.checkGlobalPermission ? globalPermissions.isPermissionsAllowed( item.permission) : userPermissions.isPermissionsAllowed( item.permission) )"
                        class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 text-center"
                        :class="{
                            'hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 bg-primary/10 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90' : ($route.path.startsWith( item.route ) && (( $route.path.startsWith( '/member/location-history') && $route.path == item.route ) || !$route.path.startsWith( '/member/location-history'))),
                            'hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25': !($route.path.startsWith( item.route ))
                        }"
                        v-tippy="item.name">
                        <img class="h-6 w-6" :src="item.iconImg" :alt="item.name" />
                </router-link>
            </template>

        </div>
        <div class="flex flex-col items-center space-y-3 py-3">

        </div>
    </div>
</div>

</template>

<script>

import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            routes:[
                {
                    name: 'Dashboard',
                    route: '/dashboard',
                    iconImg: '/images/icons/gauge.svg',
                    permission: [ ],
                    ignorePermission: true
                },
                {
                    name: 'Company Mangement',
                    route: '/company',
                    iconImg: '/images/icons/suitcase.svg',
                    permission: [ this.$permissions.COMPANY_LIST ],
                    ignorePermission: true,
                    checkGlobalPermission: true,
                },
                {
                    name: 'Branch',
                    route: '/branch',
                    iconImg: '/images/icons/network-wired.svg',
                    permission: [ this.$permissions.BRANCH_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'Roles',
                    route: '/role',
                    iconImg: '/images/icons/user-gear.svg',
                    permission: [ this.$permissions.ROLE_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'Staff Users',
                    route: '/member',
                    iconImg: '/images/icons/users.svg',
                    permission: [ this.$permissions.MEMBER_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'Property Management',
                    route: '/property',
                    iconImg: '/images/icons/building.svg',
                    permission: [ this.$permissions.PROPERTY_LIST, this.$permissions.ONLY_ASSIGNED_PROPERTY_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'Document Management',
                    route: '/document',
                    iconImg: '/images/icons/folder.svg',
                    permission: [ this.$permissions.DOCUMENT_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'Lead Management',
                    route: '/lead',
                    iconImg: '/images/icons/bullseye.svg',
                    permission: [ this.$permissions.LEAD_LIST,this.$permissions.ONLY_ASSIGNED_LEAD_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'Contacts',
                    route: '/contact',
                    iconImg: '/images/icons/phone.svg',
                    permission: [ this.$permissions.CONTACT_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'Project Management',
                    route: '/project',
                    iconImg: '/images/icons/file-invoice.svg',
                    permission: [ this.$permissions.PROJECT_LIST,this.$permissions.ONLY_ASSIGNED_PROJECT_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'Todo Task',
                    route: '/task',
                    iconImg: '/images/icons/list-check.svg',
                    permission: [ this.$permissions.TASK_LIST,this.$permissions.ONLY_ASSIGNED_TASK_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'Site Visits',
                    route: '/site-visit',
                    iconImg: '/images/icons/building-user.svg',
                    permission: [ this.$permissions.SITE_VISIT_LIST,this.$permissions.ONLY_ASSIGNED_SITE_VISIT_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'Member Location History',
                    route: '/member/location-history',
                    iconImg: '/images/icons/map-icon.svg',
                    permission: [ this.$permissions.VIEW_MEMBER_LOCATION_HISTORY ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'API Documentation',
                    route: '/api-documentation',
                    iconImg: '/images/icons/webhook.svg',
                    permission: [ this.$permissions.COMPANY_LIST ],
                    ignorePermission: false,
                }
            ]
        }
    },
    computed:{
        ...mapGetters([
            'currentUser',
            'globalPermissions',
            'userPermissions'
        ])
    }
}
</script>

<style>

</style>
