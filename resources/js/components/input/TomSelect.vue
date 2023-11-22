<template>
    <label :class="classNames">
        <span v-if="formLabel">{{ formLabel }}</span>
        <select
            :key="formLabel"
            ref="tomSelect"
            :placeholder="placeholder"
            class="mt-1.5 w-full"
            :multiple="isMultiple">
        </select>
        <span class="text-tiny+ text-error" v-if="errorMessage?.length">{{ Array.isArray( errorMessage ) ? errorMessage.at(0): errorMessage }}</span>
    </label>
</template>

<script>
import TomSelect from 'tom-select';
export default {
    props:{
        classNames:{
            type: String,
            default: 'block'
        },
        valueField:{
            type: String,
            default: 'id'
        },
        displayField:{
            type: String,
            default: 'name'
        },
        searchField:{
            type: [String, Array],
            default: ['name']
        },
        options:{
            type: Array,
            default: null
        },
        placeholder:{
            type: String,
            default: null
        },
        renderOptionFn:{
            type: Function,
            default: null
        },
        selectedItemFn:{
            type: Function,
            default: null
        },
        formLabel:{
            type:String,
            default: null
        },
        tomOptions:{
            type: Object,
            default: () => {}
        },
        isMultiple:{
            type: Boolean,
            default: false
        },
        isAjax:{
            type: Boolean,
            default: false
        },
        requestName:{
            type: String,
            default: null
        },
        allowCreate:{
            type: Boolean,
            default: false
        },
        ajaxLoadOnce:{
            type: Boolean,
            default: true
        },
        ajaxPreload:{
            type: Boolean,
            default: false
        },
        selectedItem:{
            type: [ Array, String, Number ],
            default: null
        },
        selectedOptions:{
            type: [ Object, Array, String, Number ],
            default: null
        },
        errorMsg:{
            type: [String, Array],
            default:null
        },
        allowEmptyOption:{
            type: [Boolean],
            default:false
        }
    },
    data(){
        return {
            tomSelectInstance: null,
            errorMessage: null
        }
    },
    created(){
        this.init();
    },
    watch:{
        options( nv ){
            this.refreshOptions();
        },
        tomOptions( nv ){
            this.init();
        },
        selectedItem ( nv ) {
            this.setSelectedValues()
        },
        errorMsg ( nv ) {
            this.errorMessage = nv;
        }
    },
    methods:{
        init(){
            this.$nextTick(
                () => {
                    this.initTomSelect();
                    this.setSelectedValues();
                }
            )
        },
        initTomSelect(){
            if( this.tomSelectInstance ){
                this.tomSelectInstance.destroy();
            }
            let renderOptions;
            var defaultOptions = {
                valueField: this.valueField,
		        labelField: this.displayField,
                create: (this.allowCreate || false),
                preload: this.ajaxPreload,
                openOnFocus: true,
                shouldOpen: true,
                allowEmptyOption: this.allowEmptyOption,
                // plugins: ['clear_button'],

            }

            if( this.isAjax && this.requestName ){
                var $thisApp = this;
                defaultOptions['load'] = function( qry, cb ) {
                    if( $thisApp.ajaxLoadOnce ){
                        var self = this;
                        if( self.loading > 1 ){
                            cb();
                            return;
                        }

                    }
                    $thisApp.$request[ $thisApp.requestName ]( qry )
                            .then( ( res ) => {
                                cb( res.data );
                                setTimeout(() => {
                                    $thisApp.setSelectedValues();
                                }, 500);
                                if( $thisApp.ajaxLoadOnce ){
                                    self.settings.load = null;
                                }
                            }).finally( () => {
                                cb();
                            })
                }
            }else{
                defaultOptions['options'] = this.options;
            }
            var render = {};
            var renderItem;
            if( this.renderOptionFn ){
                render['option'] = this.renderOptionFn;
            }
            if(this.selectedItem ){
                defaultOptions['items'] = [this.modelValue ];
                // render['item']  = ( item, escape ) =>{
                //     return `<div class="py-2 d-flex">
                //             <div class="mb-1">
                //                 <span class="h5">
                //                     ${ escape(item.label) }
                //                 </span>
                //             </div>
                //         </div>`
                // }
            }
            if( this.searchField ){
                defaultOptions['searchField'] = this.searchField
            }
            if( Object.keys( render )?.length ){

                defaultOptions['render'] = render;
            }

            const options = Object.assign( defaultOptions, this.tomOptions );

            this.tomSelectInstance = new TomSelect(
                    this.$refs.tomSelect,
                    options
            )

            this.tomSelectInstance.on("change", ( selectedValue ) => {
                this.$emit( 'update:modelValue', selectedValue )
                this.$emit( 'onChange', selectedValue )
            })

            this.tomSelectInstance.on("item_select", ( selectedItem ) => {
                this.$emit( 'itemSelect', selectedItem )
            })
            this.tomSelectInstance.on("item_remove", ( selectedItem ) => {
                this.$emit( 'itemRemove', selectedItem )
            })
            this.tomSelectInstance.on("clear", ( ) => {
                this.$emit( 'clear' );
            })
        },
        clearOptions () {
            this.tomSelectInstance.clear();
            this.tomSelectInstance.clearOptions();
        },
        refreshOptions (){
            this.$nextTick(
                () => {
                    this.clearOptions()
                    this.tomSelectInstance.addOptions( this.options, this.allowCreate);

                    this.setSelectedValues();
                }
            )
        },
        setSelectedValues () {
            if(this.selectedOptions ){
                if( this.isAjax ){

                    if( Array.isArray( this.selectedOptions ) ){
                        this.tomSelectInstance.addOptions( this.selectedOptions );
                    }else{
                        this.tomSelectInstance.addOptions( [this.selectedOptions] );

                    }

                }
            }
            if(this.selectedItem ){

                if( Array.isArray( this.selectedItem ) ){
                    if( this.selectedItem?.length ){

                        this.selectedItem.map( d => {

                            this.tomSelectInstance.addItem( d );
                        })
                    }else{
                        this.tomSelectInstance.clear();
                    }

                }else{
                    this.tomSelectInstance.addItem( this.selectedItem  );

                }
            }else{
                this.tomSelectInstance.clear();
            }
        }
    }
}
</script>

<style>

</style>
