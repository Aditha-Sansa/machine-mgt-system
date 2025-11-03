<script setup>
import { reactive, ref, watch, watchEffect } from 'vue'

const props = defineProps({
    open: Boolean,
    value: Object,
    errors: { type: Object, default: () => ({}) }
})

const emit = defineEmits([
    'close',
    'save'
])

const errors = reactive({})
const saving = ref(false)
const form = reactive({ name: '', purchase_date: '', purchase_price: 0, category: '', brand: '' })
watchEffect(() => {
    Object.assign(form, props.value ?? Object.keys(errors).forEach(k => delete errors[k]))
})


function save() {

    emit('save', { ...form, id: props.value?.id })

}
</script>


<template>
    <div v-if="open" class="fixed inset-0 bg-black/40 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6">
            <h3 class="text-lg font-semibold mb-4">{{ form.id ? 'Edit' : 'Add' }} Machine</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <label class="block text-sm">Name
                    <input v-model="form.name" class="mt-1 w-full border rounded px-3 py-2" />
                    <span v-if="props.errors.name" class="text-red-600 text-xs">
                        {{ props.errors.name[0] }}
                    </span>
                </label>
                <label class="block text-sm">Purchase Date
                    <input v-model="form.purchase_date" type="date" class="mt-1 w-full border rounded px-3 py-2" />
                    <span v-if="props.errors.purchase_date" class="text-red-600 text-xs">
                        {{ props.errors.purchase_date[0] }}
                    </span>
                </label>
                <label class="block text-sm">Price
                    <input v-model.number="form.purchase_price" type="number" step="0.01"
                        class="mt-1 w-full border rounded px-3 py-2" />
                    <span v-if="props.errors.purchase_price" class="text-red-600 text-xs">
                        {{ props.errors.purchase_price[0] }}
                    </span>
                </label>
                <label class="block text-sm">Category
                    <select v-model="form.category" class="mt-1 w-full border rounded px-3 py-2">
                        <option>Large</option>
                        <option>Medium</option>
                        <option>Small</option>
                    </select>
                    <span v-if="props.errors.category" class="text-red-600 text-xs">
                        {{ props.errors.category[0] }}
                    </span>
                </label>
                <label class="block text-sm">Brand
                    <select v-model="form.brand" class="mt-1 w-full border rounded px-3 py-2">
                        <option>BMW</option>
                        <option>Suzuki</option>
                        <option>CAT</option>
                    </select>
                    <span v-if="props.errors.brand" class="text-red-600 text-xs">
                        {{ props.errors.brand[0] }}
                    </span>
                </label>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button class="px-4 py-2 rounded border" @click="emit('close')">Cancel</button>
                <button class="px-4 py-2 rounded bg-gray-900 text-white" @click="save">Save</button>
            </div>
        </div>
    </div>
</template>