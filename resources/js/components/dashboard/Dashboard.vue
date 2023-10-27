<template>
    <page-header :title="pageTitle" />

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <div class="col-span-12 pb-4">
            <div class="px-4 pt-2 pb-4 mt-3 grid grid-cols-4 gap-3 px-4 gap-y-5 items-center">
                <div class=" card p-8 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.PROPERTY_LIST, $permissions.ONLY_ASSIGNED_PROPERTY_LIST ] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-4xl font-bold text-success dark:text-navy-100">
                                {{ data.property_count }}
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
                                {{ data.project_count }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Projects</p>
                        </div>
                        <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-primary/10">
                            <i class="fa text-2xl fa-file-invoice text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class=" card p-8 justify-center hidden" v-if="userPermissions.isPermissionsAllowed([ $permissions.MEMBER_LIST] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-4xl font-bold text-info dark:text-navy-100">
                                {{ data.member_count }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Members</p>
                        </div>
                        <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-info/10">
                            <i class="fa text-2xl fa-users text-info"></i>
                        </div>
                    </div>
                </div>
                <div class=" card p-8 justify-center hidden" v-if="userPermissions.isPermissionsAllowed([ $permissions.BRANCH_LIST] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-4xl font-bold text-gray dark:text-navy-100">
                                {{ data.branch_count }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Branches</p>
                        </div>
                        <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-gray-800/10">
                            <i class="fa text-2xl fa-network-wired text-gray"></i>
                        </div>
                    </div>
                </div>
                <div class=" card p-8 justify-center" v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST, $permissions.ONLY_ASSIGNED_LEAD_LIST ] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-4xl font-bold text-slate-900 dark:text-navy-100">
                                {{ data.month_leads }}
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
                                {{ data.month_site_visits }}
                            </p>
                            <p class="text-xs+ line-clamp-1">This Month Site Visits</p>
                        </div>
                        <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-red-800/10">
                            <i class="fa text-2xl fa-building-user text-red-800"></i>
                        </div>
                    </div>
                </div>

                <div class=" card p-8 justify-center hidden" v-if="userPermissions.isPermissionsAllowed([ $permissions.CONTACT_LIST] )">
                    <div class="flex items-center justify-between">

                        <div>
                            <p class="text-4xl font-bold text-warning dark:text-navy-100">
                                {{ data.contact_count }}
                            </p>
                            <p class="text-xs+ line-clamp-1">Contacts</p>
                        </div>
                        <div class="mask is-star flex h-16 w-16 shrink-0 items-center justify-center bg-warning/10">
                            <i class="fa text-2xl fa-phone text-warning"></i>
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

    <div class="mt-4 grid grid-cols-12 gap-4 bg-slate-150 py-5 dark:bg-navy-800 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6 -ml-[4rem] -mr-[4rem]"  v-if="userPermissions.isPermissionsAllowed([ $permissions.LEAD_LIST,this.$permissions.ONLY_ASSIGNED_LEAD_LIST ] )">
            <div class="col-span-12 flex flex-col px-[var(--margin-x)] transition-all duration-[.25s] lg:col-span-3 lg:pr-0">
                <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-xl">
                    Today's Leads
                </h2>

                <p class="mt-3 grow">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus obcaecati similique iste architecto excepturi error vel assumenda! Dolore vitae, saepe fugit omnis incidunt, est autem odit, perferendis et commodi illo?
                </p>

            </div>
            <div
                class="col-span-12 flex space-x-4 overflow-x-auto px-[var(--margin-x)] transition-all duration-[.25s] lg:col-span-9 lg:pl-0">
                <template v-if="data?.today_leads?.length">
                    <div class="card w-72 shrink-0 space-y-1 rounded-xl p-4 sm:px-1 " v-for="(item, idx) in data?.today_leads" :key="'today_lead_'+idx">
                        <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100 text-center" :title="item.full_title">
                            {{ item.title }}
                        </h3>
                        <p class="text-xs+ text-center">
                            {{ item.name }}
                        </p>
                        <div class="my-4 !mt-4 !mb-4 h-px w-full bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grow space-y-4">
                            <div class="flex pl-6 space-x-4">
                                <div
                                    class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                                    <i class="fa fa-phone text-xs"></i>
                                </div>
                                <p>{{ item.mobile }}</p>
                            </div>
                            <div class="flex pl-6 space-x-4">
                                <div
                                    class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                                    <i class="fa fa-envelope text-xs"></i>
                                </div>
                                <p>{{ item.email }}</p>
                            </div>
                            <div class="flex pl-6 space-x-4">
                                <div
                                    class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                                    <i class="fa fa-comment text-xs"></i>
                                </div>
                                <p :title="item.full_comment">{{ item.comment }}</p>
                            </div>
                        </div>
                        <div class="mt-5 space-x-2 text-center">

                            <router-link
                                v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_LEAD ] )"
                                :to="'/lead/view/' + item.id"
                                class="btn mt-5 space-x-2 rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                <span> View Detail </span>
                            </router-link>
                        </div>
                    </div>
                </template>
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
            inProcess: false,
            data:{

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
            this.inProcess = true;
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
        }
    }
}
</script>

<style>

</style>
