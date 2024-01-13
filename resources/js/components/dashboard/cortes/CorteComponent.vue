<template>
    <div class="card">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'shirt']" /> Control de Cortes
        </div>
        <div class="card-body">
            <corte-create-or-update-modal
                :manage-corte="manageCorte"
                :data-form="dataForm"
                :visible-modal="visibleModal"
                @save="handleNewCorte"
                @update="handleUpdatedCorte"
                @hidden="hiddenModal"
            ></corte-create-or-update-modal>

            <Toolbar>
                <template #end>
                    <Button
                        icon="pi pi-plus"
                        class="mr-2"
                        @click="showModal(true)"
                    />
                </template>
            </Toolbar>
            <DataTable
                v-model:filters="filters"
                :loading="loading"
                :value="cortes"
                :paginator="true"
                :rows="perPage"
                :sortField="sortField"
                :sortOrder="sortOrder"
                :totalRecords="totalRecords"
                :lazy="true"
                @page="onPage"
                @sort="onSort"
                @filter="onFilters"
                filterDisplay="menu"
                removableSort
                stripedRows
                scrollable
                showGridlines
            >
                <Column
                    field="nombre"
                    header="Nombre"
                    sortable
                    :showClearButton="false"
                >
                    <template #body="{ data }"> {{ data.nombre }} </template
                    ><template #filter="{ filterModel }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            class="p-column-filter"
                            placeholder="Buscar por nombre" /></template
                ></Column>
                <Column
                    field="codigo_referencia"
                    header="Codigo Referencia"
                    sortable
                    :showClearButton="false"
                >
                    <template #body="{ data }">
                        {{ data.codigo_referencia }} </template
                    ><template #filter="{ filterModel }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            class="p-column-filter"
                            placeholder="Buscar por codigo referencia" /></template
                ></Column>
                <Column
                    field="cantidad_salida"
                    header="Cantidad Salida"
                    sortable
                    :showClearButton="false"
                >
                    <template #body="{ data }">
                        {{ data.cantidad_salida }} </template
                    ><template #filter="{ filterModel }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            class="p-column-filter"
                            placeholder="Buscar por cantidad salida" /></template
                ></Column>
                <Column
                    field="cantidad_entrada"
                    header="Cantidad Entrada"
                    sortable
                    :showClearButton="false"
                >
                    <template #body="{ data }">
                        {{ data.cantidad_entrada }} </template
                    ><template #filter="{ filterModel }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            class="p-column-filter"
                            placeholder="Buscar por cantidad entrada" /></template
                ></Column>
                <Column
                    field="fecha_creacion"
                    header="Fecha Creación"
                    sortable
                    :showClearButton="false"
                >
                    <template #body="{ data }">
                        {{ data.fecha_creacion }} </template
                    ><template #filter="{ filterModel }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            class="p-column-filter"
                            placeholder="Buscar por fecha creacion" /></template
                ></Column>
                <Column
                    header="Acciones"
                    field="acciones"
                    style="min-width: 100px; text-align: center"
                >
                    <template #body="slotProps">
                        <span
                            style="cursor: pointer"
                            @click="onRowAction(slotProps.data)"
                        >
                            <i class="fas fa-pencil"></i>
                        </span>
                    </template>
                </Column>
            </DataTable>
        </div>
    </div>
</template>

<script>
// Importar Librerias o Modulos
import Column from "primevue/column";
import Button from "primevue/button";
import DataTable from "primevue/datatable";
import InputText from "primevue/inputtext";
import Toolbar from "primevue/toolbar";
import { FilterMatchMode, FilterOperator } from "primevue/api";
import CorteCreateOrUpdateModal from "./acciones/CorteCreateOrUpdateModal.vue";

export default {
    data() {
        return {
            cortes: [],
            perPage: 10,
            totalRecords: 0,
            page: 1,
            sortField: "",
            sortOrder: null,
            filters: null,
            filtroInfo: [],
            loading: true,
            manageCorte: true,
            dataForm: {},
            rpTipoCorte: null,
            visibleModal: false,
        };
    },
    components: {
        Column,
        Button,
        DataTable,
        InputText,
        Toolbar,
        FilterMatchMode,
        FilterOperator,
        CorteCreateOrUpdateModal,
    },
    created() {
        this.initFilters();
    },
    mounted() {
        this.fetchCortes();
    },
    methods: {
        initFilters() {
            this.filters = {
                nombre: {
                    clear: false,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                codigo_referencia: {
                    clear: false,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                cantidad_salida: {
                    clear: false,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                cantidad_entrada: {
                    clear: false,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                fecha_creacion: {
                    clear: false,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
            };
        },
        fetchCortes() {
            this.$axios
                .get("/corte/list", {
                    params: {
                        page: this.page,
                        perPage: this.perPage,
                        sort: [this.sortField, this.sortOrder],
                        filters: this.filtroInfo,
                    },
                })
                .then((response) => {
                    this.cortes = response.data.data;
                    this.totalRecords = response.data.total;
                    this.loading = false;
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                    this.loading = false;
                });
        },
        showModal(type) {
            this.manageCorte = type;
            this.dataForm = type ? {} : this.dataForm;
            this.hiddenModal(true);
        },
        hiddenModal(status) {
            this.visibleModal = status;
        },
        handleNewCorte(newRecord) {
            this.$axios
                .post("/corte/store", newRecord)
                .then((response) => {
                    this.fetchCortes();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
        handleUpdatedCorte(newRecord) {
            this.$axios
                .post("/corte/update/" + newRecord.id, newRecord)
                .then((response) => {
                    this.fetchCortes();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
        onRowAction(data) {
            this.$axios
                .get(`/corte/show/${data.id}`)
                .then((response) => {
                    this.dataForm = response.data;
                    this.showModal(false);
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
        onPage(event) {
            this.page = event.page + 1;
            this.perPage = event.rows;
            this.fetchCortes();
        },
        onSort(event) {
            this.page = 1;
            this.sortField = event.sortField;
            this.sortOrder = event.sortOrder;
            this.fetchCortes();
        },
        onFilters(event) {
            this.page = 1;
            this.filtroInfo = [];
            for (const [key, filter] of Object.entries(event.filters)) {
                if (filter.constraints) {
                    for (const constraint of filter.constraints) {
                        if (constraint.value) {
                            this.filtroInfo.push([
                                this.$relationTableCorte(key),
                                constraint.matchMode,
                                constraint.value,
                            ]);
                        }
                    }
                }
            }
            this.fetchCortes();
        },
    },
};
</script>
