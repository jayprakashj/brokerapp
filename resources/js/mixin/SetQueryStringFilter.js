export default {
    methods:{
        readQueryAndSetFilter( queryParam, filterVarName ){
            const routeQueryString = this.$route.query;

            if( queryParam === undefined ){
                queryParam = '_defaultFilter';
            }

            if( filterVarName === undefined ){
                filterVarName = 'filter';
            }

            if( queryParam in routeQueryString && routeQueryString[queryParam] ){

                const queryFilter = JSON.parse( routeQueryString[queryParam] );

                this[filterVarName] = Object.assign( this[filterVarName], queryFilter );

                routeQueryString[queryParam] = undefined;

                const currUrl = new URL( window.location.origin + this.$route.fullPath );
                const param = new URLSearchParams( currUrl.search );
                param.delete( queryParam );

                window.history.replaceState( null, null, "?" + param.toString() );

                this.$router.replace( {query: routeQueryString} )

            }
        },
    },
}

