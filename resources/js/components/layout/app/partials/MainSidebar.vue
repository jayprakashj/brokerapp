<template>
  <div class="main-sidebar">
    <div
        class="flex h-full w-full flex-col items-center border-r border-slate-150 bg-white dark:border-navy-700 dark:bg-navy-800">
        <!-- Application Logo -->
        <div class="flex pt-4">
            <a href="/">
                <img class="h-11 w-11 transition-transform duration-500 ease-in-out hover:rotate-[360deg]"
                    src="{{ asset('images/app-logo.svg') }}" alt="logo" />
            </a>
        </div>

        <!-- Main Sections Links -->
        <div class="is-scrollbar-hidden flex grow flex-col space-y-4 overflow-y-auto pt-6">
            <!-- Dashobards -->
            <template v-for="(item, idx) in routes">
                <router-link
                        :key="'route_' + idx"
                        :to="item.route"
                        v-if="item.ignorePermission || $checkPermission( item.permission, item.checkGlobalPermission )"
                        class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 "
                        :class="{
                            'hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 bg-primary/10 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90' : item.active,
                            'hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25': !item.active
                        }"
                        v-tippy="item.name">
                    <i class="fa fa-2x h-7 w-7" :class="item.iconClass" ></i>
                </router-link>
            </template>

            <div>
            <button type="button" @click="logout" class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                <i class="fa fa-sign-out fa-2x text-red-500"></i>
            </button>
            </div>
        </div>

    </div>
</div>

</template>

<script>

import permission from '@/constants/permissions' ;

export default {
    data() {
        return {
            routes:[
                {
                    name: 'Dashboard',
                    route: '/dashboard',
                    iconClass: 'fa-dashboard',
                    permission: [ ],
                    ignorePermission: true
                },
                {
                    name: 'Company Mangement',
                    route: '/company',
                    iconClass: 'fa-suitcase',
                    permission: [ permission.COMPANY_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: true,
                },
                {
                    name: 'Roles',
                    route: '/role',
                    iconClass: 'fa-user-gear',
                    permission: [ permission.ROLE_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: true,
                },
                {
                    name: 'Members',
                    route: '/member',
                    iconClass: 'fa-users',
                    permission: [ permission.USER_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: true,
                }
            ]
        }
    },
    methods:{
        logout(){
            this.$request.logout()
                .then(
                    () => {
                        window.location.href = '/login';
                    }
                )
        }
    }
}
</script>

<style>

</style>
