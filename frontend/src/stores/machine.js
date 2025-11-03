import { defineStore } from 'pinia'
import { listMachines, getMachine, updateMachine, createMachine } from '@/api/machineService'

export const useMachineStore = defineStore('machine', {
    state: () => ({
        items: [],
        selected: null,
        hourLogs: [],
        page: 1,
        lastPage: 1,
        total: 0,
        loading: false
    }),
    actions: {
        async fetch(page = 1) {
            this.loading = true
            try {
                const res = await listMachines(page, this.search)

                if (Array.isArray(res)) {
                    this.items = res
                    this.page = 1; this.lastPage = 1; this.total = res.length
                } else {
                    this.items = res.data
                    this.page = res.meta?.current_page ?? 1
                    this.lastPage = res.meta?.last_page ?? 1
                    this.total = res.meta?.total ?? this.items.length
                }
            } finally { this.loading = false }
        },
        async find(id) {
            this.selected = await getMachine(id)
        },
        async save(payload) {
            try {
                if (payload.id) {
                    this.selected = await updateMachine(payload.id, payload)
                } else {
                    await createMachine(payload)
                }
                await this.fetch(this.page)
            } catch (err) {
                if (err.validationErrors) {
                    throw err.validationErrors
                }
                throw err
            }
        },
    }
})