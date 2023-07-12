# SmsBundle

## Installation

### Install the package

```bash
composer req amirjon/sms-bunle
```

### Add to config/bundles.php

```php
Amir\SmsBundle\SmsBundle::class => ['all' => true],
```

### Add next lines to your .env file

```dotenv
###> sms sender ###
ESKIZ_EMAIL=john.doe@mail.com
ESKIZ_PASSWORD=password_of_eskiz
ESKIZ_FROM=4546
###< sms sender ###
```

## How to use
You need to use this service in construct method of class 
### Example of simple using
```php
class MyClass {
    public function __construct(private SmsSender $sender) 
    {
        $this->sender->sendMessage('998123456789', 'Hello Mario');
    }
}
````