@extends('layouts.admin')
@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h3>แจ้งเตือนไลน์</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">แดชบอร์ด</a></li>
                        <li class="breadcrumb-item active">แจ้งเตือนไลน์</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @can('exam_data_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createNewEdTechConnect" hidden><i class="fad fa-folder-plus"></i>
                    เพิ่มข้อมูล</a>          
                <a class="btn btn-success" href="{{$queryString}}"><i class="fad fa-sign-in"></i></i>
                    ลงทะเบียน</a>
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
                            <th>ชื่อผู้ใช้</th>
                            <th>หน่วยงาน</th>
                            <th>Access Token</th>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fad fa-window-close" style="--fa-primary-color: #bd0000; --fa-secondary-color: #bd0000;"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edtech_connect_Form" name="edtech_connect_Form" class="form-horizontal">
                        <input type="hidden" name="edtech_connect_id" id="edtech_connect_id">

                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อผู้ใช้</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="กรุณาระบุชื่อผู้ใช้"
                                            placeholder="" value="" title="กรุณาระบุชื่อผู้ใช้" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">หน่วยงาน</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="department_name" name="department_name" placeholder="กรุณาระบุหน่วยงาน"
                                            placeholder="" value="" title="กรุณาระบุหน่วยงาน" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">Access Token</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-key"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="access_token" name="access_token" placeholder="กรุณาระบุไลน์โทเคน"
                                            placeholder="" value="" title="กรุณาระบุไลน์โทเคน" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">สถานะ</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-toggle-on"></i></span>
                                        </div>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="1">เปิด</option>
                                            <option value="0">ปิด</option>
                                        </select>
                                    </div>
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
                ajax: "{{ route('admin.edtech_connects.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'department_name',
                        name: 'department_name'
                    },
                    {
                        data: 'access_token',
                        name: 'access_token'
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
            $('#createNewEdTechConnect').click(function() {
                $('#saveBtn').val("บันทึก");
                $('#edtech_connect_id').val('');
                $('#edtech_connect_Form').trigger("reset");
                $('#modelHeading').html("เพิ่มข้อมูล");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editEdTechConnect', function() {
                var edtech_connect_id = $(this).data('id');
                $.get("{{ route('admin.edtech_connects.index') }}" + '/' + edtech_connect_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("แก้ไขข้อมูล");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#edtech_connect_id').val(data.id);
                    $('#username').val(data.username);
                    $('#department_name').val(data.department_name);
                    $('#access_token').val(data.access_token);
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
                $(this).html('ส่ง..');

                $.ajax({
                    data: $('#edtech_connect_Form').serialize(),
                    url: "{{ route('admin.edtech_connects.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#edtech_connect_Form').trigger("reset");
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
            $('body').on('click', '.deleteEdTechConnect', function() {

                var edtech_connect_id = $(this).data("id");
                confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.edtech_connects.store') }}" + '/' + edtech_connect_id,
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
