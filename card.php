<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Trip Sans VF', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        background-color: #111827; /* Dark background */
        color: #f1f5f9; /* Light text */
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
        flex-wrap: wrap;
    }

    .games-title {
        font-size: 32px;
        font-weight: 700;
        color: #f9fafb;
        margin: 0;
    }

    .see-all-btn {
        background: none;
        border: 2px solid #f1f5f9;
        border-radius: 24px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 600;
        color: #f1f5f9;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }

    .see-all-btn:hover {
        background-color: #f1f5f9;
        color: #111827;
    }

    .games-subtitle {
        font-size: 14px;
        color: #94a3b8;
        margin-bottom: 24px;
        font-weight: 400;
    }

    .games-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
    }

    .game-card {
        background: #1f2937;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        transition: all 0.3s ease;
        position: relative;
        cursor: pointer;
        border: 1px solid #374151;
    }

    .game-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
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
        background: #374151;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
        color: #f9fafb;
    }

    .favorite-btn:hover {
        background-color: #ef4444;
        color: white;
    }

    .game-content {
        padding: 16px;
    }

    .game-rank,
    .game-name,
    .rating-score {
        color: #f9fafb;
    }

    .game-name:hover {
        color: #22c55e;
    }

    .rating-count,
    .game-category {
        color: #9ca3af;
    }

    .game-description {
        font-size: 14px;
        color: #e5e7eb;
        line-height: 1.4;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    .description-icon {
        width: 16px;
        height: 16px;
        color: #22c55e;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .no-image-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #9ca3af;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #6b7280;
        grid-column: 1 / -1;
    }

    .empty-state svg {
        width: 64px;
        height: 64px;
        margin-bottom: 16px;
        color: #4b5563;
    }

    #sortSelect {
        background-color: #1f2937;
        color: #f1f5f9;
        border: 1px solid #4b5563;
        border-radius: 9999px;
        padding: 8px 16px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    #sortSelect:hover {
        background-color: #374151;
    }

    .star {
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .star.filled {
        background-color: #22c55e;
    }

    .star.half {
        background: linear-gradient(90deg, #22c55e 50%, #4b5563 50%);
    }

    .star.empty {
        background-color: #4b5563;
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

<!-- HTML CONTENT START -->
<div class="games-container">
    <div class="games-header">
        <h1 class="games-title">Popular Cities in Bangladesh</h1>

        <!-- Sort dropdown -->
        <select id="sortSelect">
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
                      
                        <div class="game-category"><?= isset($g['category_name']) ? htmlspecialchars($g['category_name']) : '' ?></div>
                        <div class="game-description">
                           
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

<!-- Sort Script -->
<script>
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
</script>
