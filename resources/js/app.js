import "./bootstrap";
import { createApp } from "vue";
import { createPinia } from "pinia";
import piniaPersistedState from "pinia-plugin-persistedstate";

import App from "../App.vue";
import router from "../types/router";
import { Icon } from "@iconify/vue";

import pinia from "../types/stores/pinia";

const app = createApp(App).component("Icon", Icon);

pinia.use(piniaPersistedState);

app.use(router);
app.use(pinia);
app.mount("#app");

export { pinia };
