import "./bootstrap";
import { createApp } from "vue";
import { createPinia } from "pinia";
import piniaPersistedState from "pinia-plugin-persistedstate";

import App from "../App.vue";
import router from "../types/router";
import { Icon } from "@iconify/vue";

const app = createApp(App).component("Icon", Icon);

const pinia = createPinia();
pinia.use(piniaPersistedState);

app.use(router);
app.use(pinia);
app.mount("#app");
