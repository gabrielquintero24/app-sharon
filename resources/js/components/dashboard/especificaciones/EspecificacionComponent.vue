<template>
    <div class="card" style="width: 100%">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'list-ul']" /> Control de Especificaciones
        </div>
        <div class="card-body">
            <especificacion-create-or-update-modal
                :manage-especificacion="manageEspecificacion"
                :data-form="dataForm"
                :visible-modal="visibleModal"
                @save="handleNewEspecificacion"
                @update="handleUpdatedEspecificacion"
                @hidden="hiddenModal"
            ></especificacion-create-or-update-modal>

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
                :value="especificaciones"
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
                    field="descripcion"
                    header="Descripcion"
                    sortable
                    :showClearButton="false"
                    style="max-width: 300px"
                >
                    <template #body="{ data }"> {{ data.descripcion }} </template
                    ><template #filter="{ filterModel }">
                        <InputText
                            v-model="filterModel.value"
                            type="text"
                            class="p-column-filter"
                            placeholder="Buscar por descripcion" /></template
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
import { FilterMatchMode, FilterOperator } from "primevue/api";
import EspecificacionCreateOrUpdateModal from "./acciones/EspecificacionCreateOrUpdateModal.vue";

export default {
    data() {
        return {
            especificaciones: [],
            perPage: 10,
            totalRecords: 0,
            page: 1,
            sortField: "",
            sortOrder: null,
            filters: null,
            filtroInfo: [],
            loading: true,
            manageEspecificacion: true,
            dataForm: {},
            visibleModal: false,
        };
    },
    components: {
        FilterMatchMode,
        FilterOperator,
        EspecificacionCreateOrUpdateModal
    },
    created() {
        this.initFilters();
    },
    mounted() {
        this.fetchEspecificaciones();
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
                descripcion: {
                    constraints: [
                        { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                    ],
                }
            };
        },
        fetchEspecificaciones() {
            this.$axios
                .get("/especificaciones/list", {
                    params: {
                        page: this.page,
                        perPage: this.perPage,
                        sort: [this.sortField, this.sortOrder],
                        filters: this.filtroInfo,
                    },
                })
                .then((response) => {
                    this.especificaciones = response.data.data;
                    this.totalRecords = response.data.total;
                    this.loading = false;
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                    this.loading = false;
                });
        },
        showModal(type) {
            this.manageEspecificacion = type;
            this.dataForm = type ? {} : this.dataForm;
            this.hiddenModal(true);
        },
        hiddenModal(status) {
            this.visibleModal = status;
        },
        handleNewEspecificacion(newRecord) {
            this.$axios
                .post("/especificaciones/store", newRecord)
                .then((response) => {
                    this.fetchEspecificaciones();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
        handleUpdatedEspecificacion(newRecord) {
            this.$axios
                .post("/especificaciones/update/" + newRecord.id, newRecord)
                .then((response) => {
                    this.fetchEspecificaciones();
                })
                .catch((error) => {
                    this.$readStatusHttp(error);
                });
        },
        onRowAction(data) {
            this.$axios
                .get(`/especificaciones/show/${data.id}`)
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
            this.fetchEspecificaciones();
        },
        onSort(event) {
            this.page = 1;
            this.sortField = event.sortField;
            this.sortOrder = event.sortOrder;
            this.fetchEspecificaciones();
        },
        onFilters(event) {
            this.page = 1;
            this.filtroInfo = [];
            for (const [key, filter] of Object.entries(event.filters)) {
                if (filter.constraints) {
                    for (const constraint of filter.constraints) {
                        if (constraint.value) {
                            this.filtroInfo.push([
                                this.$relationTableEspecificacion(key),
                                constraint.matchMode,
                                constraint.value,
                            ]);
                        }
                    }
                }
            }
            this.fetchEspecificaciones();
        },
    },
};
</script>
