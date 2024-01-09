import permission from '@/constants/permissions' ;

import Dashboard from  '@/components/dashboard/Dashboard.vue'
import ProfileUpdate from  '@/components/profile/ProfileUpdate.vue'
import ChangePassword from  '@/components/profile/ChangePassword.vue'
import CompanyList from  '@/components/company/CompanyList.vue'
import CompanyCreate from  '@/components/company/CompanyCreate.vue'
import CompanySetting from  '@/components/company/CompanySetting.vue'
import RoleList from  '@/components/roles/RoleList.vue'
import RoleCreate from  '@/components/roles/RoleCreate.vue'
import MemberList from  '@/components/members/MemberList.vue'
import MemberCreate from  '@/components/members/MemberCreate.vue'
import BranchList from  '@/components/company_branch/BranchList.vue'
import BranchCreate from  '@/components/company_branch/BranchCreate.vue'
import ContactList from  '@/components/contacts/ContactList.vue'
import ContactCreate from  '@/components/contacts/ContactCreate.vue'
import LeadList from  '@/components/leads/LeadList.vue'
import LeadCreate from  '@/components/leads/LeadCreate.vue'
import LeadView from  '@/components/leads/LeadView.vue'
import PropertyList from  '@/components/property/PropertyList.vue'
import PropertyCreate from  '@/components/property/PropertyCreate.vue'
import PropertyView from  '@/components/property/PropertyView.vue'
import PropertyDocumentList from  '@/components/property/PropertyDocumentList.vue'
import DocumentList from  '@/components/documents/DocumentList.vue'
import DocumentCreate from  '@/components/documents/DocumentCreate.vue'
import ProjectList from  '@/components/project/ProjectList.vue'
import ProjectCreate from  '@/components/project/ProjectCreate.vue'
import ProjectView from  '@/components/project/ProjectView.vue'
import TaskList from  '@/components/tasks/TaskList.vue'
import TaskCreate from  '@/components/tasks/TaskCreate.vue'
import TaskView from  '@/components/tasks/TaskView.vue'
import SiteVisitList from  '@/components/site_visits/SiteVisitList.vue'
import SiteVisitCreate from  '@/components/site_visits/SiteVisitCreate.vue'
import SiteVisitView from  '@/components/site_visits/SiteVisitView.vue'
import ApiList from  '@/components/api_doc/ApiList.vue'
import EnquiryForm from  '@/components/enquiry/EnquiryForm.vue'
import ViewInvitation from  '@/components/members/ViewInvitation.vue'
import MemberRoleHierarchyTree from  '@/components/members/MemberRolesHierarchyTree.vue'
import MemberLocationHistory from  '@/components/member_location_history/MemberLocationHistory.vue'
import NotFound from  '@/components/errors/NotFound.vue'
import Unauthorize from  '@/components/errors/Unauthorize.vue'

const routes = [
    {
        path: '/',
        redirect:'/dashboard'
    },

    {
        path: '/customer/enquiry/:type',
        name: 'customer_enquiry',
        component: EnquiryForm,
        meta: {
            title: 'Customer Enquiry'
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta:{
            title: 'Dashboard'
        }
    },
    {
        path: '/profile',
        name: 'profile',
        component: ProfileUpdate,
        meta:{
            title: 'Profile'
        }
    },
    {
        path: '/company/setting',
        name: 'company_setting',
        component: CompanySetting,
        meta:{
            title: 'Company Setting'
        },
        permissions: [ permission.COMPANY_SETTING ]
    },
    {
        path: '/change-password',
        name: 'change_password',
        component: ChangePassword,
        meta:{
            title: 'Change Password'
        }
    },
    {
        path: '/company',
        name: 'company_lists',
        component: CompanyList,
        meta:{
            title: 'Company Management'
        },
    },
    // {
    //     path: '/company/create',
    //     name: 'company_create',
    //     component: CompanyCreate,
    //     meta: {
    //         title: 'Company Create'
    //     }
    // },
    {
        path: '/company/edit/:id',
        name: 'company_edit',
        component: CompanyCreate,
        meta: {
            title: 'Company Edit'
        }
    },
    {
        path: '/role',
        name: 'role_lists',
        component: RoleList,
        meta:{
            title: 'Role Management',
            permissions: [ permission.ROLE_LIST ]
        },
    },
    {
        path: '/role/create',
        name: 'role_create',
        component: RoleCreate,
        meta: {
            title: 'Role Create',
            permissions: [ permission.ADD_ROLE ]
        }
    },
    {
        path: '/role/edit/:id',
        name: 'role_edit',
        component: RoleCreate,
        meta: {
            title: 'Role Edit',
            permissions: [ permission.UPDATE_ROLE ]
        }
    },
    {
        path: '/member',
        name: 'member_lists',
        component: MemberList,
        meta:{
            title: 'Member Management',
            permissions: [ permission.MEMBER_LIST ]
        },
    },
    {
        path: '/member/create',
        name: 'member_create',
        component: MemberCreate,
        meta: {
            title: 'Member Create',
            permissions: [ permission.ADD_MEMBER ]
        }
    },
    {
        path: '/member/edit/:id',
        name: 'member_edit',
        component: MemberCreate,
        meta: {
            title: 'Member Edit',
            permissions: [ permission.UPDATE_MEMBER ]
        }
    },
    {
        path: '/member/:token/invitation',
        name: 'member_invitation',
        component: ViewInvitation,
        meta: {
            title: 'Invitation'
        }
    },
    {
        path: '/member/roles-hierarchy',
        name: 'member_roles_hierarchy',
        component: MemberRoleHierarchyTree,
        meta: {
            title: 'Roles Hierarchy Tree'
        }
    },
    {
        path: '/branch',
        name: 'branch_lists',
        component: BranchList,
        meta:{
            title: 'Branch Management',
            permissions: [ permission.BRANCH_LIST ]
        },
    },
    {
        path: '/branch/create',
        name: 'branch_create',
        component: BranchCreate,
        meta: {
            title: 'Branch Create',
            permissions: [ permission.ADD_BRANCH ]
        }
    },
    {
        path: '/branch/edit/:id',
        name: 'branch_edit',
        component: BranchCreate,
        meta: {
            title: 'Branch Edit',
            permissions: [ permission.UPDATE_BRANCH ]
        }
    },
    {
        path: '/contact',
        name: 'contact_lists',
        component: ContactList,
        meta:{
            title: 'Contact Management',
            permissions: [ permission.CONTACT_LIST ]
        },
    },
    {
        path: '/contact/create',
        name: 'contact_create',
        component: ContactCreate,
        meta: {
            title: 'Contact Create',
            permissions: [ permission.ADD_CONTACT ]
        }
    },
    {
        path: '/contact/edit/:id',
        name: 'contact_edit',
        component: ContactCreate,
        meta: {
            title: 'Contact Edit',
            permissions: [ permission.UPDATE_CONTACT ]
        }
    },
    {
        path: '/lead',
        name: 'lead_lists',
        component: LeadList,
        meta:{
            title: 'Lead Management',
            permissions: [ permission.LEAD_LIST, permission.ONLY_ASSIGNED_LEAD_LIST ]
        },
    },
    {
        path: '/lead/create',
        name: 'lead_create',
        component: LeadCreate,
        meta: {
            title: 'Lead Create',
            permissions: [ permission.ADD_LEAD ]
        }
    },
    {
        path: '/lead/edit/:id',
        name: 'lead_edit',
        component: LeadCreate,
        meta: {
            title: 'Lead Edit',
            permissions: [ permission.UPDATE_LEAD ]
        }
    },
    {
        path: '/lead/view/:id',
        name: 'lead_view',
        component: LeadView,
        meta: {
            title: 'Lead View',
            permissions: [ permission.VIEW_LEAD ]
        }
    },
    {
        path: '/property',
        name: 'property_lists',
        component: PropertyList,
        meta:{
            title: 'Property Management',
            permissions: [ permission.PROPERTY_LIST, permission.ONLY_ASSIGNED_PROPERTY_LIST ]
        },
    },
    {
        path: '/property/create',
        name: 'property_create',
        component: PropertyCreate,
        meta: {
            title: 'Property Create',
            permissions: [ permission.ADD_PROPERTY ]
        }
    },
    {
        path: '/property/edit/:id',
        name: 'property_edit',
        component: PropertyCreate,
        meta: {
            title: 'Property Edit',
            permissions: [ permission.UPDATE_PROPERTY ]
        }
    },
    {
        path: '/property/view/:id',
        name: 'property_view',
        component: PropertyView,
        meta: {
            title: 'Property View',
            permissions: [ permission.VIEW_PROPERTY ]
        }
    },
    {
        path: '/property/:id/documents',
        name: 'property_document',
        component: PropertyDocumentList,
        meta: {
            title: 'Property Document',
            permissions: [ permission.DOCUMENT_ATTACH_TO_PROPERTY ]
        }
    },
    {
        path: '/document',
        name: 'document_lists',
        component: DocumentList,
        meta:{
            title: 'Document Management',
            permissions: [ permission.DOCUMENT_LIST]
        },
    },
    {
        path: '/document/create',
        name: 'document_create',
        component: DocumentCreate,
        meta: {
            title: 'Document Create',
            permissions: [ permission.ADD_DOCUMENT ]
        }
    },
    {
        path: '/document/edit/:id',
        name: 'document_edit',
        component: DocumentCreate,
        meta: {
            title: 'Document Edit',
            permissions: [ permission.UPDATE_DOCUMENT ]
        }
    },
    {
        path: '/project',
        name: 'project_lists',
        component: ProjectList,
        meta:{
            title: 'Project Management',
            permissions: [ permission.PROJECT_LIST, permission.ONLY_ASSIGNED_PROJECT_LIST ]
        },
    },
    {
        path: '/project/create',
        name: 'project_create',
        component: ProjectCreate,
        meta: {
            title: 'Project Create',
            permissions: [ permission.ADD_PROJECT ]
        }
    },
    {
        path: '/project/edit/:id',
        name: 'project_edit',
        component: ProjectCreate,
        meta: {
            title: 'Project Edit',
            permissions: [ permission.UPDATE_PROJECT ]
        }
    },
    {
        path: '/project/view/:id',
        name: 'project_view',
        component: ProjectView,
        meta: {
            title: 'Project View',
            permissions: [ permission.VIEW_PROJECT ]
        }
    },
    {
        path: '/task',
        name: 'task_lists',
        component: TaskList,
        meta:{
            title: 'Task Management',
            permissions: [ permission.TASK_LIST, permission.ONLY_ASSIGNED_TASK_LIST ]
        },
    },
    {
        path: '/task/create',
        name: 'task_create',
        component: TaskCreate,
        meta: {
            title: 'Task Create',
            permissions: [ permission.ADD_TASK ]
        }
    },
    {
        path: '/task/edit/:id',
        name: 'task_edit',
        component: TaskCreate,
        meta: {
            title: 'Task Edit',
            permissions: [ permission.UPDATE_TASK ]
        }
    },
    {
        path: '/task/view/:id',
        name: 'task_view',
        component: TaskView,
        meta: {
            title: 'Task View',
            permissions: [ permission.VIEW_TASK ]
        }
    },
    {
        path: '/site-visit',
        name: 'site_visit_lists',
        component: SiteVisitList,
        meta:{
            title: 'Site Visit Management',
            permissions: [ permission.SITE_VISIT_LIST, permission.ONLY_ASSIGNED_SITE_VISIT_LIST ]
        },
    },
    {
        path: '/site-visit/create',
        name: 'site_visit_create',
        component: SiteVisitCreate,
        meta: {
            title: 'Site Visit Create',
            permissions: [ permission.ADD_SITE_VISIT ]
        }
    },
    {
        path: '/site-visit/edit/:id',
        name: 'site_visit_edit',
        component: SiteVisitCreate,
        meta: {
            title: 'Site Visit Edit',
            permissions: [ permission.UPDATE_SITE_VISIT ]
        }
    },
    {
        path: '/site-visit/view/:id',
        name: 'site_visit_view',
        component: SiteVisitView,
        meta: {
            title: 'Site Visit View',
            permissions: [ permission.VIEW_SITE_VISIT ]
        }
    },
    {
        path: '/api-documentation',
        name: 'api_doc',
        component: ApiList,
        meta: {
            title: 'API Documentations'
        }
    },
    {
        path: '/member/location-history',
        name: 'member_location_history',
        component: MemberLocationHistory,
        meta: {
            title: 'Location History',
            permissions: [ permission.VIEW_MEMBER_LOCATION_HISTORY ]
        }
    },
    {
        path: '/401',
        name: '401',
        component: Unauthorize,
        meta:{
            title: 'Unauthorize'
        }
    },
    {
        path: '/404',
        name: '404',
        component: NotFound,
        meta:{
            title: '404 - Not Found'
        }
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/404'
    },
];

export default routes;
