-- Veritabanı adı: kuzen_satis

-- Ürünler tablosu
CREATE TABLE `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL
);

-- Siparişler tablosu
CREATE TABLE `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `customer_email` VARCHAR(255) NOT NULL,
  `order_code` VARCHAR(32) NOT NULL,
  `status` VARCHAR(32) NOT NULL DEFAULT 'Bekliyor',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`product_id`) REFERENCES products(id)
);

-- Admin tablosu
CREATE TABLE `admin` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL
);

-- Örnek admin ekle (şifre: admin123)
INSERT INTO `admin` (`username`, `password`) VALUES ('admin', MD5('admin123'));