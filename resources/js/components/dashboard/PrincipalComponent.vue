<template>
    <div class="card">
        <div class="card-header">
            <font-awesome-icon :icon="['fas', 'list-ul']" /> Control de Cortes
        </div>
        <div class="card-body">
            <ag-grid-vue style="width: 100%; height: 500px" :class="themeClass" :columnDefs="columnDefs"
                :defaultColDef="defaultColDef" :rowData="rowData">
            </ag-grid-vue>
        </div>
    </div>
</template>

<script>
// Importar Librerias o Modulos
import { AgGridVue } from "ag-grid-vue3";

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
        };
    },
    components: {
        AgGridVue,
    },
    created() { },
    mounted() { },
    methods: {},
};
</script>
