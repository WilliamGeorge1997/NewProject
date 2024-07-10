@extends('common::layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('')}}admin/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}admin/vendors/css/pickers/pickadate/pickadate.css">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}admin/vendors/css/pickers/flatpickr/flatpickr.min.css">

@endsection

@section('content')

    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">انشاء كوبون خصم جديد</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{url('admin/coupons/')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon">الكود</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="text" class="form-control" name="code" placeholder="الكود" value="{{old('code')}}" />
                                        @error('code')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="pass-icon">نوع الخصم</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group-merge">
                                        <select name="type" class="select2 form-select select2-hidden-accessible" id="select2" tabindex="-1" aria-hidden="true">
                                                <option value="1">قيمة ثابتة</option>
                                                <option value="2">نسبة مئوية</option>
                                        </select>
                                        @error('type')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="pass-icon">الخصم علي</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group-merge">
                                        <select name="discount_on" class="select2 form-select select2-hidden-accessible" id="select2" tabindex="-1" aria-hidden="true">
                                                <option value="subtotal">قيمة الشحنة</option>
                                                <option value="delivery">تكلفة التوصيل</option>
                                                <option value="both">الاثنان معاً</option>
                                        </select>
                                        @error('discount_on')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> قيمة الخصم</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="percent"></i></span>
                                        <input type="number" id="fname-icon" class="form-control" value="{{old('value')}}" name="value" placeholder="قيمة الخصم" />
                                        @error('value')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> الحد الاقصي للخصم ان وجد</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="percent"></i></span>
                                        <input type="number" id="fname-icon" class="form-control" value="{{old('limit')}}" name="limit" placeholder="الحد الاقصي للخصم" />
                                        @error('limit')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> عدد مرات الاستخدام</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="number" id="fname-icon" class="form-control" value="{{old('num_of_uses')}}" name="num_of_uses" placeholder="عدد مرات الاستخدام" />
                                        @error('num_of_uses')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> عدد مرات الاستخدام للعميل الواحد</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="number" id="fname-icon" class="form-control" value="{{old('client_uses')}}" name="client_uses" placeholder="عدد مرات الاستخدام للعميل الواحد" />
                                        @error('client_uses')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="pass-icon">مقدمي الخدمة</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group-merge">
                                        <select name="providers[]" class="select2 form-select select2-hidden-accessible" id="select2-multiple" multiple="" data-select2-id="select2-multiple" tabindex="-1" aria-hidden="true">
                                            @foreach($viewModel->providers() as $provider)
                                                <option value="{{$provider->id}}">{{$provider->title}}</option>
                                            @endforeach
                                        </select>
                                        @error('providers')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <input type="checkbox" class="form-check-input" id="checkbox" > اختيار الكل
                                </div>
                            </div>
                        </div>


{{--                        <div class="col-md-6 mb-1" data-select2-id="106">--}}
{{--                            <label class="form-label" for="select2-multiple">Multiple</label>--}}
{{--                            <div class="position-relative" data-select2-id="105">--}}

{{--                            </div>--}}

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> تاريخ البدايه</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                                        <input type="text" name="date_from" value="{{old('date_from')}}" id="fp-default" class="form-control flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                        @error('date_from')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> تاريخ النهاية</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="calendar"></i></span>
                                        <input type="text" name="date_to" value="{{old('date_to')}}" id="fp-default" class="form-control flatpickr-basic flatpickr-input active" placeholder="YYYY-MM-DD" readonly="readonly">
                                        @error('date_to')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> وقت البدايه</label>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group input-group-merge">
                                        <input type="text" name="time_from" value="{{old('time_from')}}" id="fp-time" class="form-control flatpickr-time text-start flatpickr-input active" placeholder="HH:MM">
                                        @error('time_from')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> وقت النهاية</label>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group input-group-merge">
                                        <input type="text" name="time_to" value="{{old('time_to')}}" id="fp-time" class="form-control flatpickr-time text-start flatpickr-input active" placeholder="HH:MM">
                                        @error('time_to')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-9 offset-sm-3">
                            <div class="mb-1">
                                <div class="form-check">
                                    <input type="checkbox" value="1" name="is_active" class="form-check-input" id="customCheck2" />
                                    <label class="form-check-label" for="customCheck2">تفعيل</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary me-1">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script src="{{asset('')}}admin/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="{{asset('')}}admin/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <script src="{{asset('')}}admin/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="{{asset('')}}admin/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="{{asset('')}}admin/js/scripts/forms/pickers/form-pickers.js"></script>



    <script>

        var select = $('.select2');

        select.each(function () {
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


        $(document).ready(function() {
            $("#checkbox").click(function(){
                if($("#checkbox").is(':checked') ){ //select all
                    $("#select2-multiple").find('option').prop("selected",true);
                    $("#select2-multiple").trigger('change');
                } else { //deselect all
                    $("#select2-multiple").find('option').prop("selected",false);
                    $("#select2-multiple").trigger('change');
                }
            });
        });
    </script>


@endsection
