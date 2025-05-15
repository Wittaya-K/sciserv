@extends('layouts.admin')
@section('content')
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
@if (Session::get('success'))
    <script>
        swal("บันทึกสำเร็จ", "เพิ่มกำหนดการเรียบร้อยแล้ว", "success");
    </script>
@endif
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>งานตามกำหนดการ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">แดชบอร์ด</a></li>
                    <li class="breadcrumb-item active">งานตามกำหนดการ</li>
                </ol>
            </div>
        </div>
    </div>
</div>
    @can('schedule_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createNewSchedule"><i class="fad fa-folder-plus"></i>
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
                            <th>หมวดหมู่</th>
                            <th>ชื่อเรื่อง</th>
                            <th>รายละเอียดงาน</th>
                            <th>วันที่เริ่ม</th>
                            <th>วันที่สิ้นสุด</th>
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
                    <form id="schedule_Form" name="schedule_Form" class="form-horizontal"
                        enctype="multipart/form-data">
                        <input type="hidden" name="schedule_id" id="schedule_id">

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">หมวดหมู่</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-chevron-square-down"></i></span>
                                        </div>
                                        <select name="category_id" id="category_id" class="form-control">
                                                <option value="">กรุณาเลือกหมวดหมู่</option>
                                            @foreach ($categorys as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_category_id"></span></p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อเรื่อง</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-heading"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="title" name="title" title="กรุณาระบุชื่อเรื่อง" placeholder="กรุณาระบุชื่อเรื่อง">
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_title"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">รายละเอียดงาน</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-text"></i></span>
                                        </div>
                                        <textarea class="form-control" name="description" id="description" cols="30" rows="1" title="กรุณาระบุรายละเอียดงาน" placeholder="กรุณาระบุรายละเอียดงาน"></textarea>
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_description"></span></p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ไฟล์</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-file-alt"></i></span>
                                        </div>
                                        <input type="file" class="form-control" name="file[]" id="file" title="กรุณาเลือกไฟล์" multiple>
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_file"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">หน่วยงานที่เกี่ยวข้อง</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 100%">
                                            <span class="input-group-text"><i class="fad fa-users"></i></span>
                                            <select name="related_departments[]" id="related_departments" class="form-control select2" style="width: 100%" multiple>
                                                @forelse ($tbl_departments as $tbl_department)
                                                    <option value="{{$tbl_department->department_name}}" selected>{{$tbl_department->department_name}}</option>
                                                @empty
                                                    
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_related_departments"></span></p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">งานบริการที่ร้องขอ</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 100%">
                                            <span class="input-group-text"><i class="fad fa-share-alt"></i></span>
                                            <select name="service_requests[]" id="service_requests" class="form-control select2" style="width: 100%" multiple>
                                            </select>
                                        </div>
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_service_requests"></span></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">วันที่เริ่ม</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="schedule_from"
                                            placeholder="____-__-__ __:__" id="schedule_from">
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_schedule_from"></span></p>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">วันที่สิ้นสุด</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="schedule_to"
                                            placeholder="____-__-__ __:__" id="schedule_to">
                                    </div>
                                    <p class="help-block" style="color: red;"><span id="msg_schedule_to"></span></p>
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
        $.datetimepicker.setLocale('th');
        $('#schedule_from').datetimepicker({
            mask: '0000-00-00 00:00',
            format: 'Y-m-d H:i',
            formatTime: 'H:i',
            formatDate: 'Y-m-d',
            step: 30, //กำหนดค่านาทีของเวลา
            lang: 'th', //กำหนดค่าเป็นภาษาไทย
            minDate: '-1970/01/01' // yesterday is minimum date
        });

        $('#schedule_to').datetimepicker({
            mask: '0000-00-00 00:00',
            format: 'Y-m-d H:i',
            formatTime: 'H:i',
            formatDate: 'Y-m-d',
            step: 30, //กำหนดค่านาทีของเวลา
            lang: 'th', //กำหนดค่าเป็นภาษาไทย
            minDate: '-1970/01/01' // yesterday is minimum date
        });

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
                ajax: "{{ route('admin.schedules.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'category_id',
                        'render': function(data) {
                            @foreach ($category_names as $category_name)
                                if (data == '{{ $category_name->id }}') {
                                    return '{{ $category_name->name }}';
                                }
                            @endforeach
                        },
                        name: 'category_id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'schedule_from',
                        name: 'schedule_from'
                    },
                    {
                        data: 'schedule_to',
                        name: 'schedule_to'
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
            $('#createNewSchedule').click(function() {
                $('#saveBtn').val("บันทึก");
                $('#schedule_id').val('');
                $('#schedule_Form').trigger("reset");
                $('#modelHeading').html("เพิ่มข้อมูล");
                $('#ajaxModel').modal('show');
                
                $('#related_departments').select2({ //กำหนด placeholder ให้ select option
                    multiple: true,
                    placeholder: "เลือกหน่วยงานที่เกี่ยวข้อง"
                });
                // $('#related_departments').val(null).trigger("change");

                // var selectList = document.getElementById("related_departments"); //เพิ่มหน่วยงานที่เกี่ยวข้องใน select option
                //     @foreach ($tbl_departments as $tbl_department)
                //     var option = document.createElement("option");
                //         option.setAttribute("value", '{{$tbl_department->department_name}}');
                //         option.text = '{{$tbl_department->department_name}}';
                //         selectList.appendChild(option);
                //     @endforeach

                var selectList_service_requests = document.getElementById("service_requests"); //เพิ่มหน่วยงานที่เกี่ยวข้องใน select option
                    @foreach ($tbl_service_requests as $tbl_service_request)
                    var option_service_requests = document.createElement("option");
                        option_service_requests.setAttribute("value", '{{$tbl_service_request->service_request_name}}');
                        option_service_requests.text = '{{$tbl_service_request->service_request_name}}';
                        selectList_service_requests.appendChild(option_service_requests);
                    @endforeach

                $('#service_requests').select2({ //กำหนด placeholder ให้ select option
                    multiple: true,
                    placeholder: "เลือกงานบริการที่ร้องขอ"
                });
                $('#service_requests').val(null).trigger("change");
            });

            /*------------------------------------------
            --------------------------------------------
            Click to Edit Button
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.editSchedule', function() {
                var schedule_id = $(this).data('id');
                $.get("{{ route('admin.schedules.index') }}" + '/' + schedule_id + '/edit', function(
                    data) {
                    $('#modelHeading').html("แก้ไขข้อมูล");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#schedule_id').val(data.id);
                    $('#category_id').val(data.category_id);
                    $('#title').val(data.title);
                    $('#description').val(data.description);
                    $('#schedule_from').val(data.schedule_from);
                    $('#schedule_to').val(data.schedule_to);

                    $('#related_departments').select2({
                        multiple: true,
                        placeholder: "เลือกหน่วยงานที่เกี่ยวข้อง"
                    });
                    // set the value to null or empty string '', then trigger (change) event
                    // $('#related_departments').val(null).trigger("change");

                    $('#service_requests').select2({ //กำหนด placeholder ให้ select option
                        multiple: true,
                        placeholder: "เลือกงานบริการที่ร้องขอ"
                    });
                    $('#service_requests').val(null).trigger("change");

                    @foreach($tbl_schedules as $tbl_schedule)
                        if(data.id == '{{$tbl_schedule->id}}')
                        {
                            // var selectList_tbl_related_department = document.getElementById("related_departments");
                            //     @foreach ($tbl_related_departments as $tbl_related_department)
                            //         @foreach ($tbl_departments as $tbl_department)
                            //             var option_tbl_related_department = document.createElement("option");
                            //                 option_tbl_related_department.setAttribute("value", "{{$tbl_department->department_name}}");
                            //             if("{{$tbl_related_department->id_related_departments}}" == "{{$tbl_schedule->id}}" && "{{$tbl_related_department->related_departments}}" == "{{$tbl_department->department_name}}")
                            //             {
                            //                 option_tbl_related_department.setAttribute("selected", "");
                            //             }
                            //                 option_tbl_related_department.text = "{{$tbl_department->department_name}}";
                            //                 selectList_tbl_related_department.appendChild(option_tbl_related_department);
                            //         @endforeach
                            //     @endforeach

                            var selectList_tbl_related_service_requests = document.getElementById("service_requests");
                                @foreach ($tbl_service_requests as $tbl_service_request)
                                    var option_tbl_related_service_requests = document.createElement("option");
                                        option_tbl_related_service_requests.setAttribute("value", "{{$tbl_service_request->service_request_name}}");
                                    @foreach ($tbl_related_service_requests as $tbl_related_service_request)
                                        if("{{$tbl_related_service_request->id_related_service_requests}}" == "{{$tbl_schedule->id}}" && "{{$tbl_related_service_request->related_service_requests}}" == "{{$tbl_service_request->service_request_name}}")
                                        {
                                            option_tbl_related_service_requests.setAttribute("selected", "");
                                        }
                                    @endforeach
                                            option_tbl_related_service_requests.text = "{{$tbl_service_request->service_request_name}}";
                                            selectList_tbl_related_service_requests.appendChild(option_tbl_related_service_requests);
                                @endforeach
                        }
                    @endforeach
                })
            });

            //รีเฟรชหน้าเพื่อรับลิงค์ไฟล์เอกสารใหม่
            $('#ajaxModel').on('hidden.bs.modal', function () {
                $("#related_departments").load(location.href + " #related_departments");
            });
            /*------------------------------------------
            --------------------------------------------
            Create Course Code
            --------------------------------------------
            --------------------------------------------*/
            // $('#saveBtn').click(function(e) {
            //     e.preventDefault();
            //     $(this).html('ส่ง..');

            //     $.ajax({
            //         data: $('#schedule_Form').serialize(),
            //         url: "{{ route('admin.schedules.store') }}",
            //         type: "POST",
            //         dataType: 'json',
            //         success: function(data) {

            //             $('#schedule_Form').trigger("reset");
            //             $('#ajaxModel').modal('hide');
            //             table.draw();

            //         },
            //         error: function(data) {
            //             console.log('Error:', data);
            //             $('#saveBtn').html('บันทึก');
            //         }
            //     });
            // });

            // เมื่อฟอร์มการเรียกใช้ evnet submit ข้อมูล        
            $("#schedule_Form").on("submit", function(e) {
                e.preventDefault(); // ปิดการใช้งาน submit ปกติ เพื่อใช้งานผ่าน ajax

                if($('#category_id option:selected').val() == ''){
                    $("#category_id").focus();
                    document.getElementById("msg_category_id").innerHTML  = "กรุณาเลือกหมวดหมู่";
                    return false;
                }
                else{
                    document.getElementById("msg_category_id").innerHTML  = "";
                }

                if($('#title').val() == ''){
                    $("#title").focus();
                    document.getElementById("msg_title").innerHTML  = "กรุณาระบุชื่อเรื่อง";
                    return false;
                }
                else{
                    document.getElementById("msg_title").innerHTML  = "";
                }

                if($('#description').val() == ''){
                    $("#description").focus();
                    document.getElementById("msg_description").innerHTML  = "กรุณาระบุรายละเอียดงาน";
                    return false;
                }
                else{
                    document.getElementById("msg_description").innerHTML  = "";
                }

                if($('#related_departments').val() == ''){
                    $("#related_departments").focus();
                    document.getElementById("msg_related_departments").innerHTML  = "กรุณาเลือกหน่วยงานที่เกี่ยวข้อง";
                    return false;
                }
                else{
                    document.getElementById("msg_related_departments").innerHTML  = "";
                }

                if($('#service_requests').val() == ''){
                    $("#service_requests").focus();
                    document.getElementById("msg_service_requests").innerHTML  = "กรุณาเลือกงานบริการที่ร้องขอ";
                    return false;
                }
                else{
                    document.getElementById("msg_service_requests").innerHTML  = "";
                }

                if($('#schedule_from').val() == ''){
                    $("#schedule_from").focus();
                    document.getElementById("msg_schedule_from").innerHTML  = "กรุณาระบุวันที่เริ่มต้น";
                    return false;
                }
                else{
                    document.getElementById("msg_schedule_from").innerHTML  = "";
                }

                if($('#schedule_to').val() == ''){
                    $("#schedule_to").focus();
                    document.getElementById("msg_schedule_to").innerHTML  = "กรุณาระบุวันที่สิ้นสุด";
                    return false;
                }
                else{
                    document.getElementById("msg_schedule_to").innerHTML  = "";
                }

                // เตรียมข้อมูล form สำหรับส่งด้วย  FormData Object
                var formData = new FormData($(this)[0]);

                // ส่งค่าแบบ POST ไปยังไฟล์ show_data.php รูปแบบ ajax แบบเต็ม
                $.ajax({
                        url: "{{ route('admin.schedules.store') }}",
                        type: 'POST',
                        data: formData,
                        /*async: false,*/
                        cache: false,
                        contentType: false,
                        processData: false
                    })
                    .done(function(data) {
                        $('#schedule_Form').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        // table.draw();
                        location.reload();
                        //console.log(data); 
                        // ทดสอบแสดงค่า  ดูผ่านหน้า console
                        /*              การใช้งาน console log เพื่อ debug javascript ใน chrome firefox และ ie 
                                        http://www.ninenik.com/content.php?arti_id=692 via @ninenik         */
                    });

            });

            /*------------------------------------------
            --------------------------------------------
            Delete Course Code
            --------------------------------------------
            --------------------------------------------*/
            $('body').on('click', '.deleteSchedule', function() {

                var schedule_id = $(this).data("id");
                // confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !");
                if(confirm("คุณแน่ใจหรือไม่ว่าต้องการลบ !") == true){
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('admin.schedules.store') }}" + '/' + schedule_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                }
            });

        });
    </script>
@endsection
