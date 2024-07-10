@extends('common::layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ asset('') }}admin/css/pages/app-invoice.css ">
    {{-- Swiper --}}
    <link rel="stylesheet" href="{{ asset('') }}admin/vendors/css/extensions/swiper.min.css ">
    <link rel="stylesheet" href="{{ asset('') }}admin/css/plugins/extensions/ext-component-swiper.css ">
    {{-- Swiper --}}
@endsection
@section('content')
    <section class="invoice-preview-wrapper">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-12">
                <h3>بيانات مقدم الخدمة</h3>
                <hr class="invoice-spacing" />
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <!-- Header starts -->
                        <div class=" d-flex flex-column flex-lg-row  justify-content-between">
                            <div class="me-3 mb-1">
                                <div class="d-flex">
                                    <h5 class=" card-text mb-75 me-1">الاسم: </h5>
                                    <p> {{ $provider->title }}</p>
                                </div>
                                <div class="d-flex">
                                    <h5 class="card-text mb-75 me-1">القسم: </h5>
                                    <p> {{ $provider->category->title }}</p>
                                </div>
                                <div class="d-flex">
                                    <h5 class="card-text mb-75 me-1">عن: </h5>
                                    <p> {{ $provider->about }}</p>
                                </div>
                                <div class="d-flex">
                                    <h5 class="card-text mb-75 me-1">الوصف: </h5>
                                    <p> {{ $provider->description }}</p>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex">
                                    <h5 class="card-text mb-75 me-1">العنوان: </h5>
                                    <p> {{ $provider->address }}</p>
                                </div>
                                <div class="d-flex">
                                    <h5 class="card-text mb-75 me-1">الهاتف: </h5>
                                    <p> {{ $provider->phone }}</p>
                                </div>
                                <div class="d-flex">
                                    <h5 class="card-text mb-75 me-1">الموقع: </h5>
                                    <p> {{ $provider->website }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Header ends -->
                    </div>
                </div>
            </div>
    </section>
    <section class="invoice-preview-wrapper">
        <div class="row invoice-preview">
            <!-- Invoice -->
            <div class="col-12">
                <h3 class="mb-2">ساعات العمل</h3>
                <hr class="invoice-spacing" />
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        @if (count($provider->times) != 0)
                            <table class="datatables-basic table text-center">
                                <thead>
                                    <th>اليوم</th>
                                    <th>ميعاد الفتح</th>
                                    <th>ميعاد الغلق</th>
                                    <th>اجازة</th>
                                </thead>
                                <tbody>
                                    @foreach ($provider->times as $time)
                                        <tr>
                                            <td> {{ $time->day }}</td>
                                            <td>{{ date('h:i A', strtotime($time->open_at)) }}</td>
                                            <td>{{ date('h:i A', strtotime($time->close_at)) }}</td>
                                            <td>
                                                @if ($time->is_holiday == 1)
                                                    اجازة
                                                @else
                                                    يوم عمل
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr class="invoice-spacing" />
                        @else
                            <p class="text-center">لا توجد مواعيد للعمل</p>
                        @endif

                    </div>
                </div>
            </div>
    </section>

    {{-- Services --}}
    <!-- Basic ListGroups start -->
    <section id="basic-list-group">
        <h3>الخدمات</h3>
        <hr class="invoice-spacing" />
        <div class="row match-height">
            @if (count($services) != 0)
                @foreach ($services as $service)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card" style="background-color: #d7b4a5">
                            <div class="card-header">
                                <h4 class="card-title text-white">{{ $service->title }}</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text text-white">
                                    الخدمات الفرعية
                                </p>
                                <ul class="list-group">
                                    @foreach ($service->sub_services as $sub_service)
                                        @foreach ($sub_service->providers as $provider)
                                                <li style="background-color:#EEEEEE; border-radius:5px; border-top: 1px solid rgba(34, 41, 47, 0.125);"
                                                    class="list-group-item mb-1">{{ $sub_service->title }} (الوقت:
                                                    {{ $provider->pivot->duration }} د) (السعر: ${{ $provider->pivot->price }})</li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <section class="invoice-preview-wrapper">
                    <div class="row invoice-preview">
                        <div class="col-12">
                            <div class="card invoice-preview-card">
                                <div class="card-body">
                                    <p class="text-center">لا توجد خدمات</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        </div>
    </section>
    <!-- Basic ListGroups end -->
    {{-- Services --}}

    <!-- Responsive Breakpoints swiper -->
    <section id="component-swiper-responsive-breakpoints">
        <h3 class="card-title">الصور</h3>
        <hr class="invoice-spacing" />
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="swiper-responsive-breakpoints swiper-container">
                    <div class="swiper-wrapper">
                        @if (count($provider->images) != 0)
                            @foreach ($provider->images as $key => $image)
                                <div class="swiper-slide">
                                    <img class="img-fluid" src="{{ $image->image }}"
                                        alt="Provider image {{ $key + 1 }}" />
                                </div>
                            @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                @else
                    <div class="swiper-wrapper justify-content-center">
                        <p>لا توجد صور</p>
                    </div>
                    @endif
                    <!-- Add Pagination -->
                </div>
            </div>
        </div>
    </section>
    <!--/ Responsive Breakpoints swiper -->

@endsection
@section('js')
    {{-- Swiper --}}
    <script src="{{ asset('') }}admin/vendors/js/extensions/swiper.min.js"></script>
    <script src="{{ asset('') }}admin/js/scripts/extensions/ext-component-swiper.js"></script>
    {{-- Swiper --}}
@endsection
