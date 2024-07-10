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
    {{-- Date inputs --}}
     <link rel="stylesheet" href="{{ asset('') }}admin/css-rtl/plugins/forms/pickers/form-flat-pickr.css">
    {{-- <link rel="stylesheet" href="{{ asset('') }}admin/css-rtl/plugins/forms/pickers/form-pickadate.css"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('') }}admin/vendors/css/pickers/pickadate/pickadate.css"> --}}
@endsection
@section('content')
    {{-- Edit Modal --}}
    @include('order::ordermodals.edit')


    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    {{-- Start of Search and Filters --}}
                    <div class="card-body border-bottom">
                        <div class="row">
                            <form method="get" action="{{  url('admin/orders') }}">
                                <div class="row">
                                    {{-- Search by order no --}}
                                    <div class="col-md-3">
                                        <label class="form-label" for="basic-icon-default-date1">رقم الطلب
                                        </label>
                                        <input type="search" value="{{ @$request['order_no'] }}" class="form-control"
                                            name="order_no" placeholder="البحث برقم الطلب" id="basic-icon-default-date1" />
                                    </div>

                                    {{-- Search by date from --}}
                                    <div class="col-md-3">
                                        <label class="form-label" for="fp-default1">من</label>
                                        <input type="text" id="fp-default" value="{{ @$request['from_date'] }}" class="form-control flatpickr-basic"
                                            placeholder="YYYY-MM-DD" name="from_date" />
                                    </div>

                                    {{-- Search by date to --}}
                                    <div class="col-md-3">
                                        <label class="form-label" for="fp-default2">الي</label>
                                        <input type="text" id="fp-default" value="{{ @$request['to_date'] }}" class="form-control flatpickr-basic"
                                            placeholder="YYYY-MM-DD" name="to_date" />
                                    </div>

                                    <div class="col-md-2">
                                        <button style="margin-top: 23px" type="submit"
                                            class="btn btn-primary data-submit me-1">بحث</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- End of Search and Filters --}}
                    <table class="datatables-basic table">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>رقم الطلب</th>
                                <th>الاجمالي</th>
                                <th>الكمية</th>
                                <th>اسم مقدم الخدمة</th>
                                <th>حالة الطلب</th>
                                <th>تاريخ الانشاء</th>
                                <th>الخيارات</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
    {{ $orders->withQueryString()->links() }}
    <!--/ Basic table -->
@endsection


@section('js')
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/responsive.bootstrap5.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/tables/datatable/dataTables.rowGroup.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="{{ asset('') }}admin/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="{{ asset('') }}admin/js/scripts/forms/pickers/form-pickers.js"></script>

    {{-- <script src="{{ asset('') }}admin/vendors/js/pickers/pickadate/picker.time.js"></script> --}}
    {{-- <script src="{{ asset('') }}admin/vendors/js/pickers/pickadate/picker.date.js"></script> --}}
    {{-- <script src="{{ asset('') }}admin/vendors/js/pickers/pickadate/legacy.js"></script> --}}
    {{-- <script src="{{ asset('') }}admin/vendors/js/pickers/pickadate/picker.js"></script> --}}

    {{--    <script src="{{asset('')}}admin/js/scripts/tables/table-datatables-basic.js"></script> --}}

    {{-- <script src="{{asset('')}}js/order/order.js"></script> --}}

    @if (session('updated'))
        <script>
            Swal.fire({
                title: 'أحسنت!',
                text: 'لقد تم تعديل الطلب بنجاح',
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
            //var branch_id = url.searchParams.get("branch_id");
            var order_status_id = url.searchParams.get("order_status_id");
            var order_no = url.searchParams.get("order_no")
            var from_date = url.searchParams.get("from_date")
            var to_date = url.searchParams.get("to_date")
            var ajaxRequest = "orders?";
            var page = url.searchParams.get("page")
            if (page != null) {
                ajaxRequest += "page=" + page + '&';
            }
            // if (branch_id != null) {
            //     ajaxRequest += 'branch_id=' + branch_id + '&';
            // }
            if (order_status_id != null) {
                ajaxRequest += 'order_status_id=' + order_status_id + '&';
            }
            if (order_no != null) ajaxRequest += 'order_no=' + order_no + '&';
            if (from_date != null) ajaxRequest += 'from_date=' + from_date + '&';
            if (to_date != null) ajaxRequest += 'to_date=' + to_date + '&';


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
                            data: 'order_no'
                        },
                        {
                            data: 'total'
                        },
                        {
                            data: 'quantity'
                        },
                         {
                            data: 'provider.title.ar'
                        },
                        {
                            data: 'order_status.title.ar'
                        },
                        {
                            data: 'created_at'
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
                        // {
                        //     // Label
                        //     targets: -4,
                        //     render: function(data, type, full, meta) {
                        //         var $payment_method_title = data;
                        //         if ($payment_method_title == null) {
                        //             return 'لم يتم التحديد بعد'
                        //         }
                        //         return $payment_method_title;

                        //     }
                        // },
                        // {
                        //     // Actions
                        //     targets: -2,
                        //     title: 'تاريخ الانشاء',
                        //     orderable: false,
                        //     render: function(data, type, full, meta) {
                        //         var date = new Date(data).setTime(new Date(data).getTime() + 3 *
                        //             60 * 60 * 1000);
                        //         var createdDate = new Date(date);
                        //         var date = createdDate.toLocaleDateString();

                        //         var day = createdDate.getDate();
                        //         var month = createdDate.getMonth() + 1; //months are zero based
                        //         var year = createdDate.getFullYear();

                        //         var time = createdDate.toLocaleTimeString().replace(/(.*)\D\d+/,
                        //             '$1');

                        //         return year + '-' + month + '-' + day + ' ' + time;
                        //     }
                        // },
                        {
                            // Actions
                            targets: -1,
                            title: 'Actions',
                            orderable: false,
                            render: function(data, type, full, meta) {
                                return (
                                    '<div class="d-inline-flex">' +
                                    '<a href="orders/' + data + '" class="pe-1">' +
                                    feather.icons['eye'].toSvg({
                                        class: 'font-small-4'
                                    }) +
                                    '</a>' +
                                    '</div>' +

                                    '<button onclick=getOrder(' + full['order_status_id'] +
                                    ',' + full['id'] + ',' + full['branch_id'] +
                                    ') type="button" class="btn btn-icon btn-flat-primary" data-bs-toggle="modal" data-bs-target="#changeModal">' +
                                    feather.icons['edit'].toSvg({
                                        class: 'font-small-4'
                                    }) +
                                    '</button>'

                                    // '<a href="orders/'+data+'/edit">' +
                                    // feather.icons['edit'].toSvg({ class: 'font-small-4' }) +
                                    // '</a>'

                                );
                            }
                        }
                    ],
                    order: [
                        [2, 'desc']
                    ],
                    dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    displayLength: 100,
                    bPaginate: false,
                    lengthMenu: [7, 10, 25, 50, 75, 100],
                    buttons: [{
                        extend: 'collection',
                        className: 'btn btn-outline-secondary dropdown-toggle me-2',
                        text: feather.icons['share'].toSvg({
                            class: 'font-small-4 me-50'
                        }) + 'Export',
                        buttons: [{
                                extend: 'print',
                                text: feather.icons['printer'].toSvg({
                                    class: 'font-small-4 me-50'
                                }) + 'Print',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'csv',
                                text: feather.icons['file-text'].toSvg({
                                    class: 'font-small-4 me-50'
                                }) + 'Csv',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'excel',
                                text: feather.icons['file'].toSvg({
                                    class: 'font-small-4 me-50'
                                }) + 'Excel',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'pdf',
                                text: feather.icons['clipboard'].toSvg({
                                    class: 'font-small-4 me-50'
                                }) + 'Pdf',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7]
                                }
                            },
                            {
                                extend: 'copy',
                                text: feather.icons['copy'].toSvg({
                                    class: 'font-small-4 me-50'
                                }) + 'Copy',
                                className: 'dropdown-item',
                                exportOptions: {
                                    columns: [3, 4, 5, 6, 7]
                                }
                            }
                        ],
                        init: function(api, node, config) {
                            $(node).removeClass('btn-secondary');
                            $(node).parent().removeClass('btn-group');
                            setTimeout(function() {
                                $(node).closest('.dt-buttons').removeClass('btn-group')
                                    .addClass('d-inline-flex');
                            }, 50);
                        }
                    }, ],
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function(row) {
                                    var data = row.data();
                                    return 'Details of ' + data['uuid'];
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
                $('div.head-label').html('<h6 class="mb-0">DataTable with Buttons</h6>');
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
                    title: 'هل انت متأكد من الالغاء ؟ ',
                    text: "لن تتمكن من التراجع عن هذا!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'نعم ، الغاء!',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-outline-danger ms-1'
                    },
                    buttonsStyling: false
                }).then(function(result) {
                    // dt_basic.row($(that).parents('tr')).remove().draw();
                    $.ajax({
                        url: window.location.origin + "/admin/orders/" + id,
                        type: 'POST',
                        data: {
                            "id": id,
                            "_method": "DELETE",
                            "_token": token,
                        },
                        success: function() {}
                    });
                    if (result.value) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم الالغاء!',
                            text: 'تم الغاء الطلب.',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                    dt_basic.ajax.reload();
                });
            });
        });
    </script>

    <script>
        //Modal Order Details
        function getOrder(orderStatusId, orderId, branchId) {
            let url = '{{ url('admin/branch/drivers/') }}/' + branchId
            document.getElementById("order_id").value = orderId
            let selectStatuses = document.getElementById("statuses");

            // driver div and select
            let driversDiv = document.getElementById("drivers");
            let driversSelect = document.getElementById("driver_id");

            let button = document.getElementById("next-status")
            let cancelButton = document.getElementById("cancel-button")
            driversSelect.innerHTML = '';

            //Api to get Drivers of Each Branch
            $.get(url, function(drivers) {
                let disabledOption = document.createElement("option");
                disabledOption.disabled = true;
                disabledOption.selected = true;
                disabledOption.text = 'اختر السائق'
                driversSelect.appendChild(disabledOption)
                for (let i = 0; i < drivers.length; i++) {
                    let option = document.createElement("option");
                    option.value = drivers[i].id;
                    option.text = drivers[i].name;
                    driversSelect.appendChild(option);
                }

            })

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

        // To display the Drivers
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
