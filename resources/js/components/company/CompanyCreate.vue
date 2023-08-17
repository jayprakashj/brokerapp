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

                        <div class="flex-wrap items-start space-y-2 pt-2 sm:flex sm:space-x-5 sm:space-y-0">
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

                        <div class="flex justify-end space-x-2">
                            <button
                            type="submit"
                                class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                <i class="fa fa-save"></i>
                                <span v-if="companyDetail?.id">Update</span>
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
                status: 0
            },
            loading:{
                formSubmit: false
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
                                console.log( res.data );
                                if( res.data ){
                                    this.companyDetail = Object.assign( this.companyDetail, res.data);
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
