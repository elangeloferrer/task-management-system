import api from "./api";

const URLS = {
    task: "task/",
    tasks: "tasks/",
};

export const loadtask = async () => {
    const { get } = api();
    return await get(URLS.task);
};

export const loadTasks = async (payload: {
    page: number;
    per_page: number;
}) => {
    const { get } = api();
    return await get(URLS.tasks, {
        params: payload,
    });
};
