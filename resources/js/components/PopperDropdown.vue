<template>
    <div class="inline-flex popper-ref" v-click-outside="closePopper">
        <button ref="popperRef"
            @click="isShowPopper = !isShowPopper"
            class="btn h-8 w-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                </path>
            </svg>
        </button>
        <div ref="popperRoot"
                class="popper-root "
                :class="{'show': isShowPopper}"
                data-popper-placement="bottom-end">
            <slot />
        </div>
    </div>
</template>

<script >
import { createPopper } from '@popperjs/core/lib/createPopper';
export default {

    data() {
        return {
            isShowPopper: false,
            popperInstance: null,
            popperConfig: {
                placement:'bottom-start',
                offset:4,
                modifiers: [
                {
                    name: "offset",
                    options: {
                        offset: [0,  0],
                    },
                },
                ]
            }
        }
    },
    mounted(){
        this.$nextTick( () => {
            this.popperInstance = createPopper( this.$refs.popperRef, this.$refs.popperRoot, this.popperConfig );

        })
    },
    watch:{
        isShowPopper(nV){
            if( nV && this.popperInstance ){
                this.popperInstance.update();
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

