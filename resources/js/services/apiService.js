import axios from 'axios';
import { useAuthStore } from '@/stores/auth';

const ApiService = {

    // Function for making a GET request
    get(resource, params = {}) {

        const authStore = useAuthStore();

        return axios.get(resource, {
            headers: {
                Authorization: "Bearer "+authStore.token,
            },
            params:params
        }).then(response => response.data)
            .catch(error => {
                throw new Error(`[ApiService] GET ${resource} ${error}`);
            });
    },

    // Function for making a POST request
    post(resource, data = {}) {
        const authStore = useAuthStore();
        return axios.post(resource, data, {
            headers: {
                Authorization: "Bearer "+authStore?.token,
                'Content-Type': 'multipart/form-data'
            }
        })
            .then(response => response.data)
            .catch(error => {
                throw new Error(`[ApiService] POST ${resource} ${error}`);
            });
    },

    // Function for making a PUT request
    put(resource, data) {

        const authStore = useAuthStore();

        return axios.put(resource, data, {Authorization: "Bearer "+authStore?.token})
            .then(response => response.data)
            .catch(error => {
                throw new Error(`[ApiService] PUT ${resource} ${error}`);
            });
    },

    // Function for making a DELETE request
    delete(resource) {

        const authStore = useAuthStore();

        return axios.delete(resource, {Authorization: "Bearer "+authStore?.token})
            .then(response => response.data)
            .catch(error => {
                throw new Error(`[ApiService] DELETE ${resource} ${error}`);
            });
    },
};
export default ApiService;
