<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex place-content-center">
        <div class="card p-4 w-1/1 sm:p-5">
            <form @submit.prevent="submitForm">
                <div class="card">

                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ formData?.id ? 'Update Role' : 'Add New Role' }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <router-link to="/role"
                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </router-link>
                            <button type="submit"
                                class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                {{ formData?.id ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 items-center">

                            <label class="block">
                                <span>Role name</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Role Name..." type="text" name="role_name" v-model="formData.role_name">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-user-gear text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.role_name?.length">{{ errors.role_name.at(0) }}</span>
                            </label>


                            <div class="card px-4 pb-4 sm:px-5 mt-6 {{ $loop->last ? 'mb-5' :'' }}" v-for="(item, index) in permissions" :key="'permission_'+index">
                                <div class="my-3 flex h-8 items-center justify-between">
                                    <h2 class="flex items-center gap-2 font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                                        <input
                                            :name="'permission_group[' + item.name+ ']'"
                                            class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                            type="checkbox" @click="checkAllPermission( $event, item.permissions)">
                                        {{ item.name }}
                                    </h2>
                                </div>
                                <div class="max-w-100">
                                    <div class="mt-5 grid grid-cols-2 place-items-start gap-6 sm:grid-cols-4">
                                            <label class="inline-flex items-center space-x-2" v-for="(perItem, idx) in item.permissions" :key="'permission_label'+ idx">
                                                <input
                                                    name="permissions[]"
                                                    :value="perItem.id"
                                                    v-model="formData.permissions"
                                                    class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                    type="checkbox" >
                                                <span>{{ perItem.name }}</span>
                                            </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                </div>
            </form>

        </div>
    </div>

</template>

<script>
import * as Yup from 'yup';

export default {
    data(){
        return {
            pageTitle: 'Role Management',
            subTitle: 'Create Role',
            isShowPopper: false,
            errors: {},
            formData:{
                role_name: '',
                permissions: []
            },
            permissions: [],
            loading:{
                formSubmit: false
            }
        }
    },
    mounted(){
        this.init();
    },
    computed:{

        breadcrumbs(){

            var breadcrumbs = [
                        {
                            title: 'Role Management',
                            link: '/role'
                        },
                        {
                            title: (this.formData?.id ? 'Edit': 'Create'),
                        }
                    ];
            return breadcrumbs;
        },
        validationSchema(){
            let fields = {
                role_name: Yup.string()
                            .nullable(true)
                            .required('Required')
                            .min('2', 'Must have at least 2 characters'),

            }
            const yup = Yup.object().shape( fields );

            return yup;
        }
    },
    methods:{
        init () {
            this.loadPermissionsLists();
            if( this.$route?.params?.id ){
                this.loadEditFormDetail( this.$route.params.id );

            }
        },
        loadEditFormDetail( id ){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getRoleDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data?.data ){
                                    this.formData = Object.assign( this.formData, res.data.data);
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
        loadPermissionsLists(){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getPermissions()
                        .then(
                            ( res ) => {
                                if( res.data?.data ){
                                    this.permissions = res.data.data.map( d => {
                                        d.selectAll = false;
                                        return d;
                                    });
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
        submitForm () {
            if( this.loading.formSubmit ){
                return;
            }
            this.errors = {};
            this.validationSchema.validate( this.formData, { abortEarly: false })
                                    .then( ( resValidate ) => {
                                        this.loading.formSubmit = true;
                                        this.$store.commit('setGlobalLoaderOn');
                                        this.$request.createRole( this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! New role created successfully.';
                                                            if( this.formData?.id ){
                                                                message = 'Success! Role Data data update successfully.';
                                                            }
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            this.$router.push({ name: 'role_lists' });
                                                            this.$toast.info( message );
                                                        },
                                                        ( err ) => {
                                                            let message = 'Error! There is error occured while processing request.';
                                                            if( err?.response?.status === 422 && err?.response?.data?.errors ){
                                                                this.errors =  err.response.data.errors ;
                                                            }
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
                                    ( e ) => {
                                        const err = {};
                                        if( e.inner?.length ){

                                            e.inner.forEach( ele => {
                                                let keyPath = ele.path;
                                                err[ keyPath ] = [ele.message]
                                            });
                                            this.errors = err;
                                            this.$toast.error("Error! Please correct all the error fields.");
                                        }
                                    });
        },
        checkAllPermission ( e, permissions  ){
            permissions.forEach(d => {
                    if( e.target.checked ){
                        if( !this.formData.permissions.includes( d.id ) ){
                            this.formData.permissions.push( d.id );
                        }
                    }else{
                        const idx = this.formData.permissions.findIndex( pId => pId == d.id );
                        if( idx !== -1 ){
                            this.formData.permissions.splice( idx, 1);
                        }
                    }
                });
        }
    }
}
</script>

<style>

</style>
