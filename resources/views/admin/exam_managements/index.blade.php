@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h3>จัดห้องสอบ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">แดชบอร์ด</a></li>
                    <li class="breadcrumb-item active">จัดห้องสอบ</li>
                </ol>
            </div>
        </div>
    </div>
    @can('exam_data_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createExamManagement"><i class="fad fa-folder-plus"></i>
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
                            <th>เวลา</th>
                            <th>รหัสวิชา</th>
                            <th>ชื่อวิชา</th>
                            <th>ตอน</th>
                            <th>จำนวน</th>
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

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="exam_management_Form" name="exam_management_Form" class="form-horizontal">
                        <input type="hidden" name="exam_management_id" id="exam_management_id">

                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">รหัสวิชา</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="course_no" name="course_no"
                                            placeholder="ระบุรหัสวิชา" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อภาษาไทย</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="couse_name_th" name="couse_name_th"
                                            placeholder="ระบุชื่อภาษาไทย" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อภาษาอังกฤษ</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="couse_name_eng" name="couse_name_eng"
                                            placeholder="ระบุชื่อภาษาอังกฤษ" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ตอน</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="section" name="section"
                                            placeholder="ระบุตอน" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">จำนวนนักศึกษา</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="std_amount" name="std_amount"
                                            placeholder="ระบุจำนวนนักศึกษา" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">รหัสแถว</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="row_no" name="row_no"
                                            placeholder="ระบุรหัสแถว" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ห้องที่เลือก</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="room_name" name="room_name"
                                            placeholder="ระบุห้องที่เลือก" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">แถว</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="row" name="row"
                                            placeholder="ระบุแถว" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">จำนวนที่นั่ง</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="amount_seat" name="amount_seat"
                                            placeholder="ระบุจำนวนที่นั่ง" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ที่นั่งคงเหลือ</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="amount_seat_available" name="amount_seat_available"
                                            placeholder="ระบุที่นั่งคงเหลือ" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">นักศึกษาคงเหลือ</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="std_amount_available" name="std_amount_available"
                                            placeholder="ระบุนักศึกษาคงเหลือ" value="" maxlength="50" required="">
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
                ajax: "{{ route('admin.exam_managements.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'time',
                        name: 'time'
                    },
                    {
                        data: 'course_no',
                        name: 'course_no'
                    },
                    {
                        data: 'couse_name_eng',
                        name: 'couse_name_eng'
                    },
                    {
                        data: 'section',
                        name: 'section'
                    },
                    {
                        data: 'std_amount',
                        name: 'std_amount'
                    },
                    {
                        data: 'row_no',
                        name: 'row_no'
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
            $('#createExamManagement').click(function() {
                $('#saveBtn').val("บันทึก");
                $('#exam_management_id').val('');
                $('#exam_management_Form').trigger("reset");
                $('#modelHeading').html("เพิ่ม");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editExamManagement', function() {
                var exam_management_id = $(this).data('id');
                $.get("{{ route('admin.exam_managements.index') }}" + '/' + exam_management_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("แก้ไข");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#exam_management_id').val(data.id);
                    $('#course_no').val(data.course_no);
                    $('#couse_name_th').val(data.couse_name_th);
                    $('#couse_name_eng').val(data.couse_name_eng);
                    $('#section').val(data.section);
                    $('#std_amount').val(data.std_amount);
                    $('#row_no').val(data.row_no);
                    $('#room_name').val(data.room_name);
                    $('#row').val(data.row);
                    $('#amount_seat').val(data.amount_seat);
                    $('#amount_seat_available').val(data.amount_seat_available);
                    $('#std_amount_available').val(data.std_amount_available);
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
                    data: $('#exam_management_Form').serialize(),
                    url: "{{ route('admin.exam_managements.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#exam_management_Form').trigger("reset");
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
            $('body').on('click', '.deleteExamManagement', function() {

                var exam_management_id = $(this).data("id");
                confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.exam_managements.store') }}" + '/' + exam_management_id,
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
