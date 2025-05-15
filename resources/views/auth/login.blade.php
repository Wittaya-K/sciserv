@extends('layouts.app')
@section('content')
    <style>
        .login,
        .image {
            min-height: 100vh;
        }

        .bg-image {
            /*background-image: url('https://bootstrapious.com/i/snippets/sn-page-split/bg.jpg');*/
            background-image: url(/image/login.jpg);
            background-size: cover;
            background-position: center center;
        }
        #lblcustomeCheck1 {
            padding-left: 20px;
        }
    </style>

    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="col-md-8 d-none d-md-flex bg-image"></div>
            <div class="col-md-4 bg-light">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-10 col-xl-7 mx-auto">
                                <h4 class="display-5 text-center">ระบบแจ้งขอใช้บริการ</h4>
                                <p class="text-muted mb-4 text-center">กรุณาลงชื่อเพื่อใช้งานระบบ</p>
                            @if (\Session::has('message'))
                                <p class="alert alert-info">
                                    {{ \Session::get('message') }}
                                </p>
                            @endif
                                <form action="{{ route('login') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-group mb-3">
                                        <input type="text" placeholder="PSU Passport Account Name" name="username"
                                            autofocus="" class="form-control rounded-pill border-0 shadow-sm px-4 @error('username') is-invalid @enderror">
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="password" placeholder="Password" name="password"
                                            class="form-control rounded-pill border-0 shadow-sm px-4 text-primary @error('password') is-invalid @enderror">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary btn-block text-uppercase mb-2 rounded-pill shadow-sm"><i class="fad fa-sign-in"></i> {{ trans('global.login') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
