$(function () {
    "use strict";
    var dt_basic_table = $(".datatables-basic"),
        dt_date_table = $(".dt-date");
    if (dt_basic_table.length) {
        var dt_basic = dt_basic_table.DataTable({
            ajax: "branches",
            columns: [
                { data: "id" }, // for responsive show
                { data: "id" }, // for checkbox
                { data: "id" }, // used for sorting so will hide this column
                { data: "title" },
                { data: "created_at" },
                { data: "status" },
                { data: "id" },
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: "control",
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                },
                {
                    // For Checkboxes
                    targets: 1,
                    orderable: false,
                    responsivePriority: 3,
                    render: function (data, type, full, meta) {
                        return (
                            '<div class="form-check"> <input class="form-check-input dt-checkboxes" type="checkbox" value="" id="checkbox' +
                            data +
                            '" /><label class="form-check-label" for="checkbox' +
                            data +
                            '"></label></div>'
                        );
                    },
                    checkboxes: {
                        selectAllRender:
                            '<div class="form-check"> <input class="form-check-input" type="checkbox" value="" id="checkboxSelectAll" /><label class="form-check-label" for="checkboxSelectAll"></label></div>',
                    },
                },
                {
                    targets: 2,
                    visible: false,
                },
                {
                    // Avatar image/badge, Name and email
                    targets: 3,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        var $user_img = full["image"],
                            $name = data;
                        if ($user_img) {
                            $user_img =
                                window.location.origin +
                                "/uploads/branch/" +
                                $user_img;
                            // For Avatar image
                            var $output =
                                '<img src="' +
                                $user_img +
                                '" alt="Avatar" width="32" height="32">';
                        } else {
                            // For Avatar badge
                            var stateNum = full["is_active"];
                            var states = ["info", "primary"];
                            var $state = states[stateNum],
                                // $name = full['name'],
                                $initials = $name.match(/\b\w/g) || [];
                            $initials = (
                                ($initials.shift() || "") +
                                ($initials.pop() || "")
                            ).toUpperCase();
                            $output =
                                '<span class="avatar-content">' +
                                $initials +
                                "</span>";
                        }

                        var colorClass =
                            $user_img === null
                                ? " bg-light-" + $state + " "
                                : "";
                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-left align-items-center">' +
                            '<div class="avatar ' +
                            colorClass +
                            ' me-1">' +
                            $output +
                            "</div>" +
                            '<div class="d-flex flex-column">' +
                            '<span class="emp_name text-truncate fw-bold">' +
                            $name +
                            "</span>" +
                            "</div>" +
                            "</div>";
                        return $row_output;
                    },
                },
                {
                    // Label
                    targets: -2,
                    render: function (data, type, full, meta) {
                        var $status_number = full["is_active"];
                        var $status = {
                            0: {
                                title: "Not Active",
                                class: "badge-light-danger",
                            },
                            1: {
                                title: "Active",
                                class: " badge-light-success",
                            },
                        };
                        if (typeof $status[$status_number] === "undefined") {
                            return data;
                        }
                        return (
                            '<span class="badge rounded-pill ' +
                            $status[$status_number].class +
                            '">' +
                            $status[$status_number].title +
                            "</span>"
                        );
                    },
                },
                {
                    // Actions
                    targets: -1,
                    title: "Actions",
                    orderable: false,
                    render: function (data, type, full, meta) {
                        var activation = "";
                        if (full["is_active"] == 0) activation = "Activate";
                        else activation = "الغاء تفعيل";
                        return (
                            '<div class="d-inline-flex">' +
                            '<a class="pe-1 dropdown-toggle hide-arrow text-primary" data-bs-toggle="dropdown">' +
                            feather.icons["more-vertical"].toSvg({
                                class: "font-small-4",
                            }) +
                            "</a>" +
                            '<div class="dropdown-menu dropdown-menu-end">' +
                            '<a href="branch/' +
                            data +
                            '/products" class="dropdown-item">' +
                            feather.icons["file-text"].toSvg({
                                class: "font-small-4 me-50",
                            }) +
                            "Products</a>" +
                            '<div class="dropdown-menu dropdown-menu-end">' +
                            '<a href="branches/activate/' +
                            data +
                            '" class="dropdown-item">' +
                            feather.icons["file-text"].toSvg({
                                class: "font-small-4 me-50",
                            }) +
                            activation +
                            "</a>" +
                            '<a href="javascript:;" class="dropdown-item delete-record">' +
                            feather.icons["trash-2"].toSvg({
                                class: "font-small-4 me-50",
                            }) +
                            "حذف</a>" +
                            "</div>" +
                            "</div>" +
                            '<a href="branches/' +
                            data +
                            '/edit" class="item-edit">' +
                            feather.icons["edit"].toSvg({
                                class: "font-small-4 me-50",
                            }) +
                            "</a>"
                        );
                    },
                },
            ],
            order: [[2, "desc"]],
            dom: '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 7,
            lengthMenu: [7, 10, 25, 50, 75, 100],
            buttons: [
                // {
                //     extend: 'collection',
                //     className: 'btn btn-outline-secondary dropdown-toggle me-2',
                //     text: feather.icons['share'].toSvg({ class: 'font-small-4 me-50' }) + 'Export',
                //     buttons: [
                //         {
                //             extend: 'print',
                //             text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                //             className: 'dropdown-item',
                //             exportOptions: { columns: [3, 4, 5, 6, 7] }
                //         },
                //         {
                //             extend: 'csv',
                //             text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                //             className: 'dropdown-item',
                //             exportOptions: { columns: [3, 4, 5, 6, 7] }
                //         },
                //         {
                //             extend: 'excel',
                //             text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                //             className: 'dropdown-item',
                //             exportOptions: { columns: [3, 4, 5, 6, 7] }
                //         },
                //         {
                //             extend: 'pdf',
                //             text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                //             className: 'dropdown-item',
                //             exportOptions: { columns: [3, 4, 5, 6, 7] }
                //         },
                //         {
                //             extend: 'copy',
                //             text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                //             className: 'dropdown-item',
                //             exportOptions: { columns: [3, 4, 5, 6, 7] }
                //         }
                //     ],
                //     init: function (api, node, config) {
                //         $(node).removeClass('btn-secondary');
                //         $(node).parent().removeClass('btn-group');
                //         setTimeout(function () {
                //             $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex');
                //         }, 50);
                //     }
                // },
                {
                    text:
                        feather.icons["plus"].toSvg({
                            class: "me-50 font-small-4",
                        }) +  'اضافة جديد',
                    className: "create-new btn btn-primary",
                    // attr: {
                    //     'data-bs-toggle': 'modal',
                    //     'data-bs-target': '#modals-slide-in'
                    // },
                    action: function (e, dt, node, config) {
                        //This will send the page to the location specified
                        window.location.href = "./branches/create";
                    },
                    init: function (api, node, config) {
                        $(node).removeClass("btn-secondary");
                    },
                },
            ],
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return "Details of " + data["title"];
                        },
                    }),
                    type: "column",
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.title !== "" // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                      col.rowIdx +
                                      '" data-dt-column="' +
                                      col.columnIndex +
                                      '">' +
                                      "<td>" +
                                      col.title +
                                      ":" +
                                      "</td> " +
                                      "<td>" +
                                      col.data +
                                      "</td>" +
                                      "</tr>"
                                : "";
                        }).join("");

                        return data
                            ? $('<table class="table"/>').append(
                                  "<tbody>" + data + "</tbody>"
                              )
                            : false;
                    },
                },
            },
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: "&nbsp;",
                    next: "&nbsp;",
                },
            },
        });
        $("div.head-label").html(
            '<h6 class="mb-0">عرض البيانات الرئيسية</h6>'
        );
    }

    // Flat Date picker
    if (dt_date_table.length) {
        dt_date_table.flatpickr({
            monthSelectorType: "static",
            dateFormat: "m/d/Y",
        });
    }

    // Delete Record
    $(".datatables-basic tbody").on("click", ".delete-record", function () {
        let that = this;
        var id = dt_basic.row($(this).parents("tr")).data().id;
        var token = $("meta[name='csrf-token']").attr("content");
        Swal.fire({
            title: "هل انت متأكد من الحذف ؟ ",
            text: "لن تتمكن من التراجع عن هذا!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "نعم ، احذفها!",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-outline-danger ms-1",
            },
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                dt_basic.row($(that).parents("tr")).remove().draw();
                $.ajax({
                    url: window.location.origin + "/admin/branches/" + id,
                    type: "POST",
                    data: {
                        id: id,
                        _method: "DELETE",
                        _token: token,
                    },
                    success: function () {},
                });
                Swal.fire({
                    icon: "success",
                    title: "تم الحذف!",
                    text: "تم حذف القسم.",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                });
            }
        });
    });
});
