

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
            globalLoader: true,
            authUser: window.authUser
        }
    },
    getters:{
        isSidebarExpanded( state ){
            if( state.user ){
                return state.user;
            }
            return null;
        },
        currentUser( state ){
            return state.authUser;
        }
    },
    mutations:{
        setSidebarExpanded ( state ){

        },
        setGlobalLoaderOff ( state ){
            state.globalLoader = false
        },
        setGlobalLoaderOn ( state ){
            state.globalLoader = true
        },
        setAuthUser(state, data ){
            state.authUser = data;
        },
        changeDefaultCompany(state, data ){
            state.authUser.current_company = data;
        },
    },
    actions:{
        login(context, data ){
        },
    }
});

export default defaultStore;
