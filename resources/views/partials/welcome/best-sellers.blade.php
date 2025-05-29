<section class="flex items-center justify-between w-full max-w-6xl mx-auto text-black dark:text-white" id="products">
    <div class="w-full my-24">
        <h4 class="text-4xl font-bold mb-12">Our Best Sellers</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <x-products-cards image="{{ asset('assets/product3.jpg') }}" title="Radiance Boost Serum"
                author="A lightweight serum enriched with vitamin C to brighten and even out skin tone." price="₱1,250" />

            <x-products-cards image="{{ asset('assets/product2.jpg') }}" title="Hydrating Night Cream"
                author="Deeply moisturizes and rejuvenates skin overnight with natural botanical extracts."
                price="₱1,800" />

            <x-products-cards image="{{ asset('assets/product1.jpg') }}" title="Gentle Cleanser"
                author="A soothing cleanser that removes impurities without stripping skin’s natural moisture."
                price="₱850" />
        </div>
    </div>
</section>
