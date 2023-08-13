<template>
    <div v-if="totalPages > 1">
        <div class="py-2 m-2 p-r">
            <ul class="pagination space-x-1.5">
                <li class="prev" :class="{'active': isPrevEnable}">
                    <a href="#" @click.prevent="goPrevPage" class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-150 text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:bg-navy-500 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <i class="fa fa-less-than"></i>
                    </a>
                </li>
                <li
                        v-for="( pg, idx ) in pages"
                        :key="'pagination_'+idx"
                    >
                        <a
                            href="#"
                            @click.prevent="goToPage( pg.text, pg.isDots)"
                            :class="{
                                'text-white bg-primary  hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90': pg.text===page,
                                'transition-colors hover:bg-slate-300 bg-slate-150 focus:bg-slate-300 active:bg-slate-300/80 dark:bg-navy-500 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90': (pg.text !== page)
                            }"
                            class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight"
                            >
                            {{ pg.text }}
                        </a>
                </li>
                <li class="next" :class="{'active': isNextEnable}">
                    <a
                        href="#"
                        @click.prevent="goNextPage"
                        class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-150 text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:bg-navy-500 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                        >
                        <i class="fa fa-greater-than"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        totalRecords: {
            type: Number,
            default: null
        },
        perPage: {
            type: Number,
            default: null
        },
        currentPage: {
            type: Number,
            default: null
        },
        maxAround: {
            type: Number,
            default: 1
        },
        maxRange: {
            type: Number,
            default: 3
        }
    },
    emits: [
        'nextPage',
        'prevPage',
        'pageChange'
    ],
    data() {
        return {
            page: this.currentPage || 1
        }
    },
    computed:{
        totalPages () {
            if( this.perPage > 0 ){
                return Math.ceil( this.totalRecords / this.perPage);
            }
            return 0;
        },
        isPrevEnable(){
            return this.page > 1;
        },
        isNextEnable(){
            return this.page < this.totalPages;
        },
        endRange () {
            return this.totalPages - this.maxRange;
        },
        inStartRange () {
            return this.page <= this.maxRange;
        },
        inEndRange () {
            return this.page >= this.endRange;
        },
        pages () {
            let lastDotIndex = -1;
            let totalDots = 0;
            let pages = [];
            for( let page = 1; page <= this.totalPages; page++ ){
                let isPageAdd = false;
                let isDotsAdd = false;
                if( page == 1 || page == this.totalPages ){
                    isPageAdd = true;
                }else if( this.inStartRange && page <= this.maxRange ){
                    isPageAdd = true;
                }else if( this.inEndRange && page >= this.endRange ){
                    isPageAdd = true;
                }else if( page == this.page || page == ( this.page - this.maxAround ) || page == ( this.page + this.maxAround ) ){
                    isPageAdd = true;
                }else if( lastDotIndex === -1 || ( page > this.page && totalDots < 2 && !this.inStartRange && !this.inEndRange ) ){
                    isDotsAdd = true;
                    lastDotIndex = page;
                    totalDots++;
                }

                if( isPageAdd ){
                    pages.push({
                        text: page,
                        isDots: false
                    });
                }
                if( isDotsAdd ){
                    pages.push({
                        text: '...',
                        isDots: true
                    });
                }
            }
            return pages;
        }
    },
    watch:{
        currentPage ( newVal, oldVal ){
            if( newVal ){
                this.page = newVal;
            }
        }
    },
    methods:{
        goNextPage () {
            if( !this.isNextEnable ){
                return;
            }
            this.page++;
            this.$emit('nextPage', this.page)
            this.$emit('pageChange', this.page);
            this.updateCurrentPage();
        },
        goPrevPage () {
            if( !this.isPrevEnable ){
                return;
            }
            this.page--;
            this.$emit('prevPage', this.page)
            this.$emit('pageChange', this.page);
            this.updateCurrentPage();
        },
        goToPage ( pageNum, isDots) {
            if( isDots ){
                return;
            }
            this.page = pageNum;
            this.$emit('pageChange', this.page);
            this.updateCurrentPage();
        },
        updateCurrentPage (){
            this.$emit('update:currentPage', this.page);
        }
    }
}
</script>

<style>

</style>
