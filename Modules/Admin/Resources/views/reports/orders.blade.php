@extends('common::layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin/css-rtl/plugins/extensions/ext-component-sweet-alerts.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/plugins/charts/chart-apex.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin/css-rtl/plugins/forms/pickers/form-flat-pickr.css">
@endsection

@section('content')
    <!--Bar Chart Start -->
    <div class="row">
        <div class="col-xl-12 col-md-12 col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h4 class="card-title">الاحصائيات </h4>
                    <div class="d-flex align-items-center">
                        <p class="card-text font-small-2 me-25 mb-0">اخر تحديث الشهر السابق</p>
                    </div>
                </div>
                <div class="card-body statistics-body">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-primary me-2">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-trending-up avatar-icon">
                                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                            <polyline points="17 6 23 6 23 12"></polyline>
                                        </svg>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $orders_count }}</h4>
                                    <p class="card-text font-small-3 mb-0">الطلبات</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-sm-6 col-12">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-success me-2">
                                    <div class="avatar-content">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-dollar-sign avatar-icon">
                                            <line x1="12" y1="1" x2="12" y2="23"></line>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <h4 class="fw-bolder mb-0">{{ $orders_sum }}</h4>
                                    <p class="card-text font-small-3 mb-0">الاجمالي</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card">
        <div
            class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
            <div class="header-left">
                <h4 class="card-title">تقارير الطلبات</h4>
            </div>
        </div>

        <div class="card-body">
            <form class="dt_adv_search">
                <div class="row g-1 mb-md-1">

                    <div style="margin-top: 5%" class="col-md-3">
                        <label class="form-label" for="basic-icon-default-date">طريقة الطلب</label>

                        <select name="order_method_id" class="form-select" id="name5221">
                            <option selected value="{{ null }}">الكل</option>

                            {{-- @foreach ($viewModel->orderMethod() as $orderMethodsData)
                                <option @if ($orderMethodsData['id'] == @$_GET['order_method_id']) selected @endif
                                    value="{{ $orderMethodsData['id'] }}">{{ $orderMethodsData['title'] }}</option>
                            @endforeach --}}

                        </select>

                    </div>

                    <div style="margin-top: 5%" class="col-md-3">
                        <label class="form-label" for="basic-icon-default-date">طريقة الدفع</label>

                        <select name="payment_method_id" class="form-select" id="name522">
                            <option selected value="{{ null }}">الكل</option>

                            {{-- @foreach ($viewModel->paymentMethod() as $paymentMethodData)
                                <option @if ($paymentMethodData['id'] == @$_GET['payment_method_id']) selected @endif
                                    value="{{ $paymentMethodData['id'] }}">{{ $paymentMethodData['title'] }}</option>
                            @endforeach --}}

                        </select>

                    </div>

                    <div style="margin-top: 5%" class="col-md-3">
                        <label class="form-label" for="basic-icon-default-date">حالة الطلب</label>

                        <select name="order_status_id" class="form-select" id="name511">
                            <option selected value="{{ null }}">الكل</option>

                            @foreach ($viewModel->orderStatus() as $orderStatusData)
                                <option @if ($orderStatusData['id'] == @$_GET['order_status_id']) selected @endif
                                    value="{{ $orderStatusData['id'] }}">{{ $orderStatusData['title'] }}</option>
                            @endforeach

                        </select>

                    </div>
                    <div style="margin-top: 5%" class="col-md-3">
                        <label class="form-label">من تاريخ</label>
                        <input type="text" name="from_date" id="fp-default" value="{{ @$_GET['from_date'] }}"
                            class="form-control flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD"
                            readonly="readonly">
                    </div>
                    <div style="margin-top: 5%" class="col-md-3">
                        <label class="form-label">الى تاريخ</label>
                        <input type="text" name="to_date" id="fp-default" value="{{ @$_GET['to_date'] }}"
                            class="form-control flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD"
                            readonly="readonly">
                    </div>
                    <div style="margin-top: 5%" class="col-md-3">
                        <label class="form-label">الفرع</label>
                        <select name="branch_id" class="form-select" id="name5">
                            <option selected value="{{ null }}">الكل</option>

                            {{-- @foreach ($viewModel->Branches() as $Branch)
                                <option @if ($Branch['id'] == @$_GET['branch_id']) selected @endif value="{{ $Branch['id'] }}">
                                    {{ $Branch['title'] }}</option>
                            @endforeach --}}

                        </select>

                    </div>

                    <input type="hidden" name="type" value="search">
                    <div style=" margin-top: 7%" class="col-md-1">
                        <button type="submit" class="btn btn-outline-primary">
                            <i data-feather="search"></i>
                            <span>بحث</span>
                        </button>
                    </div>


            </form>
        </div>
    </div>


    <div class="card">




        <!-- Bar Chart End -->
        <div class="row" id="basic-table">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">تقارير الطلبات</h4>
                        <div class="header-right">
                            <button onclick="printTable()" class="btn btn-outline-secondary waves-effect">
                                <i data-feather='printer'></i>طباعة
                            </button>

                            <form style="display:inline-block" action="{{ route('excel.export') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-success waves-effect">
                                    <i data-feather='file'></i>Excel
                                </button>
                            </form>

                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="printTable" class="table">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>الفرع</th>
                                    <th> حالة الطلب</th>
                                    <th> طريقة الطلب</th>
                                    <th> طريقة الدفع</th>
                                    <th> الاجمالى</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $Order)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $Order['uuid'] }}</span>
                                        </td>
                                        {{-- <td>{{ $Order->branch['title'] }}</td> --}}
                                        <td>{{ $Order->orderStatus['title'] }}</td>
                                        {{-- <td>{{ $Order->orderMethod['title'] }}</td> --}}
                                        {{-- <td>{{ $Order->paymentMethod['title'] }}</td> --}}
                                        <td>{{ $Order['total'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>

                </div>

            </div>
        </div>
        {{ $orders->appends($_GET)->links() }}
        <!-- Basic Tables end -->
    @endsection


    @section('js')
        <script src="{{ asset('') }}admin/vendors/js/forms/select/select2.full.min.js"></script>
        <script src="{{ asset('') }}admin/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
        <script src="{{ asset('') }}admin/vendors/js/pickers/pickadate/picker.js"></script>
        <script src="{{ asset('') }}admin/vendors/js/pickers/pickadate/picker.date.js"></script>
        <script src="{{ asset('') }}admin/js/scripts/forms/pickers/form-pickers.js"></script>
        <script>
            /*=========================================================================================
                                                                                            File Name: chart-apex.js
                                                                                            Description: Apexchart Examples
                                                                                            ----------------------------------------------------------------------------------------
                                                                                            Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
                                                                                            Author: PIXINVENT
                                                                                            Author URL: http://www.themeforest.net/user/pixinvent
                                                                                        ==========================================================================================*/

            $(window).on('load', function() {
                'use strict';
                initializeOrdersChart()

            });

            function osama() {
                const date = document.getElementById('date_from_to').value;
                const from = date.slice(0, 10);
                const to = date.slice(14, 24);
                if (to !== null && to !== '') {
                    initializeOrdersChart(from, to);
                }
            }

            function initializeOrdersChart(from = null, to = null) {
                var flatPicker = $('.flat-picker'),
                    isRtl = $('html').attr('data-textdirection') === 'rtl',
                    chartColors = {
                        area: {
                            series3: '#a4f8cd',
                            series2: '#60f2ca',
                            series1: '#2bdac7'
                        }
                    };
                // Init flatpicker
                if (flatPicker.length) {
                    if (from == null && to == null) {
                        var now = new Date();
                        var dd = now.getDate();

                        var mm = now.getMonth() + 1;
                        var yyyy = now.getFullYear();

                        var from = yyyy + '-' + (mm - 1) + '-' + dd;
                        var to = yyyy + '-' + mm + '-' + dd;

                    } else {
                        var from = from;
                        var to = to;
                    }
                    flatPicker.each(function() {
                        $(this).flatpickr({
                            mode: 'range',
                            defaultDate: [from, to]
                        });
                    });
                }

            }
        </script>

        <script>
            var select = $('.select2');

            select.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this.select2({
                    // the following code is used to disable x-scrollbar when click in select input and
                    // take 100% width in responsive also
                    dropdownAutoWidth: true,
                    width: '100%',
                    dropdownParent: $this.parent()
                });
            });


            function printTable() {
                let tableToPrint = document.getElementById('printTable').outerHTML;
                let originalBody = document.body.innerHTML
                document.body.innerHTML = tableToPrint;
                window.print()
                document.body.innerHTML = originalBody;

                // newWin = window.open("");
                // newWin.document.write('<html><head><link rel="stylesheet" href="print.css"></head><body>');
                // newWin.document.write(tableToPrint.outerHTML);
                // newWin.document.write('</body></html>');
                // newWin.print();
                // newWin.close();
            }
        </script>
    @endsection
