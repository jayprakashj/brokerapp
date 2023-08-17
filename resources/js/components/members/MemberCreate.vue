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
                        <label class="block" v-if="!formData?.is_accepted">
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
                        <label class="block mt-2">
                            <span>Role</span>
                            <select
                                name="role_id"
                                v-model="formData.role"
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            >
                                <option :value="item.id" v-for="(item, idx) in rolesList" :key="'role_option_'+idx">{{ item.name }}</option>

                            </select>

                            <span class="text-tiny+ text-error" v-if="errors?.role?.length">{{ errors.role.at(0) }}</span>
                        </label>

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
            pageTitle: 'Member Management',
            subTitle: 'Add Member',
            isShowPopper: false,
            errors: {},
            formData:{
                company_name: '',
                role: null
            },
            rolesList: [],
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
                email: Yup.string()
                            .nullable(true)
                            .required('Required')
                            .email( 'Must be a valid email address'),
                role: Yup.string()
                            .nullable(true)
                            .required('Required'),

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
        }
    }
}
</script>

<style>

</style>
