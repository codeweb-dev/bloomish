<section class="flex items-center justify-between w-full max-w-6xl mx-auto text-black dark:text-white" id="home">
    <div class="w-full my-24">
        <div class="flex flex-col md:flex-row items-center justify-between gap-12">
            <div class="flex flex-col items-start gap-6 max-w-xl w-full">
                <div class="flex items-center gap-2">
                    <x-heroicon-s-paper-airplane class="w-6 h-6" />
                    <p class="text-sm uppercase text-black dark:text-white font-bold">FREE DELIVERY
                        WORLDWIDE</p>
                </div>

                <h1 class="text-6xl font-bold">Love Your Skin, Everyday</h1>

                <p>Experience radiant, healthy skin every day with our clean, science-powered skincare. Carefully
                    formulated with high-performance botanicals and advanced biotechnology, our cruelty-free products
                    deliver visible results while supporting sustainable, eco-conscious beauty.</p>

                <a href="{{ route('register') }}">
                    <div class="flex items-center gap-6 justify-center">
                        <div class="w-max">
                            <div class="dark:bg-white bg-black rounded-full px-6 py-2 flex items-center gap-1">
                                <div class="dark:text-black text-white">Order now </div> <x-heroicon-m-arrow-up-right
                                    class="w-5 h-5 dark:text-black text-white" />
                            </div>
                        </div>

                        <p class="dark:text-white text-black">Find Out More</p>
                    </div>
                </a>
            </div>

            <div class="flex-1 w-full h-full flex items-center justify-center relative px-4 sm:px-0">
                <div class="absolute -top-4 right-10 bg-[#dab8bf] w-24 h-24 sm:w-32 sm:h-32 rounded-full"></div>

                <img src="{{ asset('assets/landing.jpg') }}"
                    class="w-64 h-64 sm:w-full sm:h-[500px] object-cover mb-4 rounded-full z-40">

                <div
                    class="absolute -bottom-2 -right-2 sm:-bottom-16 sm:-right-16 bg-[#F4CBD3] w-40 h-40 sm:w-64 sm:h-64 rounded-full">
                </div>
            </div>

        </div>
    </div>
</section>
