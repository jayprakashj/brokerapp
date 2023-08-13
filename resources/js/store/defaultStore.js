

const defaultStore = ({
    state(){
        return {
            global:{
                isDarkModeEnabled: false,
                isMonochromeModeEnabled: false,
                isSearchbarActive: false,
                isSidebarExpanded: false,
                isRightSidebarExpanded: false,
            },
            isSearchbarActive: false,
            breakpoints: {},
            globalLoader: true
        }
    },
    getters:{
        isSidebarExpanded( state ){
            if( state.user ){
                return state.user;
            }
            return null;
        },
    },
    mutations:{
        setSidebarExpanded ( state ){

        },
        setGlobalLoaderOff ( state ){
            state.globalLoader = false
        },
        setGlobalLoaderOn ( state ){
            state.globalLoader = true
        }
    },
    actions:{
        login(context, data ){
        },
    }
});

export default defaultStore;
