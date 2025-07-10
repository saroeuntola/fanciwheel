<section class="py-16 from-white to-slate-50">
    <!-- Game Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      <?php if (!empty($games)): ?>
        <?php foreach ($games as $g): ?>
          <div class="group relative bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-500 overflow-hidden border border-slate-200/50 hover:border-blue-300/50 hover:-translate-y-2">
            <!-- Game Image -->
            <div class="relative overflow-hidden">
              <a href="game-detail.php?id=<?= $g['id'] ?>" class="block">
                <?php if (!empty($g['image'])): ?>
                  <img src="<?= './admin/page/game/' . htmlspecialchars($g['image']) ?>"
                       alt="<?= htmlspecialchars($g['name']) ?>"
                       class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-700">
                <?php else: ?>
                  <div class="w-full h-48 bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                    <div class="text-center">
                      <svg class="w-12 h-12 text-slate-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                      <span class="text-slate-500 text-sm font-medium">No Image</span>
                    </div>
                  </div>
                <?php endif; ?>
              </a>
            </div>

            <!-- Game Info -->
            <div class="p-5">
              <h3 class="text-lg font-bold mb-2 text-slate-800 group-hover:text-blue-600 transition-colors duration-300 line-clamp-1">
                <a href="game-detail.php?id=<?= $g['id'] ?>" class="hover:text-blue-600">
                  <?= htmlspecialchars($g['name']) ?>
                </a>
              </h3>
              <p class="text-slate-600 text-sm mb-4 line-clamp-2 leading-relaxed">
                <?= htmlspecialchars($g['description']) ?>
              </p>
            </div>

            <!-- Shine Effect -->
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -skew-x-12 translate-x-[-200%] group-hover:translate-x-[200%] transition-transform duration-1000"></div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Empty State -->
        <div class="col-span-full text-center py-16">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-slate-100 rounded-full mb-4">
            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414a1 1 0 00-.707-.293H4"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-slate-700 mb-2">No Games Found</h3>
          <p class="text-slate-500">No games found in this category. Try selecting a different category.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>