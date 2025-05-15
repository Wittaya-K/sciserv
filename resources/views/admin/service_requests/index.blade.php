@extends('layouts.admin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                {{-- <h3>งานบริการ</h3> --}}
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">แดชบอร์ด</a></li>
                    <li class="breadcrumb-item active">งานบริการ</li>
                </ol>
            </div>
        </div>
    </div>
</div>
    @can('service_request_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createServiceRequest"><i class="fad fa-folder-plus"></i>
                    เพิ่มข้อมูล</a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            รายการ
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable">
                    <thead>
                        <tr width="10">
                            <th>#</th>
                            <th>ชื่องานบริการ</th>
                            <th>ชื่อหน่วยงาน</th>
                            <th>เลือก</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fad fa-window-close" style="--fa-primary-color: #bd0000; --fa-secondary-color: #bd0000;"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="service_request_Form" name="service_request_Form" class="form-horizontal">
                        <input type="hidden" name="service_request_id" id="service_request_id">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่องานบริการ</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-building"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="service_request_name" name="service_request_name" placeholder="กรุณาระบุชื่องานบริการ"
                                        placeholder="" value="" title="กรุณาระบุชื่องานบริการ" required>
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_service_request_name"></span></p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อหน่วยงาน</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-users"></i></span>
                                        </div>
                                        <select name="department_id[]" id="department_id" class="form-control select2" multiple="multiple">
                                            <option value="">กรุณาเลือกหน่วยงาน</option>
                                            @foreach ($tbl_departments as $tbl_department)
                                                <option value="{{$tbl_department->id}}">{{$tbl_department->department_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_department_name"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success" id="saveBtn" value="create"><i
                                    class="fad fa-save"></i> บันทึก
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
    <script type="text/javascript">
        $(function() {

            /*------------------------------------------
             --------------------------------------------
             Pass Header Token
             --------------------------------------------
             --------------------------------------------*/
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#department_id").select2({ width: '80%' });

            /*------------------------------------------
            --------------------------------------------
            Render DataTable
            --------------------------------------------
            --------------------------------------------*/
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.service_requests.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'service_request_name',
                        name: 'service_request_name'
                    },
                    // {
                    //     data: 'department_name',
                    //     name: 'department_name'
                    // },
                    {
                        className: 'width-option-1 text-center',
                        "data": 'department_name',
                        "title": 'ชือหน่วยงาน',
                        "render": function(data, type, row, meta) {
                            newdata = '';
                            newdata +=
                                '<button class="btn btn-xs btn-info btn-sm font-base mt-1 editServiceRequest" type="button" data-id="' + row.id + '"><i class="fad fa-eye"></i></button>';
                            return newdata;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Button
            --------------------------------------------
            --------------------------------------------*/
            $('#createServiceRequest').click(function() {
                $('#saveBtn').val("บันทึก");
                $('#service_request_id').val('');
                $('#service_request_Form').trigger("reset");
                $('#modelHeading').html("เพิ่มข้อมูล");
                $('#ajaxModel').modal('show');
                $('#department_id').select2();
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editServiceRequest', function() {
                var service_request_id = $(this).data('id');
                $.get("{{ route('admin.service_requests.index') }}" + '/' + service_request_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("แก้ไขข้อมูล");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#service_request_id').val(data.id);
                    $('#service_request_name').val(data.service_request_name);
                    if (data.department_id) {
                        $('#department_id').val(data.department_id.split(",")).trigger('change');
                    } else {
                        $('#department_id').val([]).trigger('change');
                    }
                    $('#group_name').val(data.group_name);
                })
            });

            /*------------------------------------------
            --------------------------------------------
            Create Course Code
            --------------------------------------------
            --------------------------------------------*/
            $('#saveBtn').click(function(e) {
                e.preventDefault();

                if($('#service_request_name').val() == ''){
                    $("#service_request_name").focus();
                    document.getElementById("msg_service_request_name").innerHTML  = "กรุณาระบุชื่องานบริการ";
                    return false;
                }
                else{
                    document.getElementById("msg_service_request_name").innerHTML  = "";
                }

                if($('#department_id').val() == ''){
                    $("#department_id").focus();
                    document.getElementById("msg_department_name").innerHTML  = "กรุณาเลือกหน่วยงาน";
                    return false;
                }
                else{
                    document.getElementById("msg_department_name").innerHTML  = "";
                }

                $(this).html('ส่ง..');

                $.ajax({
                    data: $('#service_request_Form').serialize(),
                    url: "{{ route('admin.service_requests.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#service_request_Form').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();

                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('บันทึก');
                    }
                });
            });

            /*------------------------------------------
            --------------------------------------------
            Delete Course Code
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.deleteServiceRequest', function() {

                var service_request_id = $(this).data("id");
                confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.service_requests.store') }}" + '/' + service_request_id,
                    success: function(data) {
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            });

        });
    </script>
@endsection
