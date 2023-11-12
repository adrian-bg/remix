## About
The PaymentProcessor API service is used for processing credit and debit transaction. The service should implement an integration to 3rd party payment providers.
Currently, it runs a local provider for development purposes.

The service is build using Laravel v10 and php8.2, using mysql8.2 as a database.

The PaymentProcessor service is running on http://localhost:8001 by default and documentation for the requests can be found at http://localhost:8001/docs/api#/

The internal service communication can be made through the nginx server where the service can be reached on http://nginx:8001/api/v1/

## Documentation
Accepts a transaction information data to process from the wallet service and sends request to the wallet service once the transaction is processed.

Important functionalities:
- LocalPaymentService (namespace App\Services) - processes credit and debit transactions, creates a job (for dev purposes it is executed after 5 seconds) to notify the wallet service of the response.
- NotifyWalletService (namespace App\Jobs) - notifies the wallet service to complete the transaction
