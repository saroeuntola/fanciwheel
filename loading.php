<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Page with Loader</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Spinner style */
    .loader {
      border-top-color: #3b82f6;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }
  </style>
</head>
<body>
  <!-- Loader -->
  <div id="pageLoader" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center transition-opacity duration-500">
    <div class="loader ease-linear rounded-full border-8 border-t-8 border-gray-200 h-16 w-16"></div>
  </div>
  <!-- Loader Script -->
  <script>
    window.addEventListener("load", () => {
      const loader = document.getElementById("pageLoader");
      loader.classList.add("opacity-0");
      setTimeout(() => {
        loader.style.display = "none";
      }, 500);
    });
  </script>
</body>
</html>
