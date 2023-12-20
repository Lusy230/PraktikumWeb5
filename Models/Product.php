<?php

namespace prak5web\Models;

require "Config/Database.php";

use \prak5web\Config\Database;
use mysqli;

class Product extends Database
{
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database_name, $this->port);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function findAll()
    {
        $sql = "SELECT * FROM supplier";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function findById($order_id)
{
    $sql = "SELECT products.*, supplier.* FROM products
            JOIN supplier ON products.id = supplier.products_id
            WHERE supplier.id_sup = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $this->conn->close();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}



public function create($data)
{
    $productId = isset($data['products_id']) ? $data['products_id'] : null;
    $namasup = isset($data['notelp_sup']) ? $data['notelp_sup'] : null;
    $alamatsup = isset($data['umur_sup']) ? $data['umur_sup'] : null;

    // Periksa apakah data yang diperlukan ada atau tidak
    if ($productId !== null && $namasup !== null && $alamatsup !== null) {
        $query = "INSERT INTO supplier (products_id, notelp_sup, umur_sup) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iii", $productId, $namasup, $alamatsup);
        $stmt->execute();
        $this->conn->close();
    } else {
        // Handle error jika data yang diperlukan tidak lengkap
        return false; // Atau throw exception sesuai kebutuhan
    }
}

public function update($data, $id)
{
    $productId = isset($data['products_id']) ? $data['products_id'] : null;
    $namasup = isset($data['notelp_sup']) ? $data['notelp_sup'] : null;
    $alamatsup = isset($data['umur_sup']) ? $data['umur_sup'] : null;

    $query = "UPDATE supplier SET products_id = ?, notelp_sup = ?, umur_sup = ? WHERE id_sup = ?";
    $stmt = $this->conn->prepare($query);
    $stmt->bind_param("iiii", $productId, $namasup, $alamatsup, $id);
    $stmt->execute();
}


    public function destroy($id)
    {
        $query = "DELETE FROM supplier WHERE id_sup = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    public function findAllWithCategories()
    {
        $sql = "SELECT s.id_sup, s.products_id, s.notelp_sup, p.product_name FROM supplier s INNER JOIN products p ON s.id_sup = p.id";

        $result = $this->conn->query($sql);

        $this->conn->close();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}
?>
