<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold">{{ $product->name }}</h3>
                        <p class="text-xl text-gray-600 mt-2">${{ number_format($product->price_cents / 100, 2) }}</p>
                    </div>

                    <form action="{{ route('shop.buy', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Buy Now
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
