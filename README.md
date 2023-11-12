# Wallet management project

## Overview
The project contains of 3 main services, a database container running on MySQL with 6 databases where 3 of them are for testing purposes, a nginx container and a phpmyadmin service for helping purposes.

The 3 main services are
 - Authenticator
 - Wallet
 - Payment Processor

The **Authenticator service** has his own database, for storing client's data (personal user data) and providing an OAuth2 token for accessing the other functionalities

The **Wallet service** has his own database and is responsible for creating/updating the user accounts (wallets) and maneging the transactions

The **Payment processor** has his own database and is responsible for the integration of a payment provider(s) and communicating with it (them).

The **MySQL** container brings 6 databases up and running and 3 more for testing. The services connect to mysql at http://mysql:3306 with default user: `root` and password: `secret`
 - authenticator
 - test_authenticator
 - wallet
 - test_wallet
 - payment
 - test_payment

The **phpMyAdmin** is mainly for visualization and working with the records in the db for development purposes. It can be reached at http://localhost:3400 where the server is `mysql`, the user is `root` and the password is `secret`

`Docker Compose version v2.23.0`
`Docker version 24.0.6`

## Authenticator
The authenticator service is running on http://localhost:8000 by default and the internal service communication can be made through the nginx server where the service can be reached at http://nginx:8000/api/v1/.

## Wallet
The wallet service is behind a nginx load balancer and the project starts with 2 wallet service instances by default. 
The wallet service is running on http://localhost:8080 by default and shows one the instances of the wallet server.
The internal service communication can be made through the nginx server where the service can be reached on http://nginx:8080/api/v1/.

Each of the running services can be reached separately from the browser at:
 - http://localhost:8002
 - http://localhost:8003

## Payment processor
The payment processor service is running on http://localhost:8001 by default and the internal service communication can be made through the nginx server where the service can be reached at http://nginx:8001/api/v1/

## Diagram

![WalletManagement](https://github.com/adrian-bg/remix/assets/17720228/cf5b87af-42b9-4407-8b1a-178cf483221a)


## Getting started

In order to start the project, you can run the shell scrip that helps to bring all containers up and running.
Make sure the script is executable (test -x wallet.sh && echo true || echo false) or you can make it executable with `chmod +x wallet.sh` (It should be by default). 
To start the project for a first time run 1 - build, 2 - init, 3 - start; to stop the project run stop; to test the project run test;
After the init command, the services can be started from the start command only.

Available commands:
 - `./wallet.sh build`
 - `./wallet.sh init` 
 - `./wallet.sh start`
 - `./wallet.sh stop`
 - `./wallet.sh test`

### Build command

The build command is responsible to build the docker containers

### Init command

The init command is responsible to set all the project's requirement (env file, migrations, install packages)

### Start command

The start command is responsible to bring the docker containers up so that they can be accessible

### Stop command

The stop command is responsible to take the docker containers down so that they cannot be accessible

### Test command

The test command is responsible to run all the services tests

## Work flow

 - step 1 register a user and retrieve an OAuth2 token (http://localhost:8000/docs/api#/operations/register.store). 
The token must be provided as an Authorization header for all the following requests. 
If you already have a registered user you can use the user's credentials to login (http://localhost:8000/docs/api#/operations/authentication.login)
 - step 2 create an account (http://localhost:8002/docs/api#/operations/account.store)
 - step 3 create a payment card (http://localhost:8002/docs/api#/operations/card.store)
 - step 4 make a deposit (http://localhost:8002/docs/api#/operations/transactionDeposit.store)
 - step 5 make a withdraw (http://localhost:8002/docs/api#/operations/transactionWithdrawal.store)
