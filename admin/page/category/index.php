<?php

include('../library/category_lib.php');
include('../library/checkroles.php');
include('../library/users_lib.php');
$category = new Category();
protectPathAccess();
$categories = $category->getCategories();


?>

<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Dashboard</title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
	<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
	<link rel="stylesheet" href="../assets/css/ready.css">
	<link rel="stylesheet" href="../assets/css/demo.css">
	<link rel="stylesheet" href="../assets/css/style.css">
     <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <div class="logo-header">
                <a href="#" class="logo">
                    Dashboard
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <button class="topbar-toggler more"><i class="la la-ellipsis-v"></i></button>

            <!-- navbar -->
            </div>
            <!-- Corrected path for navbar.php -->
            <?php include "../include/navbar.php"; ?>
        </div>

        <!-- sidebar -->
        <div class="sidebar">
            <!-- Corrected path for sidebar.php -->
            <?php include "../include/sidebar.php"; ?>
        </div>

<!-- page content  -->
        <div class="main-panel" id="content">
           <div class="mt-5">
        <h2 class="text-2xl font-bold mb-6">Categories List</h2>
        <a href="create.php" class='text-white bg-blue-600 px-3 py-2 rounded-md '>Create</a>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg mt-3 shadow-md">
    <thead>
        <tr class="text-left text-sm font-medium text-gray-600 bg-gray-50">
            <th class="px-6 py-4 border-b">ID</th>
            <th class="px-6 py-4 border-b">Category Name</th>
            <th class="px-6 py-4 border-b">Created At</th>
            <th class="px-6 py-4 border-b">Actions</th>
        </tr>
    </thead>

    <tbody>
         <?php if (!empty($categories)): ?>
    <?php foreach ($categories as $row): ?>
        <tr class="text-gray-700 hover:bg-gray-50 transition">
            <td class="px-4 py-3 border-b">
                <img src="<?= htmlspecialchars($row['cat_image']) ?>" alt="" class="h-12 w-12 object-cover rounded-md">
            </td>
            <td class="px-4 py-3 border-b"><?= htmlspecialchars($row['name']) ?></td>

            <td class="px-4 py-3 border-b"><?= date("Y-m-d", strtotime($row['created_at'])) ?></td>
            <td class="px-4 py-3 border-b">
                <a href="edit.php?id=<?= $row['id'] ?>" class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 mr-2">Edit</a>
                <a href="delete.php?id=<?= $row['id'] ?>" class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="8" class="px-4 py-3 text-center text-gray-500">No products found</td>
    </tr>
<?php endif; ?>

</tbody>
        </table>

    </div>

            <!-- 
            <footer class="footer">
                
            </footer> 
            -->
        </div>
    </div>
</div>
</body>

<!-- Corrected path for js.php -->
<?php include "../include/js.php"; ?>

</body>
</html>
