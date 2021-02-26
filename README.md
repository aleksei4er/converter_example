# 1. SQL

```sql
        SELECT u.*, GROUP_CONCAT(b.name) FROM users u 
        LEFT JOIN user_book ub ON (u.id = ub.user_id)
        LEFT JOIN books b ON (b.id = ub.book_id)
        GROUP BY u.id
        HAVING count(b.id) = 2 and COUNT(DISTINCT (b.author)) = 1
```


# 2. Example of parser and currency converter



## Installation


```bash
composer install
php artisan db:seed

```

## Usage

Demo is located on https::/qr.aleksei4er.dev

Token might be used either as Bearer token, or from get parameter for convinient.

Page of rates

```html
https://qr.aleksei4er.dev/api/v1/rates?token=123
```

From USD to BTC

```html
https://qr.aleksei4er.dev/api/v1/convert?token=123&currency_from=USD&currency_to=BTC&value=44

```

From BTC to USD
```html
https://qr.aleksei4er.dev/api/v1/convert?token=123&currency_from=BTC&currency_to=USD&value=0.2
```

Invalid token example
```html
https://qr.aleksei4er.dev/api/v1/rates
```


## License
[MIT](https://choosealicense.com/licenses/mit/)
