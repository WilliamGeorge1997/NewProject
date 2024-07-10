@extends('common::layouts.master')

@section('css')
{{--<link rel="stylesheet" type="text/css" href="{{asset('')}}admin/css-rtl/plugins/extensions/ext-component-sweet-alerts.css">--}}
@endsection
@section('content')

    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">تعديل الاعدادات العامة</h4>
            </div>
            <div class="card-body">
                <form class="form form-horizontal" action="{{url('admin/setting')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        @foreach ($settings as $setting )
                        @if($setting->type!='textarea' && in_array($setting->key,['today_fee','next_day_fee','free_delivery_limit','points_value','points_limit','tax']))
                        <div class="col-12">
                            <div class="mb-1 row">
                                <div class="col-sm-3 text-center">
                                    <label class="col-form-label" for="fname-icon"> {{$setting->display}}</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i data-feather="user"></i></span>
                                        <input type="{{$setting->type}}" class="form-control" name="{{$setting->key}}" placeholder="{{$setting->key}}" value="{{$setting->value}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
{{--                         <div class="col-12">--}}
{{--                            <div class="mb-1 row">--}}
{{--                                <div class="col-sm-3 text-center">--}}
{{--                                    <label class="col-form-label" for="fname-icon"> {{$setting->display}}</label>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-9">--}}
{{--                                    <div class="input-group input-group-merge">--}}
{{--                                         <textarea class="form-control"  id="validationBioBootstrap" minlength="6" name="{{$setting->key}}" rows="20" style="direction: rtl !important;" >{{ @optional($setting)->value}}</textarea>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        @endif
                        @endforeach
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
<script src="{{asset('')}}admin/vendors/js/extensions/sweetalert2.all.min.js"></script>
@if(session('updated'))
<script>
    Swal.fire({
        title: 'أحسنت!',
        text: 'لقد تم تعديل البيانات بنجاح',
        icon: 'success',
        customClass: {
            confirmButton: 'btn btn-primary'
        },
        buttonsStyling: false
    });
</script>
@endif

{{--<script src="//cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>--}}
{{--<script>--}}
{{--CKEDITOR.replace('about_ar');--}}
{{--CKEDITOR.replace('about_en');--}}
{{--CKEDITOR.replace('terms_ar');--}}
{{--CKEDITOR.replace('terms_en');--}}
{{--CKEDITOR.replace('privacy_policy_ar');--}}
{{--CKEDITOR.replace('privacy_policy_en');--}}
{{--CKEDITOR.replace('refund_ar');--}}
{{--CKEDITOR.replace('refund_en');--}}

{{--</script>--}}
@endsection

