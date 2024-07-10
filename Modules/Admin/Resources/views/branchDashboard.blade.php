@extends('common::layouts.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/css-rtl/plugins/charts/chart-apex.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}admin/vendors/css/animate/animate.min.css">
@endsection

@section('content')
    <section id="dashboard-ecommerce-branch" class="branch_dashboard">


        <!--case new order-->
        @if (count($recentPlusTwoMinute) != 0 || count($recentMinusOneMinute) != 0 || count($recentMinusTwoMinutes) != 0)
            <h5 class="mt-3 mb-2">طلبات جديدة</h5>
        @endif
        <div class="row">
            @foreach ($recentMinusOneMinute as $key => $value)
                @include('admin::cards.Cardbody')
                @include('admin::cards.CardPopUp')
            @endforeach
        </div>
        <div class="row">
            @foreach ($recentMinusTwoMinutes as $key => $value)
                @include('admin::cards.Cardbody')
                @include('admin::cards.CardPopUp')
            @endforeach
        </div>

        <div class="row">
            @foreach ($recentPlusTwoMinute as $key => $value)
                @include('admin::cards.Cardbody')
                @include('admin::cards.CardPopUp')
            @endforeach
        </div>


        <!----end case new order -->

        <!--case making ready order-->
        @if (count($acceptMinus15Minute) != 0 ||
            count($acceptPlus15Minus20Minute) != 0 ||
            count($acceptPlus20Minute) != 0)
            <h5 class="mt-3 mb-2">طلبات تحت التحضير </h5>
        @endif
        <div class="row">
            @foreach ($acceptMinus15Minute as $key => $value)
                @include('admin::cards.Cardbody')
                @include('admin::cards.CardPopUp')
            @endforeach
        </div>
        <div class="row">
            @foreach ($acceptPlus15Minus20Minute as $key => $value)
                @include('admin::cards.Cardbody')
                @include('admin::cards.CardPopUp')
            @endforeach
        </div>
        <div class="row">
            @foreach ($acceptPlus20Minute as $key => $value)
                @include('admin::cards.Cardbody')
                @include('admin::cards.CardPopUp')
            @endforeach
        </div>
        <!----end  making ready order -->

        <!--case ready for delivery order-->
        @if (count($MainReadyData) != 0)
            <h5 class="mt-3 mb-2">طلبات جاهزة للتسليم </h5>
        @endif
        <div class="row">
            @foreach ($MainReadyData as $key => $value)
                @include('admin::cards.Cardbody')
                @include('admin::cards.CardPopUp')
            @endforeach
        </div>
        <!----end ready for delivery order -->

        <!--case customer in front of  branch order-->
        @if (count($FrontOfBranchMinusOneMinute) != 0 ||
            count($FrontOfBranchMinusTwoMinutes) != 0 ||
            count($FrontOfBranchPlusTwoMinute) != 0)
            <h5 class="mt-3 mb-2">العميل امام الفرع </h5>
        @endif
        <div class="row">
            @foreach ($FrontOfBranchMinusOneMinute as $key => $value)
                @include('admin::cards.Cardbody')
                @include('admin::cards.CardPopUp')
            @endforeach
        </div>
        <div class="row">
            @foreach ($FrontOfBranchMinusTwoMinutes as $key => $value)
                @include('admin::cards.Cardbody')
                @include('admin::cards.CardPopUp')
            @endforeach
        </div>
        <div class="row">
            @foreach ($FrontOfBranchPlusTwoMinute as $key => $value)
                @include('admin::cards.Cardbody')
                @include('admin::cards.CardPopUp')
            @endforeach
        </div>

    </section>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>

    <script>
        const app = new Vue({
            el: '#dashboard-ecommerce-branch',
            created() {
                window.setInterval(() => {
                    $('.allDataModal').modal('hide');
                    $.ajax({
                        url: '{{ url('admin/dashboard') }}',
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(data) {
                            $('.branch_dashboard').html(data);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }, 30000);
            }
        });
    </script>

    <script src="{{ asset('') }}admin/vendors/js/extensions/sweetalertdashboard.all.min.js"></script>
    <script src="{{ asset('') }}admin/js/core/app-menu.js"></script>
    <script src="{{ asset('') }}admin/js/core/app.js"></script>

    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script>
        var pusher = new Pusher('{{ env('MIX_PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            encrypted: true
        });

        var channel = pusher.subscribe('createOrder-notify-channel');
        channel.bind('Modules\\Order\\Events\\CreateOrderNotify', function(dataaaa) {
            $.ajax({
                url: '{{ url('admin/dashboard') }}',
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('.branch_dashboard').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    </script>
@endsection
