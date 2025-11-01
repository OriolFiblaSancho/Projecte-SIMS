<div class="flex flex-col rounded-md p-3 max-h-[60vh] overflow-auto">
    <div class="flex justify-center">
        <a href="?admin=FormVehicles">
        <button class="bg-[#f0e0ff] text-black rounded-md p-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
            </svg>
        </button>
    </a>
    </div>
    
    <ul>
    <?php foreach ($vehicles as $vehicle): ?>
        <li><?php echo htmlspecialchars($vehicle['model']); ?></li>
    <?php endforeach; ?>
    </ul>
</div>