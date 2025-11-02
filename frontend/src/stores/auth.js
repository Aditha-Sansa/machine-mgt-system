import { defineStore } from 'pinia'
import { login as apiLogin, logout as apiLogout } from '@/api/authService'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: (localStorage.getItem('token') || null),
        loading: false,
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
    actions: {
        async login(email, password) {
            this.loading = true
            try {
                const { token, user } = await apiLogin(email, password)
                this.token = token
                this.user = user
                localStorage.setItem('token', token)
            } finally {
                this.loading = false
            }
        },
        async logout() {
            try {
                await apiLogout()
            } catch { }
            this.user = null
            this.token = null
            localStorage.removeItem('token')
        },
    },
});