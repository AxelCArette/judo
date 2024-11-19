<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = 'c086157ae58ea2bca00fd960ccf91863';
    private $api_key_secret = '8d4d8d600ba4be8f7fdb2932afe35f6b';

    public function send($to_email,$to_name,$subject, $content)
    {
        $mj= new Client($this->api_key,$this->api_key_secret,true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "apolyonar@gmail.com",
                        'Name' => "Judo Club D'Isbergues"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 6482920,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => "$content",
                    
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}
