<template>
    <page-header :title="pageTitle" />
    <div class="grid place-items-center" v-if="invitationData">
        <div class="card mt-20 w-1/2">
            <div class="flex grow flex-col items-center px-4 pb-5 sm:px-5">
                <h3 class="pt-3 text-lg font-medium text-slate-700 dark:text-navy-100">
                    {{ invitationData.company_name }}
                </h3>
                <p class="text-xs+">Creator: <b>{{ invitationData.creator ?? '' }}</b></p>
                <div class="mt-6 w-full " v-if="invitationData.is_pending">
                    <button type="button" @click="acceptInvitation" class="btn space-x-2 w-1/2 m-auto bg-primary px-0 font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                        <i class="fa fa-check"></i>
                        <span>Accept</span>
                    </button>
                </div>
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
