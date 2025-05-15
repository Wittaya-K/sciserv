@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h3>ภาคการศึกษา</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">แดชบอร์ด</a></li>
                    <li class="breadcrumb-item active">ภาคการศึกษา</li>
                </ol>
            </div>
        </div>
    </div>
    @can('exam_data_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createNewSemester"><i class="fad fa-folder-plus"></i>
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
                            <th>ภาคการศึกษา</th>
                            <th>ชื่อภาคการศึกษา</th>
                            <th>เลือก</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true" style="z-index: 1100;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="semester_Form" name="semester_Form" class="form-horizontal">
                        <input type="hidden" name="semester_id" id="semester_id">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ภาคการศึกษา</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="semester" name="semester"
                                            placeholder="ระบุภาคการศึกษา" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อภาคการศึกษา</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="semester_name" name="semester_name"
                                            placeholder="ระบุชื่อภาคการศึกษา" value="" required="">
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
                ajax: "{{ route('admin.semesters.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'semester',
                        name: 'semester'
                    },
                    {
                        data: 'semester_name',
                        name: 'semester_name'
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
            $('#createNewSemester').click(function() {
                $('#saveBtn').val("บันทึก");
                $('#semester_id').val('');
                $('#semester_Form').trigger("reset");
                $('#modelHeading').html("เพิ่ม");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editSemester', function() {
                var semester_id = $(this).data('id');
                $.get("{{ route('admin.semesters.index') }}" + '/' + semester_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("แก้ไข");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#semester_id').val(data.id);
                    $('#semester').val(data.semester);
                    $('#semester_name').val(data.semester_name);
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
                    data: $('#semester_Form').serialize(),
                    url: "{{ route('admin.semesters.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#semester_Form').trigger("reset");
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
            $('body').on('click', '.deleteSemester', function() {

                var semester_id = $(this).data("id");
                confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.semesters.store') }}" + '/' + semester_id,
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
