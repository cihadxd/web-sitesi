<?php
require 'includes/db.php';

// Ürünleri çek
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Otomatik Dijital Satış</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Otomatik Dijital Satış Sistemi</h1>
    <a href="kvkk.php" class="btn btn-info mb-3">KVKK ve Gizlilik</a>
    <div class="row">
        <?php foreach($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="card-text">Fiyat: <?= number_format($product['price'], 2) ?>₺</p>
                        <a href="order.php?product_id=<?= $product['id'] ?>" class="btn btn-success">Satın Al</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <footer class="mt-5">
        <small>&copy; <?= date('Y') ?> Otomatik Dijital Satış | Tüm hakları saklıdır.</small>
    </footer>
</div>
</body>
</html>