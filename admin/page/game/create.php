<?php
include('../library/game_lib.php');
include('../library/category_lib.php');
include('../library/checkroles.php');
 protectPathAccess();
$product = new Games();
$category = new Category();
$categories = $category->getCategories();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gameName = $_POST['name'];
    $description = $_POST['description'];
    $game_link = $_POST['game_link']; 
    $categoryId = $_POST['category_id'];
    $meta_text = $_POST['meta_text'];

    // Handle Image Upload
    $imagePath = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = "game_image/";
        $imagePath = $uploadDir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath);
    }

    if ($product->createGames($gameName, $imagePath, $description, $game_link, $categoryId, $meta_text)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<p class='text-red-500'>Error: Content could not be created.</p>";
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Create Post</h2>

        <form action="create.php" method="POST" enctype="multipart/form-data">
            <!-- Product Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tilte</label>
                <input type="text" name="name" required class="w-full px-3 py-2 border rounded-md">
            </div>

            <!-- Product Image -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Upload Image</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border rounded-md">
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-md"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Meta Text</label>
        
                <textarea name="meta_text" rows="3" class="w-full px-3 py-2 border rounded-md"></textarea>
            </div>
            <!-- Price -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Link</label>
                <input type="text" name="game_link" step="0.01" class="w-full px-3 py-2 border rounded-md">
            </div>
            <!-- Category Dropdown -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" required class="w-full px-3 py-2 border rounded-md">
                    
                    <option value="">Select Category</option>
                        <?php
                        foreach ($categories as $categorys) {
                            echo "<option value='{$categorys['id']}'>{$categorys['name']}</option>";
                        }
                        ?>   
                   
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700">
                Post
            </button>
        </form>
    </div>
</body>
</html>
