import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";

import axios from "axios";

axios.defaults.baseURL = "http://localhost/api";
axios.defaults.headers.common["Accept"] = "application/json";

createApp(App).use(router).mount("#app");
