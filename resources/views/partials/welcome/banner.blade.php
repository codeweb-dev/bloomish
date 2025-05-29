<section class="flex items-center justify-between w-full max-w-6xl mx-auto text-black dark:text-white">
    <div class="w-full py-24 my-24 rounded-2xl bg-cover bg-center"
        style="background-image: url('{{ asset('assets/banner-ad.jpg') }}');">
        <div class="flex flex-col gap-3 p-6">
            <h5 class="text-5xl font-bold text-black">Pure Ingredients.</h5>
            <h5 class="text-5xl font-bold text-black">Noticeable Results.</h5>
            <h5 class="text-5xl font-bold text-black">No Trade-Offs.</h5>
            <p class="text-sm text-black">Premium skincare grounded in mindfulness and advanced science.</p>

            <a href="{{ route('register') }}">
                <div class="w-max">
                    <div class="text-white bg-black rounded-full px-6 py-2 mt-6 flex items-center gap-1">
                        <div class="text-white">Discover more </div> <x-heroicon-m-arrow-up-right
                            class="w-5 h-5 text-white" />
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
