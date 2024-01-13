<template>
    <div class="card">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'link']" /> Vinculación
        </div>
        <div class="card-body">
            <!-- <corte-create-or-update-modal
                :manage-corte="manageVinculado"
                :data-form="dataForm"
                :visible-modal="visibleModal"
                @hidden="hiddenModal"
            ></corte-create-or-update-modal> -->

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
                :value="vinculaciones"
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
                <template #expansion="{ data }">
                    <div class="p-3">
                        <h5>Especificaciones</h5>
                        <DataTable
                            :value="tableEspecificacionesId[data.id]"
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
                                field="esp_nombre"
                                header="Nombre"
                                sortable
                                :showClearButton="false"
                                ><template #body="{ data }">
                                    {{ data.esp_nombre }} </template
                                ><template #filter="{ filterModel }">
                                    <InputText
                                        v-model="filterModel.value"
                                        type="text"
                                        class="p-column-filter"
                                        placeholder="Buscar por nombre" /></template
                            ></Column>
                            <Column
                                field="cantidad"
                                header="Cantidad"
                                sortable
                                :showClearButton="false"
                                ><template #body="{ data }">
                                    {{ data.cantidad }} </template
                                ><template #filter="{ filterModel }">
                                    <InputText
                                        v-model="filterModel.value"
                                        type="text"
                                        class="p-column-filter"
                                        placeholder="Buscar por cantidad" /></template
                            ></Column>
                            <Column
                                field="precio"
                                header="Precio"
                                sortable
                                :showClearButton="false"
                                ><template #body="{ data }">
                                    {{ data.precio }} </template
                                ><template #filter="{ filterModel }">
                                    <InputText
                                        v-model="filterModel.value"
                                        type="text"
                                        class="p-column-filter"
                                        placeholder="Buscar por precio" /></template
                            ></Column>
                        </DataTable>
                    </div>
                </template>
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

export default {
    data() {
        return {
            vinculaciones: [],
            perPage: 5,
            totalRecords: 0,
            page: 1,
            sortField: "",
            sortOrder: null,
            filters: null,
            filtroInfo: [],
            loading: true,
            manageVinculado: true,
            dataForm: {},
            visibleModal: false,
            // filtros multiples de expanded
            expandedRows: [],
            filtroInfoExpanded: [],
            expandedRowsByPage: {},
            // tabla multiples de expanded
            filtersExpanded: [],
            tableEspecificacionesId: {},
            tableConfigurationsId: {},
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
    },
    created() {
        this.initFilters();
    },
    mounted() {
        this.fetchVinculacion();
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
            };
        },
        initFiltersEspecificaciones(id) {
            if (!this.filtersExpanded[id]) {
                this.filtersExpanded[id] = {
                    esp_nombre: {
                        clear: false,
                        constraints: [
                            {
                                value: null,
                                matchMode: FilterMatchMode.STARTS_WITH,
                            },
                        ],
                    },
                    cantidad: {
                        clear: false,
                        constraints: [
                            {
                                value: null,
                                matchMode: FilterMatchMode.STARTS_WITH,
                            },
                        ],
                    },
                    precio: {
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
        fetchVinculacion() {
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
                    this.vinculaciones = response.data.data;
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
            this.manageVinculado = type;
            this.dataForm = type ? {} : this.dataForm;
            this.hiddenModal(true);
        },
        hiddenModal(status) {
            this.visibleModal = status;
        },
        onPage(event) {
            this.page = event.page + 1;
            this.perPage = event.rows;
            this.expandedRows = [];
            this.fetchVinculacion();
        },
        onSort(event) {
            this.page = 1;
            this.sortField = event.sortField;
            this.sortOrder = event.sortOrder;
            this.expandedRows = [];
            this.expandedRowsByPage = {};
            this.fetchVinculacion();
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
                                this.$relationTableCorte(key),
                                constraint.matchMode,
                                constraint.value,
                            ]);
                        }
                    }
                }
            }
            this.fetchVinculacion();
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
            this.initFiltersEspecificaciones(id);
            this.fetchEspecificaciones(id);
        },
        onRowCollapse(e) {
            this.deleteRowsExpanded(e.data);
        },
        fetchEspecificaciones(id) {
            const params = this.tableConfigurationsId[id];
            this.$axios
                .get("/corte-especificacion/list", {
                    params: {
                        page: params.page,
                        perPage: params.perPage,
                        sort: [params.sortField, params.sortOrder],
                        filters: this.filtroInfoExpanded[id],
                        conditions: {
                            "corte_especificacion.corte_id": id,
                        },
                    },
                })
                .then((response) => {
                    this.tableEspecificacionesId = {
                        ...this.tableEspecificacionesId,
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
            this.fetchEspecificaciones(id);
        },
        onSortExpanded(id, event) {
            this.tableConfigurationsId[id].page = 1;
            this.tableConfigurationsId[id].sortField = event.sortField;
            this.tableConfigurationsId[id].sortOrder = event.sortOrder;
            this.fetchEspecificaciones(id);
        },
        onFiltersExpanded(id, event) {
            this.tableConfigurationsId[id].page = 1;
            this.filtroInfoExpanded[id] = [];
            for (const [key, filter] of Object.entries(event.filters)) {
                if (filter.constraints) {
                    for (const constraint of filter.constraints) {
                        if (constraint.value) {
                            this.filtroInfoExpanded[id].push([
                                this.$relationTableCorteEspecificacion(key),
                                constraint.matchMode,
                                constraint.value,
                            ]);
                        }
                    }
                }
            }
            this.fetchEspecificaciones(id);
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
    },
};
</script>
