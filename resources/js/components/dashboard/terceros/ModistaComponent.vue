<template>
    <div class="card">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'list-ul']" /> Control de Cortes
        </div>
        <div class="card-body">
            <!-- Botón para abrir el modal -->
            <button class="btn btn-primary" @click="showModal">Agregar Nuevo Modista</button>
            <add-modista-modal @save="handleNewModista"></add-modista-modal>

            <ag-grid-vue style="width: 100%; height: 500px" :class="themeClass" :columnDefs="columnDefs"
                :defaultColDef="defaultColDef" :rowData="rowData">
            </ag-grid-vue>
        </div>
    </div>
</template>

<script>
// Importar Librerias o Modulos
import { AgGridVue } from "ag-grid-vue3";
import AddModistaModal from './acciones/AddModistaModal.vue';

export default {
    data() {
        return {
            defaultColDef: {
                sortable: true,
                flex: 1,
                minWidth: 100,
                resizable: true,
            },
            rowData: [
                {
                    mission: "Voyager",
                    company: "NASA",
                    location: "Cape Canaveral",
                    date: "1977-09-05",
                    rocket: "Titan-Centaur ",
                    price: 86580000,
                    successful: true,
                },
                {
                    mission: "Apollo 13",
                    company: "NASA",
                    location: "Kennedy Space Center",
                    date: "1970-04-11",
                    rocket: "Saturn V",
                    price: 3750000,
                    successful: false,
                },
                {
                    mission: "Falcon 9",
                    company: "SpaceX",
                    location: "Cape Canaveral",
                    date: "2015-12-22",
                    rocket: "Falcon 9",
                    price: 9750000,
                    successful: true,
                },
            ],
            columnDefs: [
                { field: "mission" },
                { field: "company" },
                { field: "location" },
                { field: "date" },
                { field: "price" },
                { field: "successful" },
                { field: "rocket" },
            ],
            themeClass: "ag-theme-alpine",
            showAddModistaModal: false
        };
    },
    components: {
        AgGridVue,
        AddModistaModal
    },
    created() { },
    mounted() { },
    methods: {
        showModal() {
            var myModal = new bootstrap.Modal(document.getElementById('addRecordModal'), {});
            myModal.show();
        },
        handleNewModista(newRecord) {
            console.log("Nuevo registro agregado:", newRecord);
            // Aquí puedes añadir lógica para manejar el nuevo registro, como enviarlo a un servidor
        }
    },
};
</script>
