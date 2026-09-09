<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form action="<?= site_url('products/update/' . $product['id']); ?>" method="POST">
        <label>Product Name:</label><br>
        <input type="text" name="product_name" value="<?= htmlspecialchars($product['product_name']); ?>" required><br><br>

        <label>Description:</label><br>
        <textarea name="description"><?= htmlspecialchars($product['description']); ?></textarea><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" value="<?= $product['price']; ?>" required><br><br>

        <label>Quantity:</label><br>
        <input type="number" name="quantity" value="<?= $product['quantity']; ?>" required><br><br>

        <button type="submit">Update Product</button>
        <a href="<?= site_url('products'); ?>">Cancel</a>
    </form>
</body>
</html>