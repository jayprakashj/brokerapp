<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex place-content-center">
        <div class="card w-9/12 p-4 sm:p-5">
            <form @submit.prevent="submitForm">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Change Password
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <button type="submit"
                                class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                Change
                            </button>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 items-center w-1/2 m-auto">
                            <label class="block">
                                <span>Current Password</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="xxxxx" :type="( viewPassword.includes( 'password' ) ? 'text' :'password')" name="password" v-model="formData.password">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-key text-base"></i>
                                    </span>

                                    <div
                                        @click="showPassword('password')"
                                        class="z-1 cursor-pointer absolute right-0 flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
                                    >
                                        <i class="fa fa-eye-slash" v-if="viewPassword.includes( 'password' )"></i>
                                        <i class="fa fa-eye" v-else></i>
                                    </div>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.password?.length">{{ errors.password.at(0) }}</span>
                            </label>
                            <label class="block">
                                <span>New Password</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="xxxxx" :type="( viewPassword.includes( 'new_password' ) ? 'text' :'password')" name="new_password" v-model="formData.new_password">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-key text-base"></i>
                                    </span>
                                    <div
                                        @click="showPassword('new_password')"
                                        class="z-1 cursor-pointer absolute right-0 flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
                                    >
                                        <i class="fa fa-eye-slash" v-if="viewPassword.includes( 'new_password' )"></i>
                                        <i class="fa fa-eye" v-else></i>
                                    </div>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.new_password?.length">{{ errors.new_password.at(0) }}</span>
                            </label>
                            <label class="block">
                                <span>Confirm New Password</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="xxxxx" :type="( viewPassword.includes( 'confirm_password' ) ? 'text' :'password')" name="confirm_new_password" v-model="formData.confirm_new_password">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-key text-base"></i>
                                    </span>
                                    <div
                                        @click="showPassword('confirm_password')"
                                        class="z-1 cursor-pointer absolute right-0 flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent"
                                    >
                                        <i class="fa fa-eye-slash" v-if="viewPassword.includes( 'confirm_password' )"></i>
                                        <i class="fa fa-eye" v-else></i>
                                    </div>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.confirm_new_password?.length">{{ errors.confirm_new_password.at(0) }}</span>
                            </label>

                        </div>
                     </div>
                </div>
            </form>

        </div>
    </div>

</template>

<script>
import { getCurrentInstance } from 'vue';
import * as Yup from 'yup';

export default {
    data(){
        return {
            pageTitle: 'Change Passwrod',
            errors: {},
            formData:{
                password: '',
                new_password: '',
                confirm_new_password: '',
            },
            loading:{
                formSubmit: false,
            },
            viewPassword: []
        }
    },
    mounted(){
        this.init();
    },
    computed:{
        breadcrumbs(){

            var breadcrumbs = [
                    {
                        title: 'Dashboard',
                        link: '/dashboard'
                    },
                    {
                        title: 'Change Password',
                    }
                ];
            return breadcrumbs;
        },
        validationSchema(){
            let fields = {
                password: Yup.string()
                            .nullable(true)
                            .required('Required'),
                new_password: Yup.string().nullable( true )
                                    .required('Required')
                                    .matches( /^[0-9A-Za-z]*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?][0-9a-zA-Z]*$/, 'Must contain 1 numeric, 1 alphabet and 1 special character')
                                    .min( 8, 'Minimum 8 characters required' ),
                confirm_new_password: Yup.string().nullable( true )
                                    .required('Required')
                                    .matches( /^[0-9A-Za-z]*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?][0-9a-zA-Z]*$/, 'Must contain 1 numeric, 1 alphabet and 1 special character')
                                    .min( 8, 'Minimum 8 characters required' )
                                    .oneOf([Yup.ref('new_password')], 'Not matched with new password.')

            }
            const yup = Yup.object().shape( fields );

            return yup;
        }
    },
    methods:{
        init () {
            this.$store.commit('setGlobalLoaderOff');
        },
        submitForm () {
            if( this.loading.formSubmit || this.loading.upload ){
                return;
            }
            this.errors = {};
            this.validationSchema.validate( this.formData, { abortEarly: false })
                                    .then( ( resValidate ) => {
                                        this.loading.formSubmit = true;
                                        this.$store.commit('setGlobalLoaderOn');
                                        this.$request.updatePassword( this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! Password changed successfully.';
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            this.clearForm ();
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
        openLogoUpload(){
            this.$refs.mediaLogo.click();
        },
        uploadMedia ( e ){
            if( !this.loading.upload ){
                const mediaFiles = e.target.files;
                if( mediaFiles && mediaFiles.length ){
                    this.loading.upload = true;
                    this.$request.uploadMedia( mediaFiles[0] )
                                .then(
                                    ( res ) => {
                                        if( res.data?.files?.length ){
                                            const tmpFile = res.data.files.at(0);
                                            this.formData.logo = tmpFile.id;
                                            this.media.logo = tmpFile.url;
                                        }else{

                                            this.$toast.error( 'Oops!' );
                                        }
                                    },
                                    ( err ) => {
                                        let message = 'Error! Request failed while uploading.';
                                        if( err?.response?.data?.message ){
                                            message = err.response.data.message;
                                        }
                                        this.$toast.error( message );
                                    }
                                ).finally(
                                    () => {
                                        this.loading.upload = false;
                                    }
                                )

                }
            }
        },
        showPassword( fieldKey ){
            if( !this.viewPassword.includes( fieldKey ) ){
                this.viewPassword.push( fieldKey );
            }else{
                const findIndex = this.viewPassword.findIndex( d => d == fieldKey );
                if( findIndex !== -1 ){
                    this.viewPassword.splice( findIndex, 1 );
                }

            }
        },
        clearForm () {
            this.viewPassword = [];
            this.formData = {
                password: '',
                new_password: '',
                confirm_new_password: '',
            };
        }
    }
}
</script>

<style>

</style>
