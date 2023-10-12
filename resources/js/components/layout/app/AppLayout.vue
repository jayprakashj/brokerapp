<template>

    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900" x-cloak>
        <!-- Sidebar -->
        <div class="sidebar print:hidden">
            <MainSidebar />
        </div>

        <Header />

        <MobileSearchBar />
        <RightSidebar />

        <main class="main-content w-full px-[var(--margin-x)] pb-8">
            <router-view :key="$route.fullPath"></router-view>
        </main>
    </div>

</template>

<script>
import MainSidebar from '@/components/layout/app/partials/MainSidebar.vue';
import Header from '@/components/layout/app/partials/Header.vue';
import MobileSearchBar from '@/components/layout/app/partials/MobileSearchBar.vue';
import RightSidebar from '@/components/layout/app/partials/RightSidebar.vue';

export default {
    components:{
        MainSidebar,
        Header,
        MobileSearchBar,
        RightSidebar
    }
}
</script>

<style>

</style>
