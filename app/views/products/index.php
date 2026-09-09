<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="max-w-6xl mx-auto p-6">
        <!-- Top Bar -->
        <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-sm mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Product Dashboard</h1>
                <p class="text-sm text-gray-500">Logged in as: <span class="font-semibold text-gray-700"><?= htmlspecialchars($_SESSION['username'] ?? 'User'); ?></span></p>
            </div>
            <a href="<?= site_url('index.php/logout'); ?>" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium transition">Logout</a>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 flex justify-between items-center border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-700">Active Products</h2>
                <a href="<?= site_url('index.php/products/create'); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">+ Add New Product</a>
            </div>

            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider border-b border-gray-200">
                        <th class="p-4">ID</th>
                        <th class="p-4">Name</th>
                        <th class="p-4">Description</th>
                        <th class="p-4">Price</th>
                        <th class="p-4">Quantity</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    <?php if(!empty($products)): ?>
                        <?php foreach($products as $p): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-mono text-gray-500">#<?= $p['id']; ?></td>
                            <td class="p-4 font-medium text-gray-900"><?= htmlspecialchars($p['product_name']); ?></td>
                            <td class="p-4 text-gray-500"><?= htmlspecialchars($p['description']); ?></td>
                            <td class="p-4 font-semibold text-green-600">$<?= number_format($p['price'], 2); ?></td>
                            <td class="p-4"><?= $p['quantity']; ?></td>
                            <td class="p-4 text-center space-x-2">
                                <a href="<?= site_url('index.php/products/edit/' . $p['id']); ?>" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                                <span class="text-gray-300">|</span>
                                <a href="<?= site_url('index.php/products/delete/' . $p['id']); ?>" onclick="return confirm('Soft delete this item?');" class="text-red-600 hover:text-red-900 font-medium">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-400">No active products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>