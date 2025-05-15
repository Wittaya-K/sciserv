@extends('layouts.admin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h3>หน่วยงาน</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">แดชบอร์ด</a></li>
                    <li class="breadcrumb-item active">หน่วยงาน</li>
                </ol>
            </div>
        </div>
    </div>
</div>
    @can('department_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createNewDepartment"><i class="fad fa-folder-plus"></i>
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
                            <th>ชื่อหน่วยงาน</th>
                            <th>กลุ่มงาน</th>
                            <th>สถานะ</th>
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
                    <form id="department_Form" name="department_Form" class="form-horizontal">
                        <input type="hidden" name="department_id" id="department_id">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อหน่วยงาน</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-building"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="department_name" name="department_name" placeholder="กรุณาระบุชื่อหน่วยงาน"
                                        placeholder="" value="" title="กรุณาระบุชื่อหน่วยงาน" required>
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_department_name"></span></p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อกลุ่มงาน</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-users"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="group_name" name="group_name" placeholder="กรุณาระบุชื่อกลุ่มงาน"
                                            placeholder="" value="" title="กรุณาระบุชื่อกลุ่มงาน" required>
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_group_name"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">สถานะ</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-toggle-on"></i></span>
                                        </div>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">เลือก</option>
                                            <option value="1">เปิด</option>
                                            <option value="0">ปิด</option>
                                        </select>
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_status"></span></p>
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

            /*------------------------------------------
            --------------------------------------------
            Render DataTable
            --------------------------------------------
            --------------------------------------------*/
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.departments.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
                    {
                        data: 'group_name',
                        name: 'group_name'
                    },
                    {
                        data: 'status', 'render': function (data) {
                            if(data =='1'){
                                return '<i class="fad fa-toggle-on fa-lg" style="--fa-primary-color: #28a745; --fa-secondary-color: #28a745;"></i>';
                            }else{
                                return '<i class="fad fa-toggle-off fa-lg" style="--fa-primary-color: #bd2130; --fa-secondary-color: #bd2130;"></i>';
                            }
                        },
                        className: 'text-center',
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
            $('#createNewDepartment').click(function() {
                $('#saveBtn').val("บันทึก");
                $('#department_id').val('');
                $('#department_Form').trigger("reset");
                $('#modelHeading').html("เพิ่มข้อมูล");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editDepartment', function() {
                var department_id = $(this).data('id');
                $.get("{{ route('admin.departments.index') }}" + '/' + department_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("แก้ไขข้อมูล");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#department_id').val(data.id);
                    $('#department_name').val(data.department_name);
                    $('#group_name').val(data.group_name);
                    $('#status').val(data.status);
                })
            });

            /*------------------------------------------
            --------------------------------------------
            Create Course Code
            --------------------------------------------
            --------------------------------------------*/
            $('#saveBtn').click(function(e) {
                e.preventDefault();

                if($('#department_name').val() == ''){
                    $("#department_name").focus();
                    document.getElementById("msg_department_name").innerHTML  = "กรุณาระบุชื่อหน่วยงาน";
                    return false;
                }
                else{
                    document.getElementById("msg_department_name").innerHTML  = "";
                }

                if($('#group_name').val() == ''){
                    $("#group_name").focus();
                    document.getElementById("msg_group_name").innerHTML  = "กรุณาระบุชื่อกลุ่มงาน";
                    return false;
                }
                else{
                    document.getElementById("msg_group_name").innerHTML  = "";
                }

                if($('#status').val() == ''){
                    $("#status").focus();
                    document.getElementById("msg_status").innerHTML  = "กรุณาเลือกสถานะ";
                    return false;
                }
                else{
                    document.getElementById("msg_status").innerHTML  = "";
                }

                $(this).html('ส่ง..');

                $.ajax({
                    data: $('#department_Form').serialize(),
                    url: "{{ route('admin.departments.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#department_Form').trigger("reset");
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
            $('body').on('click', '.deleteDepartment', function() {

                var department_id = $(this).data("id");
                confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.departments.store') }}" + '/' + department_id,
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
