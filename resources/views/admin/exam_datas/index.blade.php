@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h3>ข้อมูลจัดห้องสอบ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">แดชบอร์ด</a></li>
                    <li class="breadcrumb-item active">ข้อมูลจัดห้องสอบ</li>
                </ol>
            </div>
        </div>
    </div>
    @can('exam_data_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createNewExamData"><i class="fad fa-folder-plus"></i>
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
                    <thead class="text-center">
                        <tr width="10">
                            <th>#</th>
                            <th>วันที่</th>
                            <th>เวลา</th>
                            <th>ID วิชา</th>
                            <th>รหัสวิชา</th>
                            <th>ชื่อวิชา</th>
                            <th>ตอน</th>
                            <th>จำนวน</th>
                            <th>จำนวนจากฐานข้อมูล</th>
                            <th>แล็บ</th>
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
                    <form id="exam_data_Form" name="exam_data_Form" class="form-horizontal">
                        <input type="hidden" name="exam_data_id" id="exam_data_id">

                        <div class="row">
                            <div class="col-lg-6 col-12">

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ลำดับที่</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="id_no" name="id_no"
                                            placeholder="ระบุลำดับที่" value="" maxlength="50" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">วันที่สอบ</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="date" name="date"
                                            placeholder="ระบุวันที่สอบ" value="" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">เวลาสอบ</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="time" name="time"
                                            placeholder="ระบุเวลาสอบ" value="" maxlength="50" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ID วิชา</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="course_id" name="course_id"
                                            placeholder="ระบุID วิชา" value="" maxlength="50" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">รหัสวิชา</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="course_no" name="course_no"
                                            placeholder="ระบุรหัสวิชา" value="" maxlength="50" required="">
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6 col-12">

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อวิชา</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="course_name" name="course_name"
                                            placeholder="ระบุลำชื่อวิชา" value="" maxlength="50" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ตอน</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="section" name="section"
                                            placeholder="ระบุตอน" value="" maxlength="50" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">จำนวนนักศึกษานำเข้า</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="std_amout_import"
                                            name="std_amout_import" placeholder="ระบุจำนวนนักศึกษานำเข้า" value=""
                                            maxlength="50" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">จำนวนนักศึกษาจากฐานข้อมูล</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="std_amout_data"
                                            name="std_amout_data" placeholder="ระบุจำนวนนักศึกษาจากฐานข้อมูล"
                                            value="" maxlength="50" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-12 control-label">สอบแล็บ</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="std_lab_amout"
                                            name="std_lab_amout" placeholder="ระบุสอบแล็บ" value="" maxlength="50"
                                            required="">
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
                ajax: "{{ route('admin.exam_datas.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'time',
                        name: 'time'
                    },
                    {
                        data: 'course_id',
                        name: 'course_id'
                    },
                    {
                        data: 'course_no',
                        name: 'course_no'
                    },
                    {
                        data: 'course_name',
                        name: 'course_name'
                    },
                    {
                        data: 'section',
                        name: 'section'
                    },
                    {
                        data: 'std_amout_import',
                        name: 'std_amout_import'
                    },
                    {
                        data: 'std_amout_data',
                        name: 'std_amout_data'
                    },
                    {
                        data: 'std_lab_amout',
                        name: 'std_lab_amout'
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
            $('#createNewExamData').click(function() {
                $('#saveBtn').val("บันทึก");
                $('#exam_data_id').val('');
                $('#exam_data_Form').trigger("reset");
                $('#modelHeading').html("เพิ่ม");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editExamData', function() {
                var exam_data_id = $(this).data('id');
                $.get("{{ route('admin.exam_datas.index') }}" + '/' + exam_data_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("แก้ไข");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#exam_data_id').val(data.id);
                    $('#id_no').val(data.id_no);
                    $('#date').val(data.date);
                    $('#time').val(data.time);
                    $('#course_id').val(data.course_id);
                    $('#course_no').val(data.course_no);
                    $('#course_name').val(data.course_name);
                    $('#section').val(data.section);
                    $('#std_amout_import').val(data.std_amout_import);
                    $('#std_amout_data').val(data.std_amout_data);
                    $('#std_lab_amout').val(data.std_lab_amout);
                })
            });

            /*------------------------------------------
            --------------------------------------------
            Create Product Code
            --------------------------------------------
            --------------------------------------------*/
            $('#saveBtn').click(function(e) {
                e.preventDefault();
                $(this).html('ส่ง..');

                $.ajax({
                    data: $('#exam_data_Form').serialize(),
                    url: "{{ route('admin.exam_datas.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#exam_data_Form').trigger("reset");
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
            Delete Product Code
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.deleteExamData', function() {

                var exam_data_id = $(this).data("id");
                confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.exam_datas.store') }}" + '/' + exam_data_id,
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
