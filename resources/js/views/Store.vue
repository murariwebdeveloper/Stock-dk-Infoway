<template>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Dashboard</a></li>
                        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Store</li>
                    </ol>
                </nav>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="ms-3 d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 h4 font-weight-bolder">Store</h3>
                        <button @click="openModal" class="btn btn-sm btn-primary" type="button" title="Add Operator">
                            Add Store
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
                                <h6 v-if="id" class="modal-title">Edit Store</h6>
                                <h6 v-else class="modal-title">Add Store</h6>
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
                                    <label for="name">Store name<i class="text-danger">*</i></label>
                                    <input type="text" v-model="name" id="name" class="form-control" placeholder="Enter store name">
                                </div>


                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-sm btn-primary" :disabled="isSaving">
                                    <template v-if="isSaving === true">
                                        <b-spinner small label="Spinning"></b-spinner> Saving...
                                    </template>
                                    <template v-else>
                                        <template v-if="id">
                                            <i class="fa fa-edit me-2"></i>Update
                                        </template>
                                        <template v-else>
                                            <i class="fa fa-save me-2"></i>Submit
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
const id = ref(null);
const name = ref('');

const table = ref(null);
const tabulator = ref(null);

const columns = [
    { title: "ID", field: "id", width: 50, sorter: "number", headerSort: true, headerSortTristate:true  },
    { title: "Name", field: "name", sorter: "string", headerSort: true },
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
    name.value = row.name;
    modalInstance.show();
}

const handleDelete = async (row, cell) => {
    Swal.fire({
        title: 'Are you sure to delete this record?',
        text: row.name,
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
            const response = await ApiRequest.deleteStore(form);
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
    name.value = "";
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

        const response = await ApiRequest.saveStore({ id: id.value, name: name.value });


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



onMounted(() => {
    modalInstance = new Modal(myModal.value, {backdrop: 'static', keyboard: false});
    // modalInstance = new Modal(myModal.value);

    tabulator.value = new Tabulator(table.value, {
        reactiveData:true,
        pagination:true,
        paginationMode:"remote",
        paginationSize:5,
        paginationInitialPage:1,
        paginationSizeSelector:[5, 10, 25, 50, 100],
        layout: "fitColumns",
        columns: columns,
        ajaxRequestFunc: (url, config, params) => {
            return ApiRequest.getStoreData(url, params);
        },
        ajaxURL: window.apiUrl+"/store/list",
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
