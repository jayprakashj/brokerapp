<template>

<div class="flex sm:items-center max-xs:flex-col justify-between py-5 lg:py-6">
    <div class="flex items-center space-x-1">
      <h2 class="line-clamp-1 text-xl font-medium text-slate-700 dark:text-navy-50 lg:text-2xl">
        {{ title || '' }}

      </h2>
      <!-- <span @click="$router.go($route.currentRoute)">Refresh</span> -->
      <div  v-click-outside="closePopper"
         class="inline-flex" v-if="menus && menus.length > 0">
        <button ref="popperRef" @click="isShowPopper = !isShowPopper"
          class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
          <i class="fas fa-chevron-down"></i>
        </button>

        <div ref="popperRoot" class="popper-root"  :class="{'show': isShowPopper}"
          style="position: fixed; inset: 0px auto auto 0px; margin: 0px; transform: translate(268px, 122px);"
          data-popper-placement="bottom-start">
          <div
            class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
            <ul>
              <li v-for="(item, idx) in menus" :key="'menu_' + idx">
                <router-link :to="item.link"
                  class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                  <i class="fa mr-2" :class="item.icon_class" v-if="item.icon_class"></i>
                  <span> {{ item.title }}</span></router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <template v-if="breadcrumbs && breadcrumbs.length">
        <div class="hidden h-full py-1 ">
            <div class="h-full w-px bg-slate-300 dark:bg-navy-600"></div>
        </div>
        <ul class="hidden flex-wrap items-center space-x-2 sm:flex">
            <li class="flex items-center space-x-2" v-for="(item, idx) in breadcrumbs" :key="'breadcrumb_'+idx">
                <template v-if="item.link">

                        <router-link class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                        :to="item.link" v-if="item.link">{{ item.title }}</router-link>
                        <svg x-ignore="" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </template>
                <template v-else>
                    {{ item.title }}

                </template>
            </li>
        </ul>
    </template>
    <slot name="actionContainer"></slot>
    <div class="flex items-center space-x-2" v-if="searchEnabled || filterEnabled">
      <label class="relative hidden sm:flex" v-if="searchEnabled">
        <input
          class="form-input peer h-9 w-full rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 text-xs+ placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
          :placeholder="searchPlaceholder" type="text" v-model="searchText">
        <span
          class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-colors duration-200" fill="currentColor"
            viewBox="0 0 24 24">
            <path
              d="M3.316 13.781l.73-.171-.73.171zm0-5.457l.73.171-.73-.171zm15.473 0l.73-.171-.73.171zm0 5.457l.73.171-.73-.171zm-5.008 5.008l-.171-.73.171.73zm-5.457 0l-.171.73.171-.73zm0-15.473l-.171-.73.171.73zm5.457 0l.171-.73-.171.73zM20.47 21.53a.75.75 0 101.06-1.06l-1.06 1.06zM4.046 13.61a11.198 11.198 0 010-5.115l-1.46-.342a12.698 12.698 0 000 5.8l1.46-.343zm14.013-5.115a11.196 11.196 0 010 5.115l1.46.342a12.698 12.698 0 000-5.8l-1.46.343zm-4.45 9.564a11.196 11.196 0 01-5.114 0l-.342 1.46c1.907.448 3.892.448 5.8 0l-.343-1.46zM8.496 4.046a11.198 11.198 0 015.115 0l.342-1.46a12.698 12.698 0 00-5.8 0l.343 1.46zm0 14.013a5.97 5.97 0 01-4.45-4.45l-1.46.343a7.47 7.47 0 005.568 5.568l.342-1.46zm5.457 1.46a7.47 7.47 0 005.568-5.567l-1.46-.342a5.97 5.97 0 01-4.45 4.45l.342 1.46zM13.61 4.046a5.97 5.97 0 014.45 4.45l1.46-.343a7.47 7.47 0 00-5.568-5.567l-.342 1.46zm-5.457-1.46a7.47 7.47 0 00-5.567 5.567l1.46.342a5.97 5.97 0 014.45-4.45l-.343-1.46zm8.652 15.28l3.665 3.664 1.06-1.06-3.665-3.665-1.06 1.06z">
            </path>
          </svg>
        </span>
      </label>
      <div class="flex" v-if="filterEnabled">
        <popper-dropdown :popper-options="popoverOptionsForFilter">
            <template v-slot:popper_btn>
                <i class="fa fa-2x fa-filter"></i>

            </template>
            <template v-slot:default="popperSlotOptions">
                <slot name="filterPopoverContent" :popperClose="popperSlotOptions.closePopper" />

            </template>
        </popper-dropdown>
        </div>
    </div>
</div>

</template>

<script>
import { createPopper } from '@popperjs/core';

export default {

    props:{
        title: {
            type: String,
            default: ''
        },
        menus:{
            type: Array,
            default: []
        },
        breadcrumbs:{
            type: Array,
            default: []
        },
        searchEnabled:{
            type: Boolean,
            default: false
        },
        searchPlaceholder:{
            type: String,
            default: 'Search...'
        },
        filterEnabled:{
            type: Boolean,
            default: false
        },
        filterPopoverOptions:{
            type: Object,
            default: {}
        }
    },
    data(){
        return {
            searchText: '',
            isShowPopper: false,
            popperI: null
        }
    },
    mounted(){
        this.$nextTick( () => {
            this.popperI = createPopper( this.$refs.popperRef, this.$refs.popperRoot, {placement:'bottom-start',offset:4} );

        })
    },
    computed:{
        popoverOptionsForFilter () {
            if( Object.keys( this.filterPopoverOptions ).length ){
                return this.filterPopoverOptions;
            }
            return {
                offset: 12,
                placement: 'auto',
                modifiers: [
                    {
                        name: 'preventOverflow',
                        options: {
                            padding: 10
                        }
                    }
                ]
            }
        }
    },
    watch:{
        isShowPopper(nV){
            if( nV && this.popperI ){
                // this.isShowPopper = true;
                this.popperI.update();
            }
        }
    },
    methods:{
        closePopper () {
            if( this.isShowPopper ){
                this.isShowPopper = false;
            }
        }
    }
}
</script>

<style>

</style>
