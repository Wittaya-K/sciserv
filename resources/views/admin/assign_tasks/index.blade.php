@extends('layouts.admin')
@section('content')
<style>
.select2-container {
    min-width: 90% !important;
}
</style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h3>ขอใช้บริการ</h3> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">แดชบอร์ด</a></li>
                        <li class="breadcrumb-item active">กำหนดงาน</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" onclick="add_schedule();"><i class="fad fa-folder-plus"></i> เพิ่มข้อมูล</a>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            รายการ
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tbl_schedule" style="width: 100%;">
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modal_schedule_form" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"><i class="fad fa-file-alt"></i> เพิ่มข้อมูล</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fad fa-window-close" style="--fa-primary-color: #bd0000; --fa-secondary-color: #bd0000;"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" class="needs-validation" id="schedule_form" action="{{ route('admin.assign_tasks.save') }}" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="id" id="id" />
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ผู้รับผิดชอบ</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-chevron-square-down"></i></span>
                                        </div>
                                        <select name="username" id="username" class="form-control select2" required>
                                            <option value="">เลือก</option>
                                            @foreach ($db_username as $db_username_item)
                                                <option value="{{ $db_username_item->username }}">{{ $db_username_item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">งานบริการ</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-share-alt"></i></span>
                                        </div>
                                        <select name="service_id[]" id="service_id" class="form-control select2" multiple="multiple" required>
                                            @foreach ($db_service_request as $db_service_request_item)
                                                <option value="{{ $db_service_request_item->id }}">
                                                    {{ $db_service_request_item->service_request_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">หลักสูตร</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-chevron-square-down"></i></span>
                                        </div>
                                        <select name="department_id[]" id="department_id" class="form-control select2" multiple="multiple" required>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">
                                                    {{ $department->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">

                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" id="saveBtn" value="create"><i class="fad fa-save"></i> บันทึก
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $("#username").select2({ width: '80%' });
        
        $('#service_id').select2();

        var tbl_assign_tasks;
        show_schedule();

        function show_schedule() {
            if (tbl_assign_tasks) {
                tbl_assign_tasks.destroy();
            }
            tbl_samples = $('#tbl_schedule').DataTable({
                destroy: true,
                pageLength: 10,
                responsive: true,
                ajax: "{{ route('admin.assign_tasks.list') }}",
                deferRender: true,
                columns: [
                    {
                        className: '',
                        "data": 'id',
                        "title": '#',
                    },
                    {
                        className: '',
                        "data": 'name',
                        "title": 'ผู้รับผิดชอบ',
                    },
                    {
                        className: 'width-option-1 text-center',
                        "data": 'service_request_name',
                        "title": 'หน้าที่รับผิดชอบ',
                        "render": function(data, type, row, meta) {
                            newdata = '';
                            newdata +=
                                '<button class="btn btn-xs btn-info btn-sm font-base mt-1"  onclick="edit_schedule(' + row.id + ')" type="button"><i class="fad fa-eye"></i></button> ';
                            return newdata;
                        }
                    },
                    {
                        className: 'width-option-1 text-center',
                        width: '15%',
                        "data": 'id',
                        "orderable": false,
                        "title": 'เลือก',
                        "render": function(data, type, row, meta) {
                            newdata = '';
                            newdata +=
                                '<button class="btn btn-xs btn-warning btn-sm font-base mt-1"  onclick="edit_schedule(' +
                                row.id + ')" type="button"><i class="fad fa-edit"></i></button> ';
                            newdata +=
                                ' <button class="btn btn-xs btn-danger btn-sm font-base mt-1" onclick="delete_schedule(' +
                                row.id + ');" type="button"><i class="fad fa-trash"></i></button>';
                            return newdata;
                        }
                    }
                ]
            });
        }


        $("#schedule_form").on('submit', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            let formData = new FormData(this); // use 'this' directly to refer to the HTML form element

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                dataType: 'json',
                processData: false, // important for file uploads
                contentType: false, // important for file uploads
                beforeSend: function() {
                    $('#schedule_form_btn').prop('disabled', true);
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire("Success", response.message, "success");
                        show_schedule();
                        $('#modal_schedule_form').modal('hide');
                    } else {
                        console.log(response);
                    }
                    // validation('schedule_form', response.error);
                    $('#schedule_form_btn').prop('disabled', false);
                },
                error: function(error) {
                    $('#schedule_form_btn').prop('disabled', false);
                    console.log(error);
                }
            });
        });

        function add_schedule() {
            $("#id").val('');
            $('#username').val('');
            $('#service_id').val('');
            $('#department_id').val('');
            $("#modal_schedule_form").modal('show');
        }


        function edit_schedule(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.assign_tasks.find') }}/" + id,
                data: {},
                dataType: 'json',
                beforeSend: function() {},
                success: function(response) {
                    // console.log(response);
                    var service_val = '';
                    var department_val = '';
                    
                    if (response.status == true) {

                        service_val = response.data.service_id;
                        department_val = response.data.department_id;

                        $('#id').val(response.data.id);
                        $('#username').val(response.data.username);
                        $('#service_id').val(response.data.service_id);
                        $('#department_id').val(response.data.department_id);
                        $("#username").append(response.data.username).trigger('change');

                        // Predefined service_id values
                        // let service_ids = service_val.split(",");
                        // let department_ids = department_val.split(",");

                        let service_ids = service_val ? service_val.split(",") : [];
                        let department_ids = department_val ? department_val.split(",") : [];


                        // Set selected values
                        $('#service_id').val(service_ids).trigger('change');
                        $('#department_id').val(department_ids).trigger('change');
                        $('#modal_schedule_form').modal('show');
                    } else {
                        console.log(response);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }


        function delete_schedule(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to delete schedule?",
                icon: "warning", // Use 'icon' instead of 'type'
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) { // Check if the user clicked 'Yes'
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.assign_tasks.delete') }}/" + id,
                        data: {},
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == true) {
                                show_schedule();
                                Swal.fire("Success", response.message, "success");
                            } else {
                                console.log(response);
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        }
    </script>
@endsection
