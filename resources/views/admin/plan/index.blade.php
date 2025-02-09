@extends('layouts.app')
@section('title', 'All Plans')
@section('breadcrumb')
    <li class="breadcrumb-item active">All Plans</li>
@endsection
@section('content')
    <div class="main-content p-2 p-md-4 pt-0">
        <div class="row g-4">

            <div class="col-md-12">
                <div class="my-projects">
                    <div class="my-projects-header border-bottom mb-3">
                        <h5 class="header-title">All Plans</h5>
                        <div class="project-button pull-right">

                            <a href="{{ route('plan.create') }}" class="seeall-btn d-flex">
                                <span class="icon">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_532_27281)">
                                            <path
                                                d="M7.99967 14.6666C11.6816 14.6666 14.6663 11.6818 14.6663 7.99992C14.6663 4.31802 11.6816 1.33325 7.99967 1.33325C4.31778 1.33325 1.33301 4.31802 1.33301 7.99992C1.33301 11.6818 4.31778 14.6666 7.99967 14.6666Z"
                                                stroke="#1D2939" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M8 5.33325V10.6666" stroke="#1D2939" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M5.33301 8H10.6663" stroke="#1D2939" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_532_27281">
                                                <rect width="16" height="16" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </span>
                                <span class="mt-1">Create Plan</span>
                            </a>
                        </div>
                    </div>
                    <div class="my-projects-body">
                        <div class="pricing-body">

                            <div class="pricing-cards">
                                <!-- single  card free  -->
                                @foreach ($plans as $item)
                                    <div class="pricing-card">

                                        <div class="pricing-card-header">
                                            <span class="name">{{ $item->name }}</span>
                                            <span class="price">
                                                <span class="currency">{{ readConfig('currency_symbol') }}</span>
                                                <span class="number">{{ $item->price }}</span>
                                                <span class="plane-time">/mo</span>
                                            </span>
                                            <small
                                                class="text-gray">{{ readConfig('currency_symbol') }}{{ $item->yearly_price }}/year</small>

                                        </div>

                                        <div class="pricing-card-body">
                                            <ul class="facility-list">
                                                <li>
                                                    <span class="icon-wrapper">
                                                        <img src="{{ asset('assets/images/icons/check.svg') }}"
                                                            alt="check icon ">
                                                    </span>
                                                    <span>{{ $item->word_count }} words per month</span>
                                                </li>
                                                <li>
                                                    <span class="icon-wrapper">
                                                        <img src="{{ asset('assets/images/icons/check.svg') }}"
                                                            alt="check icon ">
                                                    </span>
                                                    <span>Access to </span>
                                                    @php
                                                        $templates = explode(',', $item->templates);
                                                        $templatesCategory = [0=>'All Templates',1=>'Basic Templates',2=>'Standard Templates',3=>'Professional Templates'];
                                                    @endphp
                                                    @if (in_array(0, $templates))
                                                        <span> all templates </span>
                                                    @else
                                                        <span>
                                                            @foreach($templates as $tKey =>  $temp)
                                                                @if($tKey>0)
                                                                ,
                                                                @endif
                                                                {{ Str::lower($templatesCategory[$temp]??'')}}
                                                            @endforeach
                                                        </span>
                                                    @endif
                                                </li>
                                                <li>
                                                    <span class="icon-wrapper">
                                                        <img src="{{ asset('assets/images/icons/check.svg') }}"
                                                            alt="check icon ">
                                                    </span>
                                                    <span>{{ $item->max_words }} maximum words per request</span>
                                                </li>
                                                <li>
                                                    <span class="icon-wrapper">
                                                        <img src="{{ asset('assets/images/icons/check.svg') }}"
                                                            alt="check icon ">
                                                    </span>
                                                    <span>Generate {{ $item->image_count }} AI image per month</span>
                                                </li>
                                                
                                                <li>
                                                <span class="icon-wrapper {{$item->code_generate_enabled!=1?'bg-danger':''}}">
                                                    <img src="{{asset('')}}assets/images/icons/{{$item->code_generate_enabled==1?'check.svg':'cross.svg'}}" alt="check icon ">
                                                </span>
                                                    <span>Code generate with AI</span>
                                                </li>
                                                <li>
                                                    <span class="icon-wrapper {{$item->chat_enabled!=1?'bg-danger':''}}">
                                                        <img src="{{asset('')}}assets/images/icons/{{$item->chat_enabled==1?'check.svg':'cross.svg'}}" alt="check icon ">
                                                    </span>
                                                    <span>Chat with AI</span>
                                                </li>
                                                <li>
                                                    <span class="icon-wrapper {{$item->chat_enabled!=1?'bg-danger':''}}">
                                                        <img src="{{asset('')}}assets/images/icons/{{$item->chat_enabled==1?'check.svg':'cross.svg'}}" alt="check icon ">
                                                    </span>
                                                    <span>Email and chat support</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid">
                                                <div class="d-flex justify-content-between">
                                                    <button type="button" class="btn-edit-plan"><a class="dropdown-item"
                                                            href="{{ route('plan.edit', $item->id) }}">Edit</a></button>

                                                    @if ($item->is_published)
                                                        <button type="button" class="btn-deactive-plan"><a
                                                                class="dropdown-item"
                                                                href="{{ route('plan.status', [$item->id, 'deactive']) }}">Inactive
                                                                Now</a></button>
                                                    @else
                                                        <button type="button" class="btn-active-plan"><a
                                                                class="dropdown-item"
                                                                href="{{ route('plan.status', [$item->id, 'active']) }}">Active
                                                                Now</a></button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
