<?php
include('../library/game_lib.php');
include('../library/category_lib.php');
include('../library/checkroles.php');

protectPathAccess();

$product = new Games();
$category = new Category();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

$productData = $product->getGameById($id);
if (!$productData) {
    die("Game not found");
}
}
$categories = $category->getCategories();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gameName = $_POST['name'];
    $description = $_POST['description'];
    $game_link = $_POST['game_link'];
    $categoryId = $_POST['category_id'];
    $meta_text = $_POST['meta_text'];

    // Handle Image Upload
     $imagePath = $productData['image']; // Default to the existing image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = "game_image/";
        $imagePath = $uploadDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    if ($product->updateGame($id, $gameName, $imagePath, $description, $game_link, $categoryId, $meta_text)) {
        header("Location: index.php");
        exit;
    }
     else {
        echo "<p class='text-red-500'>Error: Product could not be created.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Edit Post</h2>

        <?php if (isset($error)): ?>
            <p class="text-red-500 text-center"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <!-- Edit Product Form -->
        <form action="edit.php?id=<?php echo $productData['id']; ?>" method="POST" enctype="multipart/form-data">
            <!-- Product Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="name" value="<?= htmlspecialchars($productData['name']) ?>" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <!-- Product Image -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Image</label>
                <img src="<?= htmlspecialchars($productData['image']) ?>" class="h-20 w-20 object-cover rounded-md">
                <input type="file" name="image" class="mt-2">
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3" required
                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?= htmlspecialchars($productData['description']) ?></textarea>
            </div>
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Meta Text image</label>
                <textarea name="meta_text" rows="3" required
                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"><?= htmlspecialchars($productData['meta_text']) ?></textarea>
               
        
            </div>
            <!-- game_link -->
            <div class="mb-4">
                <label for="game_link" class="block text-sm font-medium text-gray-700">link</label>
                <input type="text" name="game_link" step="0.01" value="<?= htmlspecialchars($productData['game_link']) ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            

            <!-- Category -->
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($cat['id'] == $productData['category_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-center">
                <button type="submit"
                        class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Update
                </button>
            </div>
        </form>
    </div>
</body>
</html>
