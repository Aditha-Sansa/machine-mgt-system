<script setup>
import { onMounted, ref, computed } from 'vue'
import { useRoute } from 'vue-router'
import Card from '@/components/Card.vue'
import { useMachineStore } from '@/stores/machine'

const store = useMachineStore()
const route = useRoute()

onMounted(() => { store.find(Number(route.params.id)) })

const m = computed(() => store.selected)

</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">Machine Detail</h2>
        </div>


        <Card>
            <div v-if="m" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <div class="text-sm text-gray-500">Name</div>
                    <div class="font-medium">{{ m.data.name }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Category</div>
                    <div class="font-medium">{{ m.data.category }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Brand</div>
                    <div class="font-medium">{{ m.data.brand }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Purchase Date</div>
                    <div class="font-medium">{{ m.data.purchase_date }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Purchase Price</div>
                    <div class="font-medium">{{ Number(m.data.purchase_price).toLocaleString() }} LKR</div>
                </div>
            </div>
        </Card>

    </div>
</template>