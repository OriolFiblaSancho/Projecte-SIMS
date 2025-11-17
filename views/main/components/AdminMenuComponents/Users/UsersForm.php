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
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('username_label'), ENT_QUOTES) ?></label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" placeholder="<?= htmlspecialchars(t('username_label'), ENT_QUOTES) ?>" class="border border-gray-300 rounded-md p-2 w-full mb-2" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('email_label'), ENT_QUOTES) ?></label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" placeholder="<?= htmlspecialchars(t('email_label'), ENT_QUOTES) ?>" class="border border-gray-300 rounded-md p-2 w-full mb-2" required>
            </div>
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('user_name_label'), ENT_QUOTES) ?></label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '') ?>" placeholder="<?= htmlspecialchars(t('user_name_label'), ENT_QUOTES) ?>" class="border border-gray-300 rounded-md p-2 w-full mb-2">
            </div>
            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('last_name_label'), ENT_QUOTES) ?></label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name'] ?? '') ?>" placeholder="<?= htmlspecialchars(t('last_name_label'), ENT_QUOTES) ?>" class="border border-gray-300 rounded-md p-2 w-full mb-2">
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('phone_label'), ENT_QUOTES) ?></label>
                <input type="text" name="phone" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="<?= htmlspecialchars(t('phone_label'), ENT_QUOTES) ?>" class="border border-gray-300 rounded-md p-2 w-full mb-2">
            </div>
            <div>
                <label for="driver_license" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('driver_license_label'), ENT_QUOTES) ?></label>
                <input type="text" name="driver_license" value="<?= htmlspecialchars($user['driver_license'] ?? '') ?>" placeholder="<?= htmlspecialchars(t('driver_license_label'), ENT_QUOTES) ?>" class="border border-gray-300 rounded-md p-2 w-full mb-2">
            </div>
            <div>
                <label for="user_type" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('user_type_label'), ENT_QUOTES) ?></label>
                <select name="user_type" class="border border-gray-300 rounded-md p-2 w-full mb-2">
                    <?php $ut = $user['user_type'] ?? 'customer'; ?>
                    <option value="customer" <?= $ut === 'customer' ? 'selected' : '' ?>><?= htmlspecialchars(t('user_type_customer'), ENT_QUOTES) ?></option>
                    <option value="admin" <?= $ut === 'admin' ? 'selected' : '' ?>><?= htmlspecialchars(t('user_type_admin'), ENT_QUOTES) ?></option>
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('status_label'), ENT_QUOTES) ?></label>
                <select name="status" class="border border-gray-300 rounded-md p-2 w-full mb-2">
                    <?php $st = $user['status'] ?? 'non-verified'; ?>
                    <option value="verified" <?= $st === 'verified' ? 'selected' : '' ?>><?= htmlspecialchars(t('status_verified'), ENT_QUOTES) ?></option>
                    <option value="non-verified" <?= $st === 'non-verified' ? 'selected' : '' ?>><?= htmlspecialchars(t('status_non_verified'), ENT_QUOTES) ?></option>
                    <option value="suspended" <?= $st === 'suspended' ? 'selected' : '' ?>><?= htmlspecialchars(t('status_suspended'), ENT_QUOTES) ?></option>
                </select>
            </div>
            <div>
                <label for="balance" class="block text-sm font-medium text-gray-700 mb-1"><?= htmlspecialchars(t('balance_label'), ENT_QUOTES) ?></label>
                <input type="number" step="0.01" name="balance" value="<?= htmlspecialchars($user['balance'] ?? '0.00') ?>" placeholder="0.00" class="border border-gray-300 rounded-md p-2 w-full mb-2">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    <?= htmlspecialchars(t('password_label'), ENT_QUOTES) ?>
                    <?php if ($isEdit): ?>
                    <?php endif; ?>
                </label>
                <input type="password" name="password" placeholder="<?= htmlspecialchars(t('password_label'), ENT_QUOTES) ?>" class="border border-gray-300 rounded-md p-2 w-full mb-2" <?= $isEdit ? '' : 'required' ?>>
            </div>
        </div>

        <button type="submit" class="mt-2 bg-[#ddfae8] text-[#0D6344] rounded-md p-2 w-full hover:bg-[#0D6344] hover:text-white border border-[#0D6344] border-2">
            <?= $isEdit ? htmlspecialchars(t('update_user'), ENT_QUOTES) : htmlspecialchars(t('add_user'), ENT_QUOTES) ?>
        </button>
    </form>
</div>
