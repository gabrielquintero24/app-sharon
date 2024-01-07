import "./bootstrap";
import { createApp } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

// Importacion de funciones compartidas
import shared from "./components/shared";

// Importar AG-Grid y sus estilos
import { AgGridVue } from "ag-grid-vue3";
import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";

// Libreria font awesome
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faUserSecret,
    faListUl,
    faUsers,
    faPlus,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

// Añadir iconos al library de FontAwesome
library.add(faUserSecret, faListUl, faUsers, faPlus);

// Crear la aplicación Vue
const app = createApp({});

// Registrar componentes
app.component("font-awesome-icon", FontAwesomeIcon);
app.component("ag-grid-vue", AgGridVue);

// Registrar funciones compartidas
app.mixin(shared.AlertsComponent);
app.mixin(shared.ReadHttpStatusErrors);

// Componentes
import PrincipalComponent from "./components/dashboard/PrincipalComponent.vue";
import ModistaComponent from "./components/dashboard/terceros/ModistaComponent.vue";

app.component("dash-principal-component", PrincipalComponent);
app.component("dash-modista-component", ModistaComponent);

// Configura Axios globalmente
app.config.globalProperties.$axios = axios;

// Configura SweetAlert2 globalmente
app.config.globalProperties.$swal = Swal;

// Montar la aplicación
app.mount("#app");
