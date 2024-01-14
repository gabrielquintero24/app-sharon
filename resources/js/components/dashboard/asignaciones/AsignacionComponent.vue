<template>
    <div class="card">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'arrow-right-arrow-left']" />
            Asignación
        </div>
        <div class="card-body">
            <asignacion-create-or-update-modal
                :manage-asignacion="manageAsignacion"
                :data-form="dataForm"
                :visible-modal="visibleModal"
                @save="handleNewAsignacion"
                @update="handleUpdatedAsignacion"
                @hidden="hiddenModal"
            ></asignacion-create-or-update-modal>

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
                :expandedRows="expandedRows"
                v-model:filters="filters"
                :loading="loading"
                :value="asignaciones"
                :paginator="true"
                :rows="perPage"
                :sortField="sortField"
                :sortOrder="sortOrder"
                :totalRecords="totalRecords"
                :lazy="true"
                @page="onPage"
                @sort="onSort"
                @filter="onFilters"
                @rowExpand="onRowExpand"
                @rowCollapse="onRowCollapse"
                filterDisplay="menu"
                removableSort
                stripedRows
                scrollable
                showGridlines
            >
                <Column expander style="width: 5rem" />
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
                <template #expansion="{ data }">
                    <div class="p-3">
                        <h5>Cortes</h5>
                        <DataTable
                            :value="tableCortesId[data.id]"
                            v-model:filters="filtersExpanded[data.id]"
                            :loading="
                                tableConfigurationsId[data.id]
                                    ? tableConfigurationsId[data.id].loading
                                    : null
                            "
                            :paginator="true"
                            :rows="
                                tableConfigurationsId[data.id]
                                    ? tableConfigurationsId[data.id].perPage
                                    : null
                            "
                            :sortField="
                                tableConfigurationsId[data.id]
                                    ? tableConfigurationsId[data.id].sortField
                                    : null
                            "
                            :sortOrder="
                                tableConfigurationsId[data.id]
                                    ? tableConfigurationsId[data.id].sortOrder
                                    : null
                            "
                            :totalRecords="
                                tableConfigurationsId[data.id]
                                    ? tableConfigurationsId[data.id].total
                                    : null
                            "
                            :lazy="true"
                            @page="(event) => onPageExpanded(data.id, event)"
                            @sort="(event) => onSortExpanded(data.id, event)"
                            @filter="
                                (event) => onFiltersExpanded(data.id, event)
                            "
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
                                ><template #body="{ data }">
                                    {{ data.nombre }} </template
                                ><template #filter="{ filterModel }">
                                    <InputText
                                        v-model="filterModel.value"
                                        type="text"
                                        class="p-column-filter"
                                        placeholder="Buscar por nombre" /></template
                            ></Column>
                            <Column
                                field="codigo_referencia"
                                header="Reeferencia"
                                sortable
                                :showClearButton="false"
                                ><template #body="{ data }">
                                    {{
                                        data.codigo_referencia
                                    }} </template
                                ><template #filter="{ filterModel }">
                                    <InputText
                                        v-model="filterModel.value"
                                        type="text"
                                        class="p-column-filter"
                                        placeholder="Buscar por referencia" /></template
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
                </template>
            </DataTable>
        </div>
    </div>
</template>

<script>
// Importar Librerias o Modulos
import { FilterMatchMode, FilterOperator } from "primevue/api";
import AsignacionCreateOrUpdateModal from "./acciones/AsignacionCreateOrUpdateModal.vue";

export default {
    data() {
        return {
            asignaciones: [],
            perPage: 5,
            totalRecords: 0,
            page: 1,
            sortField: "",
            sortOrder: null,
            filters: null,
            filtroInfo: [],
            loading: true,
            manageAsignacion: true,
            dataForm: {},
            visibleModal: false,
            // filtros multiples de expanded
            expandedRows: [],
            filtroInfoExpanded: [],
            expandedRowsByPage: {},
            // tabla multiples de expanded
            filtersExpanded: [],
            tableCortesId: {},
            tableConfigurationsId: {},
        };
    },
    components: {
        FilterMatchMode,
        FilterOperator,
        AsignacionCreateOrUpdateModal
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
                tipo_modista_id: {
                    clear: false,
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                },
            };
        },
        initFiltersCortes(id) {
            if (!this.filtersExpanded[id]) {
                this.filtersExpanded[id] = {
                    nombre: {
                        clear: false,
                        constraints: [
                            {
                                value: null,
                                matchMode: FilterMatchMode.STARTS_WITH,
                            },
                        ],
                    },
                    codigo_referencia: {
                        clear: false,
                        constraints: [
                            {
                                value: null,
                                matchMode: FilterMatchMode.STARTS_WITH,
                            },
                        ],
                    },
                };
            }
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
                    this.asignaciones = response.data.data;
                    this.totalRecords = response.data.total;
                    this.expandedRows =
                        this.expandedRowsByPage[this.page] || [];
                    this.loading = false;
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                    this.loading = false;
                });
        },
        showModal(type) {
            this.manageAsignacion = type;
            this.dataForm = type ? {} : this.dataForm;
            this.hiddenModal(true);
        },
        hiddenModal(status) {
            this.visibleModal = status;
        },
        onRowAction(data) {
            this.$axios
                .get(`/asignacion/show/${data.id}`)
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
            this.expandedRows = [];
            this.fetchModistas();
        },
        onSort(event) {
            this.page = 1;
            this.sortField = event.sortField;
            this.sortOrder = event.sortOrder;
            this.expandedRows = [];
            this.expandedRowsByPage = {};
            this.fetchModistas();
        },
        onFilters(event) {
            this.page = 1;
            this.filtroInfo = [];
            this.expandedRows = [];
            this.expandedRowsByPage = {};
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
        onRowExpand(e) {
            const id = e.data.id;
            if (!this.tableConfigurationsId[id]) {
                this.tableConfigurationsId[id] = {
                    page: 1,
                    perPage: 10,
                    sortField: "",
                    sortOrder: null,
                    total: 0,
                    loading: true,
                };
            }
            this.savedRowsExpanded(e.data);
            this.initFiltersCortes(id);
            this.fetchAsignaciones(id);
        },
        onRowCollapse(e) {
            this.deleteRowsExpanded(e.data);
        },
        fetchAsignaciones(id) {
            const params = this.tableConfigurationsId[id];
            this.$axios
                .get("/asignacion/list", {
                    params: {
                        page: params.page,
                        perPage: params.perPage,
                        sort: [params.sortField, params.sortOrder],
                        filters: this.filtroInfoExpanded[id],
                        conditions: {
                            "asignacion.modista_id": id,
                        },
                    },
                })
                .then((response) => {
                    this.tableCortesId = {
                        ...this.tableCortesId,
                        [id]: response.data.data,
                    };
                    this.tableConfigurationsId[id].total = response.data.total;
                    this.tableConfigurationsId[id].loading = false;
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                    this.tableConfigurationsId[id].loading = false;
                });
        },
        onPageExpanded(id, event) {
            this.tableConfigurationsId[id].page = event.page + 1;
            this.tableConfigurationsId[id].perPage = event.rows;
            this.fetchAsignaciones(id);
        },
        onSortExpanded(id, event) {
            this.tableConfigurationsId[id].page = 1;
            this.tableConfigurationsId[id].sortField = event.sortField;
            this.tableConfigurationsId[id].sortOrder = event.sortOrder;
            this.fetchAsignaciones(id);
        },
        onFiltersExpanded(id, event) {
            this.tableConfigurationsId[id].page = 1;
            this.filtroInfoExpanded[id] = [];
            for (const [key, filter] of Object.entries(event.filters)) {
                if (filter.constraints) {
                    for (const constraint of filter.constraints) {
                        if (constraint.value) {
                            this.filtroInfoExpanded[id].push([
                                this.$relationTableAsignacion(key),
                                constraint.matchMode,
                                constraint.value,
                            ]);
                        }
                    }
                }
            }
            this.fetchAsignaciones(id);
        },
        savedRowsExpanded(row) {
            if (!this.expandedRowsByPage[this.page]) {
                this.expandedRowsByPage[this.page] = [row];
            } else {
                let objExist = this.expandedRowsByPage[this.page].find(
                    (obj) => obj.id === row.id
                );
                if (objExist) {
                    Object.assign(objExist, row);
                } else {
                    this.expandedRowsByPage[this.page].push(row);
                }
            }
        },
        deleteRowsExpanded(row) {
            if (this.expandedRowsByPage[this.page]) {
                this.expandedRowsByPage[this.page] = this.expandedRowsByPage[
                    this.page
                ].filter((obj) => obj.id !== row.id);
                if (this.expandedRowsByPage[this.page].length === 0) {
                    delete this.expandedRowsByPage[this.page];
                }
            }
        },
        handleNewAsignacion(newRecord) {
            this.$axios
                .post("/asignacion/store", newRecord)
                .then((response) => {
                    this.$alertSuccess("Realizado", "Asignación vinculada");
                    this.expandedRows = [];
                    this.expandedRowsByPage = {};
                    this.fetchAsignaciones();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
        handleUpdatedAsignacion(newRecord) {
            this.$axios
                .post("/asignacion/update/" + newRecord.id, newRecord)
                .then((response) => {
                    this.$alertSuccess(
                        "Realizado",
                        "Asignación actualizada"
                    );
                    this.expandedRows = [];
                    this.expandedRowsByPage = {};
                    this.fetchAsignaciones();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
    },
};
</script>
