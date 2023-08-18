<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex place-content-center">
        <div class="card w-9/12 p-4 sm:p-5">
            <form @submit.prevent="submitForm">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ formData?.id ? 'Update Company Details' : 'New Company' }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <router-link to="/company"
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
                                    <input type="file" name="company_logo" id="company_logo" class="hidden" ref="companyLogo" @change="uploadMedia">
                                    <div class="absolute bottom-0 right-0 flex items-center justify-center rounded-full bg-white dark:bg-navy-700">
                                        <button
                                            type="button"
                                            @click="openCompanyLogo"
                                            class="btn h-6 w-6 rounded-full border border-slate-200 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:border-navy-500 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 items-center">
                            <label class="block">
                                <span>Company name</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Your Company" type="text" name="company_name" v-model="companyDetail.company_name">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-building text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.company_name?.length">{{ errors.company_name.at(0) }}</span>
                            </label>
                            <label class="block">
                                <span>PAN No.</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="XXXXX1111X" type="text" name="pan_no" v-model="companyDetail.pan_no">
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.pan_no?.length">{{ errors.pan_no.at(0) }}</span>
                            </label>
                            <label class="block">
                                <span>GST No.</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="GST No" type="text" name="gst_no" v-model="companyDetail.gst_no">
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.gst_no?.length">{{ errors.gst_no.at(0) }}</span>
                            </label>
                            <label class="block">
                                <span>Email</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="abc@example.com" type="email" name="email" v-model="companyDetail.email">
                                        <span
                                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                <i class="fa fa-envelope text-base"></i>
                                            </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.email?.length">{{ errors.email.at(0) }}</span>
                            </label>
                            <label class="block">
                                <span>Mobile</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="1234567890" type="text" name="mobile" v-model="companyDetail.mobile">

                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-phone  text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.mobile?.length">{{ errors.mobile.at(0) }}</span>
                            </label>

                            <div class="flex-wrap items-start space-y-2 pt-2 sm:flex sm:space-x-5 sm:space-y-0" >
                                <label class="inline-flex items-center space-x-2">
                                    <input
                                        name="status"
                                        class="form-checkbox is-basic h-5 w-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                        type="checkbox"
                                        :value="1"
                                        v-model="companyDetail.status"
                                        >
                                    <span>Active?</span>
                                </label>
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
            pageTitle: 'Company Management',
            subTitle: 'Create Company',
            isShowPopper: false,
            breadcrumbs:[
                {
                    title: 'Company Management',
                    link: '/company'
                },
                {
                    title: 'Create',
                }
            ],
            errors: {},
            companyDetail:{
                company_name: '',
                pan_no: '',
                gst_no: '',
                email: '',
                mobile: '',
                logo: '',
                status: 0
            },
            loading:{
                formSubmit: false,
                upload: false
            },
            media:{
                logo: null
            }
        }
    },
    mounted(){
        this.init();
    },
    computed:{
        validationSchema(){
            let fields = {
                company_name: Yup.string()
                            .nullable(true)
                            .required('Required')
                            .min('2', 'Must have at least 2 characters'),
                pan_no: Yup.string().nullable( true )
                            .required('Required')
                            .matches(/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/, 'Enter valid PAN no.'),
                gst_no: Yup.string().nullable( true )
                            .required('Required')
                            .matches(/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/, 'Enter valid PAN no.'),
                email: Yup.string().nullable( true )
                            .required('Required')
                            .email('Must be a valid email address'),
                mobile: Yup.string().nullable( true )
                            .required('Required')
                            .min(10,'must be 10 digits')
                            .max(10,'must be 10 digits')

            }
            const yup = Yup.object().shape( fields );

            return yup;
        }
    },
    methods:{
        init () {
            if( this.$route?.params?.id ){
                this.loadCompanyDetail( this.$route.params.id );

            }else{
                this.$store.commit('setGlobalLoaderOff');
            }
        },
        loadCompanyDetail( id ){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getCompanyDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.companyDetail = Object.assign( this.companyDetail, res.data);
                                    this.media.logo = this.companyDetail.logo_url;
                                    delete this.companyDetail.logo_url;
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
            this.validationSchema.validate( this.companyDetail, { abortEarly: false })
                                    .then( ( resValidate ) => {
                                        this.loading.formSubmit = true;
                                        this.$store.commit('setGlobalLoaderOn');
                                        this.$request.createCompany( this.companyDetail )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! Company created successfully.';
                                                            if( this.companyDetail?.id ){
                                                                message = 'Success! Company data update successfully.';
                                                            }
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            this.$router.push({ name: 'company_lists' });
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

                                        console.log( e);
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
        openCompanyLogo(){
            this.$refs.companyLogo.click();
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
                                            this.companyDetail.logo = tmpFile.id;
                                            this.media.logo = tmpFile.url;
                                        }else{

                                            this.$toast.error( 'Oops!' );
                                        }
                                        console.log( res.data );
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
