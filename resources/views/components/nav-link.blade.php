<div class="text-center lg:mt-5 hover:scale-105 ease-in-out duration-300">
    <a {{ $attributes->merge(['class' => 'navBtn block px-2 py-1 bg-gray-50 rounded-lg text-lg md:text-xl']) }}>
        {{ $slot }}
    </a>
</div>
