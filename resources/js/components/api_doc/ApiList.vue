<template>
    <page-header :title="pageTitle" >
    </page-header>
    <template v-if="currentUser?.current_company?.id">

        <div class="card items-center justify-between lg:flex-row mb-2">
            <div class="flex flex-col items-center p-4 text-center sm:p-5 lg:flex-row lg:space-x-4 lg:text-left">
                <div class="mt-2 lg:mt-0">
                    <div class="flex items-center justify-center space-x-1">
                        <h4 class="text-base font-medium text-slate-700 line-clamp-1 dark:text-navy-100">
                            Your Verification Token
                        </h4>
                        <button
                            v-if="currentUser?.current_company?.api_verify_token"
                            class="btn hidden h-6 rounded-full px-2 text-xs font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25 lg:inline-flex"
                            @click="copyText( currentUser?.current_company?.api_verify_token )">
                            Copy
                        </button>
                    </div>
                    <p class="text-xs+">{{ currentUser?.current_company?.api_verify_token ?? 'Not Available' }}</p>
                </div>

            </div>

        </div>
        <div class="grid grid-cols-1 gap-4 sm:gap-5 lg:gap-6">
            <div class="card items-center justify-between lg:flex-row" v-for="(item, idx) in api_list" :key="'api_doc_'+ idx">
                <div class="flex flex-col items-center p-4 text-center sm:p-5 lg:flex-row lg:space-x-4 lg:text-left">
                    <div class="mt-2 lg:mt-0">
                        <div class="flex space-x-1 mb-2">
                            <h4 class="text-base text-left font-medium text-slate-700 line-clamp-1 dark:text-navy-100 ">
                                {{ item.title }}
                            </h4>
                            <button
                                class="btn hidden h-6 rounded-full px-2 text-xs font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25 lg:inline-flex"
                                @click="copyUrl( item.platform )">
                                Copy
                            </button>
                        </div>
                        <p class="text-xs+ " style="overflow-wrap: anywhere;">{{ getUrl( item.platform ) }}</p>

                    </div>

                </div>

            </div>
        </div>
        <input type="text" ref="copyClipboard" class="absolute -top-[6rem] -left-[6rem]">
    </template>
    <no-data-found v-else />
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data(){
        return {
            pageTitle: 'API Documentation',
            api_list: [
                {
                    title: 'Magicbrick',
                    platform: 'magicbricks',
                    description: null
                },
                {
                    title: '99Acres.com',
                    platform: '99acres',
                    description: null
                },
                {
                    title: 'Housing.com',
                    platform: 'housing',
                    description: null
                },
                {
                    title: 'Makaan.com',
                    platform: 'makaan',
                    description: null
                },
                {
                    title: 'Facebook/Instagram',
                    platform: 'facebook',
                    description: null
                }
            ]
        }
    },
    created(){
    },
    mounted(){
        this.init();
    },
    computed:{
        ...mapGetters([
            'currentUser'
        ])
    },
    methods:{
        init () {
            this.$store.commit('setGlobalLoaderOff')
        },
        getUrl ( platform ) {
            return import.meta.env.VITE_BASE_API_URL + 'webook/' + this.currentUser?.current_company?.encrypt_id + '/leads/' + platform;
        },
        copyUrl ( platform ){
            this.copyText( this.getUrl(platform) );
        },
        copyText( content ){
            console.log(content);
            if( navigator?.clipboard ){
                navigator.clipboard.writeText( content ).then( () => {
                    this.$toast.info( 'Copied!' );
                });
            }else{
                this.$refs.copyClipboard.setAttribute('value', content);
                setTimeout(() => {

                    this.$refs.copyClipboard.focus();
                    this.$refs.copyClipboard.select();
                    document.execCommand("copy");
                    this.$toast.info( 'Copied!' );
                }, 200);
            }
        }
    }
}
</script>

<style>

</style>
