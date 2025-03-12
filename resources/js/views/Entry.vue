<template>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Dashboard</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Stock Entry</li>
                    </ol>
                </nav>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="ms-3 d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 h4 font-weight-bolder">Stock Entry</h3>
                        <button @click="openModal" class="btn btn-sm btn-primary" type="button" title="Add Operator">
                            Add Entry
                        </button>
                    </div>
                    <div ref="table"></div>
                </div>
            </div>
            <div class="modal fade" id="myModal" ref="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <form ref="myForm" @submit.prevent="saveRecord" autocomplete="off">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h6 v-if="id" class="modal-title">Edit Stock Entry</h6>
                                <h6 v-else class="modal-title">Add Stock Entry</h6>
                                <button type="button" class="btn-close" v-on:click="closeModal"></button>
                            </div>
                            <div class="modal-body">

                                <!-- Form validation error start-->
                                <div class="p-2 rounded-2 border border-danger text-danger" v-if="errors.length !== 0">
                                    <div class="d-flex align-items-center">
                                        <h5 class="text-danger flex-1">
                                            <span class="fas fa-times-circle me-1"></span> Errors
                                        </h5>
                                        <button @click="errors = []" class="btn p-0 text-end" type="button">
                                            <span class="fas fa-times fs--1"></span>
                                        </button>
                                    </div>
                                    <p class="mb-0 flex-1" v-for="(errorList, key) in errors">
                                        <span class="fw-semi-bold" >{{ formatKey(key) }} :-</span>
                                        <span v-for="error in errorList">{{ error }}</span>
                                    </p>
                                </div>
                                <!-- Form validation error start-->

                                <div class="form-group">
                                    <label for="status">Store Name<i class="text-danger">*</i></label>
                                    <select v-model="store_id" id="store_id" class="form-select">
                                        <option value="" selected>Select store name</option>

                                        <option v-if="stores.length !== 0" v-for="store in stores"  :value="store.id">{{ store.name}}</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="item_code">Item Code<i class="text-danger">*</i></label>
                                    <input type="text" v-model="item_code" id="item_code" class="form-control" placeholder="Enter item code">
                                </div>

                                <div class="form-group">
                                    <label for="item_name">Item name<i class="text-danger">*</i></label>
                                    <input type="text" v-model="item_name" id="item_name" class="form-control" placeholder="Enter item name">
                                </div>

                                <div class="form-group">
                                    <label for="quantity">Quantity<i class="text-danger">*</i></label>
                                    <input type="number" v-model="quantity" id="quantity" class="form-control" placeholder="Enter item quantity">
                                </div>

                                <div class="form-group">
                                    <label for="location">Location<i class="text-danger">*</i></label>
                                    <input type="text" v-model="location" id="location" class="form-control" placeholder="Enter item location">
                                </div>

                                <div class="form-group" v-if="id">
                                    <label for="status">Status<i class="text-danger">*</i></label>
                                    <select v-model="status" id="status" class="form-select">
                                        <option value="" selected>Select Status</option>
                                        <option value="Pending">Pending</option>
                                        <option value="In-Stock">In Stock</option>
                                        <option value="Out-Of-Stock">Out Of Stock</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-primary" :disabled="isSaving">
                                    <template v-if="isSaving === true">
                                        <b-spinner small label="Spinning"></b-spinner> Saving...
                                    </template>
                                    <template v-else>
                                        <template v-if="id">
                                            Update
                                        </template>
                                        <template v-else>
                                            Submit
                                        </template>
                                    </template>
                                </button>

                                <button type="reset" v-on:click="closeModal" class="btn btn-sm btn-outline-danger">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </main>
</template>
<script setup>
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2';

import { Modal } from "bootstrap"; // Import Bootstrap Modal

import {ref, reactive, onMounted} from 'vue';


import { useRouter } from 'vue-router';

import ApiRequest from "../services/apiRequest";

import {TabulatorFull as Tabulator} from 'tabulator-tables'; //import Tabulator library
// import "tabulator-tables/dist/css/tabulator_bootstrap5.min.css"; // Import Bootstrap 5 theme
import "tabulator-tables/dist/css/tabulator_simple.min.css"; // Import Bootstrap 5 theme


const router = useRouter();

const myModal = ref(null);
let modalInstance = null;

const isSaving = ref(false);
const errors = ref('');

const stores = ref([]);

const id = ref(null);
const store_id = ref('');
const item_code = ref('');
const item_name = ref('');
const quantity = ref('');
const location = ref('');
const status = ref('');

const table = ref(null);
const tabulator = ref(null);

const columns = [
    { title: "ID", field: "id", width: 50, sorter: "number", headerSort: true, headerSortTristate:true },
    { title: "Stock No", field: "stock_no", sorter: "number", headerSort: true },
    { title: "Item Code", field: "item_code", sorter: "string", headerSort: true },
    { title: "Item Name", field: "item_name", sorter: "string", headerSort: true },
    { title: "Quantity", field: "quantity", sorter: "number", headerSort: true },
    { title: "Location", field: "location", sorter: "number", headerSort: true },
    { title: "Stock Date", field: "in_stock_date", sorter: "date", orterParams:{format:"yyyy-MM-dd", alignEmptyValues:"top"}, headerSort: true },
    { title: "Status", field: "status", sorter: "string", headerSort: true },
    {
        title: "Actions",
        field: "actions",
        hozAlign: "center",
        headerSort: false,
        formatter: (cell, formatterParams, onRendered) => {
            return `
            <button class="btn btn-sm btn-primary edit-btn">Edit</button>
            <button class="btn btn-sm btn-danger delete-btn">Delete</button>
          `;
        },
        cellClick: (e, cell) => {
            const rowData = cell.getRow().getData();
            if (e.target.classList.contains("edit-btn")) {
                handleEdit(rowData);
            } else if (e.target.classList.contains("delete-btn")) {
                handleDelete(rowData, cell);
            }
        },
        width: 150,
    },
];

const handleEdit = (row) => {
    id.value = row.id;

    store_id.value = row.store_id;
    item_code.value = row.item_code;
    item_name.value = row.item_name;
    quantity.value = row.quantity;
    location.value = row.location;
    status.value = row.status;

    modalInstance.show();
}

const handleDelete = async (row, cell) => {
    Swal.fire({
        title: 'Are you sure to delete this record?',
        text: row.item_name,
        confirmButtonText: "Yes, Sure",
        cancelButtonText: "Cancel",
        icon: 'warning',
        showCloseButton: true,
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonColor: '#37a279',
        cancelButtonColor: '#d33',
    }).then(async result => {
        if (result.isConfirmed) {
            let form = {id: row.id};
            const response = await ApiRequest.deleteEntry(form);
            let data = response;
            if (data?.status === 1) {
                toast.success(data.message);

                cell.getRow().delete();
                tabulator.value.setData();

            }else{
                if(data?.message){
                    toast.error(data?.message);
                }
            }
        }
    });

}

const resetFormData = () => {
    id.value = null;
    store_id.value = "";
    item_code.value = "";
    item_name.value = "";
    quantity.value = "";
    location.value = "";
    status.value = "";

}

const closeModal = () => {
    resetFormData();
    modalInstance.hide();
}

const openModal = () => {
    resetFormData();
    modalInstance.show();
}

const saveRecord = async () => {
    isSaving.value = true;
    try {
        let form = {
            id: id.value,
            store_id: store_id.value,
            item_code: item_code.value,
            item_name: item_name.value,
            quantity: quantity.value,
            location: location.value,
            status: status.value,
        }
        const response = await ApiRequest.saveEntry(form);


        let data = response;
        if (data?.status === 1) {
            toast.success(data.message);

            tabulator.value.setData();

            setTimeout(async () => {
                closeModal();
            }, 2000);
        }else{
            if (data?.errors) {
                errors.value = data.errors
            }
            if(data?.message){
                toast.error(data?.message);
            }
        }
        isSaving.value = false;
    } catch (error) {
        console.error(error);
        toast.error(error);
        isSaving.value = false;
    }

}

const getStores = async () => {
    let response = await ApiRequest.getStores();
    stores.value = response.data;
}


onMounted(() => {
    modalInstance = new Modal(myModal.value, {backdrop: 'static', keyboard: false});
    // modalInstance = new Modal(myModal.value);

    getStores();

    tabulator.value = new Tabulator(table.value, {
        reactiveData:true,
        sortOrderReverse:true,
        pagination:true,
        paginationMode:"remote",
        paginationSize:10,
        paginationInitialPage:1,
        paginationSizeSelector:[5, 10, 25, 50, 100],
        layout: "fitColumns",
        columns: columns,
        ajaxRequestFunc: (url, config, params) => {
            return ApiRequest.getEntryData(url, params);
        },
        ajaxURL: window.apiUrl+"/entry/list",
        sortMode:"remote",
        ajaxConfig: "GET",
        ajaxSorting: true,
        headerSort:true,
        ajaxParams: function () {
            return {
                sortField: this.getSorters()[0]?.field || "id",
                sortOrder: this.getSorters()[0]?.dir || "desc",
            };
        },
    });
});

</script>
