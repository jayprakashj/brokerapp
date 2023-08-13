export default {
    mounted : ( el, bindings ) => {
        el.clickOutsideEvent = ( e ) => {
            if( !(el == e.target || el.contains ( e.target )) ){
                bindings.value();
            }
        }
        document.addEventListener( "click", el.clickOutsideEvent );
    },
    unmounted: ( el ) => {

        document.removeEventListener( "click", el.clickOutsideEvent );
    }
}
