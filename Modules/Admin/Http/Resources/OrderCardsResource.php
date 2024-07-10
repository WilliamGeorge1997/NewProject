<?php

namespace Modules\Admin\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Order\Entities\OrderMethod;
use Modules\Order\Entities\PaymentMethod;

class OrderCardsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function __construct($resource)
    {
        parent::__construct($resource);

        $date = new DateTime($this->created_at);
        $date->modify('+3  hour');
        $this->delivery_time_order  = $date;
 
    }
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'payment_method_id' =>  @PaymentMethod::whereId($this->payment_method_id)->first()->title,
            'order_method_id' =>   @OrderMethod::whereId($this->order_method_id)->first()->title,
            'delivery_time_order' =>  date_format($this->delivery_time_order, "h:i") ,
            'subtotal' => '+' . $this->subtotal,
            'tax' => '+' . $this->tax,
            'delivery_fee' => '+' . $this->delivery_fee,
            'discount' => '-' . $this->discount,
            'total' => $this->total,
            'notes' => $this->notes,
            'getdistance'   => $this->getdistance(),
            'clientName' => @$this->client->name,
            'client_phone' => @$this->client->phone,
            'OrderStatusVal'   => $this->OrderStatusVal,
            'ButtonColor'   => $this->ButtonColor,
            'order_status_id'   => $this->order_status_id,
            'firstSubmitButton'   => $this->firstSubmitButton,
            'secondSubmitButton'   => $this->secondSubmitButton,
            'created_at' => date('d-m-Y',  strtotime($this->created_at)),
            'OrderDetails' => $this->OrderDetails($this->details),

        ];
    }

    function OrderDetails($orderDetails)
    {
        $data = [];
        foreach ($orderDetails as $key => $value) {
            $data[$key]['id'] = $value['id'];
            $data[$key]['title'] = $value['product']['title'];
            $data[$key]['quantity'] = $value['quantity'];
            $data[$key]['total'] = $value['total'];
            $data[$key]['note'] = $value['note'];
        }
        return $data;
    }
}
