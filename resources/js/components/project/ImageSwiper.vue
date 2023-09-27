<template>
    <div
        ref="swiper"
        class="swiper rounded-lg w-full h-full"
    >
        <div class="swiper-wrapper">

                <div class=" swiper-slide text-center" v-for="(imgData, index) in images" :key="'image_list_container_'+ index">
                    <div class="w-max p-4 h-full m-auto">
                        <img
                            class="m-auto h-full object-cover w-full"
                            :src="imgData.preview_url"
                            alt=""
                        />

                    </div>
                </div>
        </div>
        <div class="swiper-button-next" ref="swiperNextBtn"></div>
        <div class="swiper-button-prev" ref="swiperPrevBtn"></div>
    </div>
</template>

<script>

import Swiper from 'swiper'
import {Navigation} from 'swiper/modules'

export default {
    props:{
        data: {
            type: [Object, Array],
            default: []
        }
    },
    data (){
        return {
            document: document,
            images: [],
            swiper: null,
        }
    },
    created() {
        if( this.data ){
            this.initImageSwiper();
        }

    },

    computed:{
        isHeaderFound () {
            return this.document.getElementById('imageTitleHeader');
        }
    },
    watch:{
        data ( nv ) {
            this.images = nv;
            if( nv ){
                this.initImageSwiper();
            }
        }
    },
    methods:{
        initImageSwiper(){
            this.images = this.data;
            this.$nextTick (
                () => {
                    if( 'swiper' in this.$refs && this.$refs?.swiper ){
                        let $this = this;
                        this.swiper = new Swiper( this.$refs['swiper'], {
                            modules: [ Navigation ],
                            navigation:{
                                nextEl: this.$refs.swiperNextBtn,
                                prevEl: this.$refs.swiperPrevBtn,
                            },
                            on:{
                                slideChange: function () {
                                    $this.$emit('slideChange', this.activeIndex );
                                }
                            }
                        })
                    }
                }
            )
        }
    }
}
</script>

<style>

</style>
