<?php
session_start();
require '../includes/db.php';

// Giriş kontrolü
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Sipariş kodu kontrolü
if (!isset($_GET['order_code'])) {
    header('Location: index.php');
    exit;
}
$order_code = $_GET['order_code'];

// Siparişi çek
$stmt = $pdo->prepare("SELECT orders.*, products.name as product_name FROM orders LEFT JOIN products ON orders.product_id=products.id WHERE orders.order_code=?");
$stmt->execute([$order_code]);
$order = $stmt->fetch();
if (!$order) {
    header('Location: index.php');
    exit;
}

// Durum güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_status = $_POST['status'];
    $stmt = $pdo->prepare("UPDATE orders SET status=? WHERE order_code=?");
    $stmt->execute([$new_status, $order_code]);
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sipariş Durumu Güncelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Sipariş Durumu Güncelle</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Sipariş Kodu</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($order['order_code']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Ürün</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($order['product_name']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Kullanıcı</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($order['username']) ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Durum</label>
            <select name="status" class="form-select">
                <option value="Bekliyor" <?= $order['status']=="Bekliyor"?'selected':'' ?>>Bekliyor</option>
                <option value="Onaylandı" <?= $order['status']=="Onaylandı"?'selected':'' ?>>Onaylandı</option>
                <option value="Teslim Edildi" <?= $order['status']=="Teslim Edildi"?'selected':'' ?>>Teslim Edildi</option>
                <option value="İptal Edildi" <?= $order['status']=="İptal Edildi"?'selected':'' ?>>İptal Edildi</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Güncelle</button>
        <a href="index.php" class="btn btn-secondary">Geri Dön</a>
    </form>
</div>
</body>
</html>
