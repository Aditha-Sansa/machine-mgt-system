<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'


const email = ref('')
const password = ref('')
const auth = useAuthStore()
const router = useRouter()


async function submit() {
    try {
        await auth.login(email.value, password.value)
        router.push('/')
    } catch (e) {
        alert(e.response?.data?.message || 'Login failed')
    }
}
</script>


<template>
    <div class="flex items-center justify-center min-h-[60vh]">
        <div class="bg-white p-6 rounded-2xl shadow border w-full max-w-md">
            <h2 class="text-xl font-semibold mb-4">Sign in</h2>
            <form @submit.prevent="submit" class="space-y-3">
                <label class="block text-sm">Email
                    <input v-model="email" type="email" class="mt-1 w-full border rounded px-3 py-2" />
                </label>
                <label class="block text-sm">Password
                    <input v-model="password" type="password" class="mt-1 w-full border rounded px-3 py-2" />
                </label>
                <button class="w-full mt-2 bg-gray-900 text-white rounded px-4 py-2 cursor-pointer">Login</button>
            </form>
        </div>
    </div>
</template>