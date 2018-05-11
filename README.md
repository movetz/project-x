#Project X

Example of RESTful API based on PSR-15 like handlers and HTTP middleware.

## Requirements

- PHP >= 7.1
- Composer (used only for autoloading)

## Installation and start

- Clone repository
- Run `composer install`
- Run `composer start` or `php -S 127.0.0.1:8091 index.php`
- Open of resource by address `http://127.0.0.1:8091` in the browser/Postman app

## API Resources

Default auth credentials

| username | password |
|----------|----------|
| test     | 12345    |


### POST /session

Start new session

|Status Code | When this happens 
|----------- | ------------------
|422         | Invalid input data or credentials
|201         | Session Created


+ Request (application/json)
    + username: "test" (string, required)
    + password: "12345" (string, required)
    
+ Response (application/json)
    + sid: "c7542b9cb624b70a156c56f28612cdd5" (string, required)
    

### GET /products/:id?sid=c7542b9cb624b70a156c56f28612cdd5

Get one product item

|Status Code | When this happens 
|----------- | ------------------
|404         | Product not found
|401         | Un-authorized
|200         | Product returned

+ Request (application/json)
    + id: 23 (number, required)
    + sid: "c7542b9cb624b70a156c56f28612cdd5" (string, required)

+ Response (application/json)
    + id: 23 (number, required)
    + name: "Product name. With #id - 23" (string, required)
    + price: 45.80 (number, required)

### GET /products

Get one product item

|Status Code | When this happens 
|----------- | ------------------
|404         | Product not found
|401         | Un-authorized
|200         | Product returned

+ Request (application/json)
    + sid: "c7542b9cb624b70a156c56f28612cdd5" (string, required)
    + limit:  5 (number, required)
    + offset: 0 (number, required)

+ Response (application/json)
    + total: 50 (number, required)
    + offset: 0 (number, required)
    + data: (array, required)
        + id: 23 (number, required)
        + name: "Product name. With #id - 23" (string, required)
        + price: 45.80 (number, required)
        
## Testing

To run tests execute:

`composer test`    