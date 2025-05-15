@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="container-fluid">

                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">แดชบอร์ด</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">แดชบอร์ด</a></li>
                                    <li class="breadcrumb-item active">ปฏิทินปฏิบัติงาน</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>

                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $all_of_jobs }}</h3>
                                <p>งานทั้งหมด</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-list"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $today_jobs }}</h3>
                                <p>งานประจำวันนี้</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-time"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $coming_jobs }}</h3>
                                <p>งานที่กำลังจะมาถึง</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-calendar"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3>{{ $tbl_users }}</h3>
                                <p>ผู้ใช้งานทั้งหมด</p>
                            </div>
                            <div class="icon">
                                <i class="fad fa-user"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

                <div class="row">

                </div>

                <div class="row">
                    <div class="container-fluid">
                        <section class="content">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-primary">
                                            <div class="card-body p-0">
                                                <div id="external-events"></div>
                                                <div id="calendar"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_schedule_form" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"> <i class="fad fa-file-alt"></i> รายละเอียด</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fad fa-window-close"
                                style="--fa-primary-color: #bd0000; --fa-secondary-color: #bd0000;"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" class="needs-validation" id="schedule_form" action=""
                        enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="id" id="id" />
                        <div class="row">
                            <div class="col-lg-6 col-12" hidden>
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">หมวดหมู่</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-chevron-square-down"></i></span>
                                        </div>
                                        <select name="category" id="category" class="form-control form-control" disabled
                                            required>
                                            <option value="">เลือก</option>
                                            @foreach ($db_category as $db_category_item)
                                                <option value="{{ $db_category_item->name }}" selected>
                                                    {{ $db_category_item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ชื่อเรื่อง</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-heading"></i></span>
                                        </div>
                                        <input type="text" name="title" id="title"
                                            class="form-control form-control" disabled required placeholder="" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">รายละเอียดงาน</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-text"></i></span>
                                        </div>
                                        <textarea type="textarea" name="description" id="description" class="form-control form-control" disabled required
                                            placeholder=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ไฟล์</label>
                                    <ul>
                                        <li><a id="download" href="#"><i class="fad fa-paperclip"></i>
                                                คลิกเพื่อดู</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">งานบริการที่ร้องขอ</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 100%">
                                            <span class="input-group-text"><i class="fad fa-share-alt"></i></span>
                                            <select name="service" id="service" class="form-control form-control"
                                                disabled required>
                                                <option value="">เลือก</option>
                                                @foreach ($db_service_request as $db_service_request_item)
                                                    <option value="{{ $db_service_request_item->id }}">
                                                        {{ $db_service_request_item->service_request_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">หน่วยงานที่เกี่ยวข้อง</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="width: 100%">
                                            <span class="input-group-text"><i class="fad fa-users"></i></span>
                                            <select name="department" id="department"
                                                class="form-control form-control"disabled required>
                                                <option value="">เลือก</option>
                                                @foreach ($db_department as $db_department_item)
                                                    <option value="{{ $db_department_item->department_name }}">
                                                        {{ $db_department_item->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
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
                                        <input type="text" name="schedule_from" id="schedule_from"
                                            class="form-control form-control" disabled required placeholder="" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ถึงวันที่</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" name="schedule_to" id="schedule_to"
                                            class="form-control form-control" disabled required placeholder="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label class="col-sm-12 control-label">ผู้ใช้บริการ</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fad fa-user"></i></span>
                                        </div>
                                        <input type="text" value="{{ Auth()->user()->name }}"
                                            class="form-control form-control" disabled required placeholder="" />
                                        <input type="hidden" name="user_service_required" id="user_service_required"
                                            value="{{ Auth()->user()->username }}" class="form-control form-control"
                                            required placeholder="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <!-- Page specific script -->
    <script>
        var events = []
        const baseDownloadUrl = "{{ route('admin.schedule.download') }}";
        $(function() {

            /* initialize the external events
             -----------------------------------------------------------------*/
            function ini_events(ele) {
                ele.each(function() {

                    // create an Event Object (https://fullcalendar.io/docs/event-object)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    }

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject)

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0 //  original position after the drag
                    })

                })
            }

            ini_events($('#external-events div.external-event'))

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;

            var containerEl = document.getElementById('external-events');
            var checkbox = document.getElementById('drop-remove');
            var calendarEl = document.getElementById('calendar');

            // initialize the external events
            // -----------------------------------------------------------------

            new Draggable(containerEl, {
                itemSelector: '.external-event',
                eventData: function(eventEl) {
                    return {
                        title: eventEl.innerText,
                        backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue(
                            'background-color'),
                        borderColor: window.getComputedStyle(eventEl, null).getPropertyValue(
                            'background-color'),
                        textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
                    };
                }
            });

            function formatDate(date) { //แปลงวันที่
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }

            // console.log(formatDate('2023-06-23 16:00:00'));

            let today = new Date().toISOString().slice(0, 10) //วันที่ปัจจุบัน
            // console.log(today)
            let Color;
            @foreach ($schedule as $schedule_item)
                if (formatDate("{{ $schedule_item->schedule_from }}") < today) {
                    Color = '#CB4335';
                } else {
                    Color = '#28a745';
                }
                // wittaya.kh
                @if ($schedule_item->user_service_required == 'wittaya.kh')
                    if (formatDate("{{ $schedule_item->schedule_from }}") < today) {
                        Color = '#CB4335';
                    } else {
                        Color = '#27ae60';
                    }
                @endif
                // sawalee.l
                @if ($schedule_item->user_service_required == 'sawalee.l')
                    if (formatDate("{{ $schedule_item->schedule_from }}") < today) {
                        Color = '#CB4335';
                    } else {
                        Color = '#f1c40f';
                    }
                @endif
                // nuengruethai.i
                @if ($schedule_item->user_service_required == 'nuengruethai.i')
                    if (formatDate("{{ $schedule_item->schedule_from }}") < today) {
                        Color = '#CB4335';
                    } else {
                        Color = '#f1548d';
                    }
                @endif
                // nuengruethai.i
                // @if ($schedule_item->user_service_required == 'nuengruethai.i')
                //     if (formatDate("{{ $schedule_item->schedule_from }}") < today) {
                //         Color = '#CB4335';
                //     } else {
                //         Color = '#dc7633';
                //     }
                // @endif

                var event_item = {
                    id: "{{ $schedule_item->id }}",
                    title: "{{ $schedule_item->title }}",
                    start: "{{ $schedule_item->schedule_from }}",
                    end: "{{ $schedule_item->schedule_to }}",
                    backgroundColor: Color,
                    borderColor: Color,
                    allDay: true,
                }
                events.push(event_item)
            @endforeach
            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                //Random default events
                // events: [
                //   {
                //     title          : 'All Day Event',
                //     start          : new Date(y, m, 1),
                //     backgroundColor: '#28a745', //red
                //     borderColor    : '#28a745', //red
                //     allDay         : true
                //   },
                // ],
                events: events,
                editable: true,
                droppable: false, // this allows things to be dropped onto the calendar !!!
                locale: 'th',
                drop: function(info) {
                    // is the "remove after drop" checkbox checked?
                    if (checkbox.checked) {
                        // if so, remove the element from the "Draggable Events" list
                        info.draggedEl.parentNode.removeChild(info.draggedEl);
                    }
                },
                aspectRatio: 2,
                showNonCurrentDates: false, // แสดงที่ของเดือนอื่นหรือไม่
                displayEventTime: false, //ซ่อน Start-Time
                height: 'auto',
                eventClick: function(info) {
                    var id = info.event.id
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.schedule.find') }}/" + id,
                        data: {},
                        dataType: 'json',
                        beforeSend: function() {},
                        success: function(response) {
                            // console.log(response);
                            if (response.status == true) {
                                // Split file names into an array
                                let fileNames = response.data.file.split(",");

                                // You can now iterate over fileNames if needed
                                let fileLinksHtml = '';
                                fileNames.forEach(function(fileName) {
                                    fileLinksHtml += `<li><a href="${baseDownloadUrl}/${fileName.trim()}" target="_blank">${fileName.trim()}</a> <i class="fad fa-paperclip"></i></li>`;
                                });

                                $('#id').val(response.data.id);
                                $('#category').val(response.data.category);
                                $('#title').val(response.data.title);
                                $('#description').val(response.data.description);
                                $('#file').val(response.data.file);
                                $('#download').html(fileLinksHtml); // Display links for each file
                                $('#department').val(response.data.department);
                                $('#service').val(response.data.service);
                                $('#schedule_from').val(response.data.schedule_from);
                                $('#schedule_to').val(response.data.schedule_to);
                                $('#modal_schedule_form').modal('show');
                            } else {
                                console.log(response);
                            }
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                },
            });
            //รีเฟรชหน้าเพื่อรับลิงค์ไฟล์เอกสารใหม่
            $('#ajaxModel').on('hidden.bs.modal', function() {
                location.reload();
            });

            // เมื่อฟอร์มการเรียกใช้ evnet submit ข้อมูล
            $("#calendar_Form").on("submit", function(e) {
                e.preventDefault(); // ปิดการใช้งาน submit ปกติ เพื่อใช้งานผ่าน ajax

                // เตรียมข้อมูล form สำหรับส่งด้วย  FormData Object
                var formData = new FormData($(this)[0]);

                // ส่งค่าแบบ POST ไปยังไฟล์ show_data.php รูปแบบ ajax แบบเต็ม
            });

            calendar.render();
            // $('#calendar').fullCalendar()
        })
    </script>
@endsection
