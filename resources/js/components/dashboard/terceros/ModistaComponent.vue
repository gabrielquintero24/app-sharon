<template>
    <div class="card">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'users']" /> Control de Modistas
        </div>
        <div class="card-body">
            <div class="button-container">
                <button
                    class="btn btn-primary mb-2 my-buttons"
                    @click="showModal(true)"
                >
                    <font-awesome-icon :icon="['fas', 'plus']" />
                </button>
                <modista-create-or-update-modal
                    :manage-modista="manageModista"
                    :data-form="dataForm"
                    @save="handleNewModista"
                    @update="handleUpdatedModista"
                ></modista-create-or-update-modal>
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
import ModistaCreateOrUpdateModal from "./acciones/ModistaCreateOrUpdateModal.vue";

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
            showAddModistaModal: false,
            manageModista: true, // true - create / false - update
            dataForm: {},
            currentPage: 0,
        };
    },
    components: {
        AgGridVue,
        spanishText,
        ModistaCreateOrUpdateModal,
    },
    created() {
        this.loadModistas();
    },
    mounted() {},
    methods: {
        onGridReady(params) {
            this.gridApi = params.api;
            this.gridColumnApi = params.columnApi;
        },
        loadModistas() {
            this.columnDefs = [
                {
                    headerName: "Nombre",
                    field: "nombre",
                    cellStyle: { textAlign: "center" },
                },
                {
                    headerName: "Dirección",
                    field: "direccion",
                    cellStyle: { textAlign: "center" },
                },
                {
                    headerName: "Celular",
                    field: "celular",
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
            var params = {
                page: this.currentPage,
                limit: this.pageSize,
            };
            this.$axios
                .get("/modista/list", { params })
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
                    .get(`/modista/show/${event.data.id}`)
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
            this.manageModista = type;
            this.dataForm = type ? {} : this.dataForm;
            var myModal = new bootstrap.Modal(
                document.getElementById("addRecordModal"),
                {}
            );
            myModal.show();
        },
        handleNewModista(newRecord) {
            this.$axios
                .post("/modista/store", newRecord)
                .then((response) => {
                    this.loadModistas();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
        handleUpdatedModista(newRecord) {
            this.$axios
                .post("/modista/update/" + newRecord.id, newRecord)
                .then((response) => {
                    this.loadModistas();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
    },
};
</script>
