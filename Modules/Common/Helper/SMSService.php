<?php

namespace Modules\Common\Helper;

use App\Domains\User\entity\User;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Modules\Client\Entities\Client as EntitiesClient;

class SMSService
{
    public function sendSMS($phone, $code)
    {
      $curl = curl_init();
      $app_id = "sijg8T5kPboOAQtGMnNN9mhJY9Www36iakRV5YrQ";
      $app_sec = "ZTuZvIScJW7C3macTkIu7AOcyn1eZXBtvpDYBl44MggnSk8P81sg4HEvIz8HxMqGM7pJEh2WkyA4ss30aiSlVoTeeke9HLY29Bdw";
      $app_hash  = base64_encode("$app_id:$app_sec");
      $messages = [];
      $messages["messages"] = [];
      $messages["messages"][0]["text"] = 'Pin Code is: ' . $code;
      $messages["messages"][0]["numbers"][] = "966".$phone;
      $messages["messages"][0]["sender"] = "ISHRAB";

      curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api-sms.4jawaly.com/api/v1/account/area/sms/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>json_encode($messages),
          CURLOPT_HTTPHEADER => array(
              'Accept: application/json',
              'Content-Type: application/json',
              'Authorization: Basic '.$app_hash
          ),
      ));

      $response = curl_exec($curl);
      curl_close($curl);
    //   var_dump(json_decode($response));
    }


}
