<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
</head>
<body>
    <h2>Product Management</h2>
    <p>Logged in as: <strong><?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?></strong> | <a href="<?= site_url('index.php/logout'); ?>">Logout</a></p>

    <a href="<?= site_url('index.php/products/create'); ?>">+ Add New Product</a>
    <br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($products)): ?>
                <?php foreach($products as $p): ?>
                <tr>
                    <td><?= $p['id']; ?></td>
                    <td><?= htmlspecialchars($p['product_name']); ?></td>
                    <td><?= htmlspecialchars($p['description']); ?></td>
                    <td>$<?= number_format($p['price'], 2); ?></td>
                    <td><?= $p['quantity']; ?></td>
                    <td>
                        <a href="<?= site_url('index.php/products/edit/' . $p['id']); ?>">Edit</a> | 
                        <a href="<?= site_url('index.php/products/delete/' . $p['id']); ?>" onclick="return confirm('Delete item?');">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No products found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>