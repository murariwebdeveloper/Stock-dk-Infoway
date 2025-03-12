import axios from 'axios';
import { defineStore } from 'pinia';
import ApiRequest from "../services/apiRequest";

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        token: localStorage.getItem('token') || null,
        apiUrl: window.apiUrl,
    }),

    getters: {
        isAuthenticated: (state) => !!state.token,
    },

    actions: {
        async login(credentials) {
            try {
                const response = await ApiRequest.login(credentials);
                if (response?.status === 1) {
                    this.token = response.data.access_token;
                    this.user = response.data.user;
                    localStorage.setItem('token', this.token);
                    axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
                }
                return response;
            } catch (error) {
                throw error.response.data.message;
            }
        },

        async logout() {
            try {
                let url = apiUrl+'/logout'
                const response = await axios.post(url, null, {
                    headers: { Authorization: `Bearer ${this.token}` }
                });

                if (response?.data.status === 1) {
                    this.token = null;
                    this.user = null;
                    localStorage.removeItem('token');
                    delete axios.defaults.headers.common['Authorization'];
                }
                return response.data;
            } catch (error) {
                console.error("Logout error:", error);
            }
        },

        async fetchUser() {
            if (!this.token) return;
            try {
                let url = apiUrl+'/user-details'
                const response = await axios.get(url,  {
                    headers: { Authorization: `Bearer ${this.token}` }
                });
                this.user = response.data.data;
            } catch (error) {

                this.token = null;
                this.user = null;
                localStorage.removeItem('token');
                delete axios.defaults.headers.common['Authorization'];

                // await this.logout();
            }
        }

    }




});
