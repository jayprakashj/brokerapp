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
        if( data?.length && data.length >= 1 ){
            for( var i =0; i< data.length; i++ ){

                fd.append('media[]', data[i] );
            }
        }else{
            fd.append('media[]', data);

        }
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
    propertySelectList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('properties/select-lists/get', config);

    },
    projectSelectList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('projects/select-lists/get', config);

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
    propertyFormDropdownList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('properties/lists/form-select-lists', config);

    },
    projectFormDropdownList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('projects/lists/form-select-lists', config);

    },
    propertyFormDropdownList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('properties/lists/form-select-lists', config);

    },
    taskStatusDropdownList: ( params) => {
        let config = {};
        if( params ) {
            config['search'] = params;
        }
        return http.get('tasks/statuses/select-lists', config);

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
    getPropertyList: ( params) => {
        let config = {};
        if( params ) {
            config['params'] = params;
        }
        return http.get('properties/lists', config);

    },
    getPropertyDetail: ( id ) => {
        return http.get(`properties/${id}/edit` );
    },
    getPropertyViewDetail: ( id ) => {
        return http.get(`properties/${id}/view` );
    },
    getPropertyDocumentList: ( id ) => {
        return http.get(`properties/${id}/documents` );
    },
    getPropertyDocumentDropdownList: ( id ) => {
        return http.get(`properties/${id}/documents/select-lists` );
    },
    createProperty: ( data ) => {
        return http.post('properties/store', data);
    },
    deleteProperty: ( id ) => {
        return http.post( `properties/${id}/delete` );
    },
    getDocumentList: ( params) => {
        let config = {};
        if( params ) {
            config['params'] = params;
        }
        return http.get('documents/lists', config);

    },
    getDocumentDetail: ( id ) => {
        return http.get(`documents/${id}/edit` );
    },
    createDocument: ( data ) => {
        return http.post('documents/store', data);
    },
    deleteDocument: ( id ) => {
        return http.post( `documents/${id}/delete` );
    },
    detachPropertyWithDocument: ( id ) => {
        return http.post( `documents/${id}/detach-property` );
    },
    attachPropertyToDocument: ( data ) => {
        return http.post( `documents/attach-property`, data );
    },
    getProjectList: ( params) => {
        let config = {};
        if( params ) {
            config['params'] = params;
        }
        return http.get('projects/lists', config);

    },
    getProjectDetail: ( id ) => {
        return http.get(`projects/${id}/edit` );
    },
    getProjectViewDetail: ( id ) => {
        return http.get(`projects/${id}/view` );
    },
    createProject: ( data ) => {
        return http.post('projects/store', data);
    },
    deleteProject: ( id ) => {
        return http.post( `projects/${id}/delete` );
    },
    getTaskList: ( params) => {
        let config = {};
        if( params ) {
            config['params'] = params;
        }
        return http.get('tasks/lists', config);

    },
    getTaskDetail: ( id ) => {
        return http.get(`tasks/${id}/edit` );
    },
    getTaskViewDetail: ( id ) => {
        return http.get(`tasks/${id}/view` );
    },
    createTask: ( data ) => {
        return http.post('tasks/store', data);
    },
    deleteTask: ( id ) => {
        return http.post( `tasks/${id}/delete` );
    },
    getSiteVisitList: ( params) => {
        let config = {};
        if( params ) {
            config['params'] = params;
        }
        return http.get('site-visits/lists', config);

    },
    getSiteVisitDetail: ( id ) => {
        return http.get(`site-visits/${id}/edit` );
    },
    getSiteVisitViewDetail: ( id ) => {
        return http.get(`site-visits/${id}/view` );
    },
    createSiteVisit: ( data ) => {
        return http.post('site-visits/store', data);
    },
    deleteSiteVisit: ( id ) => {
        return http.post( `site-visits/${id}/delete` );
    },
}
export default apis;
