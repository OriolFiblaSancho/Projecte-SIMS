<?php
// Reserve modal and overlay component
?>
<div id="overlay" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
  <div id="reserve_modal" class="not-collapse-bottom bg-white rounded-lg shadow-lg h-auto w-2/3 justify-center items-center">
    <div id="reserve_modal_content" class="w-full h-full py-6 px-4">
      <h2 class="text-2xl font-bold mb-1 text-center">Are you sure?</h2>
      <p class="text-base text-gray-600 mb-4 text-center">Reserve this vehicle</p>
      <div class="flex flex-col gap-3">
        <button class="w-full bg-white border-2 border-gray-200 text-gray-800 rounded-full px-4 py-3 text-base font-medium text-xl" id="close_reserve_modal">Cancel</button>
        <button class="w-full bg-purple-600 hover:bg-purple-700 text-white rounded-full px-4 py-3 text-base font-semibold text-xl" id="confirm_reserve_modal">Reserve</button>
      </div>
    </div>
  </div>
</div>
