@extends('common::layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/pages/app-invoice.css">
@endsection

@section('content')
    @include('order::ordermodals.edit')
    <div class="content-body">
        <section class="invoice-preview-wrapper">
            <div class="row invoice-preview">
                <!-- Invoice -->
                <div class="col-xl-12 col-md-8 col-12">
                    <div class="card invoice-preview-card">
                        <div class="card-body invoice-padding pb-0">
                            <!-- Header starts -->
                            <div class="d-flex justify-content-between flex-md-row flex-column invoice-spacing mt-0">
                                <div>
                                    <div class="logo-wrapper">
                                        {{-- <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" height="24">
                                            <defs>
                                                <linearGradient id="invoice-linearGradient-1" x1="100%"
                                                    y1="10.5120544%" x2="50%" y2="89.4879456%">
                                                    <stop stop-color="#000000" offset="0%"></stop>
                                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                                </linearGradient>
                                                <linearGradient id="invoice-linearGradient-2" x1="64.0437835%"
                                                    y1="46.3276743%" x2="37.373316%" y2="100%">
                                                    <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                                                    <stop stop-color="#FFFFFF" offset="100%"></stop>
                                                </linearGradient>
                                            </defs>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-400.000000, -178.000000)">
                                                    <g transform="translate(400.000000, 178.000000)">
                                                        <path class="text-primary"
                                                            d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                                            style="fill: currentColor"></path>
                                                        <path
                                                            d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                                            fill="url(#invoice-linearGradient-1)" opacity="0.2"></path>
                                                        <polygon fill="#000000" opacity="0.049999997"
                                                            points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325">
                                                        </polygon>
                                                        <polygon fill="#000000" opacity="0.099999994"
                                                            points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338">
                                                        </polygon>
                                                        <polygon fill="url(#invoice-linearGradient-2)" opacity="0.099999994"
                                                            points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288">
                                                        </polygon>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg> --}}
                                        <img style="height:40px" src="{{ asset('admin/logo.jpg') }}" alt="">
                                        <h3 class="text-primary invoice-logo">Wedding</h3>
                                    </div>
                                    {{-- <p class="card-text mb-25">الفرع : {{ $order['branch']['title'] }}</p> --}}
                                    @isset($order['client'])
                                        <p class="card-text mb-25">اسم العميل : {{ $order['client']['name'] }}</p>
                                        <p class="card-text mb-25">رقم هاتف العميل : {{ $order['client']['phone'] }}</p>
                                    @endisset
                                    @isset($order['provider'])
                                        <p class="card-text mb-25">اسم مقدم الخدمة : {{ $order['provider']['title'] }}</p>

                                    @endisset
                                    {{-- <p class="card-text mb-25">المدينة : {{ $order->city->title }}</p> --}}
                                    {{-- <p class="card-text mb-25"><a
                                            href="https://www.google.com/maps/search/?api=1&query={{ $order->address->lat }},{{ $order->address->long }}">اضغط
                                            هنا لعرض موقع العميل</a></p> --}}

                                    @isset($order['driver_id'])
                                        <p class="card-text mb-25">اسم السائق : {{ $order['driver']['name'] }}</p>
                                        <p class="card-text mb-25">رقم هاتف السائق : {{ $order['driver']['phone'] }}</p>
                                    @endisset
                                </div>


                                <div class="mt-md-0 mt-2">
                                    <h4 class="invoice-title">
                                        Order
                                        <span class="invoice-number">{{ $order['uuid'] }}</span>
                                    </h4>
                                    <div class="invoice-date-wrapper">
                                        <p class="invoice-date-title">تــاريــخ الانشـــاء:</p>
                                        <p class="invoice-date">{{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                                    </div>
                                    <div class="invoice-date-wrapper">
                                        <p class="invoice-date-title">وقـــــت الانشـــاء:</p>
                                        <p class="invoice-date">
                                            {{ date('H:i', strtotime($order->created_at . ' +3 hours')) }}
                                        </p>
                                    </div>
                                    <button type="button" class="btn btn-icon btn-outline-info"
                                        onclick="getOrder({{ $order->order_status_id }},{{ $order->id }})"
                                        data-bs-toggle="modal" data-bs-target="#changeModal">
                                        <i data-feather='activity'></i>
                                    </button>
                                </div>
                            </div>
                            <!-- Header ends -->
                        </div>

                        <hr class="invoice-spacing" />

                        <!-- Address and Contact starts -->
                        <div class="card-body invoice-padding pt-0">
                            <div class="row invoice-spacing">
                                <div class="col-xl-8 p-0">
                                    <h6 class="mb-2">تفاصيل الطلب:</h6>
                                    <h6 class="mb-25">حالة الطلب : {{ $order['orderStatus']['title'] }}</h6>
                                    {{-- <h6 class="mb-25">طريقة الطلب : {{ $order['orderMethod']['title'] }}</h6> --}}
                                </div>
                                <div class="col-xl-4 p-0 mt-xl-0 mt-2">
                                    <h6 class="mb-2">تفاصيل الدفع:</h6>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="pe-1">طريقة الدفع:</td>
                                                {{-- <td><span class="fw-bold">{{ $order['paymentMethod']['title'] }}</span> --}}
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Address and Contact ends -->

                        <!-- Invoice Description starts -->
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="py-1">اسم المنتج</th>
                                        <th class="py-1">الكمية</th>
                                        <th class="py-1">الخصائص</th>
                                        <th class="py-1">الاجمالي</th>
                                        <th class="py-1">الملاحظات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order['details'] as $detail)
                                        <tr>
                                            <td class="py-1">
                                                <p class="card-text fw-bold mb-25">{{ $detail['product']['title'] }}</p>
                                                {{--                                            <p class="card-text text-nowrap"> --}}
                                                {{--                                                {{$detail['product']['description']}} --}}
                                                {{--                                            </p> --}}
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{ $detail['quantity'] }}</span>
                                            </td>

                                            <td class="py-1">
                                                <span class="fw-bold">
                                                    @foreach ($detail['attributes'] as $attribute)
                                                        {{ $attribute->attribute->title }} :
                                                        {{ $attribute->attributeValue->value }}
                                                    @endforeach
                                                </span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">{{ $detail['total'] }}</span>
                                            </td>
                                            <td class="py-1">
                                                <span class="fw-bold">
                                                    {{ $detail['note'] }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-body invoice-padding pb-0">
                            <div class="row invoice-sales-total-wrapper">
                                <div class="col-md-6 order-md-1 order-2 mt-md-0 mt-3">

                                    @if ($order['notes'])
                                        <p class="card-text mb-0">
                                            <span class="fw-bold">الملاحظات:</span> <span
                                                class="ms-75">{{ $order['notes'] }}</span>
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-6 d-flex justify-content-end order-md-2 order-1">
                                    <div class="invoice-total-wrapper">
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">السعر قبل الخصم:</p>
                                            <p class="invoice-total-amount">+ {{ $order['subtotal'] }}</p>
                                        </div>
                                        {{--                                            <div class="invoice-total-item"> --}}
                                        {{--                                                <p class="invoice-total-title">Discount:</p> --}}
                                        {{--                                                <p class="invoice-total-amount">$28</p> --}}
                                        {{--                                            </div> --}}
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">الضريبة:</p>
                                            <p class="invoice-total-amount">+ {{ $order['tax'] }}</p>
                                        </div>
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">تكلفة التوصيل:</p>
                                            <p class="invoice-total-amount">+ {{ $order['delivery_fee'] }}</p>
                                        </div>
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">الخصم:</p>
                                            <p class="invoice-total-amount">- {{ $order['discount'] }}</p>
                                        </div>
                                        <p>
                                            @if ($order['coupon_id'] ?? null)
                                                @if ($order['coupon']['discount_on'] == 'subtotal')
                                                    ( علي المنتجات فقط )
                                                @elseif($order['coupon']['discount_on'] == 'delivery')
                                                    ( علي قيمة التوصيل فقط )
                                                @elseif($order['coupon']['discount_on'] == 'both')
                                                    ( علي المنتجات وقيمة التوصيل معاً )
                                                @endif
                                            @endif
                                        </p>
                                        <hr class="my-50" />
                                        <div class="invoice-total-item">
                                            <p class="invoice-total-title">الاجمالي:</p>
                                            <p class="invoice-total-amount">{{ $order['total'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Invoice Description ends -->

                        <hr class="invoice-spacing" />


                    </div>
                </div>
                <!-- /Invoice -->
                <!-- Invoice Description ends -->

                @if ($order->driver_delivery_image ?? null)
                    <hr class="invoice-spacing" />
                    <p class="invoice-total-title">صورة التسليم :</p>

                    <div class="images-container  d-flex flex-row flex-wrap"
                        style="display: flex !important;margin-right:25%">

                        <div class="image-container position-relative" style="width: 100px; height: 100px">
                            <img style="width: 100%; height: 100%" src="{{ asset($order->driver_delivery_image) }}">
                        </div>

                    </div>
                @endif

                @if ($order['rate'])
                    <hr class="invoice-spacing" />


                    <div class="col-xl-8 p-0">
                        <h5 class="mb-2 py-1">التقييم</h6>
                    </div>


                    <!-- Invoice Description starts -->
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="py-1">اسم الشخص</th>
                                    <th class="py-1">تقييم الفرع</th>
                                    <th class="py-1">تقييم الطلب</th>
                                    @if ($order->order_method_id == 4)
                                        <th class="py-1">تقييم السائق</th>
                                    @endif
                                    <th class="py-1">الملاحظة</th>
                                    <th class="py-1">تاريخ الانشاء</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="py-1">
                                        <p class="card-text fw-bold mb-25">{{ $order['client']['name'] }}</p>
                                        {{-- <p class="card-text text-nowrap"> --}}
                                        {{-- {{$detail['product']['description']}} --}}
                                        {{-- </p> --}}
                                    </td>
                                    <td class="py-1">
                                        <span class="fw-bold">{{ $order['rate']['branch_rate'] . ' / 5' }}</span>
                                    </td>

                                    <td class="py-1">
                                        <span class="fw-bold">{{ $order['rate']['order_rate'] . ' / 5' }}</span>
                                    </td>

                                    @if ($order->order_method_id == 4)
                                        <td class="py-1">
                                            <span class="fw-bold">{{ $order['rate']['driver_rate'] . ' / 5' }}</span>
                                        </td>
                                    @endif

                                    <td class="py-1">
                                        <span class="fw-bold">{{ $order['rate']['comment'] }}</span>
                                    </td>

                                    <td class="py-1">
                                        <span class="fw-bold">{{ $order['rate']['created_at'] }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
                <hr class="invoice-spacing" />


                <div class="col-xl-8 p-0">
                    <h5 class="mb-2 py-1">السجل الخاص بالطلب</h6>
                </div>


                <!-- Invoice Description starts -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="py-1">اسم الشخص</th>
                                <th class="py-1">النوع</th>
                                <th class="py-1">حالة الطلب</th>
                                <th class="py-1">الملاحظة</th>
                                <th class="py-1">تاريخ الانشاء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order['histories'] as $history)
                                <tr>
                                    <td class="py-1">
                                        <p class="card-text fw-bold mb-25">{{ $history['historible']['name'] }}</p>
                                        {{--                                            <p class="card-text text-nowrap"> --}}
                                        {{--                                                {{$detail['product']['description']}} --}}
                                        {{--                                            </p> --}}
                                    </td>
                                    <td class="py-1">
                                        <span
                                            class="fw-bold">{{ substr($history['historible_type'], strpos($history['historible_type'], 'Entities') + 9) }}</span>
                                    </td>

                                    <td class="py-1">
                                        <span class="fw-bold">{{ $history['status']['title'] }}</span>
                                    </td>

                                    <td class="py-1">
                                        <span class="fw-bold">{{ $history['notes'] }}</span>
                                    </td>

                                    <td class="py-1">
                                        <span class="fw-bold">{{ $history['created_at'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Invoice Note starts -->

            </div>
        </section>


    </div>
    <script>
        function getOrder(orderStatusId, orderId) {
            document.getElementById("order_id").value = orderId
            let selectStatuses = document.getElementById("statuses");
            let selectDrivers = document.getElementById("drivers");
            let button = document.getElementById("next-status")
            let cancelButton = document.getElementById("cancel-button")
            for (var i = 0; i < selectStatuses.options.length; i++) {
                var option = selectStatuses.options[i];

                if (option.value == orderStatusId) {
                    option.selected = true;
                    if (option.value > 4) {
                        button.style.display = "none";
                    } else {
                        button.style.display = "block";
                        button.textContent = selectStatuses.options[i + 1].text
                        button.value = orderStatusId + 1
                    }
                }
            }

            if (button.value == 3) {
                document.getElementById("drivers").style.display = 'block';
            } else {
                document.getElementById("drivers").style.display = 'none';
            }

            //display Canacel Button
            if (orderStatusId == 1) {
                cancelButton.style.display = "block";

            } else {
                cancelButton.style.display = "none";
            }

        }

        function checkStatus() {
            let statusId = document.getElementById("statuses").value;
            console.log(statusId)
            if (statusId == 3) {
                document.getElementById("drivers").style.display = 'block';

            } else {

                document.getElementById("drivers").style.display = 'none';
            }
        }
    </script>
@endsection
