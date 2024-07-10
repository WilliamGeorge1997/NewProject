<div class="col-md-6 col-xl-3">
    <div class="card bg-{{ $value['ButtonColor'] }} text-white">
        <div class="card-body">
            <h4 class="card-title text-white">{{ $value['uuid'] }}</h4>
            <p class="card-text"> وقت الاستلام:{{ $value['delivery_time_order'] }} </p>
            <p class="card-text"> طريقة الدفع :{{ $value['payment_method_id'] }} </p>
            <p class="card-text"> طريقة الطلب :{{ $value['order_method_id'] }} </p>
            <p class="card-text">{{ $value['OrderStatusVal'] }}</p>
        </div>
        <a href="javascript:void(0)" data-bs-target="#recentOrderModal{{ $value['id'] }}" data-bs-toggle="modal">
            <div style="padding: 10px;text-align:center" class="card-footer">

                <button type="button"
                    class="btn btn-{{ $value['ButtonColor'] }} waves-effect waves-float waves-light"><span
                        style="margin-left: 2px"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg></span>التفاصيل</button>


            </div>
        </a>
    </div>
</div>
