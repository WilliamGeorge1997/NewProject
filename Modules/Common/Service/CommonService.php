<?php


namespace Modules\Common\Service;


use Modules\Client\Entities\Address;

class CommonService
{

    function findBy($key, $value)
    {
        return Address::where($key, $value)->get();
    }
}
