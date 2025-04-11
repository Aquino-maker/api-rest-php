<?php

header('Content-Type: application/json');
define('DATA_FILE', 'products.json');

function readProducts()
{
    if (!file_exists(DATA_FILE)) {
        file_put_contents(DATA_FILE, json_encode([]));
    }
    $json = file_get_contents(DATA_FILE);
    return json_decode($json, true);
}

function writeProducts($products)
{
    file_put_contents(DATA_FILE, json_encode($products, JSON_PRETTY_PRINT));
}

function getNextId($products)
{
    $ids = array_column($products, 'id');
    return $ids ? max($ids) + 1 : 1;
}

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
parse_str($_SERVER['QUERY_STRING'] ?? '', $query);

$path = parse_url($request, PHP_URL_PATH);
$pathParts = explode('/', trim($path, '/'));
$resource = $pathParts[0] ?? null;
$id = $pathParts[1] ?? null;

$products = readProducts();

// GET
if ($method === 'GET' && $resource === 'products') {
    if (isset($query['name'])) {
        $name = strtolower($query['name']);
        $filtered = array_filter($products, function ($product) use ($name) {
            return strpos(strtolower($product['name']), $name) !== false;
        });
        echo json_encode(array_values($filtered));
    } elseif ($id) {
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                echo json_encode($product);
                exit;
            }
        }
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
    } else {
        echo json_encode($products);
    }
    exit;
}
