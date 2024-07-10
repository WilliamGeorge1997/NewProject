<?php


namespace Modules\Notification\ViewModel;

use Modules\Common\Service\CityService;
use Modules\Client\Service\ClientService;

class NotificationViewModel
{
    public function clients(){
        return (new ClientService())->active();
    }
    public function cities()
    {
        return (new CityService())->active();
    }

}
