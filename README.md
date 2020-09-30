#Notice

This API will work with https://github.com/tpribic/ticketing_system_frontend

# Setup

For this api to work you'll need to generate openSSL private/public key and put them in config/jwt directory of this project.

1. Due to usage of LexikJWTAuthenticationBundle you should have your private and public key
2. Run these commands from project root
```
$ mkdir -p config/jwt
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
4. Make sure public.pem and private.pem are inside config/jwt directory.
5. Change string from .env file to your passphrase. Or create .env.local file with that variable inside
 ```
JWT_PASSPHRASE='<passphrase_from_private.pem>'
```
6. Run `composer install` in terminal
7. Run `symfony server:start` in terminal


##Api endpoints expected json bodies and responses

You can test all responses and routes with included postman collection.