<script setup>
import { ref, onMounted, reactive } from 'vue'
import Card from '@/components/Card.vue'
import MachineTable from '@/components/MachineTable.vue'
import PaginationBar from '@/components/PaginationBar.vue'
import MachineFormModal from '@/components/MachineFormModal.vue'
import { useRouter } from 'vue-router'
import { useMachineStore } from '@/stores/machine'

const machines = useMachineStore()
const router = useRouter()
const editing = ref(null);
const openForm = ref(false)

onMounted(() => { machines.fetch() })
const modalErrors = reactive({})

function view(id) { router.push({ name: 'machine-detail', params: { id } }) }
function add() { editing.value = null; openForm.value = true }
async function save(val) {
    try {
        await machines.save(val)
        openForm.value = false
    } catch (e) {
        if (typeof e === 'object') {
            Object.assign(modalErrors, e)
        } else {
            console.error('Unexpected error:', e)
        }
    }
}
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
            <MachineTable :items="machines.items" @view="view" />
            <PaginationBar :page="machines.page" :lastPage="machines.lastPage" @change="machines.fetch" />
        </Card>

        <MachineFormModal :open="openForm" :value="editing" :errors="modalErrors" @save="save"
            @close="openForm = false" />
    </div>
</template>