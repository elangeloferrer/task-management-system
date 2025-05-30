import api from "./api";

const URLS = {
    user: "user/",
};

export const loadUser = async () => {
    const { get } = api();
    return await get(URLS.user);
};
