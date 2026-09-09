<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
</head>
<body>
    <h2>Add New Product</h2>
    <form action="<?= site_url('products/store'); ?>" method="POST">
        <label>Product Name:</label><br>
        <input type="text" name="product_name" required><br><br>

        <label>Description:</label><br>
        <textarea name="description"></textarea><br><br>

        <label>Price:</label><br>
        <input type="number" step="0.01" name="price" required><br><br>

        <label>Quantity:</label><br>
        <input type="number" name="quantity" required><br><br>

        <button type="submit">Save Product</button>
        <a href="<?= site_url('products'); ?>">Cancel</a>
    </form>
</body>
</html>