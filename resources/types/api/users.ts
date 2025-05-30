import api from "./api";

const URLS = {
    user: "user/",
    users: "users/",
};

export const loadUser = async () => {
    const { get } = api();
    return await get(URLS.user);
};

export const loadUsers = async (payload: {
    page: number;
    per_page: number;
}) => {
    const { get } = api();
    return await get(URLS.users, {
        params: payload,
    });
};
