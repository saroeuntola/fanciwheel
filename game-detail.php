<?php
  include "./admin/page/library/db.php";
  include "./admin/page/library/game_lib.php";

  if (!isset($_GET['id'])) {
      echo "Game ID not provided.";
      exit;
  }

  $id         = intval($_GET['id']);
  $gameObj    = new Games();
  $game       = $gameObj->getGameById($id);

  if (!$game) {
      echo "Game not found.";
      exit;
  }

  $relatedGames = $gameObj->getRelatedGames($id, $game['category_id'], 6);
  $popularGames = $gameObj->getPopularGames(8);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($game['name']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .line-clamp-3 {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .prose h2 {
      margin-bottom: 1.5rem;
    }
    
    .group:hover .group-hover\:opacity-80 {
      opacity: 0.8;
    }
    
    .group:hover .group-hover\:text-blue-600 {
      color: rgb(37 99 235);
    }
    
    .group:hover .group-hover\:scale-105 {
      transform: scale(1.05);
    }
    
    /* Custom scrollbar for sidebar */
    .sidebar-scroll::-webkit-scrollbar {
      width: 4px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-track {
      background: #f1f5f9;
      border-radius: 2px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 2px;
    }
    
    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">
  <?php include 'navbar.php'; ?>
  <?php include 'loading.php'; ?>

  <!-- Main Content Section -->
  <div class="max-w-7xl mx-auto px-4 py-8 lg:py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      
      <!-- Main Content Area -->
      <div class="lg:col-span-2 space-y-8">
        <!-- Game Detail Card -->
        <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
          <!-- Image -->
          <img
            src="<?= './admin/page/game/' . htmlspecialchars($game['image']) ?>"
            alt="<?= htmlspecialchars($game['name']) ?>"
            class="w-full h-64 object-cover rounded-xl mb-6"
          />

          <!-- Title -->
          <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3 leading-snug break-words">
  <?= htmlspecialchars($game['name']) ?>
</h1>
 
          <!-- Description -->
          <div class="text-gray-700 space-y-6 text-base leading-relaxed md:text-lg mb-10">
            <?= nl2br(htmlspecialchars($game['description'])) ?>The term originally referred to messages sent using the Short Message Service (SMS) on mobile devices. It has grown beyond alphanumeric text to include multimedia messages using the Multimedia Messaging Service (MMS) and Rich Communication Services (RCS), which can contain digital images, videos, and sound content, as well as ideograms known as emoji (happy faces, sad faces, and other icons), and on various instant messaging apps. Text messaging has been an extremely popular medium of communication since the turn of the century and has also influenced changes in societyThe term originally referred to messages sent using the Short Message Service (SMS) on mobile devices. It has grown beyond alphanumeric text to include multimedia messages using the Multimedia Messaging Service (MMS) and Rich Communication Services (RCS), which can contain digital images, videos, and sound content, as well as ideograms known as emoji (happy faces, sad faces, and other icons), and on various instant messaging apps. Text messaging has been an extremely popular medium of communication since the turn of the century and has also influenced changes in society
          </div>
        </div>

        <!-- Related Games Section -->
        <?php if (!empty($relatedGames)): ?>
        <div class="bg-white rounded-2xl shadow-md p-6 md:p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
            </svg>
            Related Games
          </h2>
          
          <!-- Grid Layout for Related Games -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($relatedGames as $related): ?>
              <div class="group bg-gray-50 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                <a href="game-detail.php?id=<?= $related['id'] ?>" class="block">
                  <!-- Game Image -->
                  <div class="relative overflow-hidden">
                    <img
                      src="<?= './admin/page/game/' . htmlspecialchars($related['image']) ?>"
                      alt="<?= htmlspecialchars($related['name']) ?>"
                      class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300"
                    />
                
                  </div>
                  
                  <!-- Game Content -->
                  <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-200">
                      <?= htmlspecialchars($related['name']) ?>
                    </h3>
                    <p class="text-gray-600 text-sm line-clamp-3">
                      <?= htmlspecialchars($related['description']) ?>
                    </p>
                    
                  
                  </div>
                </a>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <!-- Sidebar -->
      <div class="lg:col-span-1 space-y-8">
        <!-- Popular Posts -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            Popular Posts
          </h3>
          
          <div class="space-y-4">
            <?php foreach (array_slice($popularGames, 0, 5) as $index => $popular): ?>
              <div class="flex items-start space-x-3 group">
                <div class="flex-shrink-0">
                  <img
                    src="<?= './admin/page/game/' . htmlspecialchars($popular['image']) ?>"
                    alt="<?= htmlspecialchars($popular['name']) ?>"
                    class="w-16 h-16 object-cover rounded-lg group-hover:opacity-80 transition-opacity duration-200"
                  />
                </div>
                <div class="flex-1 min-w-0">
                  <a href="game-detail.php?id=<?= $popular['id'] ?>" class="block group-hover:text-blue-600 transition-colors duration-200">
                    <h4 class="text-sm font-semibold text-gray-900 truncate">
                      <?= htmlspecialchars($popular['name']) ?>
                    </h4>
                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                      <?= htmlspecialchars(substr($popular['description'], 0, 80)) ?>...
                    </p>
                    <span class="text-xs text-blue-600 mt-1 inline-block">
                      <?= htmlspecialchars($popular['category_name']) ?>
                    </span>
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <?php include 'footer.php'; ?>
</body>

</html>