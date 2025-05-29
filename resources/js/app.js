import "./bootstrap";
import { createApp } from "vue";

import App from "../components/App.vue";
import router from "../types/router";

createApp(App).use(router).mount("#app");
