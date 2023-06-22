# Keestash SDK

Keestash SDK is a collection of code that makes it easier to interact with Keestash instances. The basic idea is to configure the SDK once and create, update, delete resources on a remote Keestash server easily.

**The SDK is still under development. The service classes are added as needed. If you need something, please open a pull request or open a support ticket.**

## Installation

Use the package manager [composer](https://getcomposer.org/) to install Keestash SDK.

```bash
composer install keestash/sdk
```

## Usage

First, you need to implement the `\Keestash\Sdk\Service\Api\ApiCredentialsInterface` interface in order to provide the API URL and credentials to the SDK. The API URL needs to be there for all requests sending to Keestash whereas the user hash and user token are not necessarily need to present.

```php
class ApiCredentialsProvider implements \Keestash\Sdk\Service\Api\ApiCredentialsInterface {

    public function getApiUrl(): string
    {
        return 'your-keestash.server/api.php';
    }

    public function getUserToken(): ?string
    {
        return <userToken>;
    }

    public function getUserHash(): ?string
    {
        return <userHash>;
    }
}
```

After providing the URL to your Keestash instance, you can call the login endpoint
```php
$keestashClient = new \Keestash\Sdk\Service\Client\KeestashClient(
    new GuzzleHttp\Client(),
    new ApiCredentialsProvider()
);

$login = new \Keestash\Sdk\App\Login\Login($keestashClient);
$data = $login->login(<username>, <password>);
var_dump($data);
```
The login endpoint returns a user hash and token in case of success. You need these for all authenticated requests to Keestash. Make sure that your class implementing `\Keestash\Sdk\Service\Api\ApiCredentialsInterface` uses the returned values for all subsequent requests.

```php
require __DIR__ . '/vendor/autoload.php';

// create credential
$c = new \Keestash\Sdk\App\PasswordManager\Entity\Credential(
    'test-password',
    'theusername',
    'topsecret',
    'root',
    'https://keestash.com'
);

$credential = new \Keestash\Sdk\App\PasswordManager\Credential($keestashClient);
$credential->create($c);

// create folder
$folder = new \Keestash\Sdk\App\PasswordManager\Folder($keestashClient);
$folder->create(new \Keestash\Sdk\App\PasswordManager\Entity\Folder('test-folder', 'root'));
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[AGPLv3](https://choosealicense.com/licenses/agpl-3.0/)