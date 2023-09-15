<template>
    <page-header :title="pageTitle" />

    <div class="flex items-center w-100 h-[75vh] bg-white">
        <h2 class="m-auto text-3xl">
            Welcome to BrokerApp

        </h2>
    </div>
</template>

<script>
export default {
    data(){
        return {
            pageTitle: 'Dashboard'
        }
    },
    created(){
        this.$store.commit('setGlobalLoaderOff');
    }
}
</script>

<style>

</style>
