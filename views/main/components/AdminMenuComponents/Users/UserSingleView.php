<div class="rounded-md bg-white/90 border border-[#7E3FBC] p-4 w-full max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <a href="?admin=ViewUsers" class="text-2xl text-[#7E3FBC] hover:opacity-80">&#8592;</a>
            <h2 class="text-xl font-semibold text-[#2d0a4a]">User details</h2>
        </div>
        <div class="flex items-center gap-2">
            <a href="/users/delete/<?= $user['user_id'] ?>" onclick="return confirm('Delete this user?');" class="px-4 py-2 rounded-md bg-purple-600 text-white hover:bg-purple-600">Delete</a>
            <a href="?admin=FormUsers&id=<?= $user['user_id'] ?>" class="px-4 py-2 rounded-md bg-green-700 text-white hover:bg-green-800">Edit</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Username -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">Username</div>
            <div class="text-xl font-bold text-gray-800"><?= htmlspecialchars($user['username'] ?? '') ?></div>
        </div>

        <!-- Full name -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">Name</div>
            <div class="text-xl font-bold text-gray-800"><?= htmlspecialchars(($user['name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?></div>
        </div>

        <!-- Email -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">Email</div>
            <div class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($user['email'] ?? '') ?></div>
        </div>

        <!-- Phone -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">Phone</div>
            <div class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($user['phone'] ?? '') ?></div>
        </div>

        <!-- User Type -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">Type</div>
            <div class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($user['user_type'] ?? '') ?></div>
        </div>

        <!-- Status -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm">
            <div class="text-xs text-gray-500 uppercase">Status</div>
            <div class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($user['status'] ?? '') ?></div>
        </div>

        <!-- Driver license -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm md:col-span-2">
            <div class="text-xs text-gray-500 uppercase">Driver license</div>
            <div class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($user['driver_license'] ?? '') ?></div>
        </div>

        <!-- Balance -->
        <div class="bg-green-50 p-4 rounded-md shadow-sm md:col-span-2">
            <div class="text-xs text-gray-500 uppercase">Balance</div>
            <div class="text-2xl font-bold text-gray-800">€ <?= htmlspecialchars(number_format((float)($user['balance'] ?? 0), 2)) ?></div>
        </div>
    </div>
</div>
