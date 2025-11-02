<script setup>
import { ref, onMounted } from 'vue'
import Card from '@/components/Card.vue'
import MachineTable from '@/components/MachineTable.vue'
import PaginationBar from '@/components/PaginationBar.vue'
import { useRouter } from 'vue-router'
import { useMachineStore } from '@/stores/machine'

const machines = useMachineStore()
const router = useRouter()

onMounted(() => { machines.fetch().then(console.log('fetched records')) })


</script>

<template>
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">Machines</h2>
            <div class="flex gap-2">
                <button class="px-3 py-2 bg-gray-900 text-white rounded" @click="add">Add</button>
            </div>
        </div>


        <Card>
            <MachineTable :items="machines.items" />
            <PaginationBar :page="machines.page" :lastPage="machines.lastPage" @change="machines.fetch" />
        </Card>
    </div>
</template>