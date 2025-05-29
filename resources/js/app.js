import "./bootstrap";
import { createApp } from "vue";
import { createPinia } from "pinia";

import App from "../App.vue";
import router from "../types/router";
import { Icon } from "@iconify/vue";

const app = createApp(App).component("Icon", Icon);

app.use(router);
app.use(createPinia());
app.mount("#app");
