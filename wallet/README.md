## About
The wallet API service is used for creating user accounts, cards storing and making transaction requests for deposit and withdraw. 

The service is build using Laravel v10 and php8.2, using mysql8.2 as a database.

The wallet service is running on http://localhost:8002 (second instance on http://localhost:8003) by default and documentation for the requests can be found at http://localhost:8002/docs/api#/

The internal service communication can be made through the nginx server where the service can be reached on http://nginx:8080/api/v1/

## Documentation

All user request should contain the obtained Authorization OAuth2 header from the authenticator.
Important functionalities:
- ValidateAuthToken middleware, which uses the AuthenticatorService (namespace App\Services\Authentication): Checks if the provided Authorization OAuth2 header is valid by a request to the authentication service.
- PaymentService (namespace App\Services\Transaction): Validates the transaction request and send request the PaymentProcessor service to process the transaction.
- TransactionController (namespace App\Http\Controllers\Api) endpoint to complete a transaction, uses PaymentService completeTransaction method.

### PaymentService
Creates a transaction in Pending status and waits for a request from the PaymentService to complete the transaction. 
The request will send a transaction status Completed/Failed according to PaymentService (as currently this service is just for dev purposes, will send it as Completed, if not changed from the code) output.
If the transaction is Completed, the associated account balance will update.
