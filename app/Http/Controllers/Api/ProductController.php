<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;

class ProductController extends Controller
{
    private $externalApiUrl = "https://jsonplaceholder.typicode.com";

    private function fetchProducts()
    {
        try {
            $response = Http::get("{$this->externalApiUrl}/posts");
            $products = collect($response->json())->take(10)->map(function ($product) {
                return [
                    'id' => $product['id'],
                    'name' => "Product {$product['id']}",
                    'price' => $product['id'] * 10.99,
                    'in_stock' => $product['id'] % 2 === 1
                ];
            });

            Log::info("Successfully fetched " . count($products) . " products");
            return $products;

        } catch (\Exception $e) {
            Log::error("Error fetching products: " . $e->getMessage());
            return null;
        }
    }

    private function checkStock($productId)
    {
        return $productId % 2 === 1;
    }

    public function getProducts()
    {
        $products = $this->fetchProducts();

        if ($products === null) {
            return response()->json([
                'error' => 'Failed to fetch products'
            ], 500);
        }

        return response()->json([
            'products' => $products
        ]);
    }

    public function placeOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|integer',
                'quantity' => 'required|integer|min:1'
            ]);

            $productId = $validated['product_id'];
            $quantity = $validated['quantity'];

            // Fetch product details
            $products = $this->fetchProducts();
            $product = collect($products)->firstWhere('id', $productId);

            if (!$product) {
                return response()->json([
                    'error' => 'Product not found'
                ], 404);
            }

            // Check stock
            if (!$this->checkStock($productId)) {
                return response()->json([
                    'error' => 'Product is out of stock'
                ], 400);
            }

            // Create order
            $order = Order::create([
                'product_id' => $productId,
                'product_name' => $product['name'],
                'quantity' => $quantity,
                'total_price' => $product['price'] * $quantity
            ]);

            Log::info("Order placed successfully: " . json_encode($order));

            return response()->json([
                'message' => 'Order placed successfully',
                'order' => $order
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation error',
                'messages' => $e->errors()
            ], 400);
        } catch (\Exception $e) {
            Log::error("Error placing order: " . $e->getMessage());
            return response()->json([
                'error' => 'Internal server error'
            ], 500);
        }
    }
}
?>