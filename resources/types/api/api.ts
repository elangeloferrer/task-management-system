import axios, { AxiosInstance, AxiosRequestConfig, AxiosResponse } from "axios";
import { useAuthStore } from "../stores/authManagement";

const axiosInstance: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    withCredentials: true,
    headers: {
        "Content-Type": "application/json",
    },
});

const api = () => {
    const controller = new AbortController();
    const auth = useAuthStore();

    if (auth.user && auth.token) {
        axiosInstance.defaults.headers.common["Authorization"] =
            `Bearer ${auth.token}`;
        axiosInstance.defaults.baseURL = `${import.meta.env.VITE_API_URL}/api`;
    }

    const getCsrf = async () => {
        await axiosInstance.get("/sanctum/csrf-cookie");
    };

    const get = async <T = any>(
        url: string,
        config: AxiosRequestConfig = {},
    ): Promise<AxiosResponse<T>> => {
        await getCsrf();

        const response = await axiosInstance.get<T>(url, {
            signal: controller.signal,
            ...config,
        });

        return response;
    };

    return {
        getCsrf,
        get,
        controller,
    };
};

export default api;
