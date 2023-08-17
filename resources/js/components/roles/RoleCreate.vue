<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <div class="col-span-12">
            <div class="card p-4 sm:p-5">

                <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                    {{ $subTitle }}
                </p>
                <div class="mt-4 space-y-4">
                    <form @submit.prevent="submitForm">
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
                                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
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

                        <div class="flex justify-end space-x-2 mt-4">
                            <button
                            type="submit"
                                class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                <i class="fa fa-save"></i>
                                <span v-if="formData?.id">Update</span>
                                <span v-else>Create</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
        console.log("HEEEEEEEE");
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

            }else{
                this.$store.commit('setGlobalLoaderOff');
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
