@extends('common::layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/plugins/charts/chart-apex.css">
@endsection
@section('content')
    <!-- Dashboard Ecommerce Starts -->
    <section id="dashboard-ecommerce">
        <div class="row match-height">




            <!-- Medal Card -->
            <div class="col-xl-4 col-md-6 col-12">
                <div class="card card-congratulation-medal">
                    <div class="card-body">
                        <h5>تهانينا 🎉 !</h5>
                        <p class="card-text font-small-3">اهلا بك في تطبيق المناسبات</p>
                        <a href="{{ url('admin/orders') }}" type="button" class="btn btn-primary">عرض الطلبات</a>
                        <img src="{{ asset('') }}admin/images/illustration/badge.svg" class="congratulation-medal"
                            alt="Medal Pic" />
                    </div>
                </div>
            </div>
            {{-- Med Card --}}





            {{-- Statistics Card --}}
            <div class="col-xl-8 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-header">
                        <h4 class="card-title">احصائيات عن اليوم {{ \Carbon\Carbon::now()->toDateString() }} </h4>
                    </div>
                    <div class="card-body statistics-body">
                        <div class="row">
                            <div class="col-xl-4 col-sm-12 col-12 mb-2 mb-xl-0">
                                <div class="d-flex flex-row">
                                    <div class="avatar bg-light-success me-2">
                                        <div class="avatar-content">
                                            <i data-feather="user" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $todayClientsCount }}</h4>
                                        <p class="card-text font-small-3 mb-0">العملاء الجدد</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-12 col-12 mb-2 mb-xl-0">
                                <div class="d-flex flex-row">
                                    <div class="avatar bg-light-success me-2">
                                        <div class="avatar-content">
                                            <i data-feather="user" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $todayProvidersCount }}</h4>
                                        <p class="card-text font-small-3 mb-0">مقدمي الخدمة الجدد</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-12 col-12 mb-2 mb-sm-0">
                                <div class="d-flex flex-row">
                                    <div class="avatar bg-light-warning me-2">
                                        <div class="avatar-content">
                                            <i data-feather="clipboard" class="avatar-icon"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $todayOrdersCount }}</h4>
                                        <p class="card-text font-small-3 mb-0">الطلبات الجديدة</p>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            {{-- Statistics Card --}}




            <div class="row match-height">
                {{-- More Statistics Card --}}
                <div class="col-xl-12 ">
                    <div class="card card-statistics">
                        <div class="card-header">
                            <h4 class="card-title">اجمالى الاحصائيات</h4>
                        </div>
                        <div class="card-body statistics-body">
                            <div class="row">
                                <div class="col-xl-2 col-lg-4 col-sm-6 col-12 mb-2 mb-xl-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-success me-2">
                                            <div class="avatar-content">
                                                <i data-feather="user" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 style="font-size: 11px !important" class="fw-bolder mb-0">العملاء
                                                المفعلين
                                            </h4>
                                            <p class="card-text font-small-3 mb-0">
                                                {{ $activeClientsCount }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-4 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-danger me-2">
                                            <div class="avatar-content">
                                                <i data-feather="user" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 style="font-size: 11px !important" class="fw-bolder mb-0">العملاء الغير
                                                مفعلين
                                            </h4>
                                            <p class="card-text font-small-3 mb-0">
                                                {{ $inactiveClientsCount }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-lg-4 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-success me-2">
                                            <div class="avatar-content">
                                                <i data-feather="user" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 style="font-size: 11px !important" class="fw-bolder mb-0"> مقدمي الخدمة
                                                المفعلين
                                            </h4>
                                            <p class="card-text font-small-3 mb-0">
                                                {{ $activeProvidersCount }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-lg-4 col-sm-6 col-12 mb-2 mb-xl-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-danger me-2">
                                            <div class="avatar-content">
                                                <i data-feather="user" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 style="font-size: 11px !important" class="fw-bolder mb-0">مقدمي الخدمة
                                                الغير مفعلين</h4>
                                            <p class="card-text font-small-3 mb-0">
                                                {{ $inactiveProvidersCount }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-4 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-success me-2">
                                            <div class="avatar-content">
                                                <i data-feather="bookmark" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 style="font-size: 11px !important" class="fw-bolder mb-0">الاقسام المفعله
                                            </h4>
                                            <p class="card-text font-small-3 mb-0">
                                                {{ $activeCategoriesCount }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-4 col-sm-6 col-12">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-danger me-2">
                                            <div class="avatar-content">
                                                <i data-feather="bookmark" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 style="font-size: 11px !important" class="fw-bolder mb-0">الاقسام الغير
                                                مفعله</h4>
                                            <p class="card-text font-small-3 mb-0">
                                                {{ $inactiveCategoriesCount }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- More Statistics Card --}}
                <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                    <div class="row match-height">
                        <!-- Bar Chart - Orders -->
                        <div class="col-lg-6  col-6">
                            <div class="card">
                                <div class="card-body pb-50">
                                    <h6>الربح هذا الشهر</h6>
                                    <h2 class="fw-bolder mb-1">{{ $profitThisMonth }} ريال</h2>
                                    <div id="statistics-order-chart" style="min-height: 85px;">
                                        <div id="apexcharts6suv52si"
                                            class="apexcharts-canvas apexcharts6suv52si apexcharts-theme-light"
                                            style="width: 147px; height: 70px;"><svg id="SvgjsSvg1863" width="147"
                                                height="70" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:svgjs="http://svgjs.com/svgjs"
                                                class="apexcharts-svg apexcharts-zoomable" xmlns:data="ApexChartsNS"
                                                transform="translate(0, 0)" style="background: transparent;">
                                                <g id="SvgjsG1865" class="apexcharts-inner apexcharts-graphical"
                                                    transform="translate(13.899999999999999, 15)">
                                                    <defs id="SvgjsDefs1864">
                                                        <linearGradient id="SvgjsLinearGradient1868" x1="0"
                                                            y1="0" x2="0" y2="1">
                                                            <stop id="SvgjsStop1869" stop-opacity="0.4"
                                                                stop-color="rgba(216,227,240,0.4)" offset="0"></stop>
                                                            <stop id="SvgjsStop1870" stop-opacity="0.5"
                                                                stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                                            <stop id="SvgjsStop1871" stop-opacity="0.5"
                                                                stop-color="rgba(190,209,230,0.5)" offset="1"></stop>
                                                        </linearGradient>
                                                        <clipPath id="gridRectMask6suv52si">
                                                            <rect id="SvgjsRect1873" width="151" height="55"
                                                                x="-11.899999999999999" y="0" rx="0"
                                                                ry="0" opacity="1" stroke-width="0"
                                                                stroke="none" stroke-dasharray="0" fill="#fff">
                                                            </rect>
                                                        </clipPath>
                                                        <clipPath id="gridRectMarkerMask6suv52si">
                                                            <rect id="SvgjsRect1874" width="131.2" height="59" x="-2"
                                                                y="-2" rx="0" ry="0" opacity="1"
                                                                stroke-width="0" stroke="none" stroke-dasharray="0"
                                                                fill="#fff"></rect>
                                                        </clipPath>
                                                        <filter id="SvgjsFilter1883" filterUnits="userSpaceOnUse"
                                                            width="200%" height="200%" x="-50%" y="-50%">
                                                            <feComponentTransfer id="SvgjsFeComponentTransfer1884"
                                                                result="SvgjsFeComponentTransfer1884Out"
                                                                in="SourceGraphic">
                                                                <feFuncR id="SvgjsFeFuncR1885" type="linear"
                                                                    slope="0.5">
                                                                </feFuncR>
                                                                <feFuncG id="SvgjsFeFuncG1886" type="linear"
                                                                    slope="0.5">
                                                                </feFuncG>
                                                                <feFuncB id="SvgjsFeFuncB1887" type="linear"
                                                                    slope="0.5">
                                                                </feFuncB>
                                                                <feFuncA id="SvgjsFeFuncA1888" type="identity"></feFuncA>
                                                            </feComponentTransfer>
                                                        </filter>
                                                    </defs>
                                                    <rect id="SvgjsRect1872" width="6.36" height="55" x="0" y="0"
                                                        rx="0" ry="0" opacity="1" stroke-width="0"
                                                        stroke-dasharray="3" fill="url(#SvgjsLinearGradient1868)"
                                                        class="apexcharts-xcrosshairs" y2="55" filter="none"
                                                        fill-opacity="0.9"></rect>
                                                    <g id="SvgjsG1895" class="apexcharts-xaxis"
                                                        transform="translate(0, 0)">
                                                        <g id="SvgjsG1896" class="apexcharts-xaxis-texts-g"
                                                            transform="translate(0, -4)"></g>
                                                    </g>
                                                    <g id="SvgjsG1898" class="apexcharts-grid">
                                                        <g id="SvgjsG1899" class="apexcharts-gridlines-horizontal"
                                                            style="display: none;">
                                                            <line id="SvgjsLine1901" x1="-9.899999999999999"
                                                                y1="0" x2="137.1" y2="0"
                                                                stroke="#e0e0e0" stroke-dasharray="0"
                                                                class="apexcharts-gridline"></line>
                                                            <line id="SvgjsLine1902" x1="-9.899999999999999"
                                                                y1="11" x2="137.1" y2="11"
                                                                stroke="#e0e0e0" stroke-dasharray="0"
                                                                class="apexcharts-gridline"></line>
                                                            <line id="SvgjsLine1903" x1="-9.899999999999999"
                                                                y1="22" x2="137.1" y2="22"
                                                                stroke="#e0e0e0" stroke-dasharray="0"
                                                                class="apexcharts-gridline"></line>
                                                            <line id="SvgjsLine1904" x1="-9.899999999999999"
                                                                y1="33" x2="137.1" y2="33"
                                                                stroke="#e0e0e0" stroke-dasharray="0"
                                                                class="apexcharts-gridline"></line>
                                                            <line id="SvgjsLine1905" x1="-9.899999999999999"
                                                                y1="44" x2="137.1" y2="44"
                                                                stroke="#e0e0e0" stroke-dasharray="0"
                                                                class="apexcharts-gridline"></line>
                                                            <line id="SvgjsLine1906" x1="-9.899999999999999"
                                                                y1="55" x2="137.1" y2="55"
                                                                stroke="#e0e0e0" stroke-dasharray="0"
                                                                class="apexcharts-gridline"></line>
                                                        </g>
                                                        <g id="SvgjsG1900" class="apexcharts-gridlines-vertical"
                                                            style="display: none;"></g>
                                                        <line id="SvgjsLine1908" x1="0" y1="55"
                                                            x2="127.2" y2="55" stroke="transparent"
                                                            stroke-dasharray="0"></line>
                                                        <line id="SvgjsLine1907" x1="0" y1="1"
                                                            x2="0" y2="55" stroke="transparent"
                                                            stroke-dasharray="0"></line>
                                                    </g>
                                                    <g id="SvgjsG1875"
                                                        class="apexcharts-bar-series apexcharts-plot-series">
                                                        <g id="SvgjsG1876" class="apexcharts-series" seriesName="2020"
                                                            rel="1" data:realIndex="0">
                                                            <rect id="SvgjsRect1878" width="6.36" height="55"
                                                                x="-3.18" y="0" rx="5" ry="5"
                                                                opacity="1" stroke-width="0" stroke="none"
                                                                stroke-dasharray="0" fill="#f3f3f3"
                                                                class="apexcharts-backgroundBar"></rect>
                                                            <path id="SvgjsPath1879"
                                                                d="M -3.18 53.41L -3.18 30.25L 3.18 30.25L 3.18 30.25L 3.18 53.41Q 0 56.589999999999996 -3.18 53.41z"
                                                                fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                                stroke-opacity="1" stroke-linecap="square"
                                                                stroke-width="0" stroke-dasharray="0"
                                                                class="apexcharts-bar-area" index="0"
                                                                clip-path="url(#gridRectMask6suv52si)"
                                                                pathTo="M -3.18 53.41L -3.18 30.25L 3.18 30.25L 3.18 30.25L 3.18 53.41Q 0 56.589999999999996 -3.18 53.41z"
                                                                pathFrom="M -3.18 53.41L -3.18 55L 3.18 55L 3.18 55L 3.18 55L -3.18 55"
                                                                cy="30.25" cx="3.1800000000000006" j="0"
                                                                val="45" barHeight="24.75" barWidth="6.36"></path>
                                                            <rect id="SvgjsRect1880" width="6.36" height="55"
                                                                x="28.62" y="0" rx="5" ry="5"
                                                                opacity="1" stroke-width="0" stroke="none"
                                                                stroke-dasharray="0" fill="#f3f3f3"
                                                                class="apexcharts-backgroundBar"></rect>
                                                            <path id="SvgjsPath1881"
                                                                d="M 28.62 53.41L 28.62 8.25L 34.980000000000004 8.25L 34.980000000000004 8.25L 34.980000000000004 53.41Q 31.8 56.589999999999996 28.62 53.41z"
                                                                fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                                stroke-opacity="1" stroke-linecap="square"
                                                                stroke-width="0" stroke-dasharray="0"
                                                                class="apexcharts-bar-area" index="0"
                                                                clip-path="url(#gridRectMask6suv52si)"
                                                                pathTo="M 28.62 53.41L 28.62 8.25L 34.980000000000004 8.25L 34.980000000000004 8.25L 34.980000000000004 53.41Q 31.8 56.589999999999996 28.62 53.41z"
                                                                pathFrom="M 28.62 53.41L 28.62 55L 34.980000000000004 55L 34.980000000000004 55L 34.980000000000004 55L 28.62 55"
                                                                selected="true" filter="url(#SvgjsFilter1883)"
                                                                cy="8.25" cx="34.980000000000004" j="1"
                                                                val="85" barHeight="46.75" barWidth="6.36"></path>
                                                            <rect id="SvgjsRect1889" width="6.36" height="55"
                                                                x="60.42" y="0" rx="5" ry="5"
                                                                opacity="1" stroke-width="0" stroke="none"
                                                                stroke-dasharray="0" fill="#f3f3f3"
                                                                class="apexcharts-backgroundBar"></rect>
                                                            <path id="SvgjsPath1890"
                                                                d="M 60.42 53.41L 60.42 19.25L 66.78 19.25L 66.78 19.25L 66.78 53.41Q 63.6 56.589999999999996 60.42 53.41z"
                                                                fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                                stroke-opacity="1" stroke-linecap="square"
                                                                stroke-width="0" stroke-dasharray="0"
                                                                class="apexcharts-bar-area" index="0"
                                                                clip-path="url(#gridRectMask6suv52si)"
                                                                pathTo="M 60.42 53.41L 60.42 19.25L 66.78 19.25L 66.78 19.25L 66.78 53.41Q 63.6 56.589999999999996 60.42 53.41z"
                                                                pathFrom="M 60.42 53.41L 60.42 55L 66.78 55L 66.78 55L 66.78 55L 60.42 55"
                                                                cy="19.25" cx="66.78" j="2" val="65"
                                                                barHeight="35.75" barWidth="6.36"></path>
                                                            <rect id="SvgjsRect1891" width="6.36" height="55"
                                                                x="92.22" y="0" rx="5" ry="5"
                                                                opacity="1" stroke-width="0" stroke="none"
                                                                stroke-dasharray="0" fill="#f3f3f3"
                                                                class="apexcharts-backgroundBar"></rect>
                                                            <path id="SvgjsPath1892"
                                                                d="M 92.22 53.41L 92.22 30.25L 98.58 30.25L 98.58 30.25L 98.58 53.41Q 95.4 56.589999999999996 92.22 53.41z"
                                                                fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                                stroke-opacity="1" stroke-linecap="square"
                                                                stroke-width="0" stroke-dasharray="0"
                                                                class="apexcharts-bar-area" index="0"
                                                                clip-path="url(#gridRectMask6suv52si)"
                                                                pathTo="M 92.22 53.41L 92.22 30.25L 98.58 30.25L 98.58 30.25L 98.58 53.41Q 95.4 56.589999999999996 92.22 53.41z"
                                                                pathFrom="M 92.22 53.41L 92.22 55L 98.58 55L 98.58 55L 98.58 55L 92.22 55"
                                                                cy="30.25" cx="98.58" j="3" val="45"
                                                                barHeight="24.75" barWidth="6.36"></path>
                                                            <rect id="SvgjsRect1893" width="6.36" height="55"
                                                                x="124.02" y="0" rx="5" ry="5"
                                                                opacity="1" stroke-width="0" stroke="none"
                                                                stroke-dasharray="0" fill="#f3f3f3"
                                                                class="apexcharts-backgroundBar"></rect>
                                                            <path id="SvgjsPath1894"
                                                                d="M 124.02 53.41L 124.02 19.25L 130.38 19.25L 130.38 19.25L 130.38 53.41Q 127.2 56.589999999999996 124.02 53.41z"
                                                                fill="rgba(255,159,67,0.85)" fill-opacity="1"
                                                                stroke-opacity="1" stroke-linecap="square"
                                                                stroke-width="0" stroke-dasharray="0"
                                                                class="apexcharts-bar-area" index="0"
                                                                clip-path="url(#gridRectMask6suv52si)"
                                                                pathTo="M 124.02 53.41L 124.02 19.25L 130.38 19.25L 130.38 19.25L 130.38 53.41Q 127.2 56.589999999999996 124.02 53.41z"
                                                                pathFrom="M 124.02 53.41L 124.02 55L 130.38 55L 130.38 55L 130.38 55L 124.02 55"
                                                                cy="19.25" cx="130.38" j="4" val="65"
                                                                barHeight="35.75" barWidth="6.36"></path>
                                                        </g>
                                                        <g id="SvgjsG1877" class="apexcharts-datalabels"
                                                            data:realIndex="0">
                                                        </g>
                                                    </g>
                                                    <line id="SvgjsLine1909" x1="-9.899999999999999" y1="0"
                                                        x2="137.1" y2="0" stroke="#b6b6b6"
                                                        stroke-dasharray="0" stroke-width="1"
                                                        class="apexcharts-ycrosshairs"></line>
                                                    <line id="SvgjsLine1910" x1="-9.899999999999999" y1="0"
                                                        x2="137.1" y2="0" stroke-dasharray="0"
                                                        stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line>
                                                    <g id="SvgjsG1911" class="apexcharts-yaxis-annotations"></g>
                                                    <g id="SvgjsG1912" class="apexcharts-xaxis-annotations"></g>
                                                    <g id="SvgjsG1913" class="apexcharts-point-annotations"></g>
                                                    <rect id="SvgjsRect1914" width="0" height="0" x="0" y="0"
                                                        rx="0" ry="0" opacity="1" stroke-width="0"
                                                        stroke="none" stroke-dasharray="0" fill="#fefefe"
                                                        class="apexcharts-zoom-rect"></rect>
                                                    <rect id="SvgjsRect1915" width="0" height="0" x="0" y="0"
                                                        rx="0" ry="0" opacity="1" stroke-width="0"
                                                        stroke="none" stroke-dasharray="0" fill="#fefefe"
                                                        class="apexcharts-selection-rect"></rect>
                                                </g>
                                                <g id="SvgjsG1897" class="apexcharts-yaxis" rel="0"
                                                    transform="translate(-18, 0)"></g>
                                                <g id="SvgjsG1866" class="apexcharts-annotations"></g>
                                            </svg>
                                            <div class="apexcharts-legend" style="max-height: 35px;"></div>
                                            <div class="apexcharts-tooltip apexcharts-theme-light">
                                                <div class="apexcharts-tooltip-series-group" style="order: 1;"><span
                                                        class="apexcharts-tooltip-marker"
                                                        style="background-color: rgb(255, 159, 67);"></span>
                                                    <div class="apexcharts-tooltip-text"
                                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                        <div class="apexcharts-tooltip-y-group"><span
                                                                class="apexcharts-tooltip-text-label"></span><span
                                                                class="apexcharts-tooltip-text-value"></span></div>
                                                        <div class="apexcharts-tooltip-z-group"><span
                                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                                <div class="apexcharts-yaxistooltip-text"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Bar Chart - Orders -->

                        <!-- Line Chart - Profit -->
                        <div class="col-lg-6  col-6">
                            <div class="card card-tiny-line-stats">
                                <div class="card-body pb-50">
                                    <h6>الطلبات هذا الشهر</h6>
                                    <h2 class="fw-bolder mb-1">{{ $ordersThisMonth }}</h2>
                                    <div id="statistics-profit-chart" style="min-height: 85px;">
                                        <div id="apexchartsq4dnn7bh"
                                            class="apexcharts-canvas apexchartsq4dnn7bh apexcharts-theme-light"
                                            style="width: 147px; height: 70px;"><svg id="SvgjsSvg1916" width="147"
                                                height="70" xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg"
                                                xmlns:data="ApexChartsNS" transform="translate(0, 0)"
                                                style="background: transparent;">
                                                <g id="SvgjsG1918" class="apexcharts-inner apexcharts-graphical"
                                                    transform="translate(12, 0)">
                                                    <defs id="SvgjsDefs1917">
                                                        <clipPath id="gridRectMaskq4dnn7bh">
                                                            <rect id="SvgjsRect1923" width="132" height="68"
                                                                x="-3.5" y="-1.5" rx="0" ry="0"
                                                                opacity="1" stroke-width="0" stroke="none"
                                                                stroke-dasharray="0" fill="#fff"></rect>
                                                        </clipPath>
                                                        <clipPath id="gridRectMarkerMaskq4dnn7bh">
                                                            <rect id="SvgjsRect1924" width="137" height="77" x="-6"
                                                                y="-6" rx="0" ry="0" opacity="1"
                                                                stroke-width="0" stroke="none" stroke-dasharray="0"
                                                                fill="#fff"></rect>
                                                        </clipPath>
                                                    </defs>
                                                    <line id="SvgjsLine1922" x1="124.5" y1="0"
                                                        x2="124.5" y2="65" stroke="#b6b6b6"
                                                        stroke-dasharray="3" class="apexcharts-xcrosshairs" x="124.5"
                                                        y="0" width="1" height="65" fill="#b1b9c4"
                                                        filter="none" fill-opacity="0.9" stroke-width="1"></line>
                                                    <g id="SvgjsG1941" class="apexcharts-xaxis"
                                                        transform="translate(0, 0)">
                                                        <g id="SvgjsG1942" class="apexcharts-xaxis-texts-g"
                                                            transform="translate(0, -4)"><text id="SvgjsText1944"
                                                                font-family="Helvetica, Arial, sans-serif" x="0" y="94"
                                                                text-anchor="middle" dominant-baseline="auto"
                                                                font-size="0px" font-weight="400" fill="#373d3f"
                                                                class="apexcharts-text apexcharts-xaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan1945">1</tspan>
                                                                <title>1</title>
                                                            </text><text id="SvgjsText1947"
                                                                font-family="Helvetica, Arial, sans-serif" x="25" y="94"
                                                                text-anchor="middle" dominant-baseline="auto"
                                                                font-size="0px" font-weight="400" fill="#373d3f"
                                                                class="apexcharts-text apexcharts-xaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan1948">2</tspan>
                                                                <title>2</title>
                                                            </text><text id="SvgjsText1950"
                                                                font-family="Helvetica, Arial, sans-serif" x="50" y="94"
                                                                text-anchor="middle" dominant-baseline="auto"
                                                                font-size="0px" font-weight="400" fill="#373d3f"
                                                                class="apexcharts-text apexcharts-xaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan1951">3</tspan>
                                                                <title>3</title>
                                                            </text><text id="SvgjsText1953"
                                                                font-family="Helvetica, Arial, sans-serif" x="75" y="94"
                                                                text-anchor="middle" dominant-baseline="auto"
                                                                font-size="0px" font-weight="400" fill="#373d3f"
                                                                class="apexcharts-text apexcharts-xaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan1954">4</tspan>
                                                                <title>4</title>
                                                            </text><text id="SvgjsText1956"
                                                                font-family="Helvetica, Arial, sans-serif" x="100" y="94"
                                                                text-anchor="middle" dominant-baseline="auto"
                                                                font-size="0px" font-weight="400" fill="#373d3f"
                                                                class="apexcharts-text apexcharts-xaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan1957">5</tspan>
                                                                <title>5</title>
                                                            </text><text id="SvgjsText1959"
                                                                font-family="Helvetica, Arial, sans-serif" x="125" y="94"
                                                                text-anchor="middle" dominant-baseline="auto"
                                                                font-size="0px" font-weight="400" fill="#373d3f"
                                                                class="apexcharts-text apexcharts-xaxis-label "
                                                                style="font-family: Helvetica, Arial, sans-serif;">
                                                                <tspan id="SvgjsTspan1960">6</tspan>
                                                                <title>6</title>
                                                            </text></g>
                                                    </g>
                                                    <g id="SvgjsG1962" class="apexcharts-grid">
                                                        <g id="SvgjsG1963" class="apexcharts-gridlines-horizontal"></g>
                                                        <g id="SvgjsG1964" class="apexcharts-gridlines-vertical">
                                                            <line id="SvgjsLine1965" x1="0" y1="0"
                                                                x2="0" y2="65" stroke="#ebebeb"
                                                                stroke-dasharray="5" class="apexcharts-gridline"></line>
                                                            <line id="SvgjsLine1966" x1="25" y1="0"
                                                                x2="25" y2="65" stroke="#ebebeb"
                                                                stroke-dasharray="5" class="apexcharts-gridline"></line>
                                                            <line id="SvgjsLine1967" x1="50" y1="0"
                                                                x2="50" y2="65" stroke="#ebebeb"
                                                                stroke-dasharray="5" class="apexcharts-gridline"></line>
                                                            <line id="SvgjsLine1968" x1="75" y1="0"
                                                                x2="75" y2="65" stroke="#ebebeb"
                                                                stroke-dasharray="5" class="apexcharts-gridline"></line>
                                                            <line id="SvgjsLine1969" x1="100" y1="0"
                                                                x2="100" y2="65" stroke="#ebebeb"
                                                                stroke-dasharray="5" class="apexcharts-gridline"></line>
                                                            <line id="SvgjsLine1970" x1="125" y1="0"
                                                                x2="125" y2="65" stroke="#ebebeb"
                                                                stroke-dasharray="5" class="apexcharts-gridline"></line>
                                                        </g>
                                                        <line id="SvgjsLine1972" x1="0" y1="65"
                                                            x2="125" y2="65" stroke="transparent"
                                                            stroke-dasharray="0"></line>
                                                        <line id="SvgjsLine1971" x1="0" y1="1"
                                                            x2="0" y2="65" stroke="transparent"
                                                            stroke-dasharray="0"></line>
                                                    </g>
                                                    <g id="SvgjsG1925"
                                                        class="apexcharts-line-series apexcharts-plot-series">
                                                        <g id="SvgjsG1926" class="apexcharts-series"
                                                            seriesName="seriesx1" data:longestSeries="true"
                                                            rel="1" data:realIndex="0">
                                                            <path id="SvgjsPath1940"
                                                                d="M 0 65L 25 39L 50 58.5L 75 26L 100 45.5L 125 6.5"
                                                                fill="none" fill-opacity="1"
                                                                stroke="rgba(0,207,232,0.85)" stroke-opacity="1"
                                                                stroke-linecap="butt" stroke-width="3"
                                                                stroke-dasharray="0" class="apexcharts-line"
                                                                index="0" clip-path="url(#gridRectMaskq4dnn7bh)"
                                                                pathTo="M 0 65L 25 39L 50 58.5L 75 26L 100 45.5L 125 6.5"
                                                                pathFrom="M -1 65L -1 65L 25 65L 50 65L 75 65L 100 65L 125 65">
                                                            </path>
                                                            <g id="SvgjsG1927" class="apexcharts-series-markers-wrap"
                                                                data:realIndex="0">
                                                                <g id="SvgjsG1929" class="apexcharts-series-markers"
                                                                    clip-path="url(#gridRectMarkerMaskq4dnn7bh)">
                                                                    <circle id="SvgjsCircle1930" r="2" cx="0"
                                                                        cy="65"
                                                                        class="apexcharts-marker no-pointer-events w7i1nc3gs"
                                                                        stroke="#00cfe8" fill="#00cfe8" fill-opacity="1"
                                                                        stroke-width="2" stroke-opacity="1"
                                                                        rel="0" j="0" index="0"
                                                                        default-marker-size="2"></circle>
                                                                    <circle id="SvgjsCircle1931" r="2" cx="25"
                                                                        cy="39"
                                                                        class="apexcharts-marker no-pointer-events w0jqzk3kb"
                                                                        stroke="#00cfe8" fill="#00cfe8" fill-opacity="1"
                                                                        stroke-width="2" stroke-opacity="1"
                                                                        rel="1" j="1" index="0"
                                                                        default-marker-size="2"></circle>
                                                                </g>
                                                                <g id="SvgjsG1932" class="apexcharts-series-markers"
                                                                    clip-path="url(#gridRectMarkerMaskq4dnn7bh)">
                                                                    <circle id="SvgjsCircle1933" r="2" cx="50"
                                                                        cy="58.5"
                                                                        class="apexcharts-marker no-pointer-events w2drmc7s9l"
                                                                        stroke="#00cfe8" fill="#00cfe8" fill-opacity="1"
                                                                        stroke-width="2" stroke-opacity="1"
                                                                        rel="2" j="2" index="0"
                                                                        default-marker-size="2"></circle>
                                                                </g>
                                                                <g id="SvgjsG1934" class="apexcharts-series-markers"
                                                                    clip-path="url(#gridRectMarkerMaskq4dnn7bh)">
                                                                    <circle id="SvgjsCircle1935" r="2" cx="75"
                                                                        cy="26"
                                                                        class="apexcharts-marker no-pointer-events wgsyw7eh5"
                                                                        stroke="#00cfe8" fill="#00cfe8" fill-opacity="1"
                                                                        stroke-width="2" stroke-opacity="1"
                                                                        rel="3" j="3" index="0"
                                                                        default-marker-size="2"></circle>
                                                                </g>
                                                                <g id="SvgjsG1936" class="apexcharts-series-markers"
                                                                    clip-path="url(#gridRectMarkerMaskq4dnn7bh)">
                                                                    <circle id="SvgjsCircle1937" r="2" cx="100"
                                                                        cy="45.5"
                                                                        class="apexcharts-marker no-pointer-events wwvgpi36zj"
                                                                        stroke="#00cfe8" fill="#00cfe8" fill-opacity="1"
                                                                        stroke-width="2" stroke-opacity="1"
                                                                        rel="4" j="4" index="0"
                                                                        default-marker-size="2"></circle>
                                                                </g>
                                                                <g id="SvgjsG1938" class="apexcharts-series-markers"
                                                                    clip-path="url(#gridRectMarkerMaskq4dnn7bh)">
                                                                    <circle id="SvgjsCircle1939" r="5" cx="125"
                                                                        cy="6.5"
                                                                        class="apexcharts-marker no-pointer-events wst3nz6co"
                                                                        stroke="#00cfe8" fill="#ffffff" fill-opacity="1"
                                                                        stroke-width="2" stroke-opacity="1"
                                                                        rel="5" j="5" index="0"
                                                                        default-marker-size="5"></circle>
                                                                </g>
                                                            </g>
                                                        </g>
                                                        <g id="SvgjsG1928" class="apexcharts-datalabels"
                                                            data:realIndex="0">
                                                        </g>
                                                    </g>
                                                    <line id="SvgjsLine1973" x1="0" y1="0"
                                                        x2="125" y2="0" stroke="#b6b6b6"
                                                        stroke-dasharray="0" stroke-width="1"
                                                        class="apexcharts-ycrosshairs"></line>
                                                    <line id="SvgjsLine1974" x1="0" y1="0"
                                                        x2="125" y2="0" stroke-dasharray="0"
                                                        stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line>
                                                    <g id="SvgjsG1975" class="apexcharts-yaxis-annotations"></g>
                                                    <g id="SvgjsG1976" class="apexcharts-xaxis-annotations"></g>
                                                    <g id="SvgjsG1977" class="apexcharts-point-annotations"></g>
                                                </g>
                                                <rect id="SvgjsRect1921" width="0" height="0" x="0" y="0"
                                                    rx="0" ry="0" opacity="1" stroke-width="0"
                                                    stroke="none" stroke-dasharray="0" fill="#fefefe">
                                                </rect>
                                                <g id="SvgjsG1961" class="apexcharts-yaxis" rel="0"
                                                    transform="translate(-18, 0)"></g>
                                                <g id="SvgjsG1919" class="apexcharts-annotations"></g>
                                            </svg>
                                            <div class="apexcharts-legend" style="max-height: 35px;"></div>
                                            <div class="apexcharts-tooltip apexcharts-theme-light"
                                                style="left: 12.6px; top: 8px;">
                                                <div class="apexcharts-tooltip-series-group apexcharts-active"
                                                    style="order: 1; display: flex;"><span
                                                        class="apexcharts-tooltip-marker"
                                                        style="background-color: rgb(0, 207, 232);"></span>
                                                    <div class="apexcharts-tooltip-text"
                                                        style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">
                                                        <div class="apexcharts-tooltip-y-group"><span
                                                                class="apexcharts-tooltip-text-label">series-1:
                                                            </span><span class="apexcharts-tooltip-text-value">45</span>
                                                        </div>
                                                        <div class="apexcharts-tooltip-z-group"><span
                                                                class="apexcharts-tooltip-text-z-label"></span><span
                                                                class="apexcharts-tooltip-text-z-value"></span></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light"
                                                style="left: 121.1px; top: 67px;">
                                                <div class="apexcharts-xaxistooltip-text"
                                                    style="font-family: Helvetica, Arial, sans-serif; font-size: 12px; min-width: 8.8px;">
                                                    6</div>
                                            </div>
                                            <div
                                                class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light">
                                                <div class="apexcharts-yaxistooltip-text"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>



                <!-- Statistics Card -->
                <div class="col-xl-6 col-lg-12 col-md-12 col-12">
                    <div class="card card-statistics">
                        <div class="card-header">
                            <h4 class="card-title">اجمالى التقارير</h4>
                        </div>
                        <div class="card-body statistics-body">
                            <div class="row">
                                <div class="col-xl-6 col-sm-6 col-12 mb-2 mb-xl-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-primary me-2">
                                            <div class="avatar-content">
                                                <i data-feather="package" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 class="fw-bolder mb-0">{{ $activeServicesCount }}</h4>
                                            <p class="card-text font-small-3 mb-0">الخدمات الرئيسية المفعله</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-6 col-12 mb-2 mb-xl-0">
                                    <div class="d-flex flex-row">
                                        <div class="avatar bg-light-primary me-2">
                                            <div class="avatar-content">
                                                <i data-feather="box" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="my-auto">
                                            <h4 class="fw-bolder mb-0">{{ $activeSubservicesCount }}</h4>
                                            <p class="card-text font-small-3 mb-0">الخدمات الفرعية المفعله</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Statistics Card -->
            </div>





            {{-- Last 5 orders table --}}
            <div class="col-lg-6 col-12">
                <div class="card card-company-table">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>اسم العميل</th>
                                        <th>رقم الطلب</th>
                                        <th>تاريخ الحجز</th>
                                        <th>السعر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($latestOrders as $order)
                                        <tr>
                                            <td class="p-1">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar rounded">
                                                        <div class="avatar-content">
                                                            <img src="{{ asset('') }}admin/images/icons/parachute.svg"
                                                                alt="Parachute svg" />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bolder"><span>{{ $order->client->name }}</span>
                                                        </div>
                                                        <div class="font-small-2 text-muted">
                                                            {{ $order->client->phone }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-1">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar rounded">
                                                        <div class="avatar-content">
                                                            <img src="{{ asset('') }}admin/images/icons/order.svg"
                                                                alt="Order svg" />
                                                        </div>
                                                    </div>
                                                    <span><a
                                                            href="{{ route('orders.show', ['order' => $order->id]) }}">{{ $order->order_no }}</a></span>
                                                </div>
                                            </td>
                                            <td class="p-1">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar rounded">
                                                        <div class="avatar-content">
                                                            <img src="{{ asset('') }}admin/images/icons/book.svg"
                                                                alt="Book svg" />
                                                        </div>
                                                    </div>

                                                    <span>{{ $order->reservation_date }}</span>
                                                </div>
                                            </td>
                                            <td class="text-nowrap p-1">
                                                <div class="d-flex flex-column">
                                                    <span class="fw-bolder mb-25">{{ $order->total }} ريال</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Last 5 orders table --}}


            {{-- Top 5 Service Providers table --}}
            <div class="col-lg-6 col-12">
                <div class="card card-company-table">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="p-1">اسم مقدم الخدمة</th>
                                        <th class="p-1">معدل التقييم</th>
                                        <th class="p-1">عدد القتييمات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topProviders as $topProvider)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar rounded">
                                                        <div class="avatar-content">
                                                            <img src="{{ $topProvider->image }}" alt="Parachute svg"
                                                                height="22" width="22" />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bolder"><span>{{ $topProvider->title }}</span>
                                                        </div>
                                                        <div class="font-small-2 text-muted">
                                                            {{ $topProvider->phone }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar text-warning me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="star" class="avatar-icon"></i>
                                                        </div>
                                                    </div>
                                                    <span
                                                        class="fw-bolder">{{ number_format($topProvider->rates_avg_provider_rate , 2) }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar text-primary me-2">
                                                        <div class="avatar-content">
                                                            <i data-feather="user" class="avatar-icon"></i>
                                                        </div>
                                                    </div>

                                                    <span class="fw-bolder">{{ $topProvider->rates_count }}</span>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Last 5 Service Providers table --}}

        </div>
    </section>
    <!-- Dashboard Ecommerce ends -->
@endsection

@section('js')
    <script src="{{ asset('') }}admin/vendors/js/charts/apexcharts.min.js"></script>
@endsection
