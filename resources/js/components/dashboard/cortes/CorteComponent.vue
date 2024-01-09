<template>
    <div class="card">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'shirt']" /> Control de Cortes
        </div>
        <div class="card-body">
            <div class="button-container">
                <button
                    class="btn btn-primary mb-2 my-buttons"
                    @click="showModal(true)"
                >
                    <font-awesome-icon :icon="['fas', 'plus']" />
                </button>
                <corte-create-or-update-modal
                    :manage-corte="manageCorte"
                    :data-form="dataForm"
                    @save="handleNewCorte"
                    @update="handleUpdatedCorte"
                ></corte-create-or-update-modal>
            </div>
            <ag-grid-vue
                style="width: 100%; height: 550px"
                :class="themeClass"
                :columnDefs="columnDefs"
                :defaultColDef="defaultColDef"
                :rowData="rowData"
                :pagination="true"
                :paginationPageSize="10"
                :paginationPageSizeSelector="[10, 20, 30]"
                :localeText="spanishText"
                @grid-ready="onGridReady"
                @cell-clicked="onCellClicked"
            >
            </ag-grid-vue>
        </div>
    </div>
</template>

<script>
// Importar Librerias o Modulos
import { AgGridVue } from "ag-grid-vue3";
import spanishText from "../../../translations/spanishText";
import CorteCreateOrUpdateModal from "./acciones/CorteCreateOrUpdateModal.vue";

export default {
    data() {
        return {
            spanishText,
            defaultColDef: {
                sortable: true,
                flex: 1,
                minWidth: 100,
                resizable: false,
            },
            rowData: [],
            columnDefs: [],
            themeClass: "ag-theme-alpine",
            showAddCorteModal: false,
            manageCorte: true, // true - create / false - update
            dataForm: {},
        };
    },
    components: {
        AgGridVue,
        spanishText,
        CorteCreateOrUpdateModal,
    },
    created() {
        this.loadCortes();
    },
    mounted() {},
    methods: {
        onGridReady(params) {
            this.gridApi = params.api;
            this.gridColumnApi = params.columnApi;
        },
        loadCortes() {
            this.columnDefs = [
                {
                    headerName: "Nombre",
                    field: "nombre",
                    filter: true,
                    cellStyle: { textAlign: "center" },
                },
                {
                    headerName: "Codigo Referencia",
                    field: "codigo_referencia",
                    cellStyle: { textAlign: "center" },
                },
                {
                    headerName: "Cantidad Salida",
                    field: "cantidad_salida",
                    cellStyle: { textAlign: "center" },
                },
                {
                    headerName: "Cantidad Entrada",
                    field: "cantidad_entrada",
                    cellStyle: { textAlign: "center" },
                },
                {
                    headerName: "Fecha Creación",
                    field: "fecha_creacion",
                    cellStyle: { textAlign: "center" },
                },
                {
                    headerName: "Acciones",
                    field: "acciones",
                    headerClass: "actions",
                    cellStyle: { textAlign: "center", cursor: "pointer" },
                    cellRenderer: function (params) {
                        return `<span><i class='fas fa-pencil'></i></span>`;
                    },
                },
            ];
            this.$axios
                .get("/corte/list")
                .then((response) => {
                    this.rowData = response.data;
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
        onCellClicked(event) {
            if (event.colDef.field === "acciones") {
                this.$axios
                    .get(`/corte/show/${event.data.id}`)
                    .then((response) => {
                        this.dataForm = response.data;
                        this.showModal(false);
                    })
                    .catch((error) => {
                        this.$readStatusHttp(error);
                    });
            }
        },
        showModal(type) {
            this.manageCorte = type;
            this.dataForm = type ? {} : this.dataForm;
            var myModal = new bootstrap.Modal(
                document.getElementById("manageCorteModal"),
                {}
            );
            myModal.show();
        },
        handleNewCorte(newRecord) {
            this.$axios
                .post("/corte/store", newRecord)
                .then((response) => {
                    this.loadCortes();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
        handleUpdatedCorte(newRecord) {
            this.$axios
                .post("/corte/update/" + newRecord.id, newRecord)
                .then((response) => {
                    this.loadCortes();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
    },
};
</script>
