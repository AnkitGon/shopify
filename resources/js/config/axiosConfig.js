import axios from 'axios';
import { getSessionToken } from "@shopify/app-bridge-utils";
import { createApp } from "@shopify/app-bridge";

const urlParams = new URLSearchParams(window.location.search);
const host = urlParams.get('host');
const apiKey = import.meta.env.VITE_SHOPIFY_API_KEY;

const app = createApp({
    apiKey: apiKey,
    host: host,
});

const axiosInstance = axios.create({
    baseURL: '/api',
    timeout: 10000,
    headers: {
        'Content-Type': 'application/json',
    },
});

axiosInstance.interceptors.request.use(async (config) => {
    try {
        const token = await getSessionToken(app);
        config.headers.Authorization = `Bearer ${token}`;
    } catch (error) {
        console.error("Error fetching session token", error);
    }
    return config;
});

export default axiosInstance;
