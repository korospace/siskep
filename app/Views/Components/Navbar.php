<div
    class="w-full px-7 py-3 backdrop-blur-md bg-white/30 flex justify-between items-center text-indigo-900 rounded-xl shadow-lg">
    <div>
        <span class="opacity-80 text-xs">Pages / <?= $title; ?></span>
        <p class="text-sm text-bold capitalize"><?= $title; ?></p>
    </div>
    <div
        id="toggle_nav" 
        class="sm:hidden opacity-80 active:opacity-100 transition transform active:scale-90 cursor-pointer">
        <p class="bg-indigo-900 w-7 h-1 mb-1"></p>
        <p class="bg-indigo-900 w-7 h-1 mb-1"></p>
        <p class="bg-indigo-900 w-7 h-1 mb-1"></p>
    </div>
</div>