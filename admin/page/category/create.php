<?php
include('../library/category_lib.php');
include('../library/checkroles.php');
protectPathAccess();

$category = new Category();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['name'];
    $imagePath = "";

    if (isset($_FILES['cat_image']) && $_FILES['cat_image']['error'] == 0) {
        $uploadDir = "cat_image/";
        $fileName = basename($_FILES["cat_image"]["name"]);
        $imagePath = $uploadDir . $fileName;
        move_uploaded_file($_FILES["cat_image"]["tmp_name"], $imagePath);
    }

    if ($category->createCategory($categoryName, $imagePath)) {
        header("Location: index.php");
        exit;
    } else {
        echo "<p class='text-red-500'>Error: Category could not be created.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Category</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold text-center mb-6">Create Category</h2>

    <!-- Category Form -->
    <form action="create.php" method="POST" enctype="multipart/form-data">
      
      <!-- Category Name -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Category Name</label>
        <input type="text" name="name" required
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
      </div>

      <!-- Category Image -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Category Image</label>
        <input type="file" name="cat_image" id="cat_image" accept="image/*"
               class="mt-1 block w-full text-sm text-gray-700">
        <div class="mt-4">
          <img id="preview" src="" alt="Image Preview"
               class="w-full h-48 object-cover rounded border border-gray-300 hidden">
        </div>
      </div>

      <!-- Submit -->
      <div>
        <button type="submit"
                class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500">
          Create Category
        </button>
      </div>
    </form>
  </div>

  <!-- Preview Script -->
  <script>
    const input = document.getElementById('cat_image');
    const preview = document.getElementById('preview');

    input.addEventListener('change', () => {
      const file = input.files[0];
      if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
      } else {
        preview.src = '';
        preview.classList.add('hidden');
      }
    });
  </script>

</body>
</html>
