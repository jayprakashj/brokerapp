<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex place-content-center" :class="{'gap-4': formData?.id}">
        <div class="card p-4 w-7/12 sm:p-5 ">

            <form @submit.prevent="submitForm">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ formData?.id ? 'Update Task' : 'Add New Task' }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <router-link to="/task"
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
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block h-full col-span-2" >
                                <span>Title</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Title" type="text" name="title" v-model="formData.title">
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.title?.length">{{ errors.title.at(0) }}</span>
                            </label>
                            <div class="my-7 h-px bg-slate-200 dark:bg-navy-500 col-span-2"></div>

                            <label class="block h-full" >
                                <span>Scheduled Date </span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="YYYY-MM-DD" type="date" name="scheduled_date" v-model="formData.scheduled_date">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-calendar-alt text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.scheduled_date?.length">{{ errors.scheduled_date.at(0) }}</span>
                            </label>
                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.status"
                                        form-label="Status"
                                        placeholder="Select Status"
                                        :is-ajax="true"
                                        request-name="taskStatusDropdownList"
                                        :ajax-preload="true"
                                        :selected-item="formData.status"
                                        :selected-options="formData.status"
                                        :error-msg="errors?.status"
                                    />

                            <input-tom-select
                                        class="h-full"
                                        v-model="formData.assign_to"
                                        form-label="Assign To"
                                        placeholder="Select Assign To"
                                        :is-ajax="true"
                                        request-name="companyMembersSelectList"
                                        :ajax-preload="true"
                                        :selected-item="selected.assign_user_data?.id"
                                        :selected-options="selected.assign_user_data"
                                        :error-msg="errors?.assign_to"
                                    />
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">

                            <label class="block h-full col-span-2">
                                <span>Description</span>
                                <label class="block">
                                    <textarea
                                    rows="4"
                                    placeholder="Description"
                                    v-model="formData.description"
                                    class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    ></textarea>
                                </label>

                                <span class="text-tiny+ text-error" v-if="errors?.description?.length">{{ errors.description.at(0) }}</span>
                            </label>
                            <label class="block h-full col-span-2">
                                <span>Remark</span>
                                <label class="block">
                                    <textarea
                                    rows="4"
                                    placeholder="Remark"
                                    v-model="formData.remark"
                                    class="form-textarea w-full resize-none rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
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
            pageTitle: 'Task Management',
            subTitle: 'Add Task',
            isShowPopper: false,
            errors: {},
            formData:{
                title: '',
                assign_to: null,
                scheduled_date: null,
                status: null,
                remark: null,
                description: null,
            },
            rolesList: [],
            loading:{
                formSubmit: false,
                upload: false
            },
            selected:{
                assign_user_data: {},
            },
        }
    },
    mounted(){
        this.init();
    },
    computed:{
        ...mapGetters([
            'globalPermissions',
            'userPermissions'
        ]),
        breadcrumbs(){

            var breadcrumbs = [
                        {
                            title: 'Task Management',
                            link: '/task'
                        },
                        {
                            title: (this.formData?.id ? 'Edit': 'Create'),
                        }
                    ];
            return breadcrumbs;
        },
        validationSchema(){
            let fields = {
                title: Yup.string()
                            .nullable(true)
                            .required('Required'),
                description: Yup.string()
                            .nullable(true)
                            .required('Required'),
                status: Yup.string()
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
            this.$request.getTaskDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.formData = Object.assign( this.formData, res.data.data);
                                    this.selected.assign_user_data = this.formData.assign_user_data;
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
                                        this.$request.createTask( this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! New Task added successfully.';
                                                            if( this.formData?.id ){
                                                                message = 'Success! Task data updated successfully.';
                                                            }
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            this.$router.push({ name: 'task_lists' });
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
