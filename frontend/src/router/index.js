import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/LoginView.vue'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/login', name: 'login', component: LoginView }
    ],
})

router.beforeEach(async (to) => {
    const auth = useAuthStore()
    if (to.meta.auth && !auth.token) {
        return { name: 'login' }
    }
})

export default router