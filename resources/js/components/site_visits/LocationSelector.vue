<template>

    <div class="px-4 py-4 sm:px-5 ">
        <div id="location_picker_map" ref="location_picker_map" class="w-full h-[320px]"></div>
    </div>
</template>

<script>
export default {
    props:{
        isVisible: {
            type: Boolean,
            default: false
        },
        enableMapClick: {
            type: Boolean,
            default: true
        },
        title: {
            type: String,
            default: 'Pick your location'
        },
        defaultLatLong:{
            type: Object,
            default: () => {
                return {
                    lat: 22.321129,
                    long: 73.1847549,
                }
            }
        },
        defaultZoom:{
            type: [Number, String],
            default: 12
        },
        markerPosition:{
            type: Object,
            default: () => {
                return {}
            }
        },
        formattedAddress:{
            type: String,
            default: ""
        }
    },
    data(){
        return{
            mapObj: null,
            mapMarker: null,
            markerLatLong: null,
            geoCoderObj: null,
            markerAddress: null,
            infoWindow: null
        }
    },
    created(){
        window.addEventListener('googleMapLoaded', () => {
            this.init();
        })
        this.$nextTick( () => {

            if( typeof google !== 'undefined' ){
                this.init();
            }
        })
    },
    watch:{
        // isVisible( nV ){
        //     if( nV && typeof nV == "boolean" && nV ){
        //         this.init();
        //     }
        // }
        markerPosition( nv ){
            if( typeof nv == 'object' && Object.keys( nv ).length ){
                this.updateMarkerPosition();
            }
        }
    },
    methods:{
        init(){
            this.initMap();
        },
        initMap(){

            if( !this.mapObj ){
                this.mapObj = new google.maps.Map( document.getElementById('location_picker_map'),{
                    zoom: this.defaultZoom,
                    center: {
                        lat: this.defaultLatLong.lat,
                        lng: this.defaultLatLong.long,
                    },
                    keyboardShortcuts: false,
                } )
                this.geoCoderObj = new google.maps.Geocoder();

                this.$nextTick( () => {
                    this.updateMarkerPosition();
                });
                if( this.enableMapClick ){

                    google.maps.event.addListener( this.mapObj, 'click', ( mapE ) => {
                        this.markerLatLong = {
                            lat: mapE.latLng.lat(),
                            lng: mapE.latLng.lng(),
                        };

                        this.getAddress();
                        this.setMarkerPoint();

                        this.$emit('onMarkerSelect', mapE);
                        this.$emit('onLocationChange', {
                            latLng: this.markerLatLong,
                            address: this.markerAddress,
                            address_obj: res,
                        });
                    });
                }
            }
        },
        setMarkerPoint(){
            if( this.markerLatLong ){
                if( this.mapMarker ){
                    this.mapMarker.setPosition( this.markerLatLong );
                }else{

                    this.mapMarker = new google.maps.Marker({
                        position: this.markerLatLong,
                        map: this.mapObj
                    });
                }
            }
        },
        getAddress(){
            this.geoCoderObj.geocode({location: this.markerLatLong }, ( res, status ) => {
                if( status == 'OK'){
                    if( res.length > 0 ){
                        this.markerAddress = res[0].formatted_address;
                        this.setInfoWindow();
                        this.$emit('onAddress', this.markerAddress);
                        this.$emit('onLocationChange', {
                            latLng: this.markerLatLong,
                            address: this.markerAddress,
                            address_obj: res,
                        });
                    }
                }
            })
        },
        setInfoWindow(){
            let content = `<p class="text-base">${this.markerAddress}</p>`;
            if( this.infoWindow ){
                this.infoWindow.setContent( content )
            }else{

                this.infoWindow = new google.maps.InfoWindow({
                    content: content
                });
                this.infoWindow.open({
                    anchor: this.mapMarker
                })
                if( this.mapMarker ){
                    this.mapMarker.addListener('click', () => {
                        this.infoWindow.open(this.mapObj, this.mapMarker)
                    })
                }
            }
        },
        updateMarkerPosition(){
            if( this.markerPosition && Object.keys( this.markerPosition ).length ){
                this.markerLatLong = Object.assign( {}, this.markerPosition );
                if( this.mapObj ){
                    // this.mapObj.setCenter( this.markerLatLong );
                }
                this.setMarkerPoint();
            }
            if(this.formattedAddress){
                this.markerAddress = this.formattedAddress;
                this.setInfoWindow();
            }else{
                this.getAddress();
            }
        },
        closeModal () {
            this.$emit('close');
        }
    }
}
</script>

<style>

</style>
