<template>
  <nav class="header print:hidden">
    <!-- App Header  -->
    <div class="header-container relative flex w-full bg-white dark:bg-navy-750 print:hidden">
        <!-- Header Items -->
        <div class="flex w-full items-center justify-between">
            <!-- Left: Sidebar Toggle Button -->
            <div class="h-7 w-max" v-if="false">
                <button
                    class="menu-toggle ml-0.5 flex h-7 w-7 flex-col justify-center space-y-1.5 text-primary outline-none focus:outline-none dark:text-accent-light/80"
                    :class="$store.state.default.global.isSidebarExpanded && 'active'"
                    @click="$store.state.default.global.isSidebarExpanded = !$store.state.default.global.isSidebarExpanded">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

        </div>
    </div>
</nav>

</template>

<script>
export default {
    data(){
        return {
            activeTab: 'tabAll',
            isShowPopper: false
        }
    }
}
</script>

<style>

</style>
