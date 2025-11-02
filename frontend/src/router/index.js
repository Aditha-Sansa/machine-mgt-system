import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '@/views/LoginView.vue'
import MachineView from '../views/MachineView.vue'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/login', name: 'login', component: LoginView },
        { path: '/', name: 'machines', component: MachineView, meta: { auth: true } }
    ],
})

router.beforeEach(async (to) => {
    const auth = useAuthStore()
    if (to.meta.auth && !auth.isAuthenticated) {
        return { name: 'login' }
    }
})

export default router