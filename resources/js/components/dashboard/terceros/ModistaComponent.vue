<template>
    <div class="card" style="width: 100%">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'list-ul']" /> Control de Modistas
        </div>
        <div class="card-body">
            <modista-create-or-update-modal
                :manage-modista="manageModista"
                :data-form="dataForm"
                :visible-modal="visibleModal"
                @save="handleNewModista"
                @update="handleUpdatedModista"
                @hidden="hiddenModal"
            ></modista-create-or-update-modal>

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
                :value="modistas"
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
            >
                <Column
                    field="nombre"
                    header="Nombres"
                    sortable
                    :showClearButton="false"
                    style="min-width: 100px"
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
                    field="direccion"
                    header="Dirección"
                    sortable
                    :showClearButton="false"
                    style="min-width: 100px"
                >
                    <template #body="{ data }"> {{ data.direccion }} </template
                    ><template #filter="{ filterModel }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            class="p-column-filter"
                            placeholder="Buscar por direccion" /></template
                ></Column>
                <Column
                    field="celular"
                    header="Celular"
                    sortable
                    :showClearButton="false"
                    style="min-width: 100px"
                >
                    <template #body="{ data }"> {{ data.celular }} </template
                    ><template #filter="{ filterModel }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            class="p-column-filter"
                            placeholder="Buscar por celular" /></template
                ></Column>
                <Column
                    field="tipo_modista_id"
                    header="Tipo"
                    sortable
                    :showClearButton="false"
                    style="min-width: 100px"
                >
                    <template #body="{ data }">
                        {{ data.tipo_modista.name }} </template
                    ><template #filter="{ filterModel }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            class="p-column-filter"
                            placeholder="Buscar por tipo" /></template
                ></Column>
                <Column
                    header="Acciones"
                    field="acciones"
                    style="min-width: 100px; text-align: center;"
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
import ModistaCreateOrUpdateModal from "./acciones/ModistaCreateOrUpdateModal.vue";

export default {
    data() {
        return {
            modistas: [],
            perPage: 10,
            totalRecords: 0,
            page: 1,
            sortField: "",
            sortOrder: null,
            filters: null,
            filtroInfo: [],
            loading: true,
            manageModista: true,
            dataForm: {},
            rpTipoModista: null,
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
        ModistaCreateOrUpdateModal,
    },
    created() {
        this.initFilters();
    },
    mounted() {
        this.fetchModistas();
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
                direccion: {
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                celular: {
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
                tipo_modista_id: {
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
            };
        },
        fetchModistas() {
            this.$axios
                .get("/modista/list", {
                    params: {
                        page: this.page,
                        perPage: this.perPage,
                        sort: [this.sortField, this.sortOrder],
                        filters: this.filtroInfo,
                    },
                })
                .then((response) => {
                    this.modistas = response.data.data;
                    this.totalRecords = response.data.total;
                    this.loading = false;
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                    this.loading = false;
                });
        },
        showModal(type) {
            this.manageModista = type;
            this.dataForm = type ? {} : this.dataForm;
            this.hiddenModal(true);
        },
        hiddenModal(status) {
            this.visibleModal = status;
        },
        handleNewModista(newRecord) {
            this.$axios
                .post("/modista/store", newRecord)
                .then((response) => {
                    this.fetchModistas();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
        handleUpdatedModista(newRecord) {
            this.$axios
                .post("/modista/update/" + newRecord.id, newRecord)
                .then((response) => {
                    this.fetchModistas();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
        onRowAction(data) {
            this.$axios
                .get(`/modista/show/${data.id}`)
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
            this.fetchModistas();
        },
        onSort(event) {
            this.page = 1;
            this.sortField = event.sortField;
            this.sortOrder = event.sortOrder;
            this.fetchModistas();
        },
        onFilters(event) {
            this.page = 1;
            this.filtroInfo = [];
            for (const [key, filter] of Object.entries(event.filters)) {
                if (filter.constraints) {
                    for (const constraint of filter.constraints) {
                        if (constraint.value) {
                            this.filtroInfo.push([
                                this.$relationTableModista(key),
                                constraint.matchMode,
                                constraint.value,
                            ]);
                        }
                    }
                }
            }
            this.fetchModistas();
        },
    },
};
</script>
