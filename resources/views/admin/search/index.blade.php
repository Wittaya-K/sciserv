@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
            </div>
        </div>
    </div>

    <form id="SearchForm" name="SearchForm" action="" method="GET">
        @csrf
        <div class="card shadow-lg">
            <div class="card-header">
                <i class="fad fa-file-chart-line"></i> ค้นหารายการปฏิบัติงาน
            </div>

            <div class="card-body">
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">วันที่</label>
                            <div class="col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fad fa-chevron-square-down"></i></span>
                                    </div>
                                    <select class="form-control" name="schedule_from" id="schedule_from" title="">
                                        <option value="">เลือก</option>
                                        @foreach ($schedules as $Schedule)
                                            <option value="{{ $Schedule->schedule_from }}">{{ $Schedule->schedule_from }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">บุคลากร</label>
                            <div class="col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fad fa-clock"></i></span>
                                    </div>
                                    <select class="form-control" name="staff" id="staff" title="" >
                                        <option value="">เลือก</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->username }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">หลักสูตร</label>
                            <div class="col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fad fa-clock"></i></span>
                                    </div>
                                    <select class="form-control" name="field_of_study" id="field_of_study" title="" >
                                        <option value="">เลือก</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->department_name }}">{{ $department->department_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">ภาระงาน</label>
                            <div class="col-sm-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fad fa-clock"></i></span>
                                    </div>
                                    <select class="form-control" name="job" id="job" title="">
                                        <option value="">เลือก</option>
                                        @foreach ($serviceRequests as $serviceRequest)
                                            <option value="{{ $serviceRequest->id }}">{{ $serviceRequest->service_request_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">

                    </div>
                </div>
            </div>
        </div>
    </form>

        <div class="card shadow-lg">
            <div class="card-header">
                <i class="fad fa-th-list"></i> รายการ
            </div>
    
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover datatable">
                        <thead class="text-center">
                            <tr width="10">
                                <th>วันที่</th>
                                <th>บุคลากร</th>
                                <th>หลักสูตร</th>
                                <th>ภาระงาน</th>
                            </tr>
                        </thead>
                        <tbody class="text-center" id="tbody_datatable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@endsection
@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#schedule_from').change(function() {
                var schedule_from = $('#schedule_from').val();

                $.ajax({
                    data: {
                        schedule_from: schedule_from,
                    },
                    url: "{{ route('admin.search.search') }}",
                    type: "GET",
                    dataType: 'json',
                    success: function(data, textStatus, XmlHttpRequest) {
                        if (XmlHttpRequest.status === 200) {
                            let htmlView = '';
                            if (data.length <= 0) {
                                htmlView += ``;
                            }
                            $.each(data, function(i, value) {
                                    @foreach ($users as $user)
                                        if (value.user_service_required == "{{ $user->username }}") {
                                            htmlView += `
                                            <tr width="10">
                                                <td class="text-center">` + value.schedule_from + `</td>
                                                <td class="text-center">` + '{{ $user->name }}' + `</td>
                                                <td class="text-center">` + value.department + `</td>
                                                <td class="text-center">` + value.title + `</td>
                                            </tr>`;
                                        }
                                    @endforeach
                                    // htmlView += `
                                    // <tr width="10">
                                    //     <td class="text-center">` + value.schedule_from + `</td>
                                    //     <td class="text-center">` + value.user_service_required + `</td>
                                    //     <td class="text-center">` + value.department + `</td>
                                    //     <td class="text-center">` + value.title + `</td>
                                    // </tr>`;
                            });
                            $('#tbody_datatable').html(htmlView);
                        }
                    },
                    error: function(data) {

                    }
                });
            });

            $('#staff').change(function() {
                var staff = $('#staff').val();

                $.ajax({
                    data: {
                        staff: staff,
                    },
                    url: "{{ route('admin.search.search') }}",
                    type: "GET",
                    dataType: 'json',
                    success: function(data, textStatus, XmlHttpRequest) {
                        if (XmlHttpRequest.status === 200) {
                            let htmlView = '';
                            if (data.length <= 0) {
                                htmlView += ``;
                            }
                            $.each(data, function(i, value) {
                                    @foreach ($users as $user)
                                        if (value.user_service_required == "{{ $user->username }}") {
                                            htmlView += `
                                            <tr width="10">
                                                <td class="text-center">` + value.schedule_from + `</td>
                                                <td class="text-center">` + '{{ $user->name }}' + `</td>
                                                <td class="text-center">` + value.department + `</td>
                                                <td class="text-center">` + value.title + `</td>
                                            </tr>`;
                                        }
                                    @endforeach
                                    // htmlView += `
                                    // <tr width="10">
                                    //     <td class="text-center">` + value.schedule_from + `</td>
                                    //     <td class="text-center">` + value.user_service_required + `</td>
                                    //     <td class="text-center">` + value.department + `</td>
                                    //     <td class="text-center">` + value.title + `</td>
                                    // </tr>`;
                            });
                            $('#tbody_datatable').html(htmlView);
                        }
                    },
                    error: function(data) {

                    }
                });
            });

            $('#field_of_study').change(function() {
                var field_of_study = $('#field_of_study').val();

                $.ajax({
                    data: {
                        field_of_study: field_of_study,
                    },
                    url: "{{ route('admin.search.search') }}",
                    type: "GET",
                    dataType: 'json',
                    success: function(data, textStatus, XmlHttpRequest) {
                        if (XmlHttpRequest.status === 200) {
                            let htmlView = '';
                            if (data.length <= 0) {
                                htmlView += ``;
                            }
                            $.each(data, function(i, value) {
                                    @foreach ($users as $user)
                                        if (value.user_service_required == "{{ $user->username }}") {
                                            htmlView += `
                                            <tr width="10">
                                                <td class="text-center">` + value.schedule_from + `</td>
                                                <td class="text-center">` + '{{ $user->name }}' + `</td>
                                                <td class="text-center">` + value.department + `</td>
                                                <td class="text-center">` + value.title + `</td>
                                            </tr>`;
                                        }
                                    @endforeach
                                    // htmlView += `
                                    // <tr width="10">
                                    //     <td class="text-center">` + value.schedule_from + `</td>
                                    //     <td class="text-center">` + value.user_service_required + `</td>
                                    //     <td class="text-center">` + value.department + `</td>
                                    //     <td class="text-center">` + value.title + `</td>
                                    // </tr>`;
                            });
                            $('#tbody_datatable').html(htmlView);
                        }
                    },
                    error: function(data) {

                    }
                });
            });

            $('#job').change(function() {
                var job = $('#job').val();

                $.ajax({
                    data: {
                        job: job,
                    },
                    url: "{{ route('admin.search.search') }}",
                    type: "GET",
                    dataType: 'json',
                    success: function(data, textStatus, XmlHttpRequest) {
                        if (XmlHttpRequest.status === 200) {
                            let htmlView = '';
                            if (data.length <= 0) {
                                htmlView += ``;
                            }
                            $.each(data, function(i, value) {
                                    @foreach ($users as $user)
                                        if (value.user_service_required == "{{ $user->username }}") {
                                            htmlView += `
                                            <tr width="10">
                                                <td class="text-center">` + value.schedule_from + `</td>
                                                <td class="text-center">` + '{{ $user->name }}' + `</td>
                                                <td class="text-center">` + value.department + `</td>
                                                <td class="text-center">` + value.title + `</td>
                                            </tr>`;
                                        }
                                    @endforeach
                                    // htmlView += `
                                    // <tr width="10">
                                    //     <td class="text-center">` + value.schedule_from + `</td>
                                    //     <td class="text-center">` + value.user_service_required + `</td>
                                    //     <td class="text-center">` + value.department + `</td>
                                    //     <td class="text-center">` + value.title + `</td>
                                    // </tr>`;
                            });
                            $('#tbody_datatable').html(htmlView);
                        }
                    },
                    error: function(data) {

                    }
                });
            });
        });
    </script>
@endsection
