<template>
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900" x-cloak v-if="$route.name=='customer_enquiry'">
        <main class="main-content w-full px-[var(--margin-x)] pb-8">
            <router-view :key="$route.fullPath"></router-view>
        </main>
    </div>

    <AppLayoutVue v-else></AppLayoutVue>
</template>

<script>
import AppLayoutVue from './components/layout/app/AppLayout.vue'
export default {

    components:{
        AppLayoutVue
    },
}
</script>

<style>

</style>
