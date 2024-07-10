<?php


namespace Modules\Order\ViewModel;

use Modules\Driver\Service\DriverService;
use Modules\Order\Service\OrderStatusService;

class OrderViewModel
{
    public function orderStatuses(){
        return (new OrderStatusService())->findAll();
    }

    public function drivers(){
        return (new DriverService())->active();
    }

}
