<template>
    <div>
        <ag-grid-vue
            class="ag-theme-alpine"
            style="width: 100%; height: 500px"
            :columnDefs="columnDefs"
            :rowData="rowData"
            :defaultColDef="defaultColDef"
            rowSelection="multiple"
            animateRows="true">
        </ag-grid-vue>
    </div>
</template>

<script>
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-alpine.css';

// import 'ag-grid-enterprise';
import { AgGridVue } from "@ag-grid-community/vue3";

// import { LicenseManager } from 'ag-grid-enterprise';
export default {
    components: {
        AgGridVue,
    },
    data() {
        return {
            columnDefs: [
                { field: "name" },
                { field: "age" },
                { field: "country" },
            ],
            rowData: [
                { name: "John", age: 25, country: "USA" },
                { name: "Alice", age: 30, country: "UK" },
                { name: "Bob", age: 35, country: "Canada" },
            ],
            defaultColDef: {
                sortable: true,
                filter: true,
                resizable: true,
            },
        };
    },
    created() {
        // LicenseManager.setLicenseKey("YOUR_LICENSE_KEY_HERE"); // Replace with your AG Grid Enterprise license key
    },
};
</script>


<style>

</style>
