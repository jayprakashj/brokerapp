<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div class="flex place-content-center">
        <div class="card p-4 w-7/12 sm:p-5 ">

            <form @submit.prevent="submitForm">
                <div class="card">
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ formData?.id ? 'Update Document' : 'Add New Document' }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <router-link to="/document"
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

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-1 items-center">
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
                                <span>Description</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Description" type="text" name="description" v-model="formData.description">
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-pencil text-base"></i>
                                    </span>
                                </span>

                                <span class="text-tiny+ text-error" v-if="errors?.description?.length">{{ errors.description.at(0) }}</span>
                            </label>


                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>

                        <div class="flex flex-col">
                            <span class="text-base font-medium text-slate-600 dark:text-navy-100">Attachment</span>
                            <label
                                class="btn w-1/2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                            >
                                <input
                                    tabindex="-1"
                                    type="file"
                                    ref="mediaAttachment" @change="uploadMedia"
                                    class="pointer-events-none absolute inset-0 h-full w-full opacity-0"
                                />
                                <div class="flex items-center space-x-2">

                                    <i class="fa fa-upload"></i>
                                    <span>Choose File</span>
                                </div>
                            </label>
                            <div class="avatar mt-1.5 h-20 w-20" v-if="loading.upload || media.attachment">
                                <span class="w-full flex place-content-center fa-2x items-center" v-if="loading.upload">
                                    <i class="fa fa-spin fa-spinner" ></i>

                                </span>
                                <template v-if="!loading.upload && media.attachment">

                                    <a :href="media.attachment" target="_blank" class="m-auto">
                                        <i class="fa fa-file fa-4x" ></i>
                                    </a>
                                    <div class="absolute bottom-0 right-0 flex items-center justify-center rounded-full bg-white dark:bg-navy-700">
                                        <button
                                            type="button"
                                            @click="removeAttachment"
                                            class="btn h-6 w-6 rounded-full border border-slate-200 p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:border-navy-500 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 text-red-500">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="my-7 h-px bg-slate-200 dark:bg-navy-500"></div>
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 items-center">
                            <label class="block col-span-2">
                                <span>Content</span>
                                <div class="h-48" ref="contentQuill">
                                </div>

                                <span class="text-tiny+ text-error" v-if="errors?.content?.length">{{ errors.content.at(0) }}</span>
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
import Quill from "quill/dist/quill.min";

export default {
    data(){
        return {
            pageTitle: 'Document Management',
            subTitle: 'Add Document',
            isShowPopper: false,
            errors: {},
            formData:{
                name: null,
                description: null,
                content: null,
                attachment: null,
            },
            loading:{
                formSubmit: false,
                upload: false
            },
            media:{
                attachment: null
            },
            contentQuill: null
        }
    },
    mounted(){
        this.init();
    },
    computed:{
        breadcrumbs(){

            var breadcrumbs = [
                        {
                            title: 'Document Management',
                            link: '/document'
                        },
                        {
                            title: (this.formData?.id ? 'Edit': 'Create'),
                        }
                    ];
            if( this.formData?.property_id ){
                breadcrumbs = [
                        {
                            title: 'Property Management',
                            link: '/property'
                        },
                        {
                            title: (this.formData.property_name || ''),
                            link: '/property/view/' + this.formData.property_id
                        },
                        {
                            title: 'Property Documents',
                            link: '/property/' + this.formData.property_id + '/documents'
                        },
                        {
                            title: (this.formData.property_name || 'Update')
                        }
                    ];
            }
            return breadcrumbs;
        },
        validationSchema(){
            let fields = {
                name: Yup.string()
                            .nullable(true)
                            .required('Required'),
                description: Yup.string()
                            .nullable(true)
                            .required('Required'),
                content: Yup.string()
                            .nullable(true)
                            .required('Required'),

            }
            const yup = Yup.object().shape( fields );

            return yup;
        },
        quillOptions(){
            return  {
                modules : {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                        ['blockquote', 'code-block'],
                        [{ header: 1 }, { header: 2 }], // custom button values
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        [{ script: 'sub' }, { script: 'super' }], // superscript/subscript
                        [{ indent: '-1' }, { indent: '+1' }], // outdent/indent
                        [{ direction: 'rtl' }], // text direction
                        [{ size: ['small', false, 'large', 'huge'] }], // custom dropdown
                        [{ header: [1, 2, 3, 4, 5, 6, false] }],
                        [{ color: [] }, { background: [] }], // dropdown with defaults from theme
                        [{ font: [] }],
                        [{ align: [] }],
                        ['clean'], // remove formatting button
                    ],
                },
                placeholder: 'Enter your content...',
                theme: 'snow',
            }
        }
    },
    methods:{
        init () {
            if( this.$route?.params?.id ){
                this.loadEditFormDetail( this.$route.params.id );

            }else{
                this.quillInit();
                this.$store.commit('setGlobalLoaderOff');
            }
        },
        quillInit(){
            this.$nextTick( () => {
                this.contentQuill = new Quill( this.$refs.contentQuill, this.quillOptions );
                this.contentQuill.root.innerHTML =  this.formData.content ;
            })
        },
        loadEditFormDetail( id ){
            this.$store.commit('setGlobalLoaderOn');
            this.$request.getDocumentDetail( id )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.formData = Object.assign( this.formData, res.data.data);
                                    this.media.attachment = this.formData.attachment_url;
                                    delete this.formData.attachment_url;
                                    this.quillInit();
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
            const data = Object.assign( this.formData, {content: this.contentQuill.root.innerHTML });
            this.validationSchema.validate( data, { abortEarly: false })
                                    .then( ( resValidate ) => {
                                        this.loading.formSubmit = true;
                                        this.$store.commit('setGlobalLoaderOn');
                                        this.$request.createDocument( this.formData )
                                                    .then(
                                                        ( res ) => {
                                                            let message = 'Success! New Document added successfully.';
                                                            if( this.formData?.id ){
                                                                message = 'Success! Document data updated successfully.';
                                                            }
                                                            if( res.data?.message ){
                                                                message = res.data.message;
                                                            }
                                                            if( this.formData?.property_id ){

                                                                this.$router.push({ name: 'property_document', params: { id: this.formData.property_id} } );
                                                            }else{
                                                                this.$router.push({ name: 'document_lists' });
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
        },
        removeAttachment(){
            this.formData.attachment = null;
            this.media.attachment = null;
        },
        openAttachmentUpload(){
            this.$refs.mediaAttachment.click();
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
                                            this.formData.attachment = tmpFile.id;
                                            this.media.attachment = tmpFile.url;
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
