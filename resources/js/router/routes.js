import Dashboard from  '@/components/dashboard/Dashboard.vue'
import ProfileUpdate from  '@/components/profile/ProfileUpdate.vue'
import ChangePassword from  '@/components/profile/ChangePassword.vue'
import CompanyList from  '@/components/company/CompanyList.vue'
import CompanyCreate from  '@/components/company/CompanyCreate.vue'
import RoleList from  '@/components/roles/RoleList.vue'
import RoleCreate from  '@/components/roles/RoleCreate.vue'
import MemberList from  '@/components/members/MemberList.vue'
import MemberCreate from  '@/components/members/MemberCreate.vue'
import ViewInvitation from  '@/components/members/ViewInvitation.vue'
import NotFound from  '@/components/errors/NotFound.vue'
import Unauthorize from  '@/components/errors/Unauthorize.vue'

const routes = [
    {
        path: '/',
        name: 'home',
        component: Dashboard,
        meta:{
            title: 'Home'
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
            title: 'Role Management'
        },
    },
    {
        path: '/role/create',
        name: 'role_create',
        component: RoleCreate,
        meta: {
            title: 'Role Create'
        }
    },
    {
        path: '/role/edit/:id',
        name: 'role_edit',
        component: RoleCreate,
        meta: {
            title: 'Role Edit'
        }
    },
    {
        path: '/member',
        name: 'member_lists',
        component: MemberList,
        meta:{
            title: 'Member Management'
        },
    },
    {
        path: '/member/create',
        name: 'member_create',
        component: MemberCreate,
        meta: {
            title: 'Member Create'
        }
    },
    {
        path: '/member/edit/:id',
        name: 'member_edit',
        component: MemberCreate,
        meta: {
            title: 'Member Edit'
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
        path: '/401',
        name: '401',
        component: Unauthorize,
        meta:{
            title: 'Unauthorize'
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: '404',
        component: NotFound,
        meta:{
            title: '404'
        }
    },
];

export default routes;
