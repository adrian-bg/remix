## About

The authenticator API service is used for creating a user, obtaining a user OAuth2 token 
and destroying a user OAuth2 token.

The service is build using [Laravel v10](https://laravel.com/docs/10.x/) and php8.2, using mysql8.2 as a database.

The authenticator service is running on http://localhost:8000 by default and documentation for the requests can be found at http://localhost:8000/docs/api#/

The internal service communication can be made through the nginx server where the service can be reached on http://nginx:8000/api/v1/

## Documentation

The service is responsible for creating a user and a valid OAuth2 token for the user. It has an endpoint that can validate that token.

The requests, that require a OAuth2 token are behind a middleware, that either let a request pass or not according to the provided token.

The validation of the OAuth2 is done through the laravel passport package [laravel passport package](https://laravel.com/docs/10.x/passport).
