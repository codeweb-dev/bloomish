<footer
    class="flex flex-col sm:flex-row items-center justify-between w-full mt-6 max-w-6xl mx-auto bg-black dark:bg-white text-white dark:text-black p-6 text-center sm:text-left gap-4 sm:gap-0 rounded-2xl">

    <div class="flex flex-col gap-1">
        <h6 class="font-bold text-lg">Bloomish</h6>
        <p class="text-xs">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>
    </div>

    <ul class="flex flex-wrap justify-center sm:justify-end items-center gap-4 sm:gap-6 text-xs lg:text-sm">
        <li>Services</li>
        <li>Pricing</li>
        <li>About</li>
        <li>Contact</li>
    </ul>
</footer>
