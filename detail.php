<?php
include "./admin/page/library/db.php";
include "./admin/page/library/game_lib.php";

if (!isset($_GET['id'])) {
    echo "Game ID not provided.";
    exit;
}

$id = intval($_GET['id']);
$gameObj = new Games();
$game = $gameObj->getGameById($id);

if (!$game) {
    echo "Game not found.";
    exit;
}

$relatedGames = $gameObj->getRelatedGames($id, $game['category_id'], 6);
$popularGames = $gameObj->getPopularGames(8);

$gameImage = $game['image'] ?? 'default.png';
$metaText = $game['meta_text'] ?? 'Image';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($game['name'] ?? 'Detail') ?></title>
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
    .group:hover .group-hover\:opacity-80 { opacity: 0.8; }
    .group:hover .group-hover\:text-blue-400 { color: rgb(96 165 250); }
    .group:hover .group-hover\:scale-105 { transform: scale(1.05); }
  </style>
</head>
<body class="bg-gray-900 text-white">
<?php include 'navbar.php'; ?>
<?php include 'loading.php'; ?>
<?php include 'scroll-top-button.php'; ?>

<div class="max-w-7xl mx-auto px-4 py-8 lg:py-12">
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
      <!-- Game Detail -->
      <div class="bg-gray-800 rounded-2xl shadow-md p-6 md:p-8">
        <img
          src="<?= './admin/page/game/' . htmlspecialchars($gameImage) ?>"
          alt="<?= htmlspecialchars($metaText) ?>"
          class="w-full h-64 object-cover rounded-xl mb-6"
        />
        <h1 class="text-2xl sm:text-3xl font-bold text-white mb-3 leading-snug break-words">
          <?= htmlspecialchars($game['name'] ?? 'Unnamed Game') ?>
        </h1>
        <div class="text-gray-300 space-y-6 text-base leading-relaxed md:text-lg mb-10">
          <?= nl2br(htmlspecialchars($game['description'] ?? 'No description available.')) ?>
        </div>
      </div>

      <!-- Related Games -->
      <?php if (!empty($relatedGames)): ?>
        <div class="bg-gray-800 rounded-2xl shadow-md p-6 md:p-8">
          <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11V5a1 1 0 10-2 0v2a1 1 0 102 0zm-1 4a1 1 0 100-2 1 1 0 000 2zm0 2a1 1 0 000 2h.01a1 1 0 100-2H10z" clip-rule="evenodd" />
            </svg>
            Related Content
          </h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($relatedGames as $related): ?>
              <?php
                $relatedImage = $related['image'] ?? 'default.png';
                $relatedMeta = $related['meta_text'] ?? 'no image';
              ?>
              <div class="group bg-gray-700 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                <a href="detail.php?id=<?= $related['id'] ?>" class="block">
                  <div class="relative overflow-hidden">
                    <img
                      src="<?= './admin/page/game/' . htmlspecialchars($relatedImage) ?>"
                      alt="<?= htmlspecialchars($relatedMeta) ?>"
                      class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-300"
                    />
                  </div>
                  <div class="p-4">
                    <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-blue-400 transition-colors duration-200">
                      <?= htmlspecialchars($related['name'] ?? 'No Name') ?>
                    </h3>
                    <p class="text-gray-300 text-sm line-clamp-3">
                      <?= htmlspecialchars($related['description'] ?? 'No description') ?>
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
      <div class="bg-gray-800 rounded-2xl shadow-sm p-6">
        <h3 class="text-xl font-bold text-white mb-6 flex items-center">
          <svg class="w-5 h-5 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2 5a2 2 0 012-2h2.586a1 1 0 01.707.293l1.414 1.414A2 2 0 0010 5h6a2 2 0 012 2v8a2 2 0 01-2 2h-6a2 2 0 00-1.293.293l-1.414 1.414A1 1 0 015.586 19H4a2 2 0 01-2-2V5z" />
          </svg>
          Popular Posts
        </h3>
        <div class="space-y-4">
          <?php foreach (array_slice($popularGames, 0, 6) as $popular): ?>
            <?php
              $popularImage = $popular['image'] ?? 'default.png';
              $popularName = $popular['name'] ?? 'Popular Game';
              $popularDesc = $popular['description'] ?? '';
              $popularCategory = $popular['category_name'] ?? 'Uncategorized';
            ?>
            <div class="flex items-start space-x-3 group">
              <div class="flex-shrink-0">
                <img
                  src="<?= './admin/page/game/' . htmlspecialchars($popularImage) ?>"
                  alt="<?= htmlspecialchars($popularName) ?>"
                  class="w-16 h-16 object-cover rounded-lg group-hover:opacity-80 transition-opacity duration-200"
                />
              </div>
              <div class="flex-1 min-w-0">
                <a href="detail.php?id=<?= $popular['id'] ?>" class="block group-hover:text-blue-400 transition-colors duration-200">
                  <h4 class="text-sm font-semibold text-white truncate">
                    <?= htmlspecialchars($popularName) ?>
                  </h4>
                  <p class="text-xs text-gray-400 mt-1 line-clamp-2">
                    <?= htmlspecialchars(substr($popularDesc, 0, 80)) ?>...
                  </p>
                  <span class="text-xs text-blue-400 mt-1 inline-block">
                    <?= htmlspecialchars($popularCategory) ?>
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

<?php include 'footer.php'; ?>
</body>
</html>
