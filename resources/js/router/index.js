import { nextTick, getCurrentInstance } from 'vue';
import { createRouter, createWebHistory } from 'vue-router'
import routes from './routes'
import vueStore from "@/store/index";

const guardRotues = [
    'dashboard'
]

const router = createRouter({
	history: createWebHistory('/'),
	routes,
	scrollBehavior(to, from, savedPosition) {
		// always scroll to top
		return { top: 0 }
	},
})

router.beforeEach( ( to, from, next ) => {
    const userPermissions = vueStore.getters.userPermissions;
    vueStore.commit('setGlobalLoaderOn');
    if( to?.meta?.permissions ){
        if( userPermissions.isPermissionsAllowed( to.meta.permissions ) ){
            next();
        }else{
            next('/401');
        }
    }else{
        next();
    }
	// if( notGuardRotues.includes( to.name ) ){
	// 	notAuthGuard( to, from, next );
	// }else if( guardRotues.includes( to.name ) ){
	// 	authGuard( to, from, next );
	// }else{
		next();
	// }

});
router.afterEach( ( to, from, next ) => {
	nextTick(() =>{
		// store.commit( 'changeSubMenuVisibility', true );
		// store.commit( 'changeSelectedSubMenu', null );
		// if( typeof to?.meta?.title === 'string'){
		// 	document.title = to.meta.title;
		// }
	})
});
export default router
