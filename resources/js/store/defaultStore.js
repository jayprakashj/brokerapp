

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
            authUser: window.authUser,
            userPermissions: window.userPermissions,
            globalPermissions: window.globalPermissions
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
        },
        globalPermissions( state ){
            return state.globalPermissions;
        },
        userPermissions( state ){
            return state.userPermissions;
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
        },
        setAuthUser(state, data ){
            state.authUser = data;
        },
        changeDefaultCompany(state, data ){
            state.authUser.current_company = data;
        },
        changeUserPermissions(state, data ){
            state.userPermissions = data;
        },
    },
    actions:{
        login(context, data ){
        },
    }
});

export default defaultStore;
