import requests from '@/requests/index'
export default {
    install ( app, options) {
        app.config.globalProperties.$request = requests;
        app.config.globalProperties.$perPage = 24;
        app.config.globalProperties.$checkPermission = ( permissions, checkGlobal = false, allInclude = false  ) => {
            var isExists = false;
            const allowedPermissions = checkGlobal ? globalPermissions : userPermissions;

            if( allInclude ){
                const matched = allowedPermissions.filter( d => d.includes( permissions ) );
                isExists = matched.length  == permissions.length;
            }else{
                isExists = permissions.find( d => allowedPermissions.includes( d ) );
            }

            return isExists !== undefined;
        }

    }
}
