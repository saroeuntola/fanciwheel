<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Trip Sans VF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        background-color: #faf1ed;
        color: #1a1a1a;
        line-height: 1.5;
    }

    .games-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 32px 20px;
    }

    .games-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .games-title {
        font-size: 32px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 0;
    }

    .see-all-btn {
        background: none;
        border: 2px solid #1a1a1a;
        border-radius: 24px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }

    .see-all-btn:hover {
        background-color: #1a1a1a;
        color: white;
    }

    .games-subtitle {
        font-size: 14px;
        color: #5a5a5a;
        margin-bottom: 24px;
        font-weight: 400;
    }

    .games-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
    }

    .game-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        cursor: pointer;
    }

    .game-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .game-image {
        position: relative;
        height: 260px;
        overflow: hidden;
    }

    .game-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .game-card:hover .game-image img {
        transform: scale(1.05);
    }

    .favorite-btn {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 32px;
        height: 32px;
        background: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease;
    }

    .favorite-btn:hover {
        background-color: #ff4757;
        color: white;
    }

    .favorite-btn svg {
        width: 16px;
        height: 16px;
    }

    .game-content {
        padding: 16px;
    }

    .game-rank {
        font-size: 18px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 8px;
    }

    .game-name {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 8px;
        text-decoration: none;
    }

    .game-name:hover {
        color: #00aa6c;
    }

    .game-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .rating-score {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
    }

    .rating-stars {
        display: flex;
        gap: 2px;
    }

    .star {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .star.filled {
        background-color: #00aa6c;
    }

    .star.half {
        background: linear-gradient(90deg, #00aa6c 50%, #d4d4d4 50%);
    }

    .star.empty {
        background-color: #d4d4d4;
    }

    .rating-count {
        font-size: 14px;
        color: #5a5a5a;
    }

    .game-category {
        font-size: 14px;
        color: #5a5a5a;
        margin-bottom: 12px;
    }

    .game-description {
        font-size: 14px;
        color: #1a1a1a;
        line-height: 1.4;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    .description-icon {
        width: 16px;
        height: 16px;
        color: #00aa6c;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .no-image-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #5a5a5a;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #5a5a5a;
        grid-column: 1 / -1;
    }

    .empty-state svg {
        width: 64px;
        height: 64px;
        margin-bottom: 16px;
        color: #d4d4d4;
    }

    @media (max-width: 768px) {
        .games-grid {
            grid-template-columns: 1fr;
        }
        
        .games-title {
            font-size: 24px;
        }
        
        .games-container {
            padding: 20px 16px;
        }
    }
</style>
<div class="games-container">
    <div class="games-header">
        <h1 class="sm:text-2xl md:text-2xl lg:text-3xl text-black">
            Popular Cities in Bangladesh
        </h1>

        <!-- Filter Sort Dropdown -->
        <select id="sortSelect" class="border border-gray-800 rounded-full px-4 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-800 hover:text-white transition">
            <option value="">Filter Sort</option>
            <option value="asc" <?= isset($_GET['sort']) && $_GET['sort'] === 'asc' ? 'selected' : '' ?>>A–Z</option>
            <option value="desc" <?= isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'selected' : '' ?>>Z–A</option>
        </select>
    </div>

    <p class="games-subtitle">
        These rankings are informed by user reviews, ratings, number of downloads, and gameplay hours.
    </p>

    <div class="games-grid">
        <?php
       
        // Sorting logic
        if (isset($_GET['sort']) && in_array($_GET['sort'], ['asc', 'desc'])) {
            usort($games, function ($a, $b) {
                $order = $_GET['sort'] === 'asc' ? 1 : -1;
                return $order * strcmp($a['name'], $b['name']);
            });
        }
        ?>

        <?php if (!empty($games)): ?>
            <?php foreach ($games as $index => $g): ?>
                <div class="game-card" onclick="window.location.href='detail.php?id=<?= $g['id'] ?>'">
                    <div class="game-image">
                        <?php if (!empty($g['image'])): ?>
                            <img src="<?= './admin/page/game/' . htmlspecialchars($g['image']) ?>"
                                 alt="<?= htmlspecialchars($g['meta_text']) ?>">
                        <?php else: ?>
                            <div class="no-image-placeholder">
                                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>No Image</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="game-content">
                        <div class="game-rank"><?= ($index + 1) ?>. <?= htmlspecialchars($g['name']) ?></div>
                        <div class="game-rating">
                            <span class="rating-score"><?= isset($g['rating']) ? number_format($g['rating'], 1) : '4.2' ?></span>
                            <div class="rating-stars">
                                <?php 
                                $rating = isset($g['rating']) ? $g['rating'] : 4.2;
                                for ($i = 1; $i <= 5; $i++): 
                                    if ($i <= floor($rating)): ?>
                                        <div class="star filled"></div>
                                    <?php elseif ($i <= ceil($rating) && $rating - floor($rating) >= 0.5): ?>
                                        <div class="star half"></div>
                                    <?php else: ?>
                                        <div class="star empty"></div>
                                    <?php endif;
                                endfor; ?>
                            </div>
                            <span class="rating-count"><?= isset($g['review_count']) ? number_format($g['review_count']) : rand(100, 2000) ?></span>
                        </div>
                        <div class="game-category"><?= isset($g['category_name']) ? htmlspecialchars($g['category_name']) : '' ?></div>
                        <div class="game-description">
                            <svg class="description-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span><?= htmlspecialchars(substr($g['description'], 0, 120)) ?><?= strlen($g['description']) > 120 ? '...' : '' ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414a1 1 0 00-.707-.293H4"/>
                </svg>
                <h3 style="font-size: 20px; font-weight: 600; margin-bottom: 8px;">No Posts Found</h3>
                <p>No content found in this category. Try selecting a different category.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
// Helpers
function generateStarRating($rating, $maxStars = 5) {
    $html = '<div class="rating-stars">';
    for ($i = 1; $i <= $maxStars; $i++) {
        if ($i <= floor($rating)) {
            $html .= '<div class="star filled"></div>';
        } elseif ($i <= ceil($rating) && ($rating - floor($rating)) >= 0.5) {
            $html .= '<div class="star half"></div>';
        } else {
            $html .= '<div class="star empty"></div>';
        }
    }
    $html .= '</div>';
    return $html;
}

function formatNumber($number) {
    if ($number >= 1000000) {
        return number_format($number / 1000000, 1) . 'M';
    } elseif ($number >= 1000) {
        return number_format($number / 1000, 1) . 'K';
    }
    return number_format($number);
}

function truncateText($text, $length = 120) {
    return strlen($text) > $length ? substr($text, 0, $length) . '...' : $text;
}
?>

<script>
    // Handle sort select dropdown
    document.getElementById('sortSelect').addEventListener('change', function () {
        const selected = this.value;
        const url = new URL(window.location.href);
        if (selected) {
            url.searchParams.set('sort', selected);
        } else {
            url.searchParams.delete('sort');
        }
        window.location.href = url.toString();
    });

    // Optional visual feedback
    document.querySelectorAll('.game-card').forEach(card => {
        card.addEventListener('click', function () {
            this.style.opacity = '0.7';
            this.style.pointerEvents = 'none';
        });
    });
</script>

