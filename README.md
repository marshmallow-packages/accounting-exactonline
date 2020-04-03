<p align="center">
    <img src="https://cdn.marshmallow-office.com/media/images/logo/marshmallow.transparent.red.png">
</p>
<p align="center">
    <a href="https://github.com/Marshmallow-Development">
        <img src="https://img.shields.io/github/issues/Marshmallow-Development/package-historytracking.svg" alt="Issues">
    </a>
    <a href="https://github.com/Marshmallow-Development">
        <img src="https://img.shields.io/github/forks/Marshmallow-Development/package-historytracking.svg" alt="Forks">
    </a>
    <a href="https://github.com/Marshmallow-Development">
        <img src="https://img.shields.io/github/stars/Marshmallow-Development/package-historytracking.svg" alt="Stars">
    </a>
    <a href="https://github.com/Marshmallow-Development">
        <img src="https://img.shields.io/github/license/Marshmallow-Development/package-historytracking.svg" alt="License">
    </a>
</p>

# Marshmallow Exact Online
Koppel Exact Online aan je Laravel Nova installatie zodat we alles met elkaar kunnen verbinden.

### Installatie

`composer require marshmallow/package-exactonline`

Belangrijk:
Als je wijzigingen maakt in de config, zorg dan dat de Worker opnieuw gestart wordt!


Run `php artisan exactonline:install`
Daarna `php artisan vendor:publish --provider="Marshmallow\ExactOnline\ToolServiceProvider" --tag="config" --force`

Dan `php artisan migrate` om de ExactOnline hulp tabellen aan te maken

Dan gaan we naar `app/Providers/NovaServiceProvider` om de ExactOnline tool te registeren:
```
class NovaServiceProvider extends NovaApplicationServiceProvider
{
    //

    protected function cards()
    {
        return [
            new \Marshmallow\ExactOnline\ExactOnlineCard,
            new Help,
        ];
    }

    //

    public function tools()
    {
        return [
            new \Marshmallow\ExactOnline\ExactOnline
        ];
    }
    
    //
}
```

Als laatste moeten we nog wat env variabelen aanmaken in `.env`.
```
EXACT_ONLINE_REDIRECT_URI=https://{{jouw_domein}}/nova/exact-online
EXACT_ONLINE_CLIENT_ID="__________"
EXACT_ONLINE_CLIENT_SECRET="______"
```

Let op, het inschieten van data werkt met queue's zodat de performance van de website goed blijft. Zorg er dus voor dat je applicatie met queus om kan gaan. Bijvoorbeeld door:
```
php artisan queue:table
php artisan migrate
env betand: QUEUE_CONNECTION=database

php artisan config:clear
php artisan queue:work
```

## Exact API
Er wordt gebruik gemaakt van `https://github.com/picqer/exact-php-client`. Met onderstaande static function haal je een connection object op waarmee je deze API kan gebruiken.

```
$connection = ExactOnlineConnect::connect();
$item = new \Picqer\Financials\Exact\Item($connection);
$item->find(ID);
```

## Traits
Gebruik op alle models die verbonden worden met Exact Online de `Exactable` trait zodat we data kunnen opslaan.


- - -

Copyright (c) 2020 marshmallow