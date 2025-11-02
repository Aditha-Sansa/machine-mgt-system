<script setup>
const props = defineProps({
    page: Number,
    lastPage: Number
})

const emit = defineEmits({
    e: 'change',
    page: Number
})
</script>


<template>
    <div class="flex items-center justify-between mt-4">
        <button class="px-3 py-1.5 border rounded disabled:opacity-50" :disabled="props.page <= 1"
            @click="emit('change', props.page - 1)">Prev</button>
        <span class="text-sm text-gray-600">Page {{ props.page }} / {{ props.lastPage }}</span>
        <button class="px-3 py-1.5 border rounded disabled:opacity-50" :disabled="props.page >= props.lastPage"
            @click="emit('change', props.page + 1)">Next</button>
    </div>
</template>