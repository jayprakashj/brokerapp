import axios from 'axios';
import store from '@/store';
import router from '@/router/index';
import {useToast} from 'vue-toast-notification';

const $toast = useToast();

const http = axios.create({
    baseURL: import.meta.env.VITE_BASE_API_URL,
    headers:{
        accept: 'application/json'
        // 'Access-Control-Allow-Origin': 'tb10'
    }
});

// http.interceptors.request.use(
//     (config) => {
//         if( store.getters['authToken'] ){
//             config.headers.Authorization =  'Bearer ' + store.getters.authToken;

//         }
//         return config;
//     }
// );

http.interceptors.response.use(

    (response) => {
        return response;
    },

    (error) => {
        if (error.response && error.response.status === 401) {

            router.push({name: '401'});
        }
        if (error.response && error.response.status === 404) {
            router.push({name: '404'});
        }

        if (error.response && error.response.status === 500 && 'default_company' in error.response.data && error.response.data.default_company === false ) {
            $toast.error("Err! Please select default company.");
            router.push({name: 'company_lists'});
        }
        return Promise.reject(error);
    }
);

const apis = {
    logout: ( ) => {

        return http.post('logout');

    },
    getCompanyList: ( params) => {
        let config = {};
        if( params ) {
            config['params'] = params;
        }
        return http.get('company/lists', config);

    },
    getCompanyDetail: ( id ) => {
        return http.get(`company/${id}/edit` );

    },
    createCompany: ( data ) => {

        return http.post('company/store', data);

    },
    changeCompanyStatus: ( id ) => {

        return http.post(`company/${id}/change-status`);

    },
    makeDefaultCompany: ( id ) => {

        return http.post(`company/${id}/set-default`);

    },

    getPermissions: () => {
        return http.get('fetch/permissions');

    },
    getRoleList: ( params) => {
        let config = {};
        if( params ) {
            config['params'] = params;
        }
        return http.get('roles/lists', config);

    },
    getRoleDetail: ( id ) => {
        return http.get(`roles/${id}/edit` );

    },
    createRole: ( data ) => {

        return http.post('roles/store', data);

    },
    getMemberList: ( params) => {
        let config = {};
        if( params ) {
            config['params'] = params;
        }
        return http.get('members/lists', config);

    },
    getMemberDetail: ( id ) => {
        return http.get(`members/${id}/edit` );

    },
    getRoleForMemberForm: () => {
        return http.get(`members/roles` );

    },
    createMember: ( data ) => {
        return http.post('members/store', data);
    },
    deleteMember: ( id ) => {
        return http.post( `members/${id}/delete` );
    },
    fetchInvitation: ( token ) => {
        return http.get( 'members/' + token + '/invitation');
    },
    acceptInvitation: ( token ) => {
        return http.post( 'members/' + token + '/accept-invitation');
    },
}
export default apis;
