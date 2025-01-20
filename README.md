# E-commerce API Documentation

## Overview
This API simulates an order processing system for an e-commerce application. It interacts with a dummy external API (JSONPlaceholder) to fetch product details, check stock availability, and place orders. The API is designed to handle errors gracefully and includes bonus features like logging and a mock database for storing orders.

## Features
- **Fetch Product Details**: Retrieve a list of products with fields like `id`, `name`, `price`, and `availability`.
- **Simulate Stock Check**: Determine stock availability based on product ID (odd IDs are in stock, even IDs are out of stock).
- **Place an Order**: Create a new order in a mock database with product details and quantity.
- **Error Handling**: Handle cases like non-existent products, out-of-stock products, and invalid input.
- **Logging**: Log errors and key actions (e.g., fetching products, placing orders).
- **Mock Database**: Use a list or dictionary to simulate a database for storing orders.

## Endpoints

### 1. `/products`
- **Method**: GET
- **Description**: Fetches a list of products from the external API and includes their stock status.
- **Response**:
  ```json
  [
    {
      "id": 1,
      "name": "Product 1",
      "price": 100,
      "in_stock": true
    },
    {
      "id": 2,
      "name": "Product 2",
      "price": 200,
      "in_stock": false
    }
  ]
  ```

### 2. `/order`
- **Method**: POST
- **Description**: Places an order for a product.
- **Request Body**:
  ```json
  {
    "product_id": 1,
    "quantity": 2
  }
  ```
- **Responses**:
  - **Success**:
    ```json
    {
      "message": "Order placed successfully",
      "order": {
        "id": 1,
        "name": "Product 1",
        "price": 100,
        "quantity": 2
      }
    }
    ```
  - **Out of Stock**:
    ```json
    {
      "error": "Product is out of stock"
    }
    ```
  - **Invalid Product ID**:
    ```json
    {
      "error": "Product does not exist"
    }
    ```

## Error Handling
- **Product Not Found**: Returns an error if the product ID does not exist in the external API.
- **Out of Stock**: Returns an error if the product is not available.
- **Invalid Input**: Returns an error for invalid product IDs or quantities.

## Bonus Features
1. **Logging**:
   - Logs errors and key actions (e.g., fetching products, placing orders).
   - Logs are stored in the `storage/logs/laravel.log` file.

2. **Mock Database**:
   - Orders are stored in a mock database (a list or dictionary) to simulate a real database.

## Setup Instructions
1. Clone the repository:
   ```bash
   git clone <repository-url>
   ```
2. Navigate to the project directory:
   ```bash
   cd ecommerce-api
   ```
3. Install dependencies:
   ```bash
   composer install
   ```
4. Set up the environment file:
   ```bash
   cp .env.example .env
   ```
   Update the `.env` file with your application settings.
5. Generate the application key:
   ```bash
   php artisan key:generate
   ```
6. Start the development server:
   ```bash
   php artisan serve
   ```

## Testing
- Use tools like Postman or `curl` to test the API.
- Example `curl` commands:
  - Fetch products:
    ```bash
    curl -X GET http://127.0.0.1:8000/products
    ```
  - Place an order:
    ```bash
    curl -X POST http://127.0.0.1:8000/order -H "Content-Type: application/json" -d '{"product_id": 1, "quantity": 2}'
    ```

## Example Scenarios

### 1. Place an Order for an In-Stock Product
- **Request**:
  ```json
  {
    "product_id": 1,
    "quantity": 2
  }
  ```
- **Response**:
  ```json
  {
    "message": "Order placed successfully",
    "order": {
      "id": 1,
      "name": "Product 1",
      "price": 100,
      "quantity": 2
    }
  }
  ```

### 2. Order an Out-of-Stock Product
- **Request**:
  ```json
  {
    "product_id": 2,
    "quantity": 1
  }
  ```
- **Response**:
  ```json
  {
    "error": "Product is out of stock"
  }
  ```

### 3. Invalid Product ID
- **Request**:
  ```json
  {
    "product_id": 999,
    "quantity": 1
  }
  ```
- **Response**:
  ```json
  {
    "error": "Product does not exist"
  }
  ```

## License
This project is licensed under the MIT License.
