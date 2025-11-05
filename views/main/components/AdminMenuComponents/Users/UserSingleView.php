<div class="rounded-md bg-white/90 border border-[#7E3FBC] p-4 max-w-md">
    <div class="flex justify-between items-center mb-3">
        <h2 class="text-lg font-semibold text-[#2d0a4a]">User details</h2>
        <a href="?admin=ViewUsers" class="text-sm text-[#7E3FBC] hover:underline">Back to users</a>
    </div>
    <dl class="text-sm text-gray-800">
        <div class="grid grid-cols-3 gap-2 py-1">
            <dt class="font-medium text-gray-600">ID</dt>
            <dd class="col-span-2"><?= htmlspecialchars($user['user_id']) ?></dd>
        </div>
        <div class="grid grid-cols-3 gap-2 py-1">
            <dt class="font-medium text-gray-600">Username</dt>
            <dd class="col-span-2"><?= htmlspecialchars($user['username'] ?? '') ?></dd>
        </div>
        <div class="grid grid-cols-3 gap-2 py-1">
            <dt class="font-medium text-gray-600">Name</dt>
            <dd class="col-span-2"><?= htmlspecialchars(($user['name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?></dd>
        </div>
        <div class="grid grid-cols-3 gap-2 py-1">
            <dt class="font-medium text-gray-600">Email</dt>
            <dd class="col-span-2"><?= htmlspecialchars($user['email'] ?? '') ?></dd>
        </div>
        <div class="grid grid-cols-3 gap-2 py-1">
            <dt class="font-medium text-gray-600">Phone</dt>
            <dd class="col-span-2"><?= htmlspecialchars($user['phone'] ?? '') ?></dd>
        </div>
        <div class="grid grid-cols-3 gap-2 py-1">
            <dt class="font-medium text-gray-600">Driver License</dt>
            <dd class="col-span-2"><?= htmlspecialchars($user['driver_license'] ?? '') ?></dd>
        </div>
        <div class="grid grid-cols-3 gap-2 py-1">
            <dt class="font-medium text-gray-600">Type</dt>
            <dd class="col-span-2"><?= htmlspecialchars($user['user_type'] ?? '') ?></dd>
        </div>
        <div class="grid grid-cols-3 gap-2 py-1">
            <dt class="font-medium text-gray-600">Balance</dt>
            <dd class="col-span-2">€ <?= htmlspecialchars(number_format((float)($user['balance'] ?? 0), 2)) ?></dd>
        </div>
        <div class="grid grid-cols-3 gap-2 py-1">
            <dt class="font-medium text-gray-600">Status</dt>
            <dd class="col-span-2"><span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-800 text-xs"><?= htmlspecialchars($user['status'] ?? '') ?></span></dd>
        </div>
        <div class="grid grid-cols-3 gap-2 py-1">
            <dt class="font-medium text-gray-600">Created</dt>
            <dd class="col-span-2"><?= htmlspecialchars($user['created_at'] ?? '') ?></dd>
        </div>
    </dl>
    <div class="mt-4 flex gap-2">
        <a class="bg-[#f0e0ff] border border-[#7E3FBC] text-black rounded-md px-3 py-1 text-sm hover:bg-[#d5c3eb]" href="?admin=FormUsers&id=<?= $user['user_id'] ?>">Edit</a>
        <a class="bg-red-50 border border-red-300 text-red-700 rounded-md px-3 py-1 text-sm hover:bg-red-100" href="/users/delete/<?= $user['user_id'] ?>" onclick="return confirm('Delete this user?');">Delete</a>
    </div>
</div>
