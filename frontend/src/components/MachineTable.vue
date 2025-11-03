<script setup>
const props = defineProps({
    items: Array
})

const emit = defineEmits({
    e: 'view',
    id: Number
})
</script>

<template>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Reset Count</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="m in props.items" :key="m.id" class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ m.name }}</td>
                    <td class="px-4 py-2">{{ m.purchase_date }}</td>
                    <td class="px-4 py-2">{{ m.reset_count ?? 0 }}</td>
                    <td class="px-4 py-2">{{ Number(m.purchase_price) }}</td>
                    <td class="px-4 py-2 text-right">
                        <button class="text-blue-600 hover:underline" @click="emit('view', m.id)">View</button>
                        <button class="text-gray-700 hover:underline ml-3" @click="emit('edit', m)">Edit</button>
                        <button class="text-red-600 hover:underline ml-3" @click="emit('delete', m.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>