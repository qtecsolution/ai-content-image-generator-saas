@extends('layouts.app')
@section('title','Profile')
@section('breadcrumb')
    <li class="breadcrumb-item active"> Profile</li>
@endsection
@section('content')
    <div class="main-content p-2 p-md-4 pt-0">
        <div class="">

            <div class="col-md-12">
                <div class="my-projects">
                    <div class="my-projects-header border-bottom">
                        <h5 class="header-title text-capitalize"> Profile </h5>
                    </div>
                    <div class="my-projects-body">
                        <div class="row mt-3 g-2 ">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="p-2">
                                        @if ($user->avatar != '' && file_exists($user->avatar))
                                            <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}"
                                                style="max-width:150px" class="rounded">
                                        @else
                                            <img src="{{ asset('assets/images/placeholder.png') }}"
                                                alt="{{ $user->name }}" style="max-width:150px">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title"> {{ $user->name }} </h5>
                                    </div>
                                    <ul class="list-group list-group-flush info-list">
                                        <li class="list-group-item"> <b> Email: </b> {{ $user->email }} </li>
                                        <li class="list-group-item"> <b> Phone: </b> {{ $user->phone }} </li>
                                        <li class="list-group-item"> <b> Address: </b> {{ $user->address ?? '' }} </li>
                                        @if ($user->type == 'user')
                                            <li class="list-group-item"> <b> Plan: </b> {{ $user->plan->name ?? '' }}</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 border-none border-lg-start">
                                <form method="POST" action="{{ route('profile.update') }}"
                                    enctype="multipart/form-data" class="authentication-form needs-validation">
                                    @csrf

                                    <input type="hidden" name="id" value="{{ $user->id }}">

                                    <div class="authentication-form-body">

                                        <!-- Name   -->
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Name *</label>
                                            <input id="name" type="text"
                                                class="form-control custom-input @error('name') is-invalid @enderror"
                                                name="name" value="{{ $user->name }}" required
                                                placeholder="Enter your name" autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>

                                        <!-- Email    -->
                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">Email* </label>
                                            <input id="email" type="email" readonly
                                                class="form-control custom-input @error('email') is-invalid @enderror"
                                                name="email" value="{{ $user->email }}" required autocomplete="email"
                                                placeholder="Enter your Email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="phone" class="form-label">Phone* </label>
                                            <input id="phone" type="tel"
                                                class="form-control custom-input @error('phone') is-invalid @enderror"
                                                name="phone" value="{{ $user->phone }}" required
                                                placeholder="Enter your phone">

                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="address" class="form-label">Address </label>
                                            <input id="address" type="tel"
                                                class="form-control custom-input @error('address') is-invalid @enderror"
                                                name="address" value="{{ $user->address }}"
                                                placeholder="Enter your address">

                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="avatar" class="form-label"> New Avatar </label>
                                            <input id="avatar" type="file"
                                                class="form-control custom-input @error('avatar') is-invalid @enderror"
                                                name="avatar" value="{{ old('avatar') }}">

                                            @error('avatar')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="generate-btn-wrapper">
                                            <button type="submit" class="generate-btn">Update</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
