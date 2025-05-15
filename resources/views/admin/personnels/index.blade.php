@extends('layouts.admin')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h3>บุคลากร</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">แดชบอร์ด</a></li>
                    <li class="breadcrumb-item active">บุคลากร</li>
                </ol>
            </div>
        </div>
    </div>
</div>
    @can('personnel_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createNewPersonnel"><i class="fad fa-folder-plus"></i>
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
                            <th>ชื่อ-สกุล</th>
                            <th>เบอร์โทรภายใน</th>
                            <th>อีเมล</th>
                            <th>ชื่อหน่วยงาน</th>
                            <th>กลุ่มงาน</th>
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
                    <form id="personnel_Form" name="personnel_Form" class="form-horizontal">
                        <input type="hidden" name="personnel_id" id="personnel_id">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อ-สกุล</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="fullname" name="fullname"
                                            placeholder="กรุณาระบุชื่อ-สกุล" placeholder="" value="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">เบอร์โทรภายใน</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-phone-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="tel" name="tel"
                                            minlength="4" maxlength="4" onkeypress=" return isNumber(event)"
                                            placeholder="กรุณาระบุเบอร์โทรภายใน 4 หลัก" placeholder="" value=""
                                            required>
                                        <span id="telError" style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">อีเมล</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-envelope"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="email" name="email"
                                            placeholder="กรุณาระบุอีเมล" onkeyup="ValidateEmail();" placeholder=""
                                            value="" required>
                                        <span id="emailError" style="color: red"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อหน่วยงาน</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-building"></i></span>
                                        </div>
                                        <select name="department_name" id="department_name" class="form-control" required>
                                            <option value="">กรุณาเลือกชื่อหน่วยงาน</option>
                                            @foreach ($tbl_departments as $tbl_department)
                                                <option value="{{ $tbl_department->department_name }}">
                                                    {{ $tbl_department->department_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">กลุ่มงาน</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-users"></i></span>
                                        </div>
                                        <select name="group_name" id="group_name" class="form-control" required>
                                            <option value="">กรุณาเลือกกลุ่มงาน</option>
                                            <option value="กลุ่มงานวิชาการ">กลุ่มงานวิชาการ</option>
                                            <option value="กลุ่มงานบริหาร">กลุ่มงานบริหาร</option>
                                            <option value="กลุ่มงานพันธกิจเพื่อสังคม">กลุ่มงานพันธกิจเพื่อสังคม</option>
                                            <option value="กลุ่มงานวิจัยและนวัตกรรม">กลุ่มงานวิจัยและนวัตกรรม</option>
                                        </select>
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
        function isNumber(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            var telError = document.getElementById("telError");
            telError.innerHTML = "";
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                telError.innerHTML = "เบอร์โทรไม่ถูกต้อง!";
                return false;
            }
            return true;
        }

        function ValidateEmail() {
            var email = document.getElementById("email").value;
            var emailError = document.getElementById("emailError");
            emailError.innerHTML = "";
            var expr =
                /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (!expr.test(email)) {
                emailError.innerHTML = "อีเมลไม่ถูกต้อง!";
            }
        }
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
                ajax: "{{ route('admin.personnels.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'fullname',
                        name: 'fullname'
                    },
                    {
                        data: 'tel',
                        name: 'tel'
                    },
                    {
                        data: 'email',
                        name: 'email'
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
            $('#createNewPersonnel').click(function() {
                $('#saveBtn').val("บันทึก");
                $('#personnel_id').val('');
                $('#personnel_Form').trigger("reset");
                $('#modelHeading').html("เพิ่มข้อมูล");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editPersonnel', function() {
                var personnel_id = $(this).data('id');
                $.get("{{ route('admin.personnels.index') }}" + '/' + personnel_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("แก้ไขข้อมูล");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#personnel_id').val(data.id);
                    $('#fullname').val(data.fullname);
                    $('#tel').val(data.tel);
                    $('#email').val(data.email);
                    $('#department_name').val(data.department_name);
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
                $(this).html('ส่ง..');

                $.ajax({
                    data: $('#personnel_Form').serialize(),
                    url: "{{ route('admin.personnels.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#personnel_Form').trigger("reset");
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
            $('body').on('click', '.deletePersonnel', function() {

                var personnel_id = $(this).data("id");
                confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.personnels.store') }}" + '/' + personnel_id,
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
