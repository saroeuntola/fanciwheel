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

  $relatedGames = $gameObj->getRelatedGames($id, $game['category_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($game['name']) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <?php include 'navbar.php'; ?>
  <?php include 'loading.php'; ?>

  <!-- Game Detail Section -->
  <div class="max-w-6xl mx-auto px-4 py-10">
  <div class="w-full max-w-3xl mx-auto ">
  <!-- Game Image -->
  <div class="w-full overflow-hidden rounded-2xl mb-6">
    <img
      src="<?= './admin/page/game/' . htmlspecialchars($game['image']) ?>"
      alt="<?= htmlspecialchars($game['name']) ?>"
      class="w-full h-64 sm:h-80 object-cover hover:scale-105 transition-transform duration-500 rounded-xl"
    />
  </div>

  <!-- Title -->
  <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-extrabold text-gray-800 mb-4">
    The company you keep can significantly <?= htmlspecialchars($game['name']) ?>
  </h1>

  <!-- Description -->
  <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
    <?= nl2br(htmlspecialchars($game['description'])) ?>.
  </p>
</div>

  </div>

  <!-- Related Games -->
  <div class="max-w-6xl mx-auto px-4 mb-16">
    <h2 class="text-xl sm:text-2xl font-bold mb-6">Related Post</h2>

    <?php if (count($relatedGames)): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($relatedGames as $related): ?>
          <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
            <a href="game-detail.php?id=<?= $related['id'] ?>">
              <img
                src="<?= './admin/page/game/' . htmlspecialchars($related['image']) ?>"
                alt="<?= htmlspecialchars($related['name']) ?>"
                class="w-full h-40 object-cover"
              />
              <div class="p-4">
                <h3 class="text-base font-semibold text-gray-800 truncate">
                  <?= htmlspecialchars($related['name']) ?>
                </h3>
                <p class="text-sm text-gray-500 mt-1 truncate">
                  <?= htmlspecialchars(substr($related['description'], 0, 60)) ?>…
                </p>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-600">No related games found.</p>
    <?php endif; ?>
  </div>

  <!-- Footer -->
  <?php include 'footer.php'; ?>
</body>
</html>
