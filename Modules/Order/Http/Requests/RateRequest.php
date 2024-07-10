<?php

namespace Modules\Order\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;

class RateRequest extends FormRequest
{
    protected function prepareForValidation()
        {
            $order = Order::find($this->order_id);
            $this->merge([
                'client_id' => auth('client')->id(),
                'provider_id' => $order->provider_id,
            ]);
        }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

                return [
                    'order_id' => 'required|exists:orders,id',
                    'provider_rate' => 'required',
                    'service_rate' => 'required',
                ];


    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
