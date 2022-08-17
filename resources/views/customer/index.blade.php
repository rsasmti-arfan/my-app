@extends('dashboard.app')
@section('title', 'Customer')

@section('button_nav')

|| Data Customer || &nbsp;&nbsp;
<button type="button" id="addBtn" class=" btn btn-light btn-outline-primary"><i class="bi bi-plus-circle"></i>&nbsp;Add New</button>
&nbsp;

Toggle column: <a class="toggle-vis" data-column="1">Id</a>
<!-- -- <a class="toggle-vis" data-column="5">Password</a> -->

@endsection

@section('content')
<div class="container mt-3 mb-5">
    <button type="button" id="addBtn" class="mb-3 btn btn-light btn-outline-primary"><i class="bi bi-plus-circle"></i>&nbsp;Add New</button>


    <div class="col-md-12">
        <div class="table-responsive">
            <table id="datatable" class="table table-bordered  border-light table-striped align-middle nowrap" style="width:100%">
                <thead class="bg-purple">
                    <tr>
                        <td>Action</td>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>HP</th>
                    </tr>
                </thead>
                <tfoot class="bg-purple">
                    <tr>
                        <td>Action</td>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>HP</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

@include('customer.modal_add_edit_show')

@endsection

@push('scripts')
<!-- CDN -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script> -->
<!--  -->
<!-- first loaded -->
<script>

</script>

<!-- Datatables -->
<script type="text/javascript">
    $(document).ready(function() {

        $('#datatable tfoot th').each(function() {
            var title = $(this).text();
            $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />')
        });



        var table = $('#datatable').DataTable({
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('customers.index') }}",
                data: function(req) {
                    // req.alldata = alldata;
                }
            },
            method: 'POST',
            columns: [{
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'id',
                    name: 'id',
                    visible: false,
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'address',
                    name: 'address',
                },
                {
                    data: 'gender',
                    name: 'gender',
                },
                {
                    data: 'email',
                    name: 'email',
                    // render: $.fn.dataTable.render.number(',', '.', 0, '')
                },
                {
                    data: 'hp',
                    name: 'hp'
                },
            ],
            order: [
                // [29, 'desc']
            ],
            columnDefs: [{
                // targets: [0],
                // searchable: false,
                // orderable: false,
                // className: "dt-center",
                // targets: "_all"
                // targets: [2, 4, 5]
            }],
        });

        // Toggle Column
        $('a.toggle-vis').on('click', function(e) {
            e.preventDefault();
            var column = table.column($(this).attr('data-column'));
            column.visible(!column.visible());
        });
        // Apply the search
        table.columns().every(function() {
            var that = this;
            $('input', this.footer()).on('keyup change clear', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });


    });
</script>

<!-- fungsi-fungsi tombol tambah, view, edit, dll -->
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    // Tombol tambah data
    $('#addBtn').click(function() {
        $(document).find('span.error-text').text('');
        $('#modal-title').html("Form submit data");
        $('#id').val('');
        $('#form-modal_add_edit_show').trigger("reset");
        $('#saveBtn').show();

        $('#modal_add_edit_show').modal('show');
    });


    // Tombol simpan data
    $('#saveBtn').click(function(e) {
        e.preventDefault();
        saveData()
    });

    function saveData() {
        var formData = new FormData($("#form-modal_add_edit_show")[0]);
        $.ajax({
            url: "{{ route('customers.store') }}",
            type: "POST",
            data: formData,
            dataType: 'json',
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $(document).find('span.error-text').text('');
            },
            success: function(data) {
                if (data.status == 0) {
                    $.each(data.error, function(prefix, val) {
                        $('span.' + prefix + '_error').text(val[0]);
                    });
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Make sure all the required data is filled in, check again!',
                    })

                } else {
                    $('#form-modal_add_edit_show')[0].reset();
                    $('#form-modal_add_edit_show').trigger("reset");
                    $('#modal_add_edit_show').modal('hide');
                    $('#datatable').DataTable().ajax.reload();
                    if ($('#id').val() == '') {
                        Swal.fire(
                            'Good job!',
                            'Data has been successfully added!',
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Good job!',
                            'Data has been successfully updated!',
                            'success'
                        )
                    }
                }
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });
    };

    // Tombol edit data
    $('body').on('click', '.editData', function() {
        $(document).find('span.error-text').text('');
        var id = $(this).data('id');
        $('#saveBtn').show();

        $.get("{{ route('customers.index') }}" + "/" + id + "/edit", function(data) {
            $('#modal-title').html("Form edit data");
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#address').val(data.address);
            $('#gender').val(data.gender);
            $('#email').val(data.email);
            $('#hp').val(data.hp);

            $('#modal_add_edit_show').modal('show');
        })

    });

    $('body').on('click', '.showData', function() {
        $(document).find('span.error-text').text('');
        var id = $(this).data('id');
        $('#saveBtn').hide();

        $.get("{{ route('customers.index') }}" + "/" + id + "/edit", function(data) {
            $('#modal-title').html("Form show data");
            $('#id').val(data.id);
            $('#name').val(data.name);
            $('#address').val(data.address);
            $('#gender').val(data.gender);
            $('#email').val(data.email);
            $('#hp').val(data.hp);

            $('#modal_add_edit_show').modal('show');
        })

    });


    $('body').on('click', '.deleteData', function() {
        var id = $(this).data("id");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('customers.store') }}" + '/' + id,
                    success: function(data) {
                        $('#datatable').DataTable().ajax.reload();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            } else if (
                /* Read more about handling dismissals below */
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire(
                    'Cancelled',
                    'Your file is safe :)',
                    'error'
                )
            }
        })

    });
</script>

@endpush

@section('style')
<style>
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

    .hide {
        display: none;
    }

    .form-floating>.select2-container>.selection>.select2-selection {
        padding-top: 1.625rem;
        padding-bottom: 0.625rem;
        height: 3.60rem;
        border-top: white solid;
        border-bottom: green 2px solid;
        border-left: green 2px solid;
        border-right: green 2px solid;
    }
</style>
@endsection