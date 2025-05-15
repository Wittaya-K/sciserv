@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row mb-0">
        <div class="col-sm-6">
            <h3>นำเข้าข้อมูล</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">แดชบอร์ด</a></li>
                <li class="breadcrumb-item active">นำเข้าข้อมูล</li>
            </ol>
        </div>
    </div>
</div>
    @can('import_excel_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        กรุณาเลือกไฟล์ก่อนอัพโหลด<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                <form method="post" enctype="multipart/form-data" action="{{ route('admin.import_excels.import') }}">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>ภาคการศึกษา</label>
                                <div class="input-group col-6">
                                    <select class="form-control" name="semester" id="semester">
                                        @foreach ($semesters as $semester)
                                            <option value="{{$semester->semester_name}}">{{$semester->semester}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="form-group">
                                <label>ช่วงการสอบ</label>
                                <div class="input-group col-6">
                                    <select class="form-control" name="period_term" id="period_term">
                                        @foreach ($period_terms as $period_term)
                                            <option value="{{$period_term->id}}">{{$period_term->term_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="select_file">เลือกไฟล์</label>
                        <div class="input-group col-4">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="select_file" id="select_file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                <label class="custom-file-label" for="select_file">เลือกไฟล์</label>
                            </div>
                            <div class="input-group-append">
                                {{-- <span class="input-group-text">Upload</span> --}}
                                <button type="submit" name="upload" class="btn btn-primary"><i class="fad fa-upload"></i> อัพโหลด</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="select_file">ข้อมูลจากการนำเข้า</label>
                        <div class="input-group col-4">
                            @foreach ($val_semesters as $val_semester)
                                @foreach ($val_period_terms as $val_period_term)
                                <h5 class="text-primary">ภาคการศึกษา {{$val_semester->semester_names}} สอบ {{$val_period_term->term_ids}}</h5>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                    {{-- <div class="form-group">
                        <table class="table">
                            <tr>
                                <td width="40%" align="right"><label>เลือกไฟล์</label></td>
                                <td width="30">
                                    <input type="file" name="select_file" class="form-control" />
                                </td>
                                <td width="30%" align="left">
                                    <input type="submit" name="upload" class="btn btn-primary" value="Upload">
                                    <button type="submit" name="upload" class="btn btn-primary"><i class="fad fa-upload"></i>
                                        อัพโหลด</button>
                                </td>
                            </tr>
                        </table>
                    </div> --}}
                </form>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            รายการ
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable">
                    <thead class="text-center">
                        <tr width="10">
                            <th>วันที่</th>
                            <th>เวลา</th>
                            <th>รหัส</th>
                            <th>ชื่อวิชา</th>
                            <th>ตอน</th>
                            <th>จำนวน</th>
                            <th>ห้องสอบ</th>
                            <th>กรรมการคุมสอบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $row)
                            <tr>
                                <td>{{ $row->date }}</td>
                                <td style="width: 83px;">{{ $row->time[0] }}{{ $row->time[1] }}:{{ $row->time[2] }}{{ $row->time[3] }}{{ $row->time[4] }}{{ $row->time[5] }}{{ $row->time[6] }}:{{ $row->time[7] }}{{ $row->time[8] }}</td>
                                <td>{{ $row->course_no }}</td>
                                <td style="width: 300px;">{{ $row->course_name }}</td>
                                <td>{{ $row->section }}</td>
                                <td>{{ $row->std_amout_import }}</td>
                                <td>{{ $row->room_no }}</td>
                                <td>{{ $row->committee_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.import_excels.massDestroy') }}",
                className: 'btn-danger',
                action: function(e, dt, node, config) {
                    var ids = $.map(dt.rows({
                        selected: true
                    }).nodes(), function(entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                                headers: {
                                    'x-csrf-token': _token
                                },
                                method: 'POST',
                                url: config.url,
                                data: {
                                    ids: ids,
                                    _method: 'DELETE'
                                }
                            })
                            .done(function() {
                                location.reload()
                            })
                    }
                }
            }
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

            $('.datatable:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
        })
    </script>
@endsection
