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
                                        v-model="formData.lead_status"
                                        value-field="name"
                                        form-label="Lead Status"
                                        placeholder="Select Lead Status"
                                        :is-ajax="true"
                                        request-name="leadStatusSelectList"
                                        :ajax-preload="true"
                                        :selected-item="formData.lead_status"
                                        :selected-options="formData.lead_status"
                                        :error-msg="errors?.lead_status"
                                    />
                            <label class="block" >
                                <span>Followup Date </span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="YYYY-MM-DD" type="date" name="followup_date" v-model="formData.followup_date">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-calendar-alt text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.followup_date?.length">{{ errors.followup_date.at(0) }}</span>
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

                            <div class="space-x-2 text-right">
                                <button
                                    @click="closeModal"
                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90"
                                >
                                    Cancel
                                </button>
                                <button
                                    @click="addComment"
                                    class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                                >
                                    Add Comment
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
import dayjs from 'dayjs';

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
                lead_status: null,
                followup_date: null,
                comment: null,
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
                comment: Yup.string()
                            .nullable(true)
                            .required('Required'),
                lead_status: Yup.string()
                            .nullable(true)
                            .required('Required'),
                followup_date: Yup.date()
                            .nullable(true)
                            .min( dayjs(), 'Must be later than today'  ),

            }
            const yup = Yup.object().shape( fields );

            return yup;
        }
    },
    methods:{
        closeModal () {
            this.$emit('close');
        },
        addComment() {
            if( this.loading.formSubmit ){
                return;
            }
            this.errors = {};
            this.validationSchema.validate( this.formData, { abortEarly: false })
                                    .then( ( resValidate ) => {
                                        this.loading.formSubmit = true;
                                        this.$store.commit('setGlobalLoaderOn');
                                        this.$request.addLeadComment( this.leadId, this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! Lead comment added successfully.';
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
