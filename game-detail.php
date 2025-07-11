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
    
    .prose h2 {
      margin-bottom: 1.5rem;
    }
    
    .group:hover .group-hover\:opacity-80 {
      opacity: 0.8;
    }
    
    .group:hover .group-hover\:text-blue-600 {
      color: rgb(37 99 235);
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

  <!-- Hero Image Section -->
  <div class="relative w-full h-64 sm:h-80 md:h-96 lg:h-[500px] overflow-hidden">
    <img
      src="<?= './admin/page/game/' . htmlspecialchars($game['image']) ?>"
      alt="<?= htmlspecialchars($game['name']) ?>"
      class="w-full h-full object-cover"
    />
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
      <div class="max-w-7xl mx-auto">
        <span class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-full mb-3">
          <?= htmlspecialchars($game['category_name']) ?>
        </span>
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-2 leading-tight">
          <?= htmlspecialchars($game['name']) ?>
        </h1>
      </div>
    </div>
  </div>

  <!-- Main Content Section -->
  <div class="max-w-7xl mx-auto px-4 py-8 lg:py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      
      <!-- Main Content Area -->
      <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8">
          <!-- Content -->
          <div class="prose prose-lg max-w-none">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">About This Game</h2>
            <div class="text-gray-700 leading-relaxed text-base md:text-lg">
              <?= nl2br(htmlspecialchars($game['description'])) ?>
            </div>
          </div>
          
          <!-- Action Buttons -->
          <div class="mt-8 pt-6 border-t border-gray-200">
            <?php if (!empty($game['game_link'])): ?>
              <a 
                href="<?= htmlspecialchars($game['game_link']) ?>" 
                target="_blank"
                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors duration-200 mr-4"
              >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1m6-6V7a2 2 0 00-2-2H5a2 2 0 00-2 2v3m2 4h10a2 2 0 002-2v-3a2 2 0 00-2-2H5a2 2 0 00-2 2v3z"></path>
                </svg>
                Play Game
              </a>
            <?php endif; ?>
            
            <button class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors duration-200">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
              </svg>
              Save to Favorites
            </button>
          </div>
        </div>
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
                  <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-orange-400 to-red-500 text-white text-sm font-bold rounded-full">
                    <?= $index + 1 ?>
                  </span>
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

        <!-- Related Posts -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
          <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
            </svg>
            Related Posts
          </h3>
          
          <?php if (count($relatedGames)): ?>
            <div class="space-y-4">
              <?php foreach ($relatedGames as $related): ?>
                <div class="group">
                  <a href="game-detail.php?id=<?= $related['id'] ?>" class="block">
                    <div class="flex space-x-3">
                      <div class="flex-shrink-0">
                        <img
                          src="<?= './admin/page/game/' . htmlspecialchars($related['image']) ?>"
                          alt="<?= htmlspecialchars($related['name']) ?>"
                          class="w-16 h-16 object-cover rounded-lg group-hover:opacity-80 transition-opacity duration-200"
                        />
                      </div>
                      <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                          <?= htmlspecialchars($related['name']) ?>
                        </h4>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                          <?= htmlspecialchars(substr($related['description'], 0, 60)) ?>...
                        </p>
                        <div class="flex items-center mt-2">
                          <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                            <?= htmlspecialchars($related['category_name']) ?>
                          </span>
                        </div>
                      </div>
                    </div>
                  </a>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p class="text-gray-500 text-sm">No related games found.</p>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include 'footer.php'; ?>
</body>
</html>
