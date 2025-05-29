<div>
    <div class="my-6">
        <h1 class="text-3xl font-bold">Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{--
        <livewire:admin.dashboard-card :title="'Total Users'" :value="$totalUsers" /> --}}

        <div class="p-6 rounded-lg border dark:border-white/10 border-black/10">
            <div class="flex items-center justify-between">
                <p>Total Revenue</p>

                <x-heroicon-o-banknotes class="w-4 h-4" />
            </div>

            <h2 class="font-bold text-2xl mt-2">PHP0</h2>
        </div>

        <div class="p-6 rounded-lg border dark:border-white/10 border-black/10">
            <div class="flex items-center justify-between">
                <p>Products</p>

                <x-heroicon-o-archive-box class="w-4 h-4" />
            </div>

            <h2 class="font-bold text-2xl mt-2">0</h2>
        </div>

        <div class="p-6 rounded-lg border dark:border-white/10 border-black/10">
            <div class="flex items-center justify-between">
                <p>Sales</p>

                <x-heroicon-o-credit-card class="w-4 h-4" />
            </div>

            <h2 class="font-bold text-2xl mt-2">0</h2>
        </div>

        <div class="p-6 rounded-lg border dark:border-white/10 border-black/10">
            <div class="flex items-center justify-between">
                <p>Orders</p>

                <x-heroicon-o-shopping-cart class="w-4 h-4" />
            </div>

            <h2 class="font-bold text-2xl mt-2">0</h2>
        </div>
    </div>
</div>
