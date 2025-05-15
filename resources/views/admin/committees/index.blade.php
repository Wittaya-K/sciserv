@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h3>กรรมการคุมสอบ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">แดชบอร์ด</a></li>
                    <li class="breadcrumb-item active">กรรมการคุมสอบ</li>
                </ol>
            </div>
        </div>
    </div>
    @can('exam_data_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createCommittees"><i class="fad fa-folder-plus"></i>
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
                            <th>รหัส</th>
                            <th>ชื่อ</th>
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
                    <form id="committee_Form" name="committee_Form" class="form-horizontal">
                        <input type="hidden" name="committee_id" id="committee_id">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">รหัส</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="committee_no" name="committee_no"
                                            placeholder="ระบุรหัส" value="" maxlength="50" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อ</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" id="committee_name" name="committee_name"
                                            placeholder="ระบุชื่อ" value="" required="">
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
                ajax: "{{ route('admin.committees.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'committee_no',
                        name: 'committee_no'
                    },
                    {
                        data: 'committee_name',
                        name: 'committee_name'
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
            $('#createCommittees').click(function() {
                $('#saveBtn').val("บันทึก");
                $('#committee_id').val('');
                $('#committee_Form').trigger("reset");
                $('#modelHeading').html("เพิ่ม");
                $('#ajaxModel').modal('show');
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editCommittee', function() {
                var committee_id = $(this).data('id');
                $.get("{{ route('admin.committees.index') }}" + '/' + committee_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("แก้ไข");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#committee_id').val(data.id);
                    $('#committee_no').val(data.committee_no);
                    $('#committee_name').val(data.committee_name);
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
                    data: $('#committee_Form').serialize(),
                    url: "{{ route('admin.committees.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#committee_Form').trigger("reset");
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
            $('body').on('click', '.deleteCommittee', function() {

                var committee_id = $(this).data("id");
                confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.committees.store') }}" + '/' + committee_id,
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
