@extends('layouts.admin')
@section('content')
<style>
    table {
        border-collapse: collapse;
    }
    td {
        border: 1px solid black;
        padding: 10px;
    }
</style>
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h3>ข้อมูลที่นั่งสอบ</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">แดชบอร์ด</a></li>
                    <li class="breadcrumb-item active">ข้อมูลที่นั่งสอบ</li>
                </ol>
            </div>
        </div>
    </div>
    @can('exam_data_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="javascript:void(0)" id="createExamSeat"><i class="fad fa-folder-plus"></i>
                    เพิ่มข้อมูล</a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            รายการ
        </div>

        <div class="card-body">
            <!-- Tabs navs -->
            {{-- <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="ex1-tab-1" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab"
                        aria-controls="ex1-tabs-1" aria-selected="true">Tab 1</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex1-tab-2" data-mdb-toggle="tab" href="#ex1-tabs-2" role="tab"
                        aria-controls="ex1-tabs-2" aria-selected="false">Tab 2</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="ex1-tab-3" data-mdb-toggle="tab" href="#ex1-tabs-3" role="tab"
                        aria-controls="ex1-tabs-3" aria-selected="false">Tab 3</a>
                </li>
            </ul> --}}
            <!-- Tabs navs -->

            <!-- Tabs content -->
            {{-- <div class="tab-content" id="ex1-content">
                <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1"> --}}
                    <?php
                    // Define the number of students for each subject
                    $subject1_total_students = 10;
                    $subject2_total_students = 10;
                    $subject3_total_students = 10;
                    
                    // Define the total number of seats in the room
                    $total_seats = 30;
                    
                    // Check if the total number of students for all subjects is less than or equal to the total number of seats
                    if (($subject1_total_students + $subject2_total_students + $subject3_total_students) > $total_seats) {
                        echo "Error: Total number of students exceeds room capacity";
                        exit;
                    }
                    
                    // Create an array to hold the seating arrangement for each subject
                    $seating_arrangement = array(
                        'Subject 1' => array(),
                        'Subject 2' => array(),
                        'Subject 3' => array()
                    );
                    
                    // Calculate the number of seats for each subject based on the room capacity
                    $subject1_seats = round(($subject1_total_students / ($subject1_total_students + $subject2_total_students + $subject3_total_students)) * $total_seats);
                    $subject2_seats = round(($subject2_total_students / ($subject1_total_students + $subject2_total_students + $subject3_total_students)) * $total_seats);
                    $subject3_seats = $total_seats - $subject1_seats - $subject2_seats;
                    
                    // Create the seating arrangement for each subject
                    for ($i = 1; $i <= $subject1_total_students; $i++) {
                        $seating_arrangement['Subject 1'][] = "Seat " . 'A'.$i;
                    }
                    for ($i = 1; $i <= $subject2_total_students; $i++) {
                        $seating_arrangement['Subject 2'][] = "Seat " . 'B'.$i;
                    }
                    for ($i = 1; $i <= $subject3_total_students; $i++) {
                        $seating_arrangement['Subject 3'][] = "Seat " . 'C'.$i;
                    }
                    
                    // Shuffle the seating arrangement for each subject
                    shuffle($seating_arrangement['Subject 1']);
                    shuffle($seating_arrangement['Subject 2']);
                    shuffle($seating_arrangement['Subject 3']);
                    
                    // Display the seating arrangement for each subject
                    // echo "<h1>Exam Seating Arrangement</h1>";
                    // echo "<h2>Subject 1 ({$subject1_seats} seats)</h2>";
                    // echo "<ul>";
                    // foreach ($seating_arrangement['Subject 1'] as $seat) {
                    //     echo "<li>" . $seat . "</li>";
                    // }
                    // echo "</ul>";
                    
                    // echo "<h2>Subject 2 ({$subject2_seats} seats)</h2>";
                    // echo "<ul>";
                    // foreach ($seating_arrangement['Subject 2'] as $seat) {
                    //     echo "<li>" . $seat . "</li>";
                    // }
                    // echo "</ul>";
                    
                    // echo "<h2>Subject 3 ({$subject3_seats} seats)</h2>";
                    // echo "<ul>";
                    // foreach ($seating_arrangement['Subject 3'] as $seat) {
                    //     echo "<li>" . $seat . "</li>";
                    // }
                    // echo "</ul>";

                    echo '<table width="100%" border="1">';
                    for($i=1; $i<=13; $i++)
                    {
                        $y=10;
                        $y*=($i-1);
                        echo '<tr>';
                            for ($x=1; $x <=20; $x++) {
                                if ($i==1) {
                                    echo '<td>'.$x.'</td>';
                                }else{
                                    $y+=$x;
                                    echo '<td>'.$y.'</td>';
                                    if ($y==10) {
                                        break;
                                    }
                                    $y-=$x;
                                }

                            }
                        echo '</tr>';
                    }
                    echo '</table>';
                    ?>
                    
                {{-- </div>
                <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                    Tab 2 content
                </div>
                <div class="tab-pane fade" id="ex1-tabs-3" role="tabpanel" aria-labelledby="ex1-tab-3">
                    Tab 3 content
                </div>
            </div> --}}
            <!-- Tabs content -->
            {{-- <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable">
                    <thead>
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
            </div> --}}
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
                                        <input type="text" class="form-control" id="faculty" name="faculty"
                                            placeholder="ระบุคณะ" value="" required="">
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
                        name: 'faculty'
                    },
                    {
                        data: 'building',
                        name: 'building'
                    },
                    {
                        data: 'status',
                        'render': function(data) {
                            return ((data === 'Open') ? 'เปิด' : 'ปิด')
                        }
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
            $('#createExamSeat').click(function() {
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
            $('body').on('click', '.editExamSeat', function() {
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
            $('body').on('click', '.deleteExamSeat', function() {

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
