import axios, {
    AxiosInstance,
    AxiosRequestConfig,
    AxiosResponse,
    AxiosError,
} from "axios";
import router from "../router";

import { useAuthStore } from "../stores/authManagement";
import { useNotificationStore } from "../stores/notificationManagement";

// Lazy-loaded inside functions to avoid circular dependencies
let axiosInstance: AxiosInstance;

const createAxiosInstance = (): AxiosInstance => {
    const instance = axios.create({
        baseURL: import.meta.env.VITE_API_URL + "/api",
        withCredentials: true,
        headers: {
            "Content-Type": "application/json",
        },
    });

    instance.interceptors.response.use(
        (response: AxiosResponse) => response,
        (error: AxiosError) => {
            // Lazy load stores to avoid circular dependency

            const auth = useAuthStore();
            const notif = useNotificationStore();

            if (error.message === "Network Error" && !error.response) {
                notif.setNotification({
                    type: "error",
                    message: "Network error. Please check your connection.",
                    is_triggered: true,
                });
                return Promise.reject("Network error.");
            }

            if (error.response?.status === 401) {
                auth.clearUser();
                auth.clearToken();
                localStorage.clear();

                notif.setNotification({
                    type: "error",
                    message: "Your session has expired. Please login again.",
                    is_triggered: true,
                });

                router.push({ name: "login" });
                return Promise.reject("Session expired");
            }

            return Promise.reject(error);
        },
    );

    return instance;
};

axiosInstance = createAxiosInstance();

const api = () => {
    const controller = new AbortController();

    const getCsrf = async () => {
        await axiosInstance.get("/sanctum/csrf-cookie");
    };

    const get = async <T = any>(
        url: string,
        config: AxiosRequestConfig = {},
    ): Promise<AxiosResponse<T>> => {
        await getCsrf();
        return await axiosInstance.get<T>(url, {
            signal: controller.signal,
            ...config,
        });
    };

    const post = async <T = any>(
        url: string,
        data?: any,
        config: AxiosRequestConfig = {},
    ): Promise<AxiosResponse<T>> => {
        await getCsrf();
        return await axiosInstance.post<T>(url, data, {
            signal: controller.signal,
            ...config,
        });
    };

    const put = async <T = any>(
        url: string,
        data?: any,
        config: AxiosRequestConfig = {},
    ): Promise<AxiosResponse<T>> => {
        await getCsrf();
        return await axiosInstance.put<T>(url, data, {
            signal: controller.signal,
            ...config,
        });
    };

    const patch = async <T = any>(
        url: string,
        data?: any,
        config: AxiosRequestConfig = {},
    ): Promise<AxiosResponse<T>> => {
        await getCsrf();
        return await axiosInstance.patch<T>(url, data, {
            signal: controller.signal,
            ...config,
        });
    };

    const destroy = async <T = any>(
        url: string,
        config: AxiosRequestConfig = {},
    ): Promise<AxiosResponse<T>> => {
        await getCsrf();
        return await axiosInstance.delete<T>(url, {
            signal: controller.signal,
            ...config,
        });
    };

    return {
        getCsrf,
        get,
        post,
        put,
        patch,
        delete: destroy,
        controller,
    };
};

export default api;
