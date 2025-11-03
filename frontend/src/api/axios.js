import axios from 'axios'

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    headers: { 'Accept': 'application/json' },
})

api.interceptors.request.use((config) => {
    const token = localStorage.getItem('token')
    if (token) config.headers.Authorization = `Bearer ${token}`
    return config
})

api.interceptors.response.use(
    (res) => res,
    (err) => {
        const status = err.response?.status

        if (status === 401) {
            localStorage.removeItem('token')
            window.location.href = '/login'
        }

        if (status === 422) {
            err.validationErrors = err.response.data.errors
        }

        return Promise.reject(err)
    }
)


export default api