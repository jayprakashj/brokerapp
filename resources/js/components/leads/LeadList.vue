<template>
    <page-header :title="pageTitle" :menus="menus" :filter-enabled="false">
        <template v-slot:filterPopoverContent="popperSlotOptions">
            <div class="popper-box max-w-[22rem]">
                <div class="rounded-md border border-slate-150 bg-white p-4 dark:border-navy-600 dark:bg-navy-700">
                    <h3 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        Select Columns
                    </h3>
                    <p class="mt-1 text-xs+">Lorem ipsum dolor sit amet, consectetur.</p>
                    <div class="mt-4 flex flex-col space-y-4 text-slate-600 dark:text-navy-100">
                        <label class="block">
                            <span>Choose Username:</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="Username"
                                type="text"
                            />
                        </label>

                    </div>
                    <div class="my-4 h-px bg-slate-200 dark:bg-navy-500"></div>
                    <div class="flex flex-col space-y-4 text-slate-600 dark:text-navy-100">
                        <label class="inline-flex items-center space-x-2">
                            <input checked
                                class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                type="checkbox" />
                            <p>Created at</p>
                        </label>
                    </div>
                    <button @click="applyFilter(popperSlotOptions)"
                        class="btn mt-4 h-8 w-full rounded-md bg-primary px-4 text-xs+ font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        Apply
                    </button>
                </div>
                <div class="h-4 w-4" data-popper-arrow>
                    <i class="fa fa-magnifier"></i>
                </div>
            </div>
        </template>
    </page-header>
    <list-container>
        <template v-if="lists?.data?.length">
            <div class="card grow items-center p-4 sm:p-5 " v-for="(item, idx) in lists.data" :key="'member_'+idx">
                <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                    {{ item.title }}
                </h3>
                <p class="text-xs+">{{ item.company_name }} </p>
                <div class="my-4 h-px w-full bg-slate-200 dark:bg-navy-500"></div>
                <div class="grow space-y-4">
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-user text-xs"></i>
                        </div>
                        <p>{{ item.name }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-phone text-xs"></i>
                        </div>
                        <p>{{ item.mobile }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-envelope text-xs"></i>
                        </div>
                        <p>{{ item.email }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-location-dot text-xs"></i>
                        </div>
                        <p>{{ item.city }}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-building text-xs"></i>
                        </div>
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
                                    <tempalte #default>
                                        <span>
                                            {{ item.property_name.at(0) }} +{{ item.property_name.length-1 }} more

                                        </span>

                                    </tempalte>

                                </tippy>

                            </template>
                            <template v-else>
                                {{ item.property_name.at(0) }}
                            </template>
                        </p>
                        <p v-else>
                            N/A
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-file-invoice text-xs"></i>
                        </div>
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
                                    <tempalte #default>
                                        <span>
                                            {{ item.project_name.at(0) }} +{{ item.project_name.length-1 }} more

                                        </span>

                                    </tempalte>

                                </tippy>

                            </template>
                            <template v-else>
                                {{ item.project_name.at(0) }}
                            </template>
                        </p>
                        <p v-else>
                            N/A
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div
                            class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                            <i class="fa fa-user-gear text-xs"></i>
                        </div>
                        <p>{{ item.assigned_to }}</p>
                    </div>
                </div>
                <div class="mt-5 space-x-2">

                    <router-link :to="'/lead/edit/' + item.id"
                        v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_LEAD ] )"
                        class="btn mt-5 space-x-2 rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <i class="fa fa-pencil"></i>
                        <span> Edit </span>
                    </router-link>
                    <router-link v-if="userPermissions.isPermissionsAllowed([ $permissions.VIEW_LEAD ] )" :to="'/lead/view/' + item.id" class="btn h-7 w-7 rounded-full bg-slate-150 px-0 text-xs+ font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <i class="far fa-eye"></i>
                    </router-link>
                    <button v-if="false && userPermissions.isPermissionsAllowed([ $permissions.REMOVE_LEAD ] )"
                            @click="removeItem( item.id )"
                        class="btn rounded-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </template>
        <no-data-found v-else />
    </list-container>
    <pagination :total-records="lists?.total_records" :per-page="lists?.per_page" :current-page="page" @pageChange="updatePage"></pagination>
</template>

<script>
import { mapGetters } from 'vuex' ;

export default {
    data(){
        return {
            pageTitle: 'Lead Management',
            isShowPopper: false,
            page: 1,
            lists:{}
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
        },
        loadListsData(){
            this.$store.commit('setGlobalLoaderOn')
            const params = {
                per_page: this.$perPage,
                page: this.page
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
        applyFilter( popperSlotOptions ){
            popperSlotOptions.popperClose();
        }
    }
}
</script>

<style>

</style>
