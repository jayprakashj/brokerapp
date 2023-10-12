<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex place-content-center">
        <div class="card w-9/12 p-4 sm:p-5">
            <form @submit.prevent="submitForm">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Company Settings
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <button type="submit"
                                class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                Update
                            </button>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">

                            <label class="inline-flex items-center space-x-2">
                                <input
                                    class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:bg-primary checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-accent dark:checked:before:bg-white"
                                    type="checkbox"
                                    v-model="formData.enable_lead_notification"
                                />
                                <span>Enable Lead Notification</span>
                            </label>
                            <label class="block">
                                <span>Email for Lead Notifications</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="abc@example.com,xyz@example.com,lorem@..." type="text" name="lead_email" v-model="formData.lead_email">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-envelope text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-muted" >Add multiple email sperated by comma(,)</span>
                                <span class="text-tiny+ text-error" v-if="errors?.lead_email?.length">{{ errors.lead_email.at(0) }}</span>
                            </label>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">

                            <label class="inline-flex items-center space-x-2">
                                <input
                                    class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:bg-primary checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-accent dark:checked:before:bg-white"
                                    type="checkbox"
                                    v-model="formData.enable_property_notification"
                                />
                                <span>Enable Property Notification</span>
                            </label>
                            <label class="block">
                                <span>Email for Property Notifications</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="abc@example.com,xyz@example.com,lorem@..." type="text" name="property_email" v-model="formData.property_email">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-envelope text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-muted" >Add multiple email sperated by comma(,)</span>
                                <span class="text-tiny+ text-error" v-if="errors?.property_email?.length">{{ errors.property_email.at(0) }}</span>
                            </label>
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
            pageTitle: 'Company Setting',
            errors: {},
            formData:{
                enable_lead_notification: false
            },
            loading:{
                formSubmit: false,
            },
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
                        title: 'Company Setting',
                    }
                ];
            return breadcrumbs;
        },
        validationSchema(){
            let fields = {
                // name: Yup.string()
                //             .nullable(true)
                //             .required('Required')
                //             .min('2', 'Must have at least 2 characters'),

            }
            const yup = Yup.object().shape( fields );

            return yup;
        }
    },
    methods:{
        init () {
            this.loadCompanySetting();
            this.$store.commit('setGlobalLoaderOff');
        },
        loadCompanySetting(){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getCompanySetting()
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.formData = Object.assign( this.formData, res.data);
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
            if( this.loading.formSubmit || this.loading.upload ){
                return;
            }
            this.errors = {};
            this.validationSchema.validate( this.formData, { abortEarly: false })
                                    .then( ( resValidate ) => {
                                        this.loading.formSubmit = true;
                                        this.$store.commit('setGlobalLoaderOn');
                                        this.$request.updateCompanySetting( this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! Company Setting updated successfully.';
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }

                                                            if( res.data?.data ){
                                                                this.$store.commit('setAuthUser', res.data.data);

                                                            }
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
        }
    }
}
</script>

<style>

</style>
