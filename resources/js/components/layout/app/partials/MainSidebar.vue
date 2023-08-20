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
                        class="flex h-11 w-11 items-center justify-center rounded-lg outline-none transition-colors duration-200 "
                        :class="{
                            'hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-navy-600 bg-primary/10 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90' : item.active,
                            'hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25': !item.active
                        }"
                        v-tippy="item.name">
                    <i class="fa fa-2x h-7 w-7" :class="item.iconClass" ></i>
                </router-link>
            </template>

        </div>
        <div class="flex flex-col items-center space-y-3 py-3">
            <popper-dropdown
                    ref="popperDropdown"
                    class-name="flex"
                    popper-root-class="fixed"
                    popper-root-style="position: fixed; inset: auto auto 0px 0px; margin: 0px; transform: translate(76px, -12px);"
                    >
                <template v-slot:popper_btn>
                    <img class="rounded-full" :src="currentUser.logo_url" alt="avatar">
                </template>
                <template v-slot:default>

                    <div
                        class="popper-box w-64 rounded-lg border border-slate-150 bg-white shadow-soft dark:border-navy-600 dark:bg-navy-700">
                        <div class="flex items-center space-x-4 rounded-t-lg bg-slate-100 py-5 px-4 dark:bg-navy-800">
                            <div class="avatar h-14 w-14">
                                <img class="rounded-full" :src="currentUser.logo_url" alt="avatar">
                            </div>
                            <div>
                                <a href="#"
                                    class="text-base font-medium text-slate-700 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                                    {{ currentUser.name }}
                                </a>
                                <p class="text-xs text-slate-400 dark:text-navy-300">
                                    Admin
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col pt-2 pb-5">
                            <router-link to="/profile"
                                @click="hidePopperDropDown"
                                class="group flex items-center space-x-3 py-2 px-4 tracking-wide outline-none transition-all hover:bg-slate-100 focus:bg-slate-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-warning text-white">
                                    <i class="fa fa-user"></i>
                                </div>

                                <div>
                                    <h2
                                        class="font-medium text-slate-700 transition-colors group-hover:text-primary group-focus:text-primary dark:text-navy-100 dark:group-hover:text-accent-light dark:group-focus:text-accent-light">
                                        Profile
                                    </h2>
                                    <div class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                                        Your profile setting
                                    </div>
                                </div>
                            </router-link>

                            <router-link to="/change-password"
                                @click="hidePopperDropDown"
                                class="group flex items-center space-x-3 py-2 px-4 tracking-wide outline-none transition-all hover:bg-slate-100 focus:bg-slate-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-warning text-white">
                                    <i class="fa fa-key"></i>
                                </div>

                                <div>
                                    <h2
                                        class="font-medium text-slate-700 transition-colors group-hover:text-primary group-focus:text-primary dark:text-navy-100 dark:group-hover:text-accent-light dark:group-focus:text-accent-light">
                                        Change Password
                                    </h2>
                                    <div class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                                        Change current password
                                    </div>
                                </div>
                            </router-link>
                            <div class="mt-3 px-4">
                                <button
                                    @click="logout"
                                    class="btn h-9 w-full space-x-2 bg-primary text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </popper-dropdown>
        </div>
    </div>
</div>

</template>

<script>

import permission from '@/constants/permissions' ;
import { mapGetters } from 'vuex';

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
                    permission: [ this.$permissions.COMPANY_LIST ],
                    ignorePermission: true,
                    checkGlobalPermission: true,
                },
                {
                    name: 'Roles',
                    route: '/role',
                    iconClass: 'fa-user-gear',
                    permission: [ this.$permissions.ROLE_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
                },
                {
                    name: 'Members',
                    route: '/member',
                    iconClass: 'fa-users',
                    permission: [ this.$permissions.USER_LIST ],
                    ignorePermission: false,
                    checkGlobalPermission: false,
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
    },
    methods:{
        logout(){
            this.$request.logout()
                .then(
                    () => {
                        window.location.href = '/login';
                    }
                )
        },
        hidePopperDropDown(){
            this.$refs.popperDropdown.closePopper();
        }
    }
}
</script>

<style>

</style>
