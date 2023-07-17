# SmsBundle

## Installation

### Install the package

```bash
composer req tkg-apps/eskiz-sms-bundle
```

### Add to config/bundles.php

```php
TkgApps\EskizSmsSender\EskizSmsBundle::class => ['all' => true],
```

### Add next lines to your .env file

```dotenv
###> sms sender ###
ESKIZ_EMAIL=john.doe@mail.com
ESKIZ_PASSWORD=password_of_eskiz
ESKIZ_FROM=4546
ESKIZ_SMS_SEND_LINK=https://notify.eskiz.uz/api/message/sms/send
ESKIZ_GET_TOKEN_LINK=https://notify.eskiz.uz/api/auth/login
###< sms sender ###
```

## How to use
You need to use this service in construct method of class 
### Example of simple using
```php
class MyClass 
{
    public function __construct(private SmsSender $sender) 
    {
        $this->sender->sendMessage('998123456789', 'Hello Mario');
    }
}
````