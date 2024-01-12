import "./bootstrap";
import { createApp } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

// Importacion de funciones compartidas
import shared from "./utils/shared";

// Importacion PrimeVue
import PrimeVue from "primevue/config";
import esLocale from "./translations/primevue-es.json";
import "primeicons/primeicons.css";
import "primevue/resources/themes/bootstrap4-light-blue/theme.css";

// Libreria font awesome
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faUserSecret,
    faListUl,
    faUsers,
    faPlus,
    faShirt,
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

// Añadir iconos al library de FontAwesome
library.add(faUserSecret, faListUl, faUsers, faPlus, faShirt);

// Crear la aplicación Vue
const app = createApp({});

// Registrar componentes
app.component("font-awesome-icon", FontAwesomeIcon);
app.use(PrimeVue, {
    zIndex: {
        modal: 1100, //dialog, sidebar
        overlay: 9999, //dropdown, overlaypanel
        menu: 1000, //overlay menus
        tooltip: 1100, //tooltip
    },
    /* unstyled: true  */
});

// Componentes
import PrincipalComponent from "./components/dashboard/PrincipalComponent.vue";
import ModistaComponent from "./components/dashboard/terceros/ModistaComponent.vue";
import CorteComponent from "./components/dashboard/cortes/CorteComponent.vue";

app.component("dash-principal-component", PrincipalComponent);
app.component("dash-modista-component", ModistaComponent);
app.component("dash-corte-component", CorteComponent);

// Configura Axios globalmente
app.config.globalProperties.$axios = axios;

// Configura SweetAlert2 globalmente
app.config.globalProperties.$swal = Swal;

// Localidad de PrimeVue
app.config.globalProperties.$primevue.config.locale = esLocale;

// Registrar funciones compartidas
app.mixin(shared.AlertsComponent);
app.mixin(shared.ReadHttpStatusErrors);
app.mixin(shared.HelperFunctions);
app.mixin(shared.RelationsTables);

// Montar la aplicación
app.mount("#app");
