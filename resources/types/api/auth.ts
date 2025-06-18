import api from "./api";

const URLS = {
    register: "register",
    login: "login",
    logout: "logout",
    user: "user/",
};

const { get } = api();
const { post } = api();

export const register = async (payload) => {
    return await post(URLS.register, payload);
};

export const login = async (payload) => {
    return await post(URLS.login, payload);
};

export const logout = async () => {
    return await post(URLS.logout);
};

export const loadUser = async () => {
    return await get(URLS.user);
};
