# SF3_rest_tn
## PHP Developer Challenge

User and password to database are committed to Github which is of course against all security rules but it is only an example project so I assumed that this is the easiest way.

Project is created in Symfony 3 with Docker.
I think, that, in this case, beter then unit tests are functional tests so I added some basic functional tests and there are no tests for authenticated user.

### Instalation guide:

- git clone project from https://github.com/Glib79/SF3_rest_tn
- docker-compose build
- docker-compose up -d
- docker exec -ti -u dev sf3_php bash

- cd /home/wwwroot/sf3
- composer install
- bin/console doctrine:schema:create

User creation:
- bin/console oauth:client:create --grant-type=password --grant-type=refresh_token

You should receive information about new client.
IMPORTANT: save public_id and secret for this client.
- bin/console fos:user:create

Tests (before run the tests you should add some data to db, instruction below):
-bin/phpunit

To load data to db:
- you must exit the php container (exit)
- docker cp ./data.sql sf3_mysql:/
- docker exec sf3_mysql /bin/sh -c 'mysql -u sf3 -psf3 < /data.sql'

There is no SQL for users because users must be add according to above instruction.

To receive token:

POST localhost/oauth/v2/token
with header: Content-Type: application/json

    {
        "grant_type": "password",
        "client_id": "public_id",
        "client_secret": "secret",
        "username": "your username",
        "password": "your passowrd"
    }

Then you receive token.
To future comunication you should use authentication "Bearer token" and received token.

### User guide:

list all products
GET localhost/api/products

list all categories
GET localhost/api/categories

retrieve a single product
GET localhost/api/products/1

create a product
POST localhost/api/product + json {"name": "Pong", "category": "Games", "sku": "A0001", "price": 69.99, "quantity": 20}

update a product
PUT localhost/api/products/2 + json {"name": "Pong", "category": "Games", "sku": "A0001", "price": 69.99, "quantity": 20}

delete a product
DELETE localhost/api/products/2

