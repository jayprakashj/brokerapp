<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex place-content-center">
        <div class="card p-4 w-1/2 sm:p-5 ">

            <form @submit.prevent="submitForm">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ formData?.id ? 'Update Member' : 'Add New Member' }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <router-link to="/member"
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
                                        placeholder="Mobile" type="text" name="mobile" v-model="formData.mobile">
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
                                        v-model="formData.role"
                                        form-label="Role"
                                        placeholder="Select Role"
                                        :is-ajax="true"
                                        request-name="getRoleForMemberForm"
                                        :ajax-preload="true"
                                        :selected-item="selected.role_data?.id"
                                        :selected-options="selected.role_data"
                                        :error-msg="errors?.role"
                                    />
                            <input-tom-select
                                        v-model="formData.company_branch"
                                        form-label="Company Branch"
                                        placeholder="Select Branch"
                                        :is-ajax="true"
                                        request-name="companyBranchSelectList"
                                        :ajax-preload="true"
                                        :selected-item="selected.company_branch_data?.id"
                                        :selected-options="selected.company_branch_data"
                                        :error-msg="errors?.company_branch"
                                    />


                            <label class="block" >
                                <span>Password</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="****" type="password" name="password" v-model="formData.password">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-key text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.password?.length">{{ errors.password.at(0) }}</span>
                            </label>
                            <label class="block" >
                                <span>Confirm Password</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="****" type="password" name="confirm_password" v-model="formData.confirm_password">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-key text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.confirm_password?.length">{{ errors.confirm_password.at(0) }}</span>
                            </label>
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
            pageTitle: 'Member Management',
            subTitle: 'Add Member',
            isShowPopper: false,
            errors: {},
            formData:{
                name: '',
                role: null,
                logo: null,
                mobile: null,
                email: null,
                password: null,
                address: null,
                company_branch: null,
                confirm_password: null,
            },
            rolesList: [],
            loading:{
                formSubmit: false
            },
            media:{
                logo: null
            },
            selected:{
                company_branch_data: {},
                role_data: {},
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
                            title: 'Member Management',
                            link: '/member'
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
                email: Yup.string()
                            .nullable(true)
                            .required('Required')
                            .email( 'Must be a valid email address'),
                role: Yup.string()
                            .nullable(true)
                            .required('Required'),
                company_branch: Yup.string()
                            .nullable(true)
                            .required('Required'),
                mobile: Yup.string()
                            .nullable(true)
                            .required('Required')
                            .min( 10, 'Must be 10 digits')
                            .max( 10, 'Must be 10 digits'),
                password: Yup.string().nullable( true )
                                    .required('Required')
                                    .matches( /^[0-9A-Za-z]*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?][0-9a-zA-Z]*$/, 'Must contain 1 numeric, 1 alphabet and 1 special character')
                                    .min( 8, 'Minimum 8 characters required' ),
                confirm_password: Yup.string().nullable( true )
                                    .required('Required')
                                    .matches( /^[0-9A-Za-z]*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?][0-9a-zA-Z]*$/, 'Must contain 1 numeric, 1 alphabet and 1 special character')
                                    .min( 8, 'Minimum 8 characters required' )
                                    .oneOf([Yup.ref('password')], 'Not matched with new password.')

            }
            if( this.formData?.id ){
                fields['password']= Yup.string().nullable( true )
                                    .matches( /^[0-9A-Za-z]*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?][0-9a-zA-Z]*$/, 'Must contain 1 numeric, 1 alphabet and 1 special character')
                                    .min( 8, 'Minimum 8 characters required' ),
                fields['confirm_password'] = Yup.string().nullable( true )
                                    .matches( /^[0-9A-Za-z]*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?][0-9a-zA-Z]*$/, 'Must contain 1 numeric, 1 alphabet and 1 special character')
                                    .min( 8, 'Minimum 8 characters required' )
                                    .oneOf([Yup.ref('password')], 'Not matched with new password.')
            }
            const yup = Yup.object().shape( fields );

            return yup;
        }
    },
    methods:{
        init () {
            this.loadRolesList();
            if( this.$route?.params?.id ){
                this.loadEditFormDetail( this.$route.params.id );

            }else{
                this.$store.commit('setGlobalLoaderOff');
            }
        },
        loadEditFormDetail( id ){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getMemberDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.formData = Object.assign( this.formData, res.data.data);
                                    this.media.logo = this.formData.logo_url;
                                    delete this.formData.logo_url;
                                    Object.keys( this.selected ).forEach( d => {
                                        if( d in this.formData ){
                                            this.selected[ d ] = this.formData[ d ];
                                        }
                                    })
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
        loadRolesList(){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getRoleForMemberForm()
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.rolesList = res.data.data;
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
                                        this.$request.createMember( this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! Invitation has been sent successfully.';
                                                            if( this.formData?.id ){
                                                                message = 'Success! Member data updated successfully.';
                                                            }
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            this.$router.push({ name: 'member_lists' });
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
