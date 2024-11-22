<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = '0e46db2c88ecc829c879617f349840c8';
    private $api_key_secret = '9263e4236012d9fd9a784c39592ab24a';

    public function send($to_email,$to_name,$subject, $content)
    {
        $mj= new Client($this->api_key,$this->api_key_secret,true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "judoclubisbergues2@gmail.com",
                        'Name' => "Judo Club D'Isbergues"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 6491114,
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
