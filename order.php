<?php
require 'includes/db.php';

if (!isset($_GET['product_id'])) {
    header('Location: index.php');
    exit;
}

$product_id = intval($_GET['product_id']);
$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $order_code = substr(md5(uniqid(rand(), true)), 0, 10);

    $stmt = $pdo->prepare("INSERT INTO orders (product_id, username, customer_email, order_code, status) VALUES (?, ?, ?, ?, 'Bekliyor')");
    $stmt->execute([$product_id, $username, $email, $order_code]);

    $success = true;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sipariş Ver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Sipariş Ver: <?= htmlspecialchars($product['name']) ?></h2>
    <?php if (!empty($success)): ?>
        <div class="alert alert-success">
            Siparişiniz başarıyla alındı! Sipariş kodunuz: <strong><?= htmlspecialchars($order_code) ?></strong>
        </div>
        <a href="index.php" class="btn btn-primary">Anasayfa</a>
    <?php else: ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Adınız</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">E-posta</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Sipariş Ver</button>
        <a href="index.php" class="btn btn-secondary">Geri Dön</a>
    </form>
    <?php endif; ?>
</div>
</body>
</html>
