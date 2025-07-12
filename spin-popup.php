<style>
  #spinModal {
    backdrop-filter: blur(5px);
  }
</style>

<div id="spinModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-purple-800 rounded-2xl shadow-2xl p-6 w-[360px] h-[420px] relative flex flex-col items-center">
    <!-- Close Button -->
    <button onclick="closeSpinModal()" 
      class="absolute top-4 right-4 text-white hover:text-red-600 text-2xl font-bold transition">&times;</button>

    <!-- Modal Title -->
    <h2 class="text-white text-2xl font-bold mb-6 mt-2">🎉 Spin to Win 🎁</h2>

    <!-- Wheel Container -->
    <div class="relative w-72 h-72">
      <canvas id="wheelCanvas" width="288" height="288" class="rounded-full shadow-lg"></canvas>

      <!-- Needle -->
      <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 w-0 h-0 text-red-600 
                  border-l-[12px] border-r-[12px] border-t-[30px] 
                  border-l-transparent border-r-transparent border-b-red-600 z-20 drop-shadow-lg"></div>

      <!-- Spin Button -->
      <button id="spinBtn" 
        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
               bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold px-6 py-3 rounded-full 
               shadow-lg hover:from-purple-700 hover:to-indigo-700 active:scale-95 transition-transform">
        SPIN
      </button>

      <!-- Prize Message -->
      <div id="prizeMessage" 
        class="absolute bottom-6 left-1/2 transform -translate-x-1/2 bg-white text-gray-900 
               p-4 rounded-xl shadow-xl text-center w-64 hidden z-30 select-none">
        <p class="font-extrabold text-xl mb-2" id="prizeText"></p>
        <p class="font-extrabold text-xl mb-2">Join with us now to claim</p>
        <a href="https://fwsuperace.xyz/kh/en" 
          class="inline-block bg-indigo-600 text-white px-5 py-2 rounded-full font-semibold 
                 hover:bg-indigo-700 transition">
          Join Now
        </a>
      </div>
    </div>
  </div>
</div>

<script src="js/spin_script.js"></script>
