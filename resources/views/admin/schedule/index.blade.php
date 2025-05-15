@extends('layouts.admin')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h3>ขอใช้บริการ</h3> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">แดชบอร์ด</a></li>
                        <li class="breadcrumb-item active">ขอใช้บริการ</li>
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
                    {{-- <h4 class="modal-title" id="modelHeading"><i class="fad fa-file-alt"></i> เพิ่มข้อมูล</h4> --}}
                    <h4 class="modal-title" id="modelHeading"><i class="fad fa-file-alt"></i></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fad fa-window-close"
                                style="--fa-primary-color: #bd0000; --fa-secondary-color: #bd0000;"></i></span>
                    </button>
                </div>
                <form method="POST" class="needs-validation" id="schedule_form" action="{{ route('admin.schedule.save') }}"
                    enctype="multipart/form-data" novalidate>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header">
                                รายละเอียดเพิ่มเติม
                            </div>

                            <div class="card-body">
                                <input type="hidden" name="id" id="id" />
                                <div class="row">
                                    <div class="col-lg-6 col-12" hidden>
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">หมวดหมู่</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fad fa-chevron-square-down"></i></span>
                                                </div>
                                                <select name="category" id="category" class="form-control">
                                                    <option value="">เลือก</option>
                                                    @foreach ($db_category as $db_category_item)
                                                        <option value="{{ $db_category_item->name }}" selected>
                                                            {{ $db_category_item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">ชื่อเรื่อง</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fad fa-heading"></i></span>
                                                </div>
                                                <input type="text" name="title" id="title" class="form-control"
                                                    required placeholder="กรุณาระบุเรื่องที่ต้องการใช้บริการ" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">รายละเอียดงาน</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fad fa-text"></i></span>
                                                </div>
                                                <textarea type="textarea" name="description" id="description" class="form-control" required
                                                    placeholder="กรุณาระบุรายละเอียดงานที่ต้องการใช้บริการ"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="btcd-f-input">
                                            <label class="col-sm-12 control-label">ไฟล์</label>
                                            <div class="btcd-f-wrp">
                                                <button class="btcd-inpBtn" type="button"> <img src=""
                                                        alt=""> <span> เลือกไฟล์</span></button>
                                                <span class="btcd-f-title">ไม่มีไฟล์ที่เลือก</span>
                                                <small class="f-max"> (สูงสุด 100 MB)</small>
                                                <input multiple type="file" name="file[]" id="file">
                                            </div>
                                            <div class="btcd-files">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">งานบริการที่ร้องขอ</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend" style="width: 100%">
                                                    <span class="input-group-text"><i class="fad fa-share-alt"></i></span>
                                                    <select name="service" id="service" class="form-control" onchange="selectdepartments()" required>
                                                        <option value="">เลือก</option>
                                                        @foreach ($db_service_request as $db_service_request_item)
                                                            <option value="{{ $db_service_request_item->id }}">
                                                                {{ $db_service_request_item->service_request_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">หลักสูตร</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend" style="width: 100%">
                                                    <span class="input-group-text"><i class="fad fa-users"></i></span>
                                                    <select name="department" id="department" class="form-control" onchange="selectdepartments()"
                                                        required>
                                                        <option value="">เลือก</option>
                                                        @foreach ($db_department as $db_department_item)
                                                            <option value="{{ $db_department_item->department_name }}">
                                                                {{ $db_department_item->department_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">วันที่เริ่ม</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fad fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" name="schedule_from" id="schedule_from"
                                                    class="form-control" required placeholder="____-__-__ __:__" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">ถึงวันที่</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fad fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" name="schedule_to" id="schedule_to"
                                                    class="form-control" required placeholder="____-__-__ __:__" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">ผู้ใช้บริการ</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fad fa-user"></i></span>
                                                </div>
                                                <input type="text" value="{{ Auth()->user()->name }}"
                                                    class="form-control" required placeholder="" />
                                                <input type="hidden" name="user_service_required"
                                                    id="user_service_required" value="{{ Auth()->user()->username }}"
                                                    class="form-control" required placeholder="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label">ผู้รับผิดชอบ</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fad fa-user"></i></span>
                                                </div>
                                                <input type="text" name="services" id="services"
                                                    value="" class="form-control"
                                                    placeholder="" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" id="saveBtn" value="create"><i
                                    class="fad fa-save"></i> บันทึก</button>
                        </div>
                    </div>
                </form>
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

        $.datetimepicker.setLocale('th');
        $('#schedule_from').datetimepicker({
            mask: '0000-00-00 00:00',
            format: 'Y-m-d H:i',
            formatTime: 'H:i',
            formatDate: 'Y-m-d',
            step: 30, //กำหนดค่านาทีของเวลา
            lang: 'th', //กำหนดค่าเป็นภาษาไทย
            minDate: '-1970/01/01' // yesterday is minimum date
        });

        $('#schedule_to').datetimepicker({
            mask: '0000-00-00 00:00',
            format: 'Y-m-d H:i',
            formatTime: 'H:i',
            formatDate: 'Y-m-d',
            step: 30, //กำหนดค่านาทีของเวลา
            lang: 'th', //กำหนดค่าเป็นภาษาไทย
            minDate: '-1970/01/01' // yesterday is minimum date
        });

        var tbl_schedule;
        show_schedule();

        function show_schedule() {
            if (tbl_schedule) {
                tbl_schedule.destroy();
            }
            tbl_samples = $('#tbl_schedule').DataTable({
                destroy: true,
                pageLength: 10,
                responsive: true,
                ajax: "{{ route('admin.schedule.list') }}",
                deferRender: true,
                columns: [{
                        className: '',
                        "data": 'id',
                        "title": '#',
                        "render": function(data, type, row, meta) {
                            // Return the content with a data-id attribute
                            return '<span data-id="' + row.id + '">' + data + '</span>';
                        }
                    },
                    {
                        className: '',
                        "data": 'title',
                        "title": 'ชื่อเรื่อง',
                    },
                    {
                        className: '',
                        "data": 'description',
                        "title": 'รายละเอียดเพิ่มเติม',
                    },
                    {
                        className: '',
                        "data": 'department',
                        "title": 'กลุ่มงาน',
                    },
                    {
                        className: '',
                        "data": 'service',
                        "title": 'งานบริการ',
                        "render": function(data, type, row, meta) {
                            var text = '';
                            @foreach ($db_service_request as $db_service_request_item)
                                if (row.service == "{{ $db_service_request_item->id }}") {
                                    text = "{{ $db_service_request_item->service_request_name }}";
                                    return text;
                                }
                            @endforeach
                        }
                    },
                    {
                        className: '',
                        "data": 'schedule_from',
                        "title": 'วันที่เริ่ม',
                    },
                    {
                        className: '',
                        "data": 'schedule_to',
                        "title": 'ถึงวันที่',
                    },
                    {
                        className: '',
                        "data": 'user_service_required',
                        "title": 'ผู้ขอใช้บริการ',
                        "render": function(data, type, row, meta) {
                            var text = '';
                            @foreach ($db_users as $db_users_item)
                                if (row.user_service_required == "{{ $db_users_item->username }}") {
                                    text = "{{ $db_users_item->name }}";
                                    return text;
                                }
                            @endforeach
                        }
                    },
                    {
                        className: 'width-option-1 text-center',
                        width: '15%',
                        "data": 'id',
                        "orderable": false,
                        "title": 'สถานะ',
                        "render": function(data, type, row, meta) {

                            // Initialize selected variables for each status
                            var selectedReceived = '';
                            var selectedInProcess = '';
                            var selectedCompleted = '';

                            // Set selected based on job status
                            if (row.job_status == 'Received') {
                                selectedReceived = 'selected';
                            } else if (row.job_status == 'InProcess') {
                                selectedInProcess = 'selected';
                            } else if (row.job_status == 'Completed') {
                                selectedCompleted = 'selected';
                            }

                            // Construct the select dropdown with the appropriate option selected
                            select = '';
                            select +=
                                '<select name="job_status" id="job_status" class="form-control" onchange="job_status_schedule(this.value, this)">' +
                                '<option value="">เลือก</option>' +
                                '<option value="Received" ' + selectedReceived + '>รับเรื่องแล้ว</option>' +
                                '<option value="InProcess" ' + selectedInProcess +
                                '>กำลังดำเนินการ</option>' +
                                '<option value="Completed" ' + selectedCompleted + '>เสร็จสิ้น</option>' +
                                '</select>';

                            return select;
                        }
                    },
                    {
                        className: 'width-option-1 text-center',
                        width: '5%',
                        "data": 'id',
                        "orderable": false,
                        "title": 'เลือก',
                        "render": function(data, type, row, meta) {
                            newdata = '';
                            newdata +=
                                '<button class="btn btn-xs btn-warning btn-sm font-base mt-1"  onclick="edit_schedule(' +
                                row.id + ')" type="button"><i class="fa fa-edit"></i></button> ';
                            newdata +=
                                ' <button class="btn btn-xs btn-danger btn-sm font-base mt-1" onclick="delete_schedule(' +
                                row.id + ');" type="button"><i class="fa fa-trash"></i></button>';

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
            if ($('#title').val() == '') {
                Swal.fire({
                    title: "แจ้งเตือน!",
                    text: "กรุณาระบุเรื่องที่ต้องการใช้บริการ!",
                    icon: "warning"
                });
            } else if ($('#description').val() == '') {
                Swal.fire({
                    title: "แจ้งเตือน!",
                    text: "กรุณาระบุรายละเอียดงานที่ต้องการใช้บริการ!",
                    icon: "warning"
                });
            } else if ($('#department').val() == '') {
                Swal.fire({
                    title: "แจ้งเตือน!",
                    text: "กรุณาเลือกหน่วยงานที่เกี่ยวข้อง!",
                    icon: "warning"
                });
            } else if ($('#service').val() == '') {
                Swal.fire({
                    title: "แจ้งเตือน!",
                    text: "กรุณาเลือกงานบริการที่ร้องขอ!",
                    icon: "warning"
                });
            } else if ($('#schedule_from').val() == '') {
                Swal.fire({
                    title: "แจ้งเตือน!",
                    text: "กรุณาระบุรายวันที่เริ่ม!",
                    icon: "warning"
                });
            } else if ($('#schedule_to').val() == '') {
                Swal.fire({
                    title: "แจ้งเตือน!",
                    text: "กรุณาระบุถึงวันที่!",
                    icon: "warning"
                });
            }

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
            // $('#category').val('');
            $('#title').val('');
            $('#description').val('');
            $('#file').val('');
            $('#department').val('');
            $('#service').val('');
            $('#schedule_from').val('');
            $('#schedule_to').val('');
            $("#modal_schedule_form").modal('show');
        }


        function edit_schedule(id) {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.schedule.find') }}/" + id,
                data: {},
                dataType: 'json',
                beforeSend: function() {},
                success: function(response) {
                    // console.log(response);
                    if (response.status == true) {
                        $('#id').val(response.data.id);
                        $('#category').val(response.data.category);
                        $('#title').val(response.data.title);
                        $('#description').val(response.data.description);
                        $('#department').val(response.data.department);
                        $('#service').val(response.data.service);
                        $('#schedule_from').val(response.data.schedule_from);
                        $('#schedule_to').val(response.data.schedule_to);
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


        function selectdepartments() {
            let service = $('#service').val();
            let department = $('#department').val();
            if (service == '' || department == '') {
                return false;
            }
            $.ajax({
                type: "GET",
                url: "{{ route('admin.schedule.selectdepartments') }}/",
                data: {
                    service:service,
                    department:department
                },
                dataType: 'json',
                beforeSend: function() {},
                success: function(response) {
                    // console.log(response);
                    if (response.status == true) {
                        // $('#id').val(response.data.id);
                        // $('#category').val(response.data.category);
                        // $('#title').val(response.data.title);
                        // $('#description').val(response.data.description);
                        // $('#department').val(response.data.department);
                        // $('#service').val(response.data.service);
                        // $('#schedule_from').val(response.data.schedule_from);
                        // $('#schedule_to').val(response.data.schedule_to);
                        $('#services').val(response.data.data.services);
                        // $('#modal_schedule_form').modal('show');
                        // console.log(response);
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
                title: "แน่ใจหรือไม่?",
                text: "ต้องการลบข้อมูลใช่หรือไม่?",
                icon: "warning", // Use 'icon' instead of 'type'
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ใช่",
                cancelButtonText: "ไม่",
            }).then((result) => {
                if (result.isConfirmed) { // Check if the user clicked 'Yes'
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.schedule.delete') }}/" + id,
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

        function job_status_schedule(job_status, element) {
            // Find the nearest `span` element with `data-id` relative to `element`
            var dataId = $(element).closest('tr').find('span').data('id');
            $.ajax({
                type: "POST",
                url: "{{ route('admin.schedule.job_status') }}",
                data: {
                    job_status: job_status,
                    dataId: dataId
                },
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
    </script>
@endsection
