import api from './axios'

export async function listMachines(page = 1) {
    const { data } = await api.get(`/machines`, { params: { page } })
    return data
}

export async function getMachine(id) {
    const { data } = await api.get(`/machines/${id}`)
    return data
}

export async function createMachine(payload) {
    const { data } = await api.post(`/machines`, payload)
    return data
}

export async function updateMachine(id, payload) {
    const { data } = await api.put(`/machines/${id}`, payload)
    return data
}