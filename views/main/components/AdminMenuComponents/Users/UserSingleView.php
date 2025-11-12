<div class="rounded-md bg-white/90 border border-[#0D6344] p-4 w-full max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
                <a href="?admin=ViewUsers" class="text-2xl text-[#0D6344] hover:opacity-80">&#8592;</a>
                <h2 class="text-xl font-semibold text-[#0D6344]">Detalls de l'usuari</h2>
            </div>
        <div class="flex items-center gap-2">
            <a href="/users/delete/<?= $user['user_id'] ?>" onclick="return confirm('Eliminar aquest usuari?');" class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700">Eliminar</a>
            <a href="?admin=FormUsers&id=<?= $user['user_id'] ?>" class="px-4 py-2 rounded-md bg-[#0D6344] text-white hover:bg-[#0a4d34]">Editar</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

    <div class="bg-[#ddfae8] p-4 rounded-md shadow-sm border border-[#0D6344]/20">
            <div class="text-xs text-gray-600 uppercase">Username</div>
            <div class="text-xl font-bold text-[#0D6344]"><?= htmlspecialchars($user['username'] ?? '') ?></div>
        </div>

        <div class="bg-[#ddfae8] p-4 rounded-md shadow-sm border border-[#0D6344]/20">
            <div class="text-xs text-gray-600 uppercase">Name</div>
            <div class="text-xl font-bold text-[#0D6344]"><?= htmlspecialchars(($user['name'] ?? '') . ' ' . ($user['last_name'] ?? '')) ?></div>
        </div>

        <div class="bg-[#ddfae8] p-4 rounded-md shadow-sm border border-[#0D6344]/20">
            <div class="text-xs text-gray-600 uppercase">Email</div>
            <div class="text-lg font-semibold text-[#0D6344]"><?= htmlspecialchars($user['email'] ?? '') ?></div>
        </div>

        <div class="bg-[#ddfae8] p-4 rounded-md shadow-sm border border-[#0D6344]/20">
            <div class="text-xs text-gray-600 uppercase">Phone</div>
            <div class="text-lg font-semibold text-[#0D6344]"><?= htmlspecialchars($user['phone'] ?? '') ?></div>
        </div>

        <div class="bg-[#ddfae8] p-4 rounded-md shadow-sm border border-[#0D6344]/20">
            <div class="text-xs text-gray-600 uppercase">Type</div>
            <div class="text-lg font-semibold text-[#0D6344]"><?= htmlspecialchars($user['user_type'] ?? '') ?></div>
        </div>

        <div class="bg-[#ddfae8] p-4 rounded-md shadow-sm border border-[#0D6344]/20">
            <div class="text-xs text-gray-600 uppercase">Status</div>
            <div class="text-lg font-semibold text-[#0D6344]"><?= htmlspecialchars($user['status'] ?? '') ?></div>
        </div>

        <div class="bg-[#ddfae8] p-4 rounded-md shadow-sm border border-[#0D6344]/20 md:col-span-2">
            <div class="text-xs text-gray-600 uppercase">Driver license</div>
            <div class="text-lg font-semibold text-[#0D6344]"><?= htmlspecialchars($user['driver_license'] ?? '') ?></div>
        </div>

        <div class="bg-[#ddfae8] p-4 rounded-md shadow-sm border border-[#0D6344]/20 md:col-span-2">
            <div class="text-xs text-gray-600 uppercase">Balance</div>
            <div class="text-2xl font-bold text-[#0D6344]">€ <?= htmlspecialchars(number_format((float)($user['balance'] ?? 0), 2)) ?></div>
        </div>
    </div>
</div>
