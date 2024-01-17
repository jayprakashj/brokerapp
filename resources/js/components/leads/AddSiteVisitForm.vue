<template>
    <div
        class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
        role="dialog"
      >
      <Transition type="animation"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                <div
                      class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                  ></div>

      </Transition>
      <Transition type="animation"
                    enter-from-class="opacity-0 scale-95"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="easy-in"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-95"
                >
                <div
                    class="relative w-full max-w-lg origin-top rounded-lg bg-white transition-all duration-300 dark:bg-navy-700"
                    >
                    <div
                        class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5"
                    >
                        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                            {{ title }}
                        </h3>
                        <button
                            @click="closeModal"
                                class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                            >
                        <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="px-4 py-4 sm:px-5">
                        <p v-if="modalDescription">
                            {{modalDescription}}
                        </p>
                        <div class="mt-4 space-y-4">
                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.type"
                                        form-label="Type"
                                        placeholder="Select Type"
                                        :options="options.types"
                                        :selected-item="formData.type"
                                        :error-msg="errors?.type"
                                    />
                            <input-tom-select
                                        v-if="formData.type == 'property'"
                                        class="h-full"
                                        v-model="formData.property_id"
                                        form-label="Property"
                                        placeholder="Select Property"
                                        :options="options.properties"
                                        :selected-item="formData.property_id"
                                        :error-msg="errors?.property_id"
                                    />
                            <input-tom-select
                                        v-if="formData.type == 'project'"
                                        class="h-full"
                                        v-model="formData.project_id"
                                        form-label="Project"
                                        placeholder="Select Project"
                                        :options="options.projects"
                                        :selected-item="formData.project_id"
                                        :error-msg="errors?.project_id"
                                    />

                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.visit_type"
                                        form-label="Visit Type"
                                        placeholder="Select Visit Type"
                                        :options="options.visit_types"
                                        :selected-item="formData.visit_type"
                                        :error-msg="errors?.visit_type"
                                    />


                            <span class="text-tiny+ text-error" v-if="errors?.latitude?.length">* {{ errors.latitude.at(0) }}</span>
                            <span class="text-tiny+ text-error" v-else-if="errors?.longitude?.length">* {{ errors.longitude.at(0) }}</span>
                            <div class="space-x-2 text-right">
                                <button
                                    @click="closeModal"
                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90"
                                >
                                    Cancel
                                </button>
                                <button
                                    @click="addRecord"
                                    class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                                >
                                    Add Site Visit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

      </Transition>
    </div>
</template>

<script>
import * as Yup from 'yup';

export default {
    props:{
        title:{
            type: String,
            default: null
        },
        modalDescription:{
            type: String,
            default: null
        },
        leadId:{
            type: [String, Number],
            default: null
        }
    },
    data(){
        return {
            formData:{
                lead_id: this.leadId,
                type: null,
                visit_type: "Direct Visit",
                project_id: null,
                property_id: null,
                comment: "Automated: Site visit added from the lead form."
            },
            options:{
                types: [],
                projects: [],
                properties: [],
                visit_types: [],
            },
            loading:{
                formData: false
            },
            errors: {}
        }
    },
    computed:{
        validationSchema(){
            let fields = {
                // latitude: Yup.string()
                //             .nullable(true)
                //             .required('Current location positions is required'),
                // longitude: Yup.string()
                //             .nullable(true)
                //             .required('Current location positions is required'),
                type: Yup.string()
                            .nullable(true)
                            .required('Required'),
                visit_type: Yup.string()
                            .nullable(true)
                            .required('Required'),
                property_id: Yup.string()
                            .nullable(true)
                            .when("type", (data, schema) => {
                                if( data.at(0) == 'property'){

                                    return schema.required('Required')
                                }
                                return schema;
                            }),
                project_id: Yup.string()
                            .nullable(true)
                            .when("type", (data, schema) => {
                                if( data.at(0) == 'project'){

                                    return schema.required('Required')
                                }
                                return schema;
                            }),

            }
            const yup = Yup.object().shape( fields );

            return yup;
        }
    },
    created(){
        this.init();
    },
    methods:{
        init(){
            // this.getCurrentLatLong();
            this.loadSelectListData();
        },
        closeModal () {
            this.$emit('close');
        },
        loadSelectListData(){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.siteVisitFormDropdownList()
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
        getCurrentLatLong(){
            navigator.geolocation.getCurrentPosition( ( res ) => {
                if( res.coords ){
                    const coord = res.coords;
                    this.formData.latitude = coord.latitude;
                    this.formData.longitude = coord.longitude;
                }
            });
        },
        addRecord() {
            if( this.loading.formSubmit ){
                return;
            }
            this.errors = {};
            this.validationSchema.validate( this.formData, { abortEarly: false })
                                    .then( ( resValidate ) => {
                                        this.loading.formSubmit = true;
                                        this.$store.commit('setGlobalLoaderOn');
                                        this.$request.addLeadSiteVisit( this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! Site Visit added successfully.';
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            this.$emit('onAdded', this.formData);
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
    }
}
</script>

<style>

</style>
