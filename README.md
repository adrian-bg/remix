# Wallet management project

## Overview
The project contain of 3 main services, a database container running on MySQL with 4 databases where 2 of them are for testing purposes, a nginx container and a phpmyadmin service for helping perposes.

The 3 main services are
 - Authenticator
 - Wallet
 - Payment Processor

The **Authenticator service** has his own database, for storing client's data (personal user data) and providing an OAuth2 token for accessing the other functionalities

The **Wallet service** has his own database and is responsible for creating/updating user accounts (wallets) and maneging transactions

The **Payment processor** is responsible for integrating a payment provider and communicating with it (them).

The **MySQL** container brings 2 main databases up and running and 2 more for testing. The services connect to mysql at http://mysql:3306 with default user: `root` and password: `secret`
- authenticator
- test_authenticator
- wallet
- test_wallet

The **phpMyAdmin** is for mainly for visualization and working with the records in the db for development purposes. It can be reached at http://localhost:3400 where server is `mysql`, user is `root` and password is `secret`

## Authenticator
The authenticator service is running on http://localhost:8000 by default and the internal service communication can be made through the nginx server where the service can be reached at http://nginx:8000/api/v1/.

## Wallet
The wallet service is behind a nginx load balancer and the project starts with 2 wallet services by default. 
The wallet service is running on http://localhost:8080 by default and loads one the instances of the wallet server.
The internal service communication can be made through the nginx server where the service can be reached on http://nginx:8080/api/v1/.

Each of the running services can be reached separately at:
 - http://localhost:8002
 - http://localhost:8003

## Payment processor
The payment processor service is running on http://localhost:8001 by default and the internal service communication can be made through the nginx server where the service can be reached at http://nginx:8001/api/v1/

## Diagram


## Getting started

In order to start the project, you can run the shell scrip that helps bring all containers up and running

Available commands:
 - `./wallet.sh build`
 - `./wallet.sh start`
 - `./wallet.sh stop`
 - `./wallet.sh test`
 - `./wallet.sh init`

### Build command

The build command is responsible to build the docker containers and initialise the projects (./wallet.sh init)

### Start command

The start command is responsible to bring the docker containers up so that they can be accessible

### Stop command

The stop command is responsible to take the docker containers down so that they cannot be accessible

### Test command

The test command is responsible to run all the services tests
