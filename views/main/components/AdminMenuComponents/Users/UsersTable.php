<div class="flex flex-col rounded-md p-3 max-h-[60vh] overflow-auto">
    <div class="flex justify-center">
        <a href="?admin=FormUsers">
            <button class="bg-[#f0e0ff] text-black rounded-md p-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
            </button>
        </a>
    </div>

    <div class="overflow-x-auto mt-2">
        <table class="min-w-full divide-y divide-gray-200 bg-white shadow-sm rounded-md overflow-hidden">
            <thead class="bg-[#7E3FBC] text-white text-left text-xs font-semibold uppercase">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Username</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Balance</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2" colspan="3">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if (empty($users)): ?>
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-4 py-6 text-sm text-gray-500 text-center" colspan="8">No users found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-800"><?php echo htmlspecialchars(($u['name'] ?? '') . ' ' . ($u['last_name'] ?? '')); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($u['email'] ?? ''); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($u['username'] ?? ''); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700"><?php echo htmlspecialchars($u['user_type'] ?? ''); ?></td>
                            <td class="px-4 py-3 text-sm text-gray-700">€ <?php echo htmlspecialchars(number_format((float)($u['balance'] ?? 0), 2)); ?></td>

                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <?php echo htmlspecialchars($u['status'] ?? ''); ?>
                                </span>
                            </td>
                            <td>
                                <!-- View Button (opcional) -->
                                <a href="?admin=FormUsers&id=<?= $u['user_id'] ?>" class="px-2 py-3" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                        <path d="M13.488 2.513a1.75 1.75 0 0 0-2.475 0L6.75 6.774a2.75 2.75 0 0 0-.596.892l-.848 2.047a.75.75 0 0 0 .98.98l2.047-.848a2.75 2.75 0 0 0 .892-.596l4.261-4.262a1.75 1.75 0 0 0 0-2.474Z" />
                                        <path d="M4.75 3.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h6.5c.69 0 1.25-.56 1.25-1.25V9A.75.75 0 0 1 14 9v2.25A2.75 2.75 0 0 1 11.25 14h-6.5A2.75 2.75 0 0 1 2 11.25v-6.5A2.75 2.75 0 0 1 4.75 2H7a.75.75 0 0 1 0 1.5H4.75Z" />
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <!-- Delete Button -->
                                <a href="/users/delete/<?= $u['user_id'] ?>" class="px-2 py-3" title="Delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                        <path fill-rule="evenodd" d="M5 3.25V4H2.75a.75.75 0 0 0 0 1.5h.3l.815 8.15A1.5 1.5 0 0 0 5.357 15h5.285a1.5 1.5 0 0 0 1.493-1.35l.815-8.15h.3a.75.75 0 0 0 0-1.5H11v-.75A2.25 2.25 0 0 0 8.75 1h-1.5A2.25 2.25 0 0 0 5 3.25Zm2.25-.75a.75.75 0 0 0-.75.75V4h3v-.75a.75.75 0 0 0-.75-.75h-1.5ZM6.05 6a.75.75 0 0 1 .787.713l.275 5.5a.75.75 0 0 1-1.498.075l-.275-5.5A.75.75 0 0 1 6.05 6Zm3.9 0a.75.75 0 0 1 .712.787l-.275 5.5a.75.75 0 0 1-1.498-.075l.275-5.5a.75.75 0 0 1 .786-.711Z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
