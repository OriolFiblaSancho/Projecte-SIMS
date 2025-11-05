<div>
    <?php
        $isEdit = isset($user) && is_array($user) && !empty($user);
        $action = $isEdit ? "/users/update/{$user['user_id']}" : "/users/create";
    ?>
    <form class="mt-5" action="<?= $action ?>" method="POST">
        <?php if ($isEdit): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($user['user_id']) ?>">
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" placeholder="Username" class="border border-gray-300 rounded-md p-2 w-full mb-2" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" placeholder="Email" class="border border-gray-300 rounded-md p-2 w-full mb-2" required>
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" placeholder="Name" class="border border-gray-300 rounded-md p-2 w-full mb-2" required>
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last name</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" placeholder="Last name" class="border border-gray-300 rounded-md p-2 w-full mb-2">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="Phone" class="border border-gray-300 rounded-md p-2 w-full mb-2">
            </div>
            <div>
                <label for="driver_license" class="block text-sm font-medium text-gray-700 mb-1">Driver license</label>
                <input type="text" name="driver_license" value="<?= htmlspecialchars($user['driver_license'] ?? '') ?>" placeholder="Driver license" class="border border-gray-300 rounded-md p-2 w-full mb-2">
            </div>
            <div>
                <label for="user_type" class="block text-sm font-medium text-gray-700 mb-1">User type</label>
                <select name="user_type" class="border border-gray-300 rounded-md p-2 w-full mb-2">
                    <?php $ut = $user['user_type'] ?? 'customer'; ?>
                    <option value="customer" <?= $ut === 'customer' ? 'selected' : '' ?>>Customer</option>
                    <option value="admin" <?= $ut === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="border border-gray-300 rounded-md p-2 w-full mb-2">
                    <?php $st = $user['status'] ?? 'non-verified'; ?>
                    <option value="verified" <?= $st === 'verified' ? 'selected' : '' ?>>Verified</option>
                    <option value="non-verified" <?= $st === 'non-verified' ? 'selected' : '' ?>>Non-verified</option>
                    <option value="suspended" <?= $st === 'suspended' ? 'selected' : '' ?>>Suspended</option>
                </select>
            </div>
            <div>
                <label for="balance" class="block text-sm font-medium text-gray-700 mb-1">Balance</label>
                <input type="number" step="0.01" name="balance" value="<?= htmlspecialchars($user['balance'] ?? '0.00') ?>" placeholder="0.00" class="border border-gray-300 rounded-md p-2 w-full mb-2">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <?= $isEdit ? '(leave blank to keep)' : '' ?></label>
                <input type="password" name="password" placeholder="Password" class="border border-gray-300 rounded-md p-2 w-full mb-2" <?= $isEdit ? '' : 'required' ?>>
            </div>
        </div>

        <button type="submit" class="mt-2 bg-[#CB97FF] text-black rounded-md p-2 w-full hover:bg-[#7E3FBC] hover:border-[#f0e0ff] hover:text-white bg-[#f0e0ff] border border-[#7E3FBC] border-[2px]">
            <?= $isEdit ? 'Update User' : 'Add User' ?>
        </button>
    </form>
</div>
