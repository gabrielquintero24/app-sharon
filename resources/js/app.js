import "./bootstrap";
import { createApp } from "vue";
import axios from "axios";

// Importar AG-Grid y sus estilos
import { AgGridVue } from "ag-grid-vue3";
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";

// libreria font awesome
import { library } from "@fortawesome/fontawesome-svg-core";
import { faUserSecret, faListUl } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

// Añadir iconos al library de FontAwesome
library.add(faUserSecret, faListUl);

// Crear la aplicación Vue
const app = createApp({});

// Registrar componentes
app.component("font-awesome-icon", FontAwesomeIcon);
app.component("ag-grid-vue", AgGridVue);
import PrincipalComponent from "./components/dashboard/PrincipalComponent.vue";
import ModistaComponent from "./components/dashboard/terceros/ModistaComponent.vue";
app.component("dash-principal-component", PrincipalComponent);
app.component("dash-modista-component", ModistaComponent);

// Añadimos axios
app.config.globalProperties.$axios = axios;

// Montar la aplicación
app.mount("#app");
