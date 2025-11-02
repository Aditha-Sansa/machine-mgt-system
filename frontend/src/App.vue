<script setup>
import AppHeader from '@/components/AppHeader.vue'
</script>

<template>
    <div class="min-h-screen bg-gray-50 text-gray-800">
        <AppHeader />
        <main class="max-w-6xl mx-auto p-4 sm:p-6">
            <router-view />
        </main>
    </div>
</template>

<style scoped></style>
