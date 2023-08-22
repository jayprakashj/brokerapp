<template>
    <page-header :title="pageTitle" />
    <div class="py-5 text-center lg:py-6">
        <p class="text-sm uppercase">Invitation!</p>
        <h3 class="mt-1 text-xl font-semibold text-slate-600 dark:text-navy-100">
        You've received the request to join the company.
        </h3>
    </div>
    <div class="grid  place-items-center" v-if="invitationData">
        <div class="card grow items-center p-4 sm:p-5 " >
            <div class="avatar h-20 w-20">
                <img class="rounded-full" src="/public/images/100x100.png" alt="avatar">
                <div
                    class="absolute right-0 m-1 h-4 w-4 rounded-full border-2 border-white bg-primary dark:border-navy-700 dark:bg-accent">
                </div>
            </div>
            <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                {{ invitationData.company_name }}
            </h3>
            <div class="my-4 h-px w-full bg-slate-200 dark:bg-navy-500"></div>
            <div class="grow space-y-4">
                <div class="flex items-center space-x-4">
                    <div
                        class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                        <i class="fa fa-phone text-xs"></i>
                    </div>
                    <p>{{ invitationData.company_phone}}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div
                        class="flex h-7 w-7 items-center rounded-lg bg-primary/10 p-2 text-primary dark:bg-accent-light/10 dark:text-accent-light">
                        <i class="fa fa-envelope text-xs"></i>
                    </div>
                    <p>{{ invitationData.company_email }}</p>
                </div>
            </div>
            <div class="mt-5 space-x-2">

                <button v-if="invitationData.is_pending"
                        @click="acceptInvitation"
                    class="btn mt-8 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    <i class="fa fa-check"></i> <span class="ml-2"> Accept </span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            pageTitle: 'Invitation',
            isShowPopper: false,
            invitationData: null,
        }
    },
    created(){
    },
    mounted(){
        this.init();
    },
    methods:{
        init () {
            this.loadInvitation();
        },
        loadInvitation(){
            this.$store.commit('setGlobalLoaderOn')
            this.$request.fetchInvitation( this.$route.params.token )
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.invitationData = res.data.data;
                                }
                            },
                            (err) => {

                            }
                        ).finally(
                            () => {
                                this.$store.commit('setGlobalLoaderOff')
                            }
                        )
        },
		acceptInvitation( ){
            this.$store.commit('setGlobalLoaderOn');
            this.$request
                .acceptInvitation( this.$route.params.token )
                    .then(
                        ( res ) => {
                            let message = 'Success! Invitation accepted successfully.';
                            this.$router.push({ name: 'company_lists' });
                            this.$toast.info( message );
                        },
                        ( err ) => {
                            let message = 'Error! There is error occured while processing request.';
                            if( err?.response?.data?.message ){
                                message = err.response.data.message;
                            }
                            this.$toast.error( message );
                        }
                    ).finally(
                        () => {
                            this.$store.commit('setGlobalLoaderOff');
                        }
                    );
		},
    }
}
</script>

<style>

</style>
