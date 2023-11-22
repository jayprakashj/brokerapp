<template>
  <nav class="header print:hidden">
    <!-- App Header  -->
    <div class="header-container relative flex w-full bg-white dark:bg-navy-750 print:hidden">
        <!-- Header Items -->
        <div class="flex w-full items-center justify-between">
            <!-- Left: Sidebar Toggle Button -->
            <div >

                <popper-dropdown :popper-btn-class="'!w-[9rem] space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90'">
                    <template v-slot:popper_btn>
                        <span>Enquiry Form</span>
                        <i class="fa fa-caret-down"></i>
                    </template>
                    <template v-slot:default="popperSlotOptions">
                        <div
                            class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                            <ul>
                                <li v-for="(item, index) in $enquiryTypes" :key="'enquiry_menu_'+index">
                                    <router-link :to="'/customer/enquiry/' + item.id"
                                        @click="popperSlotOptions.closePopper"
                                        target="_blank"
                                        class="flex  items-center px-3 h-8 pr-12 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Enquiry for {{ item.title }} <i class="ml-2 fa fa-external-link"></i></router-link>
                                </li>
                            </ul>
                        </div>

                    </template>
                </popper-dropdown>
            </div>
            <div class="h-7 w-max" v-if="false">
                <button
                    class="menu-toggle ml-0.5 flex h-7 w-7 flex-col justify-center space-y-1.5 text-primary outline-none focus:outline-none dark:text-accent-light/80"
                    :class="$store.state.default.global.isSidebarExpanded && 'active'"
                    @click="$store.state.default.global.isSidebarExpanded = !$store.state.default.global.isSidebarExpanded">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <div class="-mr-1.5 flex items-center space-x-2">
                <popper-dropdown
                    ref="popperDropdown"
                    class-name="flex"
                    popper-root-class="fixed"
                    popper-root-style="position: fixed; inset: auto auto 0px 0px; margin: 0px; transform: translate(76px, -12px);"
                    >
                <template v-slot:popper_btn>
                    <img class="rounded-full" :src="currentUser.logo_url" alt="avatar">
                </template>
                <template v-slot:default="popperSlotOptions">

                    <div
                        class="popper-box w-64 rounded-lg border border-slate-150 bg-white shadow-soft dark:border-navy-600 dark:bg-navy-700">
                        <div class="flex items-center space-x-4 rounded-t-lg bg-slate-100 py-5 px-4 dark:bg-navy-800">
                            <div class="avatar h-14 w-14">
                                <img class="rounded-full" :src="currentUser.logo_url" alt="avatar">
                            </div>
                            <div>
                                <router-link to="/profile" @click="popperSlotOptions.closePopper"
                                    class="text-base font-medium text-slate-700 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">
                                    {{ currentUser.name }}
                                </router-link>
                                <p class="text-xs text-slate-400 dark:text-navy-300">
                                    {{ currentUser.role_name || '' }}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col pt-2 pb-5">
                            <router-link to="/profile"
                                @click="popperSlotOptions.closePopper"
                                class="group flex items-center space-x-3 py-2 px-4 tracking-wide outline-none transition-all hover:bg-slate-100 focus:bg-slate-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-warning text-white">
                                    <i class="fa fa-user"></i>
                                </div>

                                <div>
                                    <h2
                                        class="!font-sans !text-sm font-medium text-slate-700 transition-colors group-hover:text-primary group-focus:text-primary dark:text-navy-100 dark:group-hover:text-accent-light dark:group-focus:text-accent-light">
                                        Profile
                                    </h2>
                                    <div class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                                        Your profile setting
                                    </div>
                                </div>
                            </router-link>

                            <router-link to="/change-password"
                                @click="popperSlotOptions.closePopper"
                                class="group flex items-center space-x-3 py-2 px-4 tracking-wide outline-none transition-all hover:bg-slate-100 focus:bg-slate-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-warning text-white">
                                    <i class="fa fa-key"></i>
                                </div>

                                <div>
                                    <h2
                                        class="!font-sans !text-sm font-medium text-slate-700 transition-colors group-hover:text-primary group-focus:text-primary dark:text-navy-100 dark:group-hover:text-accent-light dark:group-focus:text-accent-light">
                                        Change Password
                                    </h2>
                                    <div class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                                        Change current password
                                    </div>
                                </div>
                            </router-link>
                            <router-link to="/company/setting"
                                v-if="userPermissions.isPermissionsAllowed( this.$permissions.COMPANY_SETTING )"
                                @click="popperSlotOptions.closePopper"
                                class="group flex items-center space-x-3 py-2 px-4 tracking-wide outline-none transition-all hover:bg-slate-100 focus:bg-slate-100 dark:hover:bg-navy-600 dark:focus:bg-navy-600">
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-warning text-white">
                                    <i class="fa fa-gear"></i>
                                </div>

                                <div>
                                    <h2
                                        class="!font-sans !text-sm font-medium text-slate-700 transition-colors group-hover:text-primary group-focus:text-primary dark:text-navy-100 dark:group-hover:text-accent-light dark:group-focus:text-accent-light">
                                        Company Setting
                                    </h2>
                                    <div class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                                        Update your company setting
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
</nav>

</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data(){
        return {
            activeTab: 'tabAll',
            isShowPopper: false
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
    }
}
</script>

<style>

</style>
