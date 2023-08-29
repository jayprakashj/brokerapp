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
        if (error.response && error.response.status === 403) {

            router.push({name: '401'});
        }
        if (error.response && error.response.status === 404) {
            router.push({name: '404'});
        }

        if (error.response && error.response.status === 500 && error.response?.data?.default_company && error.response.data.default_company === false ) {
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
    uploadMedia: ( data ) => {
        const headers = {
            headers: { 'Content-Type': 'multipart/form-data' }
        }
        const fd = new FormData;
        fd.append('media[]', data);
        return http.post('upload-media', fd, headers);

    },
    updateProfile: ( data ) => {
        return http.post('update-profile', data);

    },
    updatePassword: ( data ) => {
        return http.post('update-password', data);

    },
    contactTypeSelectList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('contacts/contact-types/select-list', config);

    },
    customerTypeSelectList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('contacts/customer-types/select-list', config);

    },
    leadSourceSelectList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('leads/lead-source/select-list', config);

    },
    leadStatusSelectList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('leads/lead-status/select-list', config);

    },
    companyBranchSelectList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('leads/company-branch/select-list', config);

    },
    companyMembersSelectList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('leads/company-members/select-list', config);

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
    deleteRole: ( id ) => {
        return http.post( `roles/${id}/delete` );
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
    getBranchList: ( params) => {
        let config = {};
        if( params ) {
            config['params'] = params;
        }
        return http.get('branches/lists', config);

    },
    getBranchDetail: ( id ) => {
        return http.get(`branches/${id}/edit` );

    },
    createBranch: ( data ) => {
        return http.post('branches/store', data);
    },
    deleteBranch: ( id ) => {
        return http.post( `branches/${id}/delete` );
    },
    getContactList: ( params) => {
        let config = {};
        if( params ) {
            config['params'] = params;
        }
        return http.get('contacts/lists', config);

    },
    getContactDetail: ( id ) => {
        return http.get(`contacts/${id}/edit` );
    },
    createContact: ( data ) => {
        return http.post('contacts/store', data);
    },
    deleteContact: ( id ) => {
        return http.post( `contacts/${id}/delete` );
    },
    getLeadList: ( params) => {
        let config = {};
        if( params ) {
            config['params'] = params;
        }
        return http.get('leads/lists', config);

    },
    getLeadDetail: ( id ) => {
        return http.get(`leads/${id}/edit` );
    },
    getLeadViewDetail: ( id ) => {
        return http.get(`leads/${id}/view` );
    },
    createLead: ( data ) => {
        return http.post('leads/store', data);
    },
    deleteLead: ( id ) => {
        return http.post( `leads/${id}/delete` );
    },
    addLeadComment: ( id, data ) => {
        return http.post( `leads/${id}/add-comment`, data );
    },
}
export default apis;
