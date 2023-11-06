
# Domena

Odpowiedzialność: zapis danych (write model)

Interfejs:

```php
// App\TravelAllowance\BusinessTrip

public function add(
        int $employeeId,
        string $country,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate
    ): void

```
## Zależności

Wymaga dostarczenia implementacji interfejsu `App\TravelAllowance\BusinessTripRepositoryInterface`

## Testy 

### Instalacja zależności
```shell
$ composer install
```

### Phpunit:
```shell
$ php vendor/bin/phpunit tests
PHPUnit 9.6.13 by Sebastian Bergmann and contributors.

.......................                                           23 / 23 (100%)

Time: 00:00.013, Memory: 6.00 MB

OK (23 tests, 23 assertions)
```

### Formatowanie kodu

Standard: PSR-12

Weryfikacja:
```shell
$ php vendor/bin/phpcs
```
