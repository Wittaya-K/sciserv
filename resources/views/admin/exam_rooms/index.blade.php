@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h3>ข้อมูลห้องสอบ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">แดชบอร์ด</a></li>
                    <li class="breadcrumb-item active">ข้อมูลห้องสอบ</li>
                </ol>
            </div>
        </div>
    </div>
    @can('exam_data_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createExamRoom"><i class="fad fa-folder-plus"></i>
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
                            <th>ชื่อห้อง</th>
                            <th>แถว</th>
                            <th>จำนวนที่นั่ง</th>
                            <th>คณะ</th>
                            <th>อาคาร</th>
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

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="exam_room_Form" name="exam_room_Form" class="form-horizontal">
                        <input type="hidden" name="exam_room_id" id="exam_room_id">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อห้อง</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="room_name" name="room_name"
                                            placeholder="ระบุชื่อห้อง" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">แถว</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="row" name="row"
                                            placeholder="ระบุแถว" value="" required="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">จำนวนที่นั่ง</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="amount_seat" name="amount_seat"
                                            placeholder="ระบุจำนวนที่นั่ง" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

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
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">อาคาร</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="building" name="building"
                                            placeholder="ระบุอาคาร" value="" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">สถานะ</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" name="status" id="status">
                                            <option value="">เลือก</option>
                                            <option value="Open">เปิด</option>
                                            <option value="Close">ปิด</option>
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
                ajax: "{{ route('admin.exam_rooms.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'room_name',
                        name: 'room_name'
                    },
                    {
                        data: 'row',
                        name: 'row'
                    },
                    {
                        data: 'amount_seat',
                        name: 'amount_seat'
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
                        data: 'building',
                        name: 'building'
                    },
                    {
                        data: 'status', 'render': function (data) {
                            if(data === 'Open'){
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
            $('#createExamRoom').click(function() {
                $('#saveBtn').val("บันทึก");
                $('#exam_room_id').val('');
                $('#exam_room_Form').trigger("reset");
                $('#modelHeading').html("เพิ่ม");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editExamRoom', function() {
                var exam_room_id = $(this).data('id');
                $.get("{{ route('admin.exam_rooms.index') }}" + '/' + exam_room_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("แก้ไข");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#exam_room_id').val(data.id);
                    $('#room_name').val(data.room_name);
                    $('#row').val(data.row);
                    $('#amount_seat').val(data.amount_seat);
                    $('#faculty').val(data.faculty);
                    $('#building').val(data.building);
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
                    data: $('#exam_room_Form').serialize(),
                    url: "{{ route('admin.exam_rooms.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#exam_room_Form').trigger("reset");
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
            $('body').on('click', '.deleteExamRoom', function() {

                var exam_room_id = $(this).data("id");
                confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.exam_rooms.store') }}" + '/' + exam_room_id,
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
