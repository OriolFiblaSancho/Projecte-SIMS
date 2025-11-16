<div class="p-6">
    <?php if (isset($data['error'])): ?>
        <p>Error loading dashboard data: <?php echo htmlspecialchars($data['error']); ?></p>
    <?php else: ?>
    <h3 class="text-lg font-semibold mb-4">Dashboard Overview</h3>
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h4 class="text-md font-medium">Total Users</h4>
            <p class="text-2xl font-bold text-[#0D6344]"><?php echo htmlspecialchars($data['totalUsers']); ?></p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h4 class="text-md font-medium">Total Vehicles</h4>
            <p class="text-2xl font-bold text-[#0D6344]"><?php echo htmlspecialchars($data['totalVehicles']); ?></p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h4 class="text-md font-medium">Total Geofencing Zones</h4>
            <p class="text-2xl font-bold text-[#0D6344]"><?php echo htmlspecialchars($data['totalZones']); ?></p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h4 class="text-md font-medium">Total Balance</h4>
            <p class="text-2xl font-bold text-[#0D6344]">€ <?php echo htmlspecialchars(number_format($data['totalBalance'], 2)); ?></p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h4 class="text-md font-medium">Verified Users</h4>
            <p class="text-2xl font-bold text-[#0D6344]"><?php echo htmlspecialchars($data['verifiedUsers']); ?></p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h4 class="text-md font-medium">Available Vehicles</h4>
            <p class="text-2xl font-bold text-[#0D6344]"><?php echo htmlspecialchars($data['availableVehicles']); ?></p>
        </div>
    </div>
    <div class="mt-6">
        <h4 class="text-lg font-semibold mb-4">User Registrations by Month</h4>
        <?php
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $maxVal = max($data['usersByMonth']);
        $scale = $maxVal > 0 ? 120 / $maxVal : 0;
        $barWidth = 30;
        $startX = 60;
        $spacing = 35;
        ?>
        <svg width="600" height="200" class="border rounded bg-gray-50">
            <!-- Y-axis -->
            <line x1="50" y1="20" x2="50" y2="150" stroke="#0D6344" stroke-width="2"/>
            <!-- Grid lines -->
            <line x1="50" y1="150" x2="550" y2="150" stroke="#ccc" stroke-width="1"/>
            <line x1="50" y1="110" x2="550" y2="110" stroke="#ccc" stroke-width="1"/>
            <line x1="50" y1="70" x2="550" y2="70" stroke="#ccc" stroke-width="1"/>
            <line x1="50" y1="30" x2="550" y2="30" stroke="#ccc" stroke-width="1"/>
            <!-- Y labels -->
            <text x="40" y="155" text-anchor="end" font-size="10">0</text>
            <text x="40" y="115" text-anchor="end" font-size="10"><?php echo round($maxVal * 0.25); ?></text>
            <text x="40" y="75" text-anchor="end" font-size="10"><?php echo round($maxVal * 0.5); ?></text>
            <text x="40" y="35" text-anchor="end" font-size="10"><?php echo round($maxVal * 0.75); ?></text>
            <!-- Bars -->
            <?php for($i = 0; $i < 12; $i++): ?>
                <?php
                $x = $startX + $i * $spacing;
                $height = $data['usersByMonth'][$i+1] * $scale;
                $y = 150 - $height;
                ?>
                <rect x="<?php echo $x; ?>" y="<?php echo $y; ?>" width="<?php echo $barWidth; ?>" height="<?php echo $height; ?>" fill="#0D6344" rx="4"/>
                <?php if($height > 20): ?>
                    <text x="<?php echo $x + $barWidth/2; ?>" y="<?php echo $y + 15; ?>" text-anchor="middle" font-size="10" fill="white"><?php echo $data['usersByMonth'][$i+1]; ?></text>
                <?php endif; ?>
                <text x="<?php echo $x + $barWidth/2; ?>" y="170" text-anchor="middle" font-size="10"><?php echo $months[$i]; ?></text>
            <?php endfor; ?>
        </svg>
    </div>
    <?php endif; ?>
    <div id="toast" class="fixed bottom-4 right-4 bg-red-500 text-white p-4 rounded shadow-lg transform translate-y-full transition-transform duration-300 z-50 hidden">
        <p id="toast-message"></p>
    </div>
    <script>
    function showToast(message, type = 'error') {
        const toast = document.getElementById('toast');
        const msg = document.getElementById('toast-message');
        msg.textContent = message;
        toast.className = `fixed bottom-4 right-4 p-4 rounded shadow-lg transform transition-transform duration-300 z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
        toast.classList.remove('hidden');
        setTimeout(() => {
            toast.classList.remove('translate-y-full');
        }, 100);
        setTimeout(() => {
            toast.classList.add('translate-y-full');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 300);
        }, 3000);
    }
    </script>
    <?php if (isset($data['error'])): ?>
        <script>showToast('<?php echo addslashes($data['error']); ?>');</script>
    <?php endif; ?>
</div>