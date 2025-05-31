import { reactive, watch } from "vue";

const store = reactive<Record<string, any>>({});

// Save value to localStorage and reactive store
export const save = (key: string, value: any) => {
    localStorage.setItem(key, JSON.stringify(value));
    store[key] = value;
};

// Remove from localStorage and store
export const remove = (key: string) => {
    localStorage.removeItem(key);
    delete store[key];
};

// Load from localStorage into reactive store
export const load = (key: string) => {
    const raw = localStorage.getItem(key);
    if (raw) {
        try {
            store[key] = JSON.parse(raw);
        } catch {
            store[key] = raw;
        }
    }
};

// Get from reactive store
export const get = (key: string) => store[key];
