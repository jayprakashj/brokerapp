<template>
    <page-header :title="pageTitle" />

    <div class="grid grid-cols-12 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
        <div class="col-span-5 pb-4">
            <div class="px-4 pt-2 pb-4 mt-3 grid grid-cols-12 gap-3 px-4 gap-y-5">
                <div class="col-span-6 card p-4.5 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.PROPERTY_LIST, $permissions.ONLY_ASSIGNED_PROPERTY_LIST ] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                {{ data.property_count }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Properties</p>
                        </div>
                        <div class="mask is-star flex h-10 w-10 shrink-0 items-center justify-center bg-success">
                            <i class="fa fa-building text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 card p-4.5 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.PROJECT_LIST, $permissions.ONLY_ASSIGNED_PROJECT_LIST ] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                {{ data.project_count }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Projects</p>
                        </div>
                        <div class="mask is-star flex h-10 w-10 shrink-0 items-center justify-center bg-primary">
                            <i class="fa fa-file-invoice text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 card p-4.5 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.MEMBER_LIST] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                {{ data.member_count }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Members</p>
                        </div>
                        <div class="mask is-star flex h-10 w-10 shrink-0 items-center justify-center bg-info">
                            <i class="fa fa-users text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 card p-4.5 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.BRANCH_LIST] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                {{ data.branch_count }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Branches</p>
                        </div>
                        <div class="mask is-star flex h-10 w-10 shrink-0 items-center justify-center bg-gray-800">
                            <i class="fa fa-network-wired text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 card p-4.5 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.CONTACT_LIST] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                {{ data.contact_count }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Contacts</p>
                        </div>
                        <div class="mask is-star flex h-10 w-10 shrink-0 items-center justify-center bg-warning">
                            <i class="fa fa-phone text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 col-start-1 card p-4.5 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST, $permissions.ONLY_ASSIGNED_LEAD_LIST ] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                {{ data.month_leads }}
                            </p>
                            <p class="text-xs+ line-clamp-1">This Month Leads</p>
                        </div>
                        <div class="mask is-star flex h-10 w-10 shrink-0 items-center justify-center bg-slate-900/60">
                            <i class="fa fa-bullseye text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 card p-4.5 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.SITE_VISIT_LIST, $permissions.ONLY_ASSIGNED_SITE_VISIT_LIST ] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                {{ data.month_site_visits }}
                            </p>
                            <p class="text-xs+ line-clamp-1">This Month Site Visits</p>
                        </div>
                        <div class="mask is-star flex h-10 w-10 shrink-0 items-center justify-center bg-red-800">
                            <i class="fa fa-building-user text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card p-4 sm:p-5 col-span-7" v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST,this.$permissions.ONLY_ASSIGNED_LEAD_LIST ] )">
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
</template>

<script>
import { mapGetters } from 'vuex' ;
export default {
    data(){
        return {
            pageTitle: 'Dashboard',
            data:{

            }
        }
    },
    created(){
        this.init();

    },
    computed:{

        ...mapGetters([
            'globalPermissions',
            'userPermissions'
        ]),
    },
    methods:{
        init(){
            this.loadData();
        },
        loadData(){
            this.$request.getDashboardData()
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
                                this.$store.commit('setGlobalLoaderOff');
                            }
                        )
        }
    }
}
</script>

<style>

</style>
