# Installation steps for Symfony 4

### Add github repo
```json
// composer.json
    "repositories": [
        {
          "type": "vcs",
          "url": "https://github.com/juliosibaja/PayumMoneticoBundle"
        }
      ],
```

### Require the package

```bash
$ composer require php-http/guzzle6-adapter ^2.0
$ composer require juliosibaja/payum-monetico-bundle
```

### Register the bundle

Add the bundle to the kernel:

```php
// config/bundles.php
return [
    // ...
    Codatte\Bundle\PayumMoneticoBundle\EkynaPayumMoneticoBundle::class => ['all' => true],
];
```

### Configure Monetico

Declare the Monetico gateway:

```yaml
# config/packages/payum.yaml
payum:
    gateways:
        ...
    
        monetico_1:
            factory: monetico_1
        monetico_2:
            factory: monetico_2
```

Setup the API parameters:

```yaml
# config/packages/ekyna_payum_monetico.yaml
ekyna_payum_monetico:
    monetico_1:
        mode : 'TEST'    # enum from Ekyna\Component\Payum\Monetico\Api\Api
        tpe : 'your-tpe' # value from your Monetico account
        key : 'your-key' # value from your Monetico account
        company : 'acme' # value from your Monetico account
        debug : true
    monetico_2:
        mode : 'TEST'    # enum from Ekyna\Component\Payum\Monetico\Api\Api
        tpe : 'your-tpe' # value from your Monetico account
        key : 'your-key' # value from your Monetico account
        company : 'acme' # value from your Monetico account
        debug : true
```

### Next steps

[Implement convert action and notify controller](https://github.com/juliosibaja/PayumMoneticoBundle/blob/master/doc/develop.md)