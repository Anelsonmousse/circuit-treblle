# Marketplace API

This repository contains the PHP code for a marketplace API that allows users to perform various operations related to products, users, and orders. The API provides endpoints for retrieving, creating, updating, and deleting resources such as products, users, and orders.

## Endpoints

The following endpoints are available in the API:

- **GET /products**: Retrieves a list of available products for sale on the marketplace.

- **GET /products/{product_id}**: Retrieves detailed information about a specific product based on its unique ID.

- **POST /products**: Allows sellers to create a new product listing with the provided product details.

- **PUT /products/{product_id}**: Updates the details of an existing product listing identified by its ID.

- **DELETE /products/{product_id}**: Deletes a product listing from the marketplace.

- **GET /users/{user_id}**: Retrieves information about a specific user or seller based on their unique ID.

- **POST /users**: Creates a new user account or seller profile on the marketplace.

- **PUT /users/{user_id}**: Updates the profile information of a user or seller.

- **GET /orders**: Retrieves a list of orders placed on the marketplace.

- **GET /orders/{order_id}**: Retrieves detailed information about a specific order based on its unique ID.

- **POST /orders**: Initiates the process of creating a new order with the provided product and user details.

- **DELETE /orders/{order_id}**: Cancels an order and removes it from the system.

## Installation

To set up and run the marketplace API locally, follow these steps:

1. Clone this repository to your local machine: git clone https://github.com/Anelsonmousse/circuit-treblle.git
2. Change to the project directory: cd circuit-treblle
3. Install the required dependencies using Composer: composer install
4. Configure the database connection by copying the `.env.example` file to `.env`: cp .env.example .env
Then, update the `DB_*` variables in the `.env` file with your database credentials.

5. Generate an application key: php artisan key:generate
6. Run the database migrations: php artisan migrate 
7. Start the local development server: php artisan serve


The API will now be accessible at `http://localhost:8000`.

## Usage

Once the API is running, you can use an API testing tool like Postman or cURL to interact with the endpoints mentioned above.

Make sure to include the appropriate HTTP method, request headers, and request body (if required) when making requests to the API endpoints.

For example, to retrieve a list of available products, send a GET request to `http://localhost:8000/products`.

Refer to the API documentation or the source code for more details on the request/response formats and parameters for each endpoint.








