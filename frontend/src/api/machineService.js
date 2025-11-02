import api from './axios'

export async function listMachines(page = 1) {
    const { data } = await api.get(`/machines`, { params: { page } })
    return data
}