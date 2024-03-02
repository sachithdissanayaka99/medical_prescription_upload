<x-app-layout>
    <div class="w-3/4 mx-auto text-center" style="margin-top: 100px; margin-bottom: 100px;">
        <!-- Set width to 75%, center it, and center all items -->
        @if (!auth()->user()->isAdmin())
            <h1 class="text-black text-lg font-bold">Your Order List</h1>
        @else
            <h1 class="text-black text-lg font-bold">All Orders</h1>
        @endif

        <div
            class="max-w-3/4 lg:max-w-4/5 mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            @foreach ($prescriptions as $prescription)
                <div>

                    <a href="{{ route('prescriptions.show', $prescription->id) }}">

                        <div class="max-w-3/4 lg:max-w-4/5"
                            style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                            <p style="margin: 10px; padding: 10px;">Prescription Id : {{ $prescription->id }}</p>
                            <p style="margin: 10px; padding: 10px;">Delivery Address :
                                {{ $prescription->delivery_address }}
                            </p>
                        </div>
                    </a>

                    <div class="max-w-3/4 lg:max-w-4/5"
                        style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                        <p> </p>
                        <p style="margin-right: 10px; padding-rigth: 10px; color:blue;">
                            {{ $prescription->created_at->diffForHumans() }}</p>

                    </div>
                </div>

                <hr> <!-- Divider -->
            @endforeach
        </div>
    </div>
</x-app-layout>
