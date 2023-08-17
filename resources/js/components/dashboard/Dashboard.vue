<template>
    <page-header :title="pageTitle" />

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
