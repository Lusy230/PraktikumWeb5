<?php

namespace prak5web\Controllers;

require "Traits/ApiResponseFormatter.php";
require "Models/Product.php";

use \prak5web\Models\Product;
use \prak5web\Traits\ApiResponseFormatter;

class ProductController
{
    use ApiResponseFormatter;

    public function index()
    {
        $productModel = new Product();
        $response = $productModel->findAll();
        return $this->apiResponse(200, "success", $response);
    }

    public function getById($order_id)
    {
        $productModel = new Product();
        $response = $productModel->findById($order_id);
        return $this->apiResponse(200, "success", $response);
    }

    public function insert()
{
    $jsonInput = file_get_contents('php://input');
    $inputData = json_decode($jsonInput, true);

    if (json_last_error()) {
        return $this->apiResponse(400, "error invalid input", null);
    }

    $orderModel = new Product();  // Ganti dengan instansiasi model order
    $response = $orderModel->create([
        "products_id" => $inputData['products_id'],
        "notelp_sup" => $inputData['notelp_sup'],
        "umur_sup" => $inputData['umur_sup']
    ]);

    return $this->apiResponse(200, "success", $response);
}


public function update($id)
{
    $jsonInput = file_get_contents('php://input');
    $inputData = json_decode($jsonInput, true);

    if (json_last_error()) {
        return $this->apiResponse(400, "error invalid input", null);
    }

    $productModel = new Product();
    $response = $productModel->update($inputData, $id);

    return $this->apiResponse(200, "success", $response);
}


    public function delete($id)
    {
        $productModel = new Product();
        $response = $productModel->destroy($id);
        return $this->apiResponse(200, "success", $response);
    }

    public function getProductsWithPackages()
    {
        $productModel = new Product;
        $response = $productModel->findAllWithCategories();

        return $this->apiResponse(200, "success", $response);
    }
}
?>
