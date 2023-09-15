<template>
    <div
        class="fixed inset-0 z-[100] flex flex-col items-center  overflow-hidden px-4 py-6 sm:px-5"
        role="dialog"
    >
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur transition-opacity duration-300" >
        </div>

        <div
            class="relative w-full max-h-[95%] origin-top rounded-lg transition-all duration-300 dark:bg-navy-700"
        >
            <div
                class=" flex justify-between rounded-t-lg bg-slate-200/85 px-4 py-3 dark:bg-navy-800 sm:px-5"
            >
                <template v-for="(imgData, idx) in images" >
                    <div class="space-x-2 text-white m-auto w-max bg-slate-200/50 p-2 text-xl" :key="'img_title'+ idx" v-if="idx == swiperActiveIndex">
                        {{ imgData.title }}
                    </div>

                </template>
                <button
                    @click="closeModal"
                        class="btn -mr-1.5 h-7 w-7 rounded-full p-0 hover:bg-slate-300/20 bg-white focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25"
                    >
                <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="px-4 py-4 sm:px-5 h-[90%]" v-if="images">

                <ImageSwiperVue :data="images" ref="imgSwiper" @slideChange="onSlideChange" />
            </div>
        </div>

    </div>
</template>

<script>
import ImageSwiperVue from './ImageSwiper.vue';
export default {
    components:{
        ImageSwiperVue
    },
    props:{
        images: [ Object, Array ],
        default: [],
    },
    data(){
        return {

            swiperActiveIndex: 0,
        }
    },
    methods:{
        closeModal() {
            this.$emit('close')
        },
        onSlideChange ( num ) {

            this.swiperActiveIndex = num;
        }
    }
}
</script>

<style>

</style>
