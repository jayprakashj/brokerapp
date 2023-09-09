<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="card mt-2 p-4 sm:p-5 mb-4">
        <div
            class="col-span-12 flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
            <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                Attach Documents
                <small class="text-sm font-light">{{ data.name || '' }}</small>
            </h2>
        </div>
        <div class="w-1/2 grid grid-cols-2 gap-4 mt-2 items-center">
            <input-tom-select
                    v-model="selectedDocument"
                    placeholder="Select Document"
                    :options="documents"
                />
                <button :disabled="!selectedDocument" @click="attachDocument" class="w-1/2 h-10 btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    <span>Attach</span>
                    <i class="fa fa-paperclip"></i>
            </button>
        </div>
    </div>
    <list-container>
        <template v-if="data?.documents?.length">
            <div class="card grow items-center p-4 sm:p-5 " v-for="(item, idx) in data.documents" :key="'document_'+idx">
                <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                    {{ item.name }}
                </h3>
                <p class="text-xs+">{{ item.company_name }} </p>
                <div class="my-4 h-px w-full bg-slate-200 dark:bg-navy-500"></div>
                <div class="grow space-y-4">
                    <div class="flex items-center space-x-4">

                        <p>{{ item.description }}</p>
                    </div>
                </div>
                <div class="mt-5 space-x-2">

                    <router-link :to="'/document/edit/' + item.id"
                        v-if="userPermissions.isPermissionsAllowed([ $permissions.UPDATE_DOCUMENT ] )"
                        class="btn mt-5 space-x-2 rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <i class="fa fa-pencil"></i>
                        <span> Edit </span>
                    </router-link>
                    <button v-if="userPermissions.isPermissionsAllowed([ $permissions.REMOVE_DOCUMENT ] )"
                            @click="removeItem( item.id )"
                        class="btn rounded-full bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
        </template>
        <no-data-found v-else />
    </list-container>
</template>

<script>
import { mapGetters } from 'vuex' ;

export default {
    data(){
        return {
            pageTitle: 'Property Document Management',
            isShowPopper: false,
            page: 1,
            data:{},
            documents: [],
            selectedDocument: null
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
            return menus;
        },
        breadcrumbs(){

            var breadcrumbs = [
                        {
                            title: 'Property Management',
                            link: '/property'
                        },
                        {
                            title: (this.data.name || ''),
                            link: '/property/view/' + this.data.id
                        },
                        {
                            title: 'Documents',
                        }
                    ];
            return breadcrumbs;
        },
    },
    methods:{
        init () {
            this.loadSelectListData();
            this.loadListsData();
        },
        loadListsData(){
            this.$store.commit('setGlobalLoaderOn')
            this.$request.getPropertyDocumentList( this.$route.params.id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.data = res.data.data;
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
        loadSelectListData(){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getPropertyDocumentDropdownList( this.$route.params.id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.documents = res.data;
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
        removeItem ( id ){


            this.$swal.fire({
                    title: 'Are you sure you want to remove?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove.',
                }).then(
                    ( res ) =>{
                        if( res.isConfirmed ){
                            this.$store.commit('setGlobalLoaderOn')
                            this.$request
                                .detachPropertyWithDocument( id )
                                .then(
                                    ( res ) => {
                                        let message = 'Success! Document removed successfully.';

                                        if( res.data?.message ){
                                            message = res.data.message;
                                        }
                                        this.documents = [];
                                        this.selectedDocument = null;
                                        this.loadSelectListData();
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
        attachDocument ( ){


            this.$swal.fire({
                    title: 'Are you sure you want to attach?',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, attach.',
                }).then(
                    ( res ) =>{
                        if( res.isConfirmed ){
                            this.$store.commit('setGlobalLoaderOn')
                            const data = {
                                property_id: this.$route.params.id,
                                document_id: this.selectedDocument,
                            }
                            this.$request
                                .attachPropertyToDocument( data )
                                .then(
                                    ( res ) => {
                                        let message = 'Success! Document attached successfully.';

                                        if( res.data?.message ){
                                            message = res.data.message;
                                        }
                                        this.documents = [];
                                        this.selectedDocument = null;
                                        this.loadSelectListData();
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
        }
    }
}
</script>

<style>

</style>
