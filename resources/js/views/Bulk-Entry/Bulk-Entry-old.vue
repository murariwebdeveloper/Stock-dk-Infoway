<template>
    <div class="ag-theme-alpine" style="height: 500px">

        <ag-grid-vue
            ref="gridRef"
            :columnDefs="columnDefs"
            :defaultColDef="defaultColDef"
            :rowData="rowData"
            :theme="myTheme"

            @cell-value-changed="onCellValueChanged"
        ></ag-grid-vue>

<!--        class="ag-theme-alpine"-->

<!--        class="ag-theme-quartz"-->

    </div>
</template>

<script>

/*import "ag-grid-community/styles/ag-grid.css";
import "ag-grid-community/styles/ag-theme-alpine.css";*/

import { ref, onMounted } from "vue";
import { AgGridVue } from "ag-grid-vue3";

// import "ag-grid-community/styles/ag-theme-quartz.css";
import "ag-grid-enterprise";

// ✅ Import required AG Grid modules
import { ModuleRegistry } from 'ag-grid-community';
import { ClientSideRowModelModule } from 'ag-grid-community';
import { ValidationModule } from 'ag-grid-community';

import { TextEditorModule } from 'ag-grid-community';

import { RichSelectModule } from 'ag-grid-enterprise';
import { LargeTextEditorModule } from 'ag-grid-enterprise';

import { themeBalham } from 'ag-grid-community';




// ✅ Register required modules
ModuleRegistry.registerModules([RichSelectModule, TextEditorModule, LargeTextEditorModule, ClientSideRowModelModule, ValidationModule]);

export default {
    components: {
        AgGridVue,
    },
    setup() {
        const gridRef = ref(null);

        const rowData = ref(getData());

        const GenderCellRenderer = {
            template: `<span><i :class="params.value === 'Male' ? 'fa fa-male' : 'fa fa-female'"></i> {{ params.value }}</span>`
        };

        const columnDefs = ref([
            { field: "name" },
            {
                field: "gender",
                cellRenderer: GenderCellRenderer,
                cellEditor: "agRichSelectCellEditor",
                cellEditorParams: {
                    values: ["Male", "Female"],
                },
            },
            {
                field: "country",
                cellEditor: "agRichSelectCellEditor",
                cellEditorParams: {
                    cellHeight: 50,
                    values: ["Ireland", "USA"],
                },
            },
            {
                field: "city",
                cellEditor: "agRichSelectCellEditor",
                cellEditorParams: (params) => {
                    const selectedCountry = params.data.country;
                    const allowedCities = countyToCityMap(selectedCountry);
                    return {
                        values: allowedCities,
                        formatValue: (value) => `${value} (${selectedCountry})`,
                    };
                },
            },
            {
                field: "address",
                cellEditor: "agLargeTextCellEditor",
                cellEditorPopup: true,
                minWidth: 550,
            },
        ]);

        // to use myTheme in an application, pass it to the theme grid option
        const myTheme = themeBalham.withParams({ accentColor: 'red' });

        const defaultColDef = ref({
            flex: 1,
            minWidth: 130,
            editable: true,
        });

        function getData() {
            return [
                {
                    name: "Bob Harrison",
                    gender: "Male",
                    address: "1197 Thunder Wagon Common, Cataract, RI, 02987-1016, US",
                    city: "Dublin",
                    country: "Ireland",
                },
                {
                    name: "Mary Wilson",
                    gender: "Female",
                    age: 11,
                    address: "3685 Rocky Glade, Showtucket, NU, X1E-9I0, CA",
                    city: "New York",
                    country: "USA",
                },
            ];
        }

        function countyToCityMap(match) {
            const map = {
                Ireland: ["Dublin", "Cork", "Galway"],
                USA: ["New York", "Los Angeles", "Chicago", "Houston"],
            };
            return map[match] || [];
        }

        function onCellValueChanged(params) {
            const colId = params.column.getId();
            if (colId === "country") {
                const selectedCountry = params.data.country;
                const selectedCity = params.data.city;
                const allowedCities = countyToCityMap(selectedCountry) || [];
                if (!allowedCities.includes(selectedCity)) {
                    params.node.setDataValue("city", null);
                }
            }
        }

        onMounted(() => {
            console.log("AG Grid Vue Component Mounted");
        });

        return {
            gridRef,
            columnDefs,
            defaultColDef,
            rowData,
            onCellValueChanged,
            myTheme
        };
    },
};
</script>

<style>
@import "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css";
</style>
