<section class="flex items-center justify-between w-full max-w-6xl mx-auto text-black dark:text-white" id="about">
    <div class="w-full my-24">
        <h4 class="text-4xl font-bold mb-12">How Our Skincare Benefits Both You and Your Skin</h4>

        <div class="flex justify-between gap-12 lg:flex-row flex-col-reverse">
            <div class="flex-1">
                <img src="{{ asset('assets/description.jpg') }}" class="h-[500px] w-full object-cover rounded-lg mb-4">
            </div>

            <div class="flex flex-col items-start gap-12 flex-1">
                <x-description title="Visible Results You Can Trust"
                    description="Our skincare formulas deliver real, lasting changes — so you can see and feel the difference.">
                    <x-heroicon-s-eye class="w-14 h-14" />
                </x-description>

                <x-description title="Gentle on All Skin Types"
                    description="Thoughtfully created with sensitive skin in mind, our products soothe, not irritate.">
                    <x-heroicon-s-heart class="w-14 h-14" />
                </x-description>

                <x-description title="Backed by Science"
                    description="We combine mindfulness with biotechnology to ensure safe, effective skincare backed by research.">
                    <x-heroicon-s-beaker class="w-14 h-14" />
                </x-description>

                <x-description title="Sustainable Beauty"
                    description="Eco-friendly packaging and cruelty-free practices make every product a conscious choice.">
                    <x-heroicon-s-globe-alt class="w-14 h-14" />
                </x-description>
            </div>
        </div>

        <a href="{{ route('register') }}">
            <div class="flex items-center justify-center mt-12">
                <div class="w-max">
                    <div class="dark:bg-white bg-black rounded-full px-6 py-2 flex items-center gap-1">
                        <div class="dark:text-black text-white">Order now </div> <x-heroicon-m-arrow-up-right
                            class="w-5 h-5 dark:text-black text-white" />
                    </div>
                </div>
            </div>
        </a>
    </div>
</section>
