<section class="flex items-center justify-between w-full max-w-6xl mx-auto text-black dark:text-white">
    <div class="w-full py-24 my-24 rounded-2xl bg-cover bg-center"
        style="background-image: url('{{ asset('assets/newsletter.jpg') }}');">
        <div class="flex flex-col items-center justify-center gap-3 p-6">
            <h5 class="text-5xl font-bold max-w-sm text-center text-white">Subscribe to our newsletter</h5>
            <p class="text-sm text-white">Stay updated with our latest news and offers.</p>

            <div class="relative mt-6">
                <input type="email" placeholder="Enter your email"
                    class="px-6 py-3 rounded-full lg:w-96 w-72 bg-white text-black">
                <button
                    class="px-4 py-2 bg-black text-white rounded-full absolute right-1 top-1 cursor-pointer">Subscribe</button>
            </div>
        </div>
    </div>
</section>
