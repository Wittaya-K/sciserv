@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h3>นักศึกษาเข้าสอบ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">แดชบอร์ด</a></li>
                    <li class="breadcrumb-item active">นักศึกษาเข้าสอบ</li>
                </ol>
            </div>
        </div>
    </div>
    @can('exam_data_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createExamStudent"><i class="fad fa-folder-plus"></i>
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
                            <th>เลขบัตรประชาชน</th>
                            <th>รหัสนักศึกษา</th>
                            <th>ชื่อนักศึกษา</th>
                            <th>หลักสูตรการเรียน</th>
                            <th>คณะ</th>
                            <th>ชั้นปี</th>
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
                    <form id="exam_student_Form" name="exam_student_Form" class="form-horizontal">
                        <input type="hidden" name="exam_student_id" id="exam_student_id">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">เลขบัตรประชาชน</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="id_card" name="id_card"
                                            placeholder="ระบุเลขบัตรประชาชน" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">รหัสนักศึกษา</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="std_no" name="std_no"
                                            placeholder="ระบุรหัสนักศึกษา" value="" required="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อนักศึกษา</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="std_name" name="std_name"
                                            placeholder="ระบุชื่อนักศึกษา" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">หลักสูตรการเรียน</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="course_study" id="course_study">
                                            <option value="">เลือก</option>
                                            @foreach ($tbl_course_studys as $tbl_course_study)
                                                <option value="{{$tbl_course_study->course_study}}">{{$tbl_course_study->course_study_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">คณะ</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="faculty" id="faculty">
                                            <option value="">เลือก</option>
                                            @foreach ($tbl_facultys as $tbl_faculty)
                                                <option value="{{$tbl_faculty->faculty}}">{{$tbl_faculty->faculty_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชั้นปี</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="year" id="year">
                                            <option value="">เลือก</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
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
                ajax: "{{ route('admin.exam_students.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'id_card',
                        name: 'id_card'
                    },
                    {
                        data: 'std_no',
                        name: 'std_no'
                    },
                    {
                        data: 'std_name',
                        name: 'std_name'
                    },
                    {
                        data: 'course_study',
                        'render': function(data) {
                            @foreach ($tbl_course_studys as $tbl_course_study)
                                if(data === '{{$tbl_course_study->course_study}}'){
                                    return '{{$tbl_course_study->course_study_name}}';
                                }
                            @endforeach
                        }
                    },
                    {
                        data: 'faculty',
                        'render': function(data) {
                            @foreach ($tbl_facultys as $tbl_faculty)
                                if(data === '{{$tbl_faculty->faculty}}'){
                                    return '{{$tbl_faculty->faculty_name}}';
                                }
                            @endforeach
                        }
                    },
                    {
                        data: 'year',
                        name: 'year',
                        className: 'text-center',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
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
            $('#createExamStudent').click(function() {
                $('#saveBtn').val("บันทึก");
                $('#exam_student_id').val('');
                $('#exam_student_Form').trigger("reset");
                $('#modelHeading').html("เพิ่ม");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editExamStudent', function() {
                var exam_student_id = $(this).data('id');
                $.get("{{ route('admin.exam_students.index') }}" + '/' + exam_student_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("แก้ไข");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#exam_student_id').val(data.id);
                    $('#id_card').val(data.id_card);
                    $('#std_no').val(data.std_no);
                    $('#std_name').val(data.std_name);
                    $('#course_study').val(data.course_study);
                    $('#faculty').val(data.faculty);
                    $('#year').val(data.year);
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
                    data: $('#exam_student_Form').serialize(),
                    url: "{{ route('admin.exam_students.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#exam_student_Form').trigger("reset");
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
            $('body').on('click', '.deleteExamStudent', function() {

                var exam_student_id = $(this).data("id");
                confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.exam_students.store') }}" + '/' + exam_student_id,
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
