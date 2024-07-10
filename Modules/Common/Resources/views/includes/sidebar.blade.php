@php
    $route = Route::current()->getName();
@endphp
<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand"
                                            href="../../../html/rtl/vertical-menu-template/index.html">
                    <span class="brand-logo" style="display: flex; align-items: center;">
                        <img src="{{ asset('admin/logo.jpg') }}" alt="" style="max-height: 100px;">
                        <h2 class="brand-text" style="margin-right: 10px;">Wedding</h2>
                    </span>

                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="{{$route == 'admin.dashboard'?'active' :''}}"><a class="d-flex align-items-center"
                                                                        href="{{route('admin.dashboard')}}"><i
                        data-feather="circle"></i><span class="menu-item text-truncate"
                                                        data-i18n="eCommerce">الرئيسية</span></a>
            </li>
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps &amp; Pages</span><i
                    data-feather="more-horizontal"></i>
            </li>

            @if(auth()->user()->can('Index-admin') ||
                auth()->user()->can('Index-branch') ||
                auth()->user()->can('Index-driver') ||
                auth()->user()->can('Index-role')||
                auth()->user()->can('Index-employee')||
                auth()->user()->can('Index-client') ||
                auth()->user()->can('Index-provider'))

                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">ادارة العضويات</span></a>
                    <ul class="menu-content">
                        @can('Index-admin')
                            <li class="nav-item {{$route == 'admins.index'?'active' :''}}"><a
                                    class="d-flex align-items-center" href="{{url('admin/admins')}}"><i
                                        data-feather="user-check"></i><span class="menu-title text-truncate"
                                                                            data-i18n="Email">المديرين</span></a>
                            </li>
                        @endcan

                        @can('Index-role')
                            <li class="nav-item {{$route == 'roles.index'?'active' :''}}"><a
                                    class="d-flex align-items-center" href="{{url('admin/roles')}}"><i
                                        data-feather='shield'></i><span class="menu-title text-truncate"
                                                                        data-i18n="Email">الوظائف</span></a>
                            </li>
                        @endcan

                        @can('Index-client')
                            <li class="nav-item {{$route == 'clients.index'?'active' :''}}"><a
                                    class="d-flex align-items-center" href="{{url('admin/clients')}}"><i
                                        data-feather='users'></i><span class="menu-title text-truncate"
                                                                       data-i18n="Email">العملاء</span></a>
                            </li>
                        @endcan

                           @can('Index-provider')
                            <li class="nav-item {{$route == 'providers.index'?'active' :''}}"><a
                                    class="d-flex align-items-center" href="{{url('admin/providers')}}"><i
                                        data-feather='users'></i><span class="menu-title text-truncate"
                                                                       data-i18n="Email">مقدمين الخدمات</span></a>
                            </li>
                        @endcan


                    </ul>
                </li>

            @endif

            @can('Index-order')
                <li class=" nav-item {{$route == 'orders.index'?'sidebar-group-active open' :''}} "><a
                        class="d-flex align-items-center" href="#"><i data-feather="file-text"></i><span
                            class="menu-title text-truncate" data-i18n="Invoice">الطلبات</span></a>
                    <ul class="menu-content">
                        <li class="@if(!app('request')->input('order_status_id') && $route == 'orders.index') active @endif">
                            <a class="d-flex align-items-center" href="{{url('admin/orders')}}"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">كل الطلبات</span></a>
                        </li>
                        <li class="@if(app('request')->input('order_status_id') && app('request')->input('order_status_id') ==1) active @endif">
                            <a class="d-flex align-items-center" href="{{url('admin/orders?order_status_id=1')}}"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">تم ارسال الطلب للفرع</span></a>
                        </li>
                        <li class="@if(app('request')->input('order_status_id') && app('request')->input('order_status_id') ==2) active @endif">
                            <a class="d-flex align-items-center" href="{{url('admin/orders?order_status_id=2')}}"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Edit">مقبول وجاري التحضير</span></a>
                        </li>
                        <li class="@if(app('request')->input('order_status_id') && app('request')->input('order_status_id') ==3) active @endif">
                            <a class="d-flex align-items-center" href="{{url('admin/orders?order_status_id=3')}}"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add">تسليم الطلب للسائق</span></a>
                        </li>
                        <li class="@if(app('request')->input('order_status_id') && app('request')->input('order_status_id') ==4) active @endif">
                            <a class="d-flex align-items-center" href="{{url('admin/orders?order_status_id=4')}}"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add">جاري التوصيل للعميل</span></a>
                        </li>
                        <li class="@if(app('request')->input('order_status_id') && app('request')->input('order_status_id') ==5) active @endif">
                            <a class="d-flex align-items-center" href="{{url('admin/orders?order_status_id=5')}}"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add">تم التوصيل بنجاح</span></a>
                        </li>
                        <li class="@if(app('request')->input('order_status_id') && app('request')->input('order_status_id') ==6) active @endif">
                            <a class="d-flex align-items-center" href="{{url('admin/orders?order_status_id=6')}}"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add">الطلبات المرفوضة من السائق</span></a>
                        </li>
                        <li class="@if(app('request')->input('order_status_id') && app('request')->input('order_status_id') ==7) active @endif">
                            <a class="d-flex align-items-center" href="{{url('admin/orders?order_status_id=7')}}"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add">فشل في توصيل الطلب للعميل</span></a>
                        </li>
                        <li class="@if(app('request')->input('order_status_id') && app('request')->input('order_status_id') ==8) active @endif">
                            <a class="d-flex align-items-center" href="{{url('admin/orders?order_status_id=8')}}"><i
                                    data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Add">تم الغاء الطلب</span></a>
                        </li>
                    </ul>
                </li>
            @endcan

            @if(auth()->user()->can('Index-category') ||
                auth()->user()->can('Index-service') ||
                auth()->user()->can('Index-product'))

                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">ادارة الاقسام</span></a>
                    <ul class="menu-content">
                        @can('Index-category')
                            <li class="nav-item {{$route == 'categories.index'?'active' :''}}"><a
                                    class="d-flex align-items-center" href="{{url('admin/categories')}}"><i
                                        data-feather='users'></i><span class="menu-title text-truncate"
                                                                       data-i18n="Email">الاقسام</span></a>
                            </li>
                        @endcan
                            @can('Index-service')
                            <li class="nav-item {{$route == 'services.index'?'active' :''}}"><a
                                    class="d-flex align-items-center" href="{{url('admin/services')}}"><i
                                        data-feather='users'></i><span class="menu-title text-truncate"
                                                                       data-i18n="Email">الخدمات الرئيسية</span></a>
                            </li>
                        @endcan
                            @can('Index-service')
                                <li class="nav-item {{$route == 'sub_services.index'?'active' :''}}"><a
                                        class="d-flex align-items-center" href="{{url('admin/sub_services')}}"><i
                                            data-feather='users'></i><span class="menu-title text-truncate"
                                                                           data-i18n="Email">الخدمات الفرعية</span></a>
                                </li>
                            @endcan

                    </ul>
                </li>

            @endif

            @can('Index-coupon')
                <li class="nav-item {{$route == 'coupons.index'?'active' :''}}"><a class="d-flex align-items-center"
                                                                                   href="{{url('admin/coupons')}}"><i
                            data-feather='users'></i><span class="menu-title text-truncate" data-i18n="Email">كوبونات الخصم</span></a>
                </li>
            @endcan

            @can('Index-report')
                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">التقارير</span></a>
                    <ul class="menu-content">
                        <li class="nav-item {{$route == 'reports.clients'?'active' :''}}"><a
                                class="d-flex align-items-center" href="{{url('admin/clinetReport')}}"><i
                                    data-feather='user'></i><span class="menu-title text-truncate" data-i18n="Email">العملاء</span></a>
                        </li>

                        <li class="nav-item {{$route == 'reports.products'?'active' :''}}"><a
                                class="d-flex align-items-center" href="{{url('admin/productReport')}}"><i
                                    data-feather='user'></i><span class="menu-title text-truncate" data-i18n="Email">الاصناف الاعلى مبيعا</span></a>
                        </li>
                        <li class="nav-item {{$route == 'reports.categories'?'active' :''}}"><a
                                class="d-flex align-items-center" href="{{url('admin/categoriesReport')}}"><i
                                    data-feather='user'></i><span class="menu-title text-truncate" data-i18n="Email">الفئات الاعلى مبيعا</span></a>
                        </li>

                        <li class="nav-item {{$route == 'reports.orders'?'active' :''}}"><a
                                class="d-flex align-items-center" href="{{url('admin/ordersReport')}}"><i
                                    data-feather='user'></i><span class="menu-title text-truncate" data-i18n="Email">تقارير  الطلبات</span></a>
                        </li>
                    </ul>
                </li>
            @endcan


            @if(auth()->user()->can('Index-ordermethod') ||
                auth()->user()->can('Index-paymentmethods') ||
                auth()->user()->can('Index-orderstatus'))

                <li class=" nav-item "><a class="d-flex align-items-center" href="#"><i
                            data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Invoice">بيانات اساسية</span></a>
                    <ul class="menu-content">

                        @can('Index-orderstatus')
                            <li class="nav-item {{$route == 'orderstatus.index'?'active' :''}}"><a
                                    class="d-flex align-items-center" href="{{url('admin/orderstatus')}}"><i
                                        data-feather='shopping-cart'></i><span class="menu-title text-truncate"
                                                                               data-i18n="Email">حالات الطلب</span></a>
                            </li>
                        @endcan


                    </ul>
                </li>

            @endif


            @can('Create-notification')
                <li class="nav-item {{$route == 'notifications.create'?'active' :''}}"><a
                        class="d-flex align-items-center" href="{{url('admin/notifications/')}}"><i
                            data-feather='users'></i><span class="menu-title text-truncate"
                                                           data-i18n="Email">الاشعارات</span></a>
                </li>
            @endcan


            @can('Index-setting')
                <li class="nav-item {{$route == 'setting.index'?'active' :''}}"><a class="d-flex align-items-center"
                                                                                   href="{{url('admin/setting')}}"><i
                            data-feather='settings'></i><span class="menu-title text-truncate" data-i18n="Email">الاعدادات</span></a>
                </li>
            @endcan

            @can('Index-log')
                <li class="nav-item {{$route == 'logs.index'?'active' :''}}"><a class="d-flex align-items-center"
                                                                                href="{{url('admin/logs')}}"><i
                            data-feather='shopping-cart'></i><span class="menu-title text-truncate" data-i18n="Email">السجل</span></a>
                </li>
            @endcan
        </ul>

    </div>
</div>
<!-- END: Main Menu-->
