@extends('layouts.admin.app')

@section('title', 'Uniform Prices')

@push('scripts')
    <script>
        const name = $('#name');
        const uniformPriceListName = $('#uniform_price_list_name');
        const uniformPriceListPrice = $('#price');
        let selectedUniform;
        let selectedUniformPriceList;
        let selectUniformId;
        let selectUniformPriceListId;
        let selectUniformName;
        let currentUniformListPage = 1;

        $('#uniform-form #submitButton').on('click', function(event) {
            event.preventDefault();

            const formData = new FormData();
            formData.append('name', $('#name').val());

            const isUpdate = $("#uniform-form #submitButton").text() === "Update";
            if (isUpdate) {
                formData.append("_method", "PATCH");
            }
            const url = isUpdate && selectedUniform ?
                `uniform-prices/api/update-uniform/${selectedUniform}` :
                'uniform-prices/api/store-uniform';

            ajaxPostRequest(url, formData)
                .then(() => {
                    swalMessage("", `Uniform ${isUpdate ? 'updated' : 'saved'} successfully`, "success");
                    const page = isUpdate ? currentUniformListPage : currentUniformListPage = 1;
                    fetchUniforms(currentUniformListPage);
                    clearFields();
                })
                .catch(error => {
                    if (error.responseJSON && error.responseJSON.errors) {
                        const errors = error.responseJSON.errors;
                        let errorMessage = '';
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += errors[key].join('<br>') + '<br>';
                            }
                        }
                        swalMessage(errorMessage);
                    } else {
                        swalMessage(`Failed to ${isUpdate ? 'update' : 'save'} uniform.`);
                    }
                });
        });

        $("#uniform-form #clear-button").on('click', function() {
            clearFields();
        });

        $("#uniform-list-form #clear-button").on('click', function() {
            $("#uniformName").text("")
            $("#createUniform").removeClass("d-none");
            $("#addUniformPrices").addClass("d-none");
            $("#uniformPriceListCard").addClass("d-none");
            clearUniformListFields();
        });

        function clearFields() {
            name.val('');
            $("#uniform-form #submitButton").text("Save");
        }

        function clearUniformListFields() {
            uniformPriceListName.val('');
            uniformPriceListPrice.val('');
            $("#uniform-list-form #submitButton").text("Save");
        }



        // Fetch Uniforms
        function fetchUniforms(page = 1) {
            ajaxGetRequest(`uniform-prices/api/get-all?page=${page}`)
                .then(response => {
                    const tbody = $('#uniform_list tbody');
                    tbody.empty();

                    const data = response.data.data;
                    const pagination = response.data;

                    if (data.length === 0) {
                        tbody.append('<tr><td colspan="2" class="text-center">No uniform available.</td></tr>');
                    } else {
                        data.forEach(uniform => {
                            const row = `<tr>
                <td>${uniform.name}</td>
                <td width="40%" class="text-center">
                <button type="button" class="btn btn-primary btn-sm" onclick="editUniform('${uniform.id}')">Edit</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="deleteUniform('${uniform.id}')">Delete</button>
                <button type="button" class="btn btn-info btn-sm" onclick="viewUniformPriceLists('${uniform.id}','${uniform.name}')">View Item Prices</button>
                </td>
                </tr>`;
                            tbody.append(row);
                        });
                    }

                    const paginationContainer = $('#uniformListPagination');
                    paginationContainer.empty();

                    if (pagination.last_page > 1) {
                        paginationContainer.append(
                            '<div class="d-flex justify-content-center mt-3"><nav><ul class="pagination"></ul></nav></div>'
                        );
                        const paginationList = paginationContainer.find('.pagination');

                        paginationList.append(
                            `<li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${pagination.current_page - 1}" onclick="return false;">Previous</a></li>`
                        );

                        for (let i = 1; i <= pagination.last_page; i++) {
                            paginationList.append(
                                `<li class="page-item ${i === pagination.current_page ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}" onclick="return false;">${i}</a></li>`
                            );
                        }

                        paginationList.append(
                            `<li class="page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${pagination.current_page + 1}" onclick="return false;">Next</a></li>`
                        );
                    }
                })
                .catch(error => {
                    console.error('Error fetching uniform lists:', error);
                    swalMessage("Failed to fetch uniform lists.");
                });
        }

        // delete Uniform
        function deleteUniform(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this uniform!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxDeleteRequest(`uniform-prices/api/destroy-uniform/${id}`)
                        .then(() => {
                            swalMessage("", "Uniform has been deleted!", "success");
                            $("#uniformPriceListCard").addClass("d-none");
                            clearUniformListFields();
                            fetchUniforms(currentUniformListPage);
                        })
                        .catch(() => {
                            swalMessage("", "Error", "error");
                        });
                }
            });
        }

        // edit Uniform
        function editUniform(id) {
            ajaxGetRequest(`uniform-prices/api/edit-uniform/${id}`)
                .then(response => {
                    selectedUniform = id;
                    const data = response.data;
                    name.val(data.name);
                    $("#createUniform").removeClass("d-none");
                    $("#addUniformPrices").addClass("d-none");
                    $("#uniformPriceListCard").addClass("d-none");
                    $("#uniform-form #submitButton").text("Update");
                })
                .catch(error => {
                    console.error('Error fetching payment options:', error);
                    swalMessage("Failed to fetch payment options.");
                });
        }


        // paginate for uniform list
        $(document).on('click', '#uniformListPagination .pagination .page-link', function(event) {
            event.preventDefault();
            const page = $(this).data('page');
            currentUniformListPage = page;
            fetchUniforms(page);
        });


        // view uniform price lists
        function viewUniformPriceLists(id, name) {
            selectUniformId = id;
            selectUniformName = name;
            $("#uniformPriceListCard").removeClass("d-none");
            fetchUniformPriceLists()
        }


        // fetch uniform price lists
        function fetchUniformPriceLists(page = 1) {
            ajaxGetRequest(`uniform-prices/api/get-all/price-lists/${selectUniformId}?page=${page}`)
                .then(response => {
                    const tbody = $('#uniform_price_list tbody');
                    tbody.empty();

                    $("#uniformName").text(selectUniformName)
                    $("#createUniform").addClass("d-none");
                    $("#addUniformPrices").removeClass("d-none");
                    const data = response.data.data;
                    const pagination = response.data;

                    if (data.length === 0) {
                        tbody.append(
                            '<tr><td colspan="4" class="text-center">No uniform price lists available.</td></tr>');
                    } else {
                        data.forEach(list => {
                            const row = `<tr>
                        <td>${list.name}</td>
                        <td>${list.price}</td>
                        <td width="40%" class="text-center">
                        <button type="button" class="btn btn-primary btn-sm" onclick="editUniformPriceList('${list.id}')">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteUniformPriceList('${list.id}')">Delete</button>
                        </td>
                    </tr>`;
                            tbody.append(row);
                        });
                    }

                    const paginationContainer = $('#uniformPriceListsPagination');
                    paginationContainer.empty();

                    if (pagination.last_page > 1) {
                        paginationContainer.append(
                            '<div class="d-flex justify-content-center mt-3"><nav><ul class="pagination"></ul></nav></div>'
                        );
                        const paginationList = paginationContainer.find('.pagination');

                        paginationList.append(
                            `<li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${pagination.current_page - 1}" onclick="return false;">Previous</a></li>`
                        );

                        for (let i = 1; i <= pagination.last_page; i++) {
                            paginationList.append(
                                `<li class="page-item ${i === pagination.current_page ? 'active' : ''}"><a class="page-link" href="#" data-page="${i}" onclick="return false;">${i}</a></li>`
                            );
                        }

                        paginationList.append(
                            `<li class="page-item ${pagination.current_page === pagination.last_page ? 'disabled' : ''}"><a class="page-link" href="#" data-page="${pagination.current_page + 1}" onclick="return false;">Next</a></li>`
                        );
                    }
                })
                .catch(error => {
                    console.error('Error fetching uniform lists:', error);
                    swalMessage("Failed to fetch uniform lists.");
                });


        }

        // paginate for uniform price lists
        $(document).on('click', '#uniformPriceListsPagination .pagination .page-link', function(event) {
            event.preventDefault();
            const page = $(this).data('page');
            fetchUniformPriceLists(page);
        });


        $('#uniform-list-form #submitButton').on('click', function(event) {
            event.preventDefault();

            const formData = new FormData();
            formData.append('name', $('#uniform_price_list_name').val());
            formData.append('price', $('#price').val());

            const isUpdate = $("#uniform-list-form #submitButton").text() === "Update";

            if (isUpdate) {
                formData.append("_method", "PATCH");
            }

            const url = isUpdate && selectUniformPriceListId ?
                `uniform-prices/api/update-uniform-price-list/${selectUniformId}/${selectUniformPriceListId}` :
                `uniform-prices/api/store-uniform-price-list/${selectUniformId}`;

            ajaxPostRequest(url, formData)
                .then(() => {
                    swalMessage("", `Uniform price list ${isUpdate ? 'updated' : 'saved'} successfully`,
                        "success");
                    const page = isUpdate ? currentUniformListPage : currentUniformListPage = 1;
                    fetchUniformPriceLists();
                    clearUniformListFields();
                })
                .catch(error => {
                    if (error.responseJSON && error.responseJSON.errors) {
                        const errors = error.responseJSON.errors;
                        let errorMessage = '';
                        for (const key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += errors[key].join('<br>') + '<br>';
                            }
                        }
                        swalMessage(errorMessage);
                    } else {
                        swalMessage(`Failed to ${isUpdate ? 'update' : 'save'} uniform price list.`);
                    }
                });
        });


        // edit Uniform Price List
        function editUniformPriceList(id) {
            ajaxGetRequest(`uniform-prices/api/edit-uniform/price-list/${id}`)
                .then(response => {
                    selectUniformPriceListId = id;
                    const data = response.data;
                    uniformPriceListName.val(data.name);
                    uniformPriceListPrice.val(data.price);
                    $("#uniform-list-form #submitButton").text("Update");
                })
                .catch(error => {
                    console.error('Error fetching payment options:', error);
                    swalMessage("Failed to fetch payment options.");
                });
        }

        // delete Uniform Price List
        function deleteUniformPriceList(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this uniform price list!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    ajaxDeleteRequest(`uniform-prices/api/destroy-uniform/price-list/${id}`)
                        .then(() => {
                            swalMessage("", "Uniform Price List has been deleted!", "success");
                            fetchUniformPriceLists();
                        })
                        .catch(() => {
                            swalMessage("", "Error", "error");
                        });
                }
            });
        }


        fetchUniforms();
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Uniform List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="uniform_list">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div id="uniformListPagination"></div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4 col-12" id="createUniform">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Uniform</h3>
                </div>
                <div class="card-body">
                    <form id="uniform-form">
                        <x-admin.input-field label="Name" name="name" />
                        <div class="d-flex gap-2">
                            <a class="btn btn-secondary w-100 mt-2" id="clear-button">Cancel</a>
                            <button type="button" id="submitButton" class="btn btn-primary w-100 mt-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4 col-12 d-none" id="addUniformPrices">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Uniform Prices</h3>
                </div>
                <div class="card-body">
                    <form id="uniform-list-form">
                        <x-admin.input-field label="Name" name="uniform_price_list_name" />
                        <x-admin.input-field label="Price" name="price" />
                        <div class="d-flex gap-2">
                            <a class="btn btn-secondary w-100 mt-2" id="clear-button">Cancel</a>
                            <button type="button" id="submitButton" class="btn btn-primary w-100 mt-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="col-md-12 mt-2 d-none" id="uniformPriceListCard">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><span id="uniformName"></span> Price Lists</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="uniform_price_list">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div id="uniformPriceListsPagination"></div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
@endsection
