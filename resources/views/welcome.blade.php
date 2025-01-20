<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce API Documentation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">E-commerce API Documentation</h1>
        <p class="text-muted text-center">Simulating an order processing system for an e-commerce application.</p>

        <hr>

        <h2>Overview</h2>
        <p>
            This API simulates an order processing system for an e-commerce application. It interacts with a dummy external API
            (<a href="https://jsonplaceholder.typicode.com" target="_blank">JSONPlaceholder</a>) to fetch product details, check stock availability, and place orders.
            The API is designed to handle errors gracefully and includes bonus features like logging.
        </p>

        <h2>Features</h2>
        <ul>
            <li><strong>Fetch Product Details:</strong> Retrieve a list of products with fields like <code>id</code>, <code>name</code>, <code>price</code>, and <code>availability</code>.</li>
            <li><strong>Simulate Stock Check:</strong> Determine stock availability based on product ID (odd IDs are in stock, even IDs are out of stock).</li>
            <li><strong>Place an Order:</strong> Create a new order in a mock database with product details and quantity.</li>
            <li><strong>Error Handling:</strong> Handle cases like non-existent products, out-of-stock products, and invalid input.</li>
            <li><strong>Logging:</strong> Log errors and key actions (e.g., fetching products, placing orders).</li>
        </ul>

        <h2>Endpoints</h2>
        <h4>1. <code>/products</code></h4>
        <ul>
            <li><strong>Method:</strong> GET</li>
            <li><strong>Description:</strong> Fetches a list of products from the external API and includes their stock status.</li>
            <li><strong>Response:</strong></li>
        </ul>
        <pre><code>[
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
]</code></pre>

        <h4>2. <code>/order</code></h4>
        <ul>
            <li><strong>Method:</strong> POST</li>
            <li><strong>Description:</strong> Places an order for a product.</li>
            <li><strong>Request Body:</strong></li>
        </ul>
        <pre><code>{
    "product_id": 1,
    "quantity": 2
}</code></pre>
        <ul>
            <li><strong>Responses:</strong></li>
        </ul>
        <pre><code>// Success
{
    "message": "Order placed successfully",
    "order": {
        "id": 1,
        "name": "Product 1",
        "price": 100,
        "quantity": 2
    }
}

// Out of Stock
{
    "error": "Product is out of stock"
}

// Invalid Product ID
{
    "error": "Product does not exist"
}</code></pre>

        <h2>Error Handling</h2>
        <ul>
            <li><strong>Product Not Found:</strong> Returns an error if the product ID does not exist in the external API.</li>
            <li><strong>Out of Stock:</strong> Returns an error if the product is not available.</li>
            <li><strong>Invalid Input:</strong> Returns an error for invalid product IDs or quantities.</li>
        </ul>

        <h2>Bonus Features</h2>
        <h4>Logging</h4>
        <p>Logs errors and key actions (e.g., fetching products, placing orders). Logs are stored in the <code>storage/logs/laravel.log</code> file.</p>

        <h2>Testing</h2>
        <p>Use tools like Postman or <code>curl</code> to test the API.</p>
        <h4>Example <code>curl</code> Commands:</h4>
        <ul>
            <li>Fetch products:</li>
            <pre><code>curl -X GET https://ecommerce-api.jasmitrasolusindo.com/products</code></pre>
            <li>Place an order:</li>
            <pre><code>curl -X POST https://ecommerce-api.jasmitrasolusindo.com/order -H "Content-Type: application/json" -d '{"product_id": 1, "quantity": 2}'</code></pre>
        </ul>

    </div>
</body>
</html>
