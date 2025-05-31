import axios, {
    AxiosInstance,
    AxiosRequestConfig,
    AxiosResponse,
    AxiosError,
} from "axios";
import router from "../router";
import { useAuthStore } from "../stores/authManagement";
import { useNotificationStore } from "../stores/notificationManagement";

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
    const notif = useNotificationStore();

    if (auth.user && auth.token) {
        axiosInstance.defaults.headers.common["Authorization"] =
            `Bearer ${auth.token}`;
        axiosInstance.defaults.baseURL = `${import.meta.env.VITE_API_URL}/api`;
    }

    axiosInstance.interceptors.response.use(
        (response: AxiosResponse) => {
            return response;
        },
        (error: AxiosError) => {
            if (error.message === "Network Error" && !error.response) {
                notif.setNotification({
                    type: "error",
                    message: "Network error. Please check your connection.",
                    is_triggered: true,
                });

                return Promise.reject(
                    "Network error. Please check your connection.",
                );
            }
            if (error.response!.status === 401) {
                auth.clearUser();
                auth.clearToken();

                notif.setNotification({
                    type: "error",
                    message:
                        "Your session is going to be closed now, please login again!",
                    is_triggered: true,
                });

                router.push({ name: "login" });
            } else {
                return Promise.reject(error);
            }
        },
    );

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
