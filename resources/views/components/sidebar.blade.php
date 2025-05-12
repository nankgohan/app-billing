<aside
    id="sidebar"
    class="fixed md:relative w-64 h-full bg-white shadow-md md:shadow-none transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-10">
    <div class="p-4 border-b border-gray-200">
        <h2 class="text-xl font-semibold text-gray-800">
            {{ $header }}
        </h2>
    </div>
    <nav class="p-4">
        <ul class="space-y-2">
            {{ $slot }} <!-- Item menu akan dimasukkan di sini -->
        </ul>
    </nav>
</aside>