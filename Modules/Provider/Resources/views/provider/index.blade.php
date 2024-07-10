@extends('common::layouts.master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('') }}admin/css-rtl/plugins/extensions/ext-component-sweet-alerts.css">
@endsection
@section('content')
    <!-- Basic table -->
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body border-bottom">
                        <div class="row">
                            <form method="get" action="{{ url('admin/providers') }}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label" for="basic-icon-default-date">الاسم او الهاتف
                                        </label>
                                        <input type="text" value="{{ @$request['query'] }}" class="form-control"
                                            name="query" placeholder="ابحث بالاسم او الهاتف"/>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="basic-icon-default-date">الاقسام</label>
                                        <select class="select2 form-select dt-role" name="category_id">
                                            <option selected value={{ null }}>اختر تصنيف</option>
                                            @foreach (\Modules\Category\Entities\Category::all() as $category)
                                                <option value="{{ $category['id'] }}"
                                                    @if (isset($request['category_id']) && $request['category_id'] == $category['id']) selected @endif>
                                                    {{ $category['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button style="margin-top: 23px" type="submit"
                                            class="btn btn-primary data-submit me-1">بحث</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="datatables-basic table">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>id</th>
                                <th>الاسم</th>
                                <th>القسم</th>
                                <th>التاريخ</th>
                                <th>Slider</th>
                                <th>الحالة</th>
                                <th>الادوات</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </section>
    <!--/ Basic table -->
    {{ $providers->links() }}
@endsection


@section('js')
    @include('common::includes.datatable')


    {{-- <script src="{{asset('')}}admin/js/scripts/tables/table-datatables-basic.js"></script> --}}

    {{-- <script src="{{asset('')}}js/categories/script.js"></script> --}}

    @if (session('updated'))
        <script>
            Swal.fire({
                title: 'أحسنت!',
                text: 'لقد تم تعديل مقدم الخدمة بنجاح',
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        </script>
    @endif

    @if (session('created'))
        <script>
            Swal.fire({
                title: 'أحسنت!',
                text: 'لقد تم انشاء مقدم الخدمة بنجاح',
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        </script>
    @endif
    <script>
        $(function() {
            'use strict';
            var url = new URL(window.location.href);
            var ajaxRequest = 'providers?';
            var page = url.searchParams.get('page');
            var query = url.searchParams.get('query');
            var category = url.searchParams.get('category_id');
            if (page == null) page = 1;
            if (page != null) ajaxRequest += "page=" + page + '&';
            if (query != null) ajaxRequest += "query=" + query + "&";
            if (query != null) ajaxRequest += "category_id=" + category + "&";

            var dt_basic_table = $('.datatables-basic'),
                dt_date_table = $('.dt-date');
            if (dt_basic_table.length) {
                var dt_basic = dt_basic_table.DataTable({
                    ajax: ajaxRequest,
                    columns: [{
                            data: 'id'
                        }, // for responsive show
                        {
                            data: 'id'
                        }, // for checkbox
                        {
                            data: 'id'
                        }, // used for sorting so will hide this column
                        {
                            data: 'title.ar'
                        },
                        {
                            data: 'category.title.ar'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'is_slider',
                            render: function(data, type, full, meta) {
                                var checked = data == 1 ? 'checked' : '';
                                var toggleSwitch = '<div class="form-check form-switch">' +
                                    '<input class="form-check-input dt-toggle" type="checkbox" id="sliderToggle' +
                                    full.id + '" data-id="' + full.id + '" ' + checked + '>' +
                                    '<label class="form-check-label" for="sliderToggle' + full.id +
                                    '"></label>' +
                                    '</div>';
                                return toggleSwitch;
                            }
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'id'
                        },
                    ],
                    columnDefs: [{
                            // For Responsive
                            className: 'control',
                            orderable: false,
                            responsivePriority: 2,
                            targets: 0
                        },
                        {
                            // For Checkboxes
                            targets: 1,
                            orderable: false,
                            responsivePriority: 3,
                            render: function(data, type, full, meta) {
                                return (
                                    '<div class="form-check"> <input class="form-check-input dt-checkboxes" type="checkbox" value="" id="checkbox' +
                                    data +
                                    '" /><label class="form-check-label" for="checkbox' +
                                    data +
                                    '"></label></div>'
                                );
                            },
                            checkboxes: {
                                selectAllRender: '<div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="form-check-label" for="checkboxSelectAll"></label></div>'
                            }
                        },
                        {
                            targets: 2,
                            visible: false
                        },

                        {
                            // Avatar image/badge, Name and email
                            targets: 3,
                            responsivePriority: 4,
                            render: function(data, type, full, meta) {
                                var $user_img = full['image'],
                                    $name = data,
                                    $phone = full['phone'];
                                if ($user_img) {
                                    // $user_img = window.location.origin+'/uploads/provider/'+$user_img;
                                    // For Avatar image
                                    var $output =
                                        '<img src="' + $user_img +
                                        '" alt="Avatar" width="32" height="32">';
                                } else {
                                    // For Avatar badge
                                    var stateNum = full['is_active'];
                                    var states = ['info', 'primary'];
                                    var $state = states[stateNum],
                                        // $name = full['name'],
                                        $initials = $name.match(/\b\w/g) || [];
                                    $initials = (($initials.shift() || '') + ($initials.pop() ||
                                        '')).toUpperCase();
                                    $output = '<span class="avatar-content">' + $initials +
                                        '</span>';
                                }

                                var colorClass = $user_img === null ? ' bg-light-' + $state + ' ' :
                                    '';
                                // Creates full output for row
                                var $row_output =
                                    '<div class="d-flex justify-content-left align-items-center">' +
                                    '<div class="avatar ' +
                                    colorClass +
                                    ' me-1">' +
                                    $output +
                                    '</div>' +
                                    '<div class="d-flex flex-column">' +
                                    '<span class="emp_name text-truncate fw-bold">' +
                                    $name +
                                    '</span>' +
                                    '<small class="emp_post text-truncate text-muted">' +
                                    $phone +
                                    '</small>' +
                                    '</div>' +
                                    '</div>';
                                return $row_output;
                            }
                        },
                        {
                            // Label
                            targets: -2,
                            render: function(data, type, full, meta) {
                                var $status_number = full['is_active'];
                                var $status = {
                                    0: {
                                        title: 'غير مفعل',
                                        class: 'badge-light-danger'
                                    },
                                    1: {
                                        title: 'مفعل',
                                        class: ' badge-light-success'
                                    },
                                };
                                if (typeof $status[$status_number] === 'undefined') {
                                    return data;
                                }
                                return (
                                    '<span class="badge rounded-pill ' +
                                    $status[$status_number].class +
                                    '">' +
                                    $status[$status_number].title +
                                    '</span>'
                                );
                            }
                        },
                        {
                            // Actions
                            targets: -1,
                            title: 'الادوات',
                            orderable: false,
                            render: function(data, type, full, meta) {
                                var activation = '';
                                if (full['is_active'] == 0) activation = 'تفعيل';
                                else activation = 'الغاء تفعيل';
                                return (
                                    '<div class="d-inline-flex">' +
                                    '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                                    feather.icons['more-vertical'].toSvg({
                                        class: 'font-small-4'
                                    }) +
                                    '</a>' +
                                    '<div class="dropdown-menu dropdown-menu-end">'
                                    @can('Edit-provider')
                                        +
                                        '<a href="providers/activate/' + data +
                                            '" class="dropdown-item">' +
                                            feather.icons['file-text'].toSvg({
                                                class: 'font-small-4 me-50'
                                            }) +
                                            activation + '</a>'
                                    @endcan
                                    @can('Delete-provider')
                                        +
                                        '<a href="javascript:;" class="dropdown-item delete-record">' +
                                        feather.icons['trash-2'].toSvg({
                                                class: 'font-small-4 me-50'
                                            }) +
                                            'حذف</a>'
                                    @endcan +
                                    '</div>' +
                                    '</div>' +
                                    '  ' +
                                    '<a href="providers/' + data +
                                    '" class="item-edit">' +
                                    feather.icons['eye'].toSvg({
                                        class: 'font-small-4 me-50'
                                    }) +
                                    '</a>'

                                );
                            }
                        }
                    ],
                    order: [
                        [2, 'desc']
                    ],
                    dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    displayLength: 100,
                    lengthMenu: [7, 10, 25, 50, 75, 100],
                    buttons: [
                        @can('Create-provider')
                            // {
                            //     text: feather.icons['plus'].toSvg({
                            //         class: 'me-50 font-small-4'
                            //     }) + 'اضافة عنصر جديد',
                            //     className: 'create-new btn btn-primary',
                            //     // attr: {
                            //     //     'data-bs-toggle': 'modal',
                            //     //     'data-bs-target': '#modals-slide-in'
                            //     // },
                            //     action: function(e, dt, node, config) {
                            //         //This will send the page to the location specified
                            //         window.location.href = './providers/create';
                            //     },
                            //     init: function(api, node, config) {
                            //         $(node).removeClass('btn-secondary');
                            //     }
                            // }
                        @endcan
                    ],
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details of ' + data['title'];
                                }
                            }),
                            type: 'column',
                            renderer: function(api, rowIdx, columns) {
                                var data = $.map(columns, function(col, i) {
                                    return col.title !==
                                        '' // ? Do not show row in modal popup if title is blank (for check box)
                                        ?
                                        '<tr data-dt-row="' +
                                        col.rowIdx +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>' :
                                        '';
                                }).join('');

                                return data ? $('<table class="table"/>').append('<tbody>' + data +
                                    '</tbody>') : false;
                            }
                        }
                    },
                    language: {
                        paginate: {
                            // remove previous & next text from pagination
                            previous: '&nbsp;',
                            next: '&nbsp;'
                        }
                    }
                });


                // Switch button handler
                $(document).on('change', '.dt-toggle', function() {
                    var id = $(this).data('id');
                    var isChecked = $(this).prop('checked') ? 1 : 0;
                    var token = $("meta[name='csrf-token']").attr("content");


                    $.ajax({
                        url: window.location.origin + "/admin/providers/" + id,
                        type: 'POST',
                        data: {
                            "is_slider": isChecked,
                            "_method": "PUT",
                            "_token": token,
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'احسنت!',
                                text: 'تم تعديل مقدم الخدمة بنجاح',
                            })
                        },
                        error: function(xhr) {


                        }
                    });
                });

                // Switch button handler



                $('div.head-label').html('<h6 class="mb-0">البيانات الرئيسية</h6>');
            }

            // Flat Date picker
            if (dt_date_table.length) {
                dt_date_table.flatpickr({
                    monthSelectorType: 'static',
                    dateFormat: 'm/d/Y'
                });
            }

            // Delete Record
            $('.datatables-basic tbody').on('click', '.delete-record', function() {
                let that = this;
                var id = dt_basic.row($(this).parents('tr')).data().id
                var token = $("meta[name='csrf-token']").attr("content");
                Swal.fire({
                    title: 'هل انت متأكد من الحذف ؟ ',
                    text: "لن تتمكن من التراجع عن هذا!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'نعم ، احذفها!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    if (result.value) {
                        dt_basic.row($(that).parents('tr')).remove().draw();
                        $.ajax({
                            url: window.location.origin + "/admin/providers/" + id,
                            type: 'POST',
                            data: {
                                "id": id,
                                "_method": "DELETE",
                                "_token": token,
                            },
                            success: function() {}
                        });
                        Swal.fire({
                            icon: 'success',
                            title: 'تم الحذف!',
                            text: 'تم حذف الفئة.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });
            $('#DataTables_Table_0_paginate').hide();
        });
    </script>
@endsection
