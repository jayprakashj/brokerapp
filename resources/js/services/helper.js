import requests from '@/requests/index'
import permission from '@/constants/permissions' ;

export default {
    install ( app, options) {
        app.config.globalProperties.$request = requests;
        app.config.globalProperties.$perPage = 8;
        app.config.globalProperties.$authUser = window.authUser;
        app.config.globalProperties.$permissions = permission;
        app.config.globalProperties.$enquiryTypes = enquiryTypes;
        app.config.globalProperties.$genders = [
            {
                id: 'male',
                name: 'Male'
            },
            {
                id: 'female',
                name: 'Female'
            },
            {
                id: 'other',
                name: 'Other'
            }
        ];
        var canPermission = ( permissions, checkGlobal = false, allInclude = false  ) => {
            var isExists = false;
            const allowedPermissions = checkGlobal ? globalPermissions : userPermissions;

            if( allInclude ){
                const matched = allowedPermissions.filter( d => permissions.includes( d ) );
                isExists = matched.length  == permissions.length;
            }else{
                isExists = permissions.find( d => allowedPermissions.includes( d ) );
            }

            return isExists !== undefined;
        }

        app.config.globalProperties.$checkPermission = canPermission;

        Array.prototype.isPermissionsAllowed = function ( permissions, allInclude ) {
            var isExists = false;
            const allowedPermissions = this;

            if( Array.isArray( permissions ) ){

                if( allInclude ){
                    const matched = allowedPermissions.filter( d => permissions.includes( d ) );
                    isExists = matched.length  == permissions.length;
                }else{
                    isExists = permissions.find( d => allowedPermissions.includes( d ) );
                    isExists = isExists !== undefined;
                }
            }else if( typeof permissions == 'string' ){

                isExists = allowedPermissions.includes( permissions ) ;

            }

            return isExists;
        };

    }
}
