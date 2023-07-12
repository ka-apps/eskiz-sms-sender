<?php

declare(strict_types=1);

namespace Amir\SmsBundle\Component;

use Amir\SmsBundle\Component\core\ParameterGetter;
use Symfony\Component\HttpClient\HttpClient;

class SmsSender
{
    public function __construct(private ParameterGetter $parameterGetter)
    {
    }

    public function sendMessage(string $phoneNumber, string $message): void
    {
        $filteredPhoneNumber = preg_replace("/[^0-9]/", "", $phoneNumber);

        if (!preg_match('/^[0-9]*[0-9]$/', $filteredPhoneNumber)) {
            return;
        }

        $client = HttpClient::create();

        $client->request('POST', 'https://notify.eskiz.uz/api/message/sms/send', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getToken()
            ],
            'body' => [
                'mobile_phone' => $filteredPhoneNumber,
                'message' => $message,
                'from' => $this->parameterGetter->getString('eskiz_from'),
            ]
        ]);
    }

    private function getToken()
    {
        $body = [
            'body' => [
                'email' => $this->parameterGetter->getString('eskiz_email'),
                'password' => $this->parameterGetter->getString('eskiz_password')
            ]
        ];
        $client = HttpClient::create();
        $response = $client->request('POST', 'https://notify.eskiz.uz/api/auth/login', $body);

        return json_decode($response->getContent())->data->token;
    }
}