// stores/notification.ts
import { defineStore } from "pinia";
import { showSuccessToast, showErrorToast } from "../utils/toast";
import type { INotification } from "../models/INotification";

export const useNotificationStore = defineStore("notification", {
    state: (): { latest_notif: INotification | null } => ({
        latest_notif: null,
    }),

    actions: {
        setNotification(notif: INotification) {
            this.latest_notif = notif;
        },

        clearNotification() {
            this.latest_notif = null;
        },

        triggerNotification() {
            const notif = this.latest_notif;
            if (!notif || !notif.is_triggered) return;

            if (notif.type === "success") {
                showSuccessToast(notif.message);
            } else if (notif.type === "error") {
                showErrorToast(notif.message);
            }

            this.clearNotification();
        },
    },

    persist: true,
});
