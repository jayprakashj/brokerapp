<template>
    <div class="flex place-content-center" :class="{'gap-4': formData?.id}">
        <div class="card p-4 w-7/12 sm:p-5 ">

            <form @submit.prevent="submitForm">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ formTitle }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <a href="/"
                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                Cancel
                            </a>
                            <button type="submit"
                                class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                Submit
                            </button>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">

                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block h-full" >
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
                            <label class="block h-full" >
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

                            <label class="block h-full" >
                                <span>Email</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Email" type="email" name="email" v-model="formData.email">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-envelope text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.email?.length">{{ errors.email.at(0) }}</span>
                            </label>

                            <label class="block h-full" >
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

                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <input-tom-select
                                            class="h-full"
                                            v-model="formData.property_type"
                                            form-label="Property Type"
                                            placeholder="Select Property Type"
                                            :is-multiple="true"
                                            :tomOptions="propertyTypeTomOptions"
                                            :options="options.property_sub_types"
                                            :error-msg="errors?.property_type"
                                            :selected-item="formData.property_type"
                                        />
                            <label class="block h-full" v-if="isBuyerEnqiry">
                                <span>Interest In</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Interest" type="text" name="interest_in" v-model="formData.interest_in">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-thumbs-up text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.interest_in?.length">{{ errors.interest_in.at(0) }}</span>
                            </label>

                            <label class="block h-full" >
                                <span>Budget</span>
                                <span class="relative flex gap-2">
                                    <div class="h-full">
                                        <span class="relative mt-1.5 flex">
                                            <input
                                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                placeholder="Min Budget" type="text" name="min_budget" v-model="formData.min_budget">
                                            <span
                                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                <i class="fa fa-inr text-base"></i>
                                            </span>
                                        </span>
                                        <span class="text-tiny+ text-error" v-if="errors?.min_budget?.length">{{ errors.min_budget.at(0) }}</span>
                                    </div>
                                    <div class="h-full">
                                        <span class="relative mt-1.5 flex">
                                            <input
                                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                placeholder="Max Budget" type="text" name="max_budget" v-model="formData.max_budget">
                                            <span
                                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                <i class="fa fa-inr text-base"></i>
                                            </span>
                                        </span>
                                        <span class="text-tiny+ text-error" v-if="errors?.max_budget?.length">{{ errors.max_budget.at(0) }}</span>
                                    </div>
                                </span>

                            </label>

                            <label class="block h-full col-span-2">
                                <span>Remark</span>
                                <label class="block">
                                    <textarea
                                    rows="4"
                                    placeholder="Remark"
                                    v-model="formData.remark"
                                    class="form-textarea w-full rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    ></textarea>
                                </label>

                                <span class="text-tiny+ text-error" v-if="errors?.remark?.length">{{ errors.remark.at(0) }}</span>
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
import { mapGetters } from 'vuex' ;

export default {
    data(){
        return {
            pageTitle: 'Enquiry Form',
            isShowPopper: false,
            errors: {},
            formData:{
                name: '',
                mobile: null,
                email: null,
                city: null,
                min_budget: null,
                max_budget: null,
                interest_in: null,
                remark: null,
                property_type: []
            },
            loading:{
                formSubmit: false,
            },
            buyerKeys: [
                'buy',
                'rent_tenant'
            ],
            options:{
                'property_types': [],
                'property_sub_types': [],
            },
        }
    },
    mounted(){
        this.init();
    },
    computed:{
        formType() {
            return this.$route.params.type
        },
        formTitle (){
            if( this.formType ){
                const findRecord = this.$enquiryTypes.find( d => d.id == this.formType );
                if( findRecord ){
                    return 'Enquiry Form for ' + findRecord.title;
                }
            }
            return null;
        },
        isBuyerEnqiry(){
            return this.buyerKeys.includes( this.formType );
        },
        propertyTypeTomOptions () {
            let options = {
                    optgroups: this.options.property_types,
                    optgroupField: 'property_type_id',
                    render:{
                        optgroup_header: ( data, escape ) => {
                            return '<div class="border-gray-700 p-2 font-bold text-primary border-b mb-1">' + escape(data.label) + '</div>';
                        }
                    }
                };
            return options;
        },
        validationSchema(){
            let fields = {
                name: Yup.string()
                            .nullable(true)
                            .required('Required'),
                city: Yup.string()
                            .nullable(true)
                            .required('Required'),
                mobile: Yup.string()
                            .nullable(true)
                            .required('Required')
                            .min( 10, 'Must be 10 digits')
                            .max( 10, 'Must be 10 digits'),
                email: Yup.string()
                            .nullable(true)
                            .required('Required')
                            .email( 'Must be a valid email address'),
                property_type: Yup.array()
                            .min(1, 'Required'),

                remark: Yup.string()
                            .nullable(true)
                            .required('Required'),

                min_budget: Yup.number()
                            .positive()
                            .typeError('Must be a valid digit')
                            .nullable(true)
                            .required('Required')
                            .min(1, 'Must be greater than 1'),

                max_budget: Yup.number()
                            .positive()
                            .typeError('Must be a valid digit')
                            .nullable(true)
                            .required('Required')
                            .min(1, 'Must be greater than 1'),

            }

            if( this.isBuyerEnqiry ){
                fields['interest_in'] = Yup.string()
                                                .nullable(true)
                                                .required('Required');
            }
            const yup = Yup.object().shape( fields );

            return yup;
        }
    },
    methods:{
        init () {
            this.loadSelectListData();
            this.$store.commit('setGlobalLoaderOff');
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
                                        const data = {
                                            enquiry_type: this.formType,
                                            ...this.formData
                                        }
                                        this.$request.createEnquiryRequest( data )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! Enquiry form has been submited successfully.';
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            this.$toast.info( message );
                                                            this.resetForm();
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
        loadSelectListData(){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.enquiryFormDropdownList()
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.options = Object.assign( this.options, res.data);
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
        resetForm () {
            this.formData = {
                name: '',
                mobile: null,
                email: null,
                city: null,
                budget: null,
                interest_in: null,
                remark: null,
                property_type: []
            };
        }
    }
}
</script>

<style>

</style>
