import requests from '@/requests/index'
import permission from '@/constants/permissions' ;

export default {
    install ( app, options) {
        app.config.globalProperties.$request = requests;
        app.config.globalProperties.$perPage = 8;
        app.config.globalProperties.$authUser = window.authUser;
        app.config.globalProperties.$permissions = permission;
        app.config.globalProperties.$enquiryTypes = enquiryTypes;
        app.config.globalProperties.$broadcastChannelName = import.meta.env.VITE_BROADCAST_CHANNEL_NAME;
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

        app.config.globalProperties.$checkIsObjectEmpty = function ( obj ) {
            const objectData = Object.assign( {}, obj );
            const keys = Object.keys( objectData );
            keys.forEach( ( d ) => {
                const keyVal = objectData[ d ];

                if( keyVal == null || keyVal == "" || ( Array.isArray( keyVal ) && keyVal.length == 0 ) ){
                    delete objectData[d];
                }
            });

            return Object.keys( objectData ).length == 0;
        }

        app.config.globalProperties.$transformFilledOnly = function ( obj ) {
            const objectData = Object.assign( {}, obj );
            const keys = Object.keys( objectData );
            keys.forEach( ( d ) => {
                const keyVal = objectData[ d ];

                if( keyVal == null || keyVal == "" || ( Array.isArray( keyVal ) && keyVal.length == 0 ) ){
                    delete objectData[d];
                }
            });

            return objectData;
        }

    }
}
