<template>

    <div class="px-4 py-4 sm:px-5 h-[320px]">
        <div id="location_picker_map" ref="location_picker_map" class="w-full h-full"></div>
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
        },
        addressLabel:{
            type: String,
            default: ""
        },
        markersList:{
            type: [Array],
            default: () => []
        },
        highlightMarker:{
            type: [ String, Number],
            default: null
        },
        fitMapToMarkers:{
            type: Boolean,
            default: true
        }
    },
    data(){
        return{
            mapObj: null,
            mapMarker: null,
            markerLatLong: null,
            geoCoderObj: null,
            markerAddress: null,
            infoWindow: null,
            mapMarkers: [],
            markersData: [],
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
        },
        markersList( nV ){
            if( nV && nV?.length ){
                this.markersData = nV;
                this.$nextTick( () => {
                    this.cleanMarkersPoint();

                    this.showMarkers();
                })
            }
        },
        highlightMarker(){
            this.focusOnHighlightMarker()
        }
    },
    methods:{
        init(){
            this.initMap();
            if( this.markersList && this.markersList?.length ){
                this.markersData = this.markersList;
                this.$nextTick( () => {

                    this.showMarkers();
                })
            }
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
                        if( !this.enableMapClick ){
                            return;
                        }
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
            let content = (this.addressLabel ? `<p><b class="text-lg">${this.addressLabel}</b></p>` : '' ) + `<p class="text-base">${this.markerAddress}</p>`;
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
                if( this.markerPosition.lat && this.markerPosition.lng ){
                    this.markerLatLong = Object.assign( {}, this.markerPosition );

                    if( this.mapObj ){
                        // this.mapObj.setCenter( this.markerLatLong );
                    }
                    this.setMarkerPoint();
                }
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
        },
        cleanMarkersPoint(){
            if( this.mapMarkers && this.mapMarkers?.length ){
                this.mapMarkers.forEach( d => {
                    d.marker.setVisible( false );
                    d.marker.setMap( null );

                });
                this.mapMarkers = [];
            }
        },
        showMarkers(){
            if(this.markersData && this.markersData?.length ){
                this.cleanMarkersPoint();
                this.mapMarkers = [];
                const __map = this.mapObj;
                setTimeout(() => {

                    this.markersData.forEach( ( d ) => {
                        let markerObj = new google.maps.Marker({
                            position: d.marker_points,
                            map: this.mapObj,
                            id: d.id
                        });
                        let infoWindow;
                        if( d.marker_content ){
                            let content = (d.marker_label ? `<p><b class="text-lg">${d.marker_label}</b></p>` : '' ) + `<p class="text-base">${d.marker_content}</p>`;
                            infoWindow = new google.maps.InfoWindow({
                                content: content
                            })
                            markerObj.addListener("click", (e, data) => {
                                this.mapMarkers.forEach( d => {
                                    if( d.infoWindow && d.infoWindow != infoWindow){
                                        d.infoWindow.close();
                                    }
                                })
                                infoWindow.open( __map,markerObj)
                            })

                        }
                        this.mapMarkers[ d.id ] = {
                            marker: markerObj,
                            infoWindow: infoWindow
                        };

                    });
                    if( this.fitMapToMarkers ){
                        this.fitMapAccordingMarkers();
                    }
                }, 300);
            }
        },
        focusOnHighlightMarker(){
            if( this.highlightMarker && this.highlightMarker in this.mapMarkers ){
                this.mapMarkers.forEach( (d, k) => {
                    if( k !== this.highlightMarker && d.infoWindow ){
                        d.infoWindow.close();
                    }
                })
                let markerObj = this.mapMarkers[ this.highlightMarker ].marker;
                let infoWindow = this.mapMarkers[ this.highlightMarker ].infoWindow;
                if( !infoWindow ){
                    new google.maps.event.trigger( markerObj, 'click');
                }else{
                    infoWindow.open( this.mapObj, markerObj);

                }
            }
        },
        fitMapAccordingMarkers(){
            if(this.mapMarkers && this.mapMarkers?.length ){
                let bounds =  new google.maps.LatLngBounds();
                this.mapMarkers.forEach( d => {
                    if( d.marker ){
                        bounds.extend( d.marker.getPosition() );
                    }
                })

                this.mapObj.fitBounds( bounds );
            }
        }
    }
}
</script>

<style>

</style>
