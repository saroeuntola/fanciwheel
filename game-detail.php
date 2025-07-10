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
<body class="bg-gray-100">
  <?php include 'navbar.php'; ?>
  <?php include 'loading.php'; ?>

  <!-- Game Detail -->
  <div class="max-w-5xl mx-auto py-12 px-4 mb-10">
    <div class="bg-white rounded-3xl shadow-2xl p-6 md:p-10">
      <div class="flex flex-col md:flex-row gap-8">
        <!-- Game Image -->
        <div class="md:w-1/2 overflow-hidden rounded-2xl">
          <img
            src="<?= './admin/page/game/' . htmlspecialchars($game['image']) ?>"
            alt="<?= htmlspecialchars($game['name']) ?>"
            class="w-full h-auto object-cover hover:scale-105 transition-transform duration-500 "
          />
        </div>

        <!-- Game Info -->
        <div class="md:w-1/2 flex flex-col justify-between">
          <div>
            <h1 class="text-4xl font-extrabold text-gray-800 mb-4">
              <?= htmlspecialchars($game['name']) ?>
            </h1>
            <p class="text-lg text-gray-600 mb-6 leading-relaxed">
              <?= nl2br(htmlspecialchars($game['description'])) ?>
            </p>
          </div>

          <!-- Action Button -->
          <a
            href="<?= htmlspecialchars($game['game_link']) ?>"
            class="inline-block w-full md:w-auto text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-full font-semibold shadow hover:from-indigo-700 hover:to-purple-700 transition-all duration-300"
            target="_blank" rel="noopener noreferrer"
          >
            Play Now
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Related Games -->
  <div class="max-w-5xl mx-auto px-4 mb-16">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Games</h2>
    <?php if (count($relatedGames)): ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <?php foreach ($relatedGames as $related): ?>
          <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
            <a href="game-detail.php?id=<?= $related['id'] ?>">
              <img
                src="<?= './admin/page/game/' . htmlspecialchars($related['image']) ?>"
                alt="<?= htmlspecialchars($related['name']) ?>"
                class="w-full h-40 object-cover"
              />
              <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 truncate">
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
