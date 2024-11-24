<?php

require "./connection.php";

$api = "https://seg-server.vercel.app/api/books";
$json = file_get_contents($api);
$data = json_decode($json, true);

if ($data) {
    $stmt = $con->prepare("INSERT IGNORE INTO books (isbn, name, category, bookPrice, ebookPrice, createdAt) VALUES (:isbn, :name, :category, :bookPrice, :ebookPrice, :createdAt)");

    foreach ($data as $book) {
        $stmt->bindParam(':isbn', $book['isbn']);
        $stmt->bindParam(':name', $book['name']);
        $stmt->bindParam(':category', $book['category']);
        $stmt->bindParam(':bookPrice', $book['bookPrice']);
        $stmt->bindParam(':ebookPrice', $book['ebookPrice']);
        $stmt->bindParam(':createdAt', $book['createdAt']);

        try {
            $stmt->execute();
            echo "Record inserted successfully for book ISBN: " . $book['isbn'] . "\n";
        } catch (PDOException $e) {
            echo "Error inserting record for book ISBN: " . $book['isbn'] . " - " . $e->getMessage() . "\n";
        }
    }
} else {
    echo "No data fetched from API.";
}

?>
