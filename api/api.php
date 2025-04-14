<?php

$file = 'products.json';
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

function readProducts($file) {
    if (!file_exists($file)) {
        file_put_contents($file, '[]');
    }
    $data = file_get_contents($file);
    return json_decode($data, true);
}

function saveProducts($file, $products) {
    file_put_contents($file, json_encode($products, JSON_PRETTY_PRINT));
}

function getNextId($products) {
    $ids = array_column($products, 'id');
    return $ids ? max($ids) + 1 : 1;
}

// Obter o ID da URL, se existir
$id = $_GET['id'] ?? null;

if ($method === 'GET') {
    $products = readProducts($file);

    if ($id) {
        foreach ($products as $product) {
            if ($product['id'] == $id) {
                echo json_encode($product);
                exit;
            }
        }
        http_response_code(404);
        echo json_encode(['erro' => 'Produto não encontrado']);
        exit;
    }

    echo json_encode($products);
    exit;
}

if ($method === 'POST') {
    $input = file_get_contents('php://input');
    $newProduct = json_decode($input, true);

    if (!isset($newProduct['name']) || !isset($newProduct['price'])) {
        http_response_code(400);
        echo json_encode(['erro' => 'Os campos "name" e "price" são obrigatórios']);
        exit;
    }

    $products = readProducts($file);
    $newProduct['id'] = getNextId($products);
    $products[] = $newProduct;
    saveProducts($file, $products);

    echo json_encode(['mensagem' => 'Produto adicionado com sucesso.', 'produto' => $newProduct]);
    exit;
}

if ($method === 'PUT' && $id) {
    $input = file_get_contents('php://input');
    $updateData = json_decode($input, true);

    $products = readProducts($file);
    foreach ($products as &$product) {
        if ($product['id'] == $id) {
            $product['name'] = $updateData['name'] ?? $product['name'];
            $product['price'] = $updateData['price'] ?? $product['price'];
            saveProducts($file, $products);
            echo json_encode(['mensagem' => 'Produto atualizado com sucesso.', 'produto' => $product]);
            exit;
        }
    }

    http_response_code(404);
    echo json_encode(['erro' => 'Produto não encontrado']);
    exit;
}

if ($method === 'DELETE' && $id) {
    $products = readProducts($file);
    foreach ($products as $index => $product) {
        if ($product['id'] == $id) {
            array_splice($products, $index, 1);
            saveProducts($file, $products);
            echo json_encode(['mensagem' => 'Produto deletado com sucesso.']);
            exit;
        }
    }

    http_response_code(404);
    echo json_encode(['erro' => 'Produto não encontrado']);
    exit;
}

http_response_code(405);
echo json_encode(['erro' => 'Método não permitido ou ID ausente']);