<script setup>
import router from '@/router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()

async function handleLogout() {
    try {
        await auth.logout()
        router.push('/login')
    } catch (error) {
        console.error(error)
    }
}
</script>

<template>
    <header class="bg-white border-b sticky top-0 z-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between">
            <div class="flex items-center justify-between w-100">
                <h1 class="font-semibold text-lg">Machine Management System</h1>
                <router-link class="text-gray-600 hover:text-gray-900" to="/">Machines</router-link>
            </div>

            <div class="flex items-center justify-center gap-3" v-if="$route.path !== '/login'">
                <button class="px-2 py-2 hover:underline bg-red-400 text-white rounded flex items-center cursor-pointer"
                    @click="handleLogout">
                    <span>Logout</span>
                    <span class="mx-2 icon-[streamline-sharp--logout-2]"></span>
                </button>
            </div>
        </div>
    </header>
</template>