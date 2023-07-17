<?php

declare(strict_types=1);

namespace TkgApps\EskizSmsSender\Component;

use Symfony\Component\HttpClient\HttpClient;
use TkgApps\EskizSmsSender\Component\core\ParameterGetter;
use TkgApps\EskizSmsSender\Component\Exceptions\SmsSenderException;

class SmsSender
{
    public function __construct(private ParameterGetter $parameterGetter)
    {
    }

    public function sendMessage(string $phoneNumber, string $message): void
    {
        $filteredPhoneNumber = preg_replace("/[^0-9]/", "", $phoneNumber);

        if (!preg_match('/^[0-9]+$/', $filteredPhoneNumber)) {
            throw new SmsSenderException('The phone number format is not correct');
        }

        $client = HttpClient::create();

        $client->request('POST', $this->parameterGetter->getString('eskiz_sms_send_link'), [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getToken(),
            ],
            'body' => [
                'mobile_phone' => $filteredPhoneNumber,
                'message' => $message,
                'from' => $this->parameterGetter->getString('eskiz_from'),
            ],
        ]);
    }

    private function getToken()
    {
        $body = [
            'body' => [
                'email' => $this->parameterGetter->getString('eskiz_email'),
                'password' => $this->parameterGetter->getString('eskiz_password'),
            ],
        ];

        $client = HttpClient::create();
        $response = $client->request('POST', $this->parameterGetter->getString('eskiz_get_token_link'), $body);

        return json_decode($response->getContent())->data->token;
    }
}
