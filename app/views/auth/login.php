<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Product System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-sm border border-gray-100">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Welcome Back</h1>
            <p class="text-sm text-gray-500 mt-1">Please sign in to access product management</p>
        </div>

        <?php if(!empty($error)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-4 text-sm rounded">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('index.php/login/submit'); ?>" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
            </div>

            <button type="submit" 
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md text-sm transition">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>