<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex place-content-center">
        <div class="card p-4 w-7/12 sm:p-5 ">

            <form @submit.prevent="submitForm">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ formData?.id ? 'Update Contact' : 'Add New Contact' }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <router-link to="/contact"
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

                        <div class="flex flex-col">
                            <span class="text-base font-medium text-slate-600 dark:text-navy-100">Logo</span>
                            <div class="avatar mt-1.5 h-20 w-20">
                                <span class="w-full flex place-content-center fa-2x items-center" v-if="loading.upload">
                                    <i class="fa fa-spin fa-spinner" ></i>

                                </span>
                                <template v-else>
                                    <img class="mask is-squircle" :src="(media.logo || '/images/100x100.png')" alt="avatar">
                                    <input type="file" name="logo" id="logo" class="hidden" ref="mediaLogo" @change="uploadMedia">
                                    <div class="absolute bottom-0 right-0 flex items-center justify-center rounded-full bg-white dark:bg-navy-700">
                                        <button
                                            type="button"
                                            @click="openLogoUpload"
                                            class="btn h-6 w-6 rounded-full border border-slate-200 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:border-navy-500 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block" >
                                <span>Name</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Name" type="text" name="name" v-model="formData.name">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-user text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.name?.length">{{ errors.name.at(0) }}</span>
                            </label>
                            <label class="block" >
                                <span>Mobile</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Name" type="text" name="mobile" v-model="formData.mobile">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-phone text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.mobile?.length">{{ errors.mobile.at(0) }}</span>
                            </label>

                            <label class="block" >
                                <span>Email</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Email..." type="email" name="email" v-model="formData.email">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-envelope text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.email?.length">{{ errors.email.at(0) }}</span>
                            </label>
                            <input-tom-select
                                        v-model="formData.gender"
                                        form-label="Gender"
                                        placeholder="Select Gender"
                                        :options="$genders"
                                        :selected-item="selected.gender"
                                        :error-msg="errors?.gender"
                                    />
                            <input-tom-select
                                        v-model="formData.contact_type"
                                        form-label="Contact Type"
                                        placeholder="Select Contact Type"
                                        :is-ajax="true"
                                        request-name="contactTypeSelectList"
                                        :allow-create="true"
                                        :ajax-preload="true"
                                        :selected-item="selected.contact_type?.id"
                                        :selected-options="selected.contact_type"
                                        :error-msg="errors?.contact_type"
                                    />
                            <input-tom-select
                                        v-model="formData.customer_type"
                                        form-label="Customer Type"
                                        placeholder="Select Customer Type"
                                        :is-ajax="true"
                                        request-name="customerTypeSelectList"
                                        :allow-create="true"
                                        :ajax-preload="true"
                                        :selected-item="selected.customer_type?.id"
                                        :selected-options="selected.customer_type"
                                        :error-msg="errors?.contact_type"
                                    />
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block col-span-2">
                                <span>Address</span>
                                <label class="block">
                                    <textarea
                                    rows="4"
                                    placeholder="Address"
                                    v-model="formData.address"
                                    class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    ></textarea>
                                </label>

                                <span class="text-tiny+ text-error" v-if="errors?.address?.length">{{ errors.address.at(0) }}</span>
                            </label>
                            <label class="block" >
                                <span>City</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="City" type="text" name="city" v-model="formData.city">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-building text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.city?.length">{{ errors.city.at(0) }}</span>
                            </label>
                            <label class="block" >
                                <span>Locality</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Locality" type="text" name="locality" v-model="formData.locality">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-location-crosshairs text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.locality?.length">{{ errors.locality.at(0) }}</span>
                            </label>
                            <label class="block" >
                                <span>Pincode</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Pinicode" type="text" name="pincode" v-model="formData.pincode">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-location-dot text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.pincode?.length">{{ errors.pincode.at(0) }}</span>
                            </label>
                            <label class="block col-span-2">
                                <span>Comment</span>
                                <label class="block">
                                    <textarea
                                    rows="4"
                                    placeholder="Comment"
                                    v-model="formData.comment"
                                    class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    ></textarea>
                                </label>

                                <span class="text-tiny+ text-error" v-if="errors?.comment?.length">{{ errors.comment.at(0) }}</span>
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
            pageTitle: 'Contact Management',
            subTitle: 'Add Contact',
            isShowPopper: false,
            errors: {},
            formData:{
                name: '',
                mobile: null,
                email: null,
                contact_type: null,
                customer_type: null,
                address: null,
                city: null,
                locality: null,
                pincode: null,
                comment: null,
                gender: null,
            },
            rolesList: [],
            loading:{
                formSubmit: false,
                upload: false
            },
            media:{
                logo: null
            },
            selected:{
                contact_type: {},
                customer_type: {},
                gender: {},
            },
            selectedOptions:{
                contact_type: [],
                customer_type: [],

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
                            title: 'Contact Management',
                            link: '/contact'
                        },
                        {
                            title: (this.formData?.id ? 'Edit': 'Create'),
                        }
                    ];
            return breadcrumbs;
        },
        validationSchema(){
            let fields = {
                name: Yup.string()
                            .nullable(true)
                            .required('Required'),
                mobile: Yup.string()
                            .nullable(true)
                            .required('Required')
                            .min( 10, 'Must be 10 digits')
                            .max( 10, 'Must be 10 digits'),
                email: Yup.string()
                            .nullable(true)
                            .email( 'Must be a valid email address'),
                pincode: Yup.string()
                            .nullable(true)
                            .max( 6, 'Maximum 6 digis allowed'),
                gender: Yup.string()
                            .nullable(true)
                            .required('Required'),

            }
            const yup = Yup.object().shape( fields );

            return yup;
        }
    },
    methods:{
        init () {
            if( this.$route?.params?.id ){
                this.loadEditFormDetail( this.$route.params.id );

            }else{
                this.$store.commit('setGlobalLoaderOff');
            }
        },
        loadEditFormDetail( id ){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getContactDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.formData = Object.assign( this.formData, res.data.data);
                                    this.selected.contact_type = this.formData.contact_type_data;
                                    this.selected.customer_type = this.formData.customer_type_data;
                                    this.selected.gender = this.formData.gender;
                                    this.media.logo = this.formData.logo_url;
                                    delete this.formData.logo_url;
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
                                        this.$request.createContact( this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! New Contact added successfully.';
                                                            if( this.formData?.id ){
                                                                message = 'Success! Contact data updated successfully.';
                                                            }
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            this.$router.push({ name: 'contact_lists' });
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
        }
    }
}
</script>

<style>

</style>
