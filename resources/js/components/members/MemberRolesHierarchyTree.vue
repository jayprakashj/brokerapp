<template>
    <page-header :title="pageTitle" :breadcrumbs="breadcrumbs" />
    <div>
        <div class="card mt-3 p-4">
            <div class="min-w-full overflow-x-auto">
                <router-link to="/member" class="btn bg-primary font-medium text-white hover:bg-primary-focus hover:shadow-lg hover:shadow-primary/50 focus:bg-primary-focus focus:shadow-lg focus:shadow-primary/50 active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:hover:shadow-accent/50 dark:focus:bg-accent-focus dark:focus:shadow-accent/50 dark:active:bg-accent/90">Back</router-link>
                <ol class="timeline line-space max-w-sm mt-8" v-if="lists?.data?.length">
                    <li class="timeline-item" v-for="(item, index) in lists.data" :key="'hierarchy_order_' + index">
                        <div
                            class="timeline-item-point rounded-full bg-slate-300 dark:bg-navy-400"
                        ></div>
                        <div class="timeline-item-content flex-1 pl-4 sm:pl-8">
                            <div class="flex flex-col justify-between pb-2 sm:flex-row sm:pb-0">
                                <p
                                    class="pb-2 font-medium leading-none text-slate-600 dark:text-navy-100 sm:pb-0"
                                >
                                    {{ item.name }}
                                </p>
                            </div>
                            <p class="py-1 mt-3" v-if="item.members?.length">
                                <ul class="max-w-md space-y-1 text-gray-500 list-decimal list-inside dark:text-gray-400 ml-4">
                                    <li v-for="(user, idx) in item.members" :key="'user_'+idx">
                                        <span class="font-semibold text-primary dark:text-white">
                                            {{ user }}
                                        </span>

                                    </li>
                                </ul>
                            </p>
                            <no-data-found v-else message="No users available." class="!text-primary" />
                        </div>
                    </li>
                </ol>
                <no-data-found v-else />
            </div>

        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex' ;
import NoDataFound from '../NoDataFound.vue';

export default {
  components: { NoDataFound },
    data(){
        return {
            pageTitle: 'Roles Hierarchy Tree',
            isShowPopper: false,
            page: 1,
            lists:{},
        }
    },
    created(){
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
                        title: 'Staff User Management',
                        link: '/member'
                    },
                    {
                        title: 'Role Hierarchy Tree',
                    }
                ];
            return breadcrumbs;
        },
    },
    methods:{
        init () {
            this.loadListsData();
        },
        loadListsData(){
            this.$store.commit('setGlobalLoaderOn')
            this.$request.getRoleHierarchyList()
                        .then(
                            ( res ) => {
                                if( res.data ){
                                    this.lists = res.data;
                                }
                            },
                            (err) => {

                            }
                        ).finally(
                            () => {
                                this.$store.commit('setGlobalLoaderOff')
                            }
                        )
        }
    }
}
</script>

<style>

</style>
