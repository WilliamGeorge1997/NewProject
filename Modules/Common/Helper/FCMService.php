<?php


namespace Modules\Common\Helper;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use FCM;
use Modules\Client\Service\ClientService;
use Modules\Driver\Service\DriverService;

class FCMService
{

    public function sendNotification(array $data, array $tokens) {
        
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $option = $optionBuilder->build();


        if($data['user_id'] ?? null){
          $client = (new ClientService())->findById($data['user_id']);
          if(!$client){
            $driver = (new DriverService())->findById($data['user_id']);
            if(!$driver) $client_lang = 'en';
            else $client_lang = $driver['lang'];
          }  
          else $client_lang = $client['lang'];
        }else{
            $client_lang = 'en';
        }

        // create notification
        $notificationBuilder = new PayloadNotificationBuilder($data['title'][$client_lang]);
        $notificationBuilder->setBody($data['description'][$client_lang])
                            ->setSound('default');
        $notification = $notificationBuilder->build();

        // add data to notification
        $dataBuilder = new PayloadDataBuilder();
        $data['title_ar'] = $data['title']['ar'];
        $data['title_en'] = $data['title']['en'];
        $data['description_ar'] = $data['description']['ar'];
        $data['description_en'] = $data['description']['en'];
        $dataBuilder->addData($data);
        $data = $dataBuilder->build();

        // send notification
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        
        return [
            'numberSucces' => $downstreamResponse->numberSuccess(),
            'numberFailure' => $downstreamResponse->numberFailure(),
            'numberModification' => $downstreamResponse->numberModification()
        ];
    }

    public function sendTopicNotification(array $message, string $newTopic) {

        $notificationBuilder = new PayloadNotificationBuilder($message[0]);
        $notificationBuilder->setBody($message[0])
                            ->setSound('default');

        $notification = $notificationBuilder->build();

        $topic = new Topics();
        $topic->topic($newTopic);
        
        $topicResponse = FCM::sendToTopic($topic, null, $notification, null);

        return [
            'numberSucces' => $topicResponse->isSuccess(),
            'numberFailure' => $topicResponse->shouldRetry(),
            'numberModification' => $topicResponse->error()
        ];
    }

    public function subscribeToTopic(string $token,string $newTopic)
    {   
        $notificationBuilder = new PayloadNotificationBuilder('topic');
        $notificationBuilder->setBody('topic')
                            ->setSound('default');

        $notification = $notificationBuilder->build();

        $topic = new Topics();
        $topic->topic($newTopic);
        
        $topicResponse = FCM::sendToTopic($topic, null, $notification, null);

        return [
            'numberSucces' => $topicResponse->isSuccess(),
            'numberFailure' => $topicResponse->shouldRetry(),
            'numberModification' => $topicResponse->error()
        ];
    }

    public function unSubscribeToTopic(string $token,string $topic)
    {   
        $api = config('fcm-settings.fcm_api_server_url');
        $url = "{$api}:batchRemove";
        $fields = array(
            'to' => "/topics/{$topic}",
            'registration_tokens' => array($token)
        );
        return $this->sendRequest($fields,$url);
    }


    private function sendRequest(array $fields, array $tokens)
    {    
        $url = !$url ? config('fcm-settings.fcm_api_url'):$url;

        // Open connection
        $ch = curl_init ();
         // Set the url, number of POST vars, POST data
        curl_setopt ( $ch, CURLOPT_URL,$url);

        curl_setopt ( $ch, CURLOPT_POST, true );

        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $this->headers );

        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );

         // Disabling SSL Certificate support temporarly
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );

        curl_setopt ( $ch, CURLOPT_POSTFIELDS,json_encode ( $fields ) );

        $result = curl_exec ( $ch );
        
        curl_close ( $ch );
        return  $result;
    }

    private function setHeaders(array $headers = []):array
    {    

       $defaultHeaders = [
        'Authorization: key=' . config('fcm-settings.fcm_server_key'),
        'Content-Type: application/json'
       ];
       if(count($headers))
       $defaultHeaders = array_merge($defaultHeaders,$headers);

       return $defaultHeaders;
    }
}