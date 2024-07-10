<div class="modal fade text-start allDataModal" id="recentOrderModal{{ $value['id'] }}" tabindex="-1"
    aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.updateCardStatus') }}" method="POST" enctype="multipart/form-data">

            {{ csrf_field() }}
            <input type="hidden" value="{{ $value['id'] }}" name="order_id">
            <input type="hidden" value="{{ $value['order_status_id'] }}" name="order_status_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel120">عرض تفاصيل الطلب

                        <a href="orders/{{ $value['id'] }}" class="pe-1"> <button type="button"
                                class="btn btn-info waves-effect waves-float waves-light"><span><svg
                                        xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg></span></button></a>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="card-text mb-25">اسم العميل : {{ $value['clientName'] }}</p>
                    <p class="card-text mb-25">رقم هاتف العميل : {{ $value['client_phone'] }}</p>
                    <p class="card-text mb-25">تــاريــخ الانشـــاء : {{ $value['created_at'] }}</p>
                    <p class="card-text mb-25">الملاحظات: {{ $value['notes'] }}</p>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="py-1">اسم المنتج</th>
                                    <th class="py-1">الكمية</th>
                                    <th class="py-1">الاجمالي</th>
                                    <th class="py-1">الملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($value['OrderDetails'] as $detail)
                                    <tr>
                                        <td class="py-1">
                                            <p class="card-text fw-bold mb-25">{{ $detail['title'] }}</p>
                                        </td>
                                        <td class="py-1">
                                            <span class="fw-bold">{{ $detail['quantity'] }}</span>
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
                    <p class="card-text mb-25">السعر قبل الخصم: {{ $value['subtotal'] }}</p>
                    <p class="card-text mb-25">الضريبة: {{ $value['tax'] }}</p>
                    <p class="card-text mb-25">قيمة التوصيل: {{ $value['delivery_fee'] }}</p>
                    <p class="card-text mb-25">الخصم: {{ $value['discount'] }}</p>
                    <p class="card-text mb-25">الاجمالي: {{ $value['total'] }}</p>
                </div>
                @if ($value['firstSubmitButton'] == 'تسليم للسائق')
                    <div class="col-8" id="driver">
                        <div class="mb-1 row">
                            <div class="col-sm-3 text-center">
                                <label class="col-form-label" for="pass-icon">السائق</label>
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group-merge">
                                    <select name="driver_id" required
                                        class="select2 form-select select2-hidden-accessible" id="select2"
                                        data-select2-id="select2" tabindex="-1" aria-hidden="true">
                                        @foreach ($viewModel->drivers() as $key => $driver)
                                            <option value="{{ $driver->id }}">
                                                {{ $driver->name }}
                                                (يبعد عنك {{ $value['getdistance'][$key] }} كم)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('driver_id')
                                        <p class="alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="modal-footer">
                    @if (!empty($value['firstSubmitButton']))
                        <button type="submit" name="accept" value="1"
                            class="btn btn-info">{{ $value['firstSubmitButton'] }}</button>
                    @endif
                    @if (!empty($value['secondSubmitButton']))
                        <button type="submit" class="btn btn-danger" name="reject" value="1">
                            {{ $value['secondSubmitButton'] }}</button>
                    @endif
                </div>


            </div>


        </form>
    </div>
</div>
