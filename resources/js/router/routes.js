import permission from '@/constants/permissions' ;

import Dashboard from  '@/components/dashboard/Dashboard.vue'
import ProfileUpdate from  '@/components/profile/ProfileUpdate.vue'
import ChangePassword from  '@/components/profile/ChangePassword.vue'
import CompanyList from  '@/components/company/CompanyList.vue'
import CompanyCreate from  '@/components/company/CompanyCreate.vue'
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
import ViewInvitation from  '@/components/members/ViewInvitation.vue'
import NotFound from  '@/components/errors/NotFound.vue'
import Unauthorize from  '@/components/errors/Unauthorize.vue'

const routes = [
    {
        path: '/',
        redirect:'/dashboard'
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
