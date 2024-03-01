<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 ">
        @foreach ($prescriptions as $prescription)
            <div class="w-full sm:max-w-4xl mx-auto mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
                style="width: 75vw;">

                <div class="text-black flex justify-between py-4">
                    <p>{{ 'Prescription Id :' . $prescription->id }}</p>
                    <p>{{ $prescription->created_at->diffForHumans() }}</p>

                </div>

                <div class="px-6 py-4">

                    <p>{{ 'Note :' . $prescription->notes }}</p>
                    <p >{{ 'Address :' . $prescription->delivery_address }}</p>

                    <br>
                    @if ($prescription->attachment)
                        <!-- Assuming you want to display the first attachment -->
                        @php $index = 1; @endphp
                        <div
                            style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 10px;">
                            <p>Attachments:</p>
                            @foreach (json_decode($prescription->attachment) as $attachment)
                                <div>
                                    <a href="{{ asset('storage/' . $attachment) }}" target="_blank"
                                        style="display: inline-block; padding: 10px; background-color: #4CAF50; color: white; text-align: center; text-decoration: none; display: inline-block; border-radius: 5px; transition: background-color 0.3s ease;">{{ ' ' . 'attachment : ' . $index }}</a><br>
                                </div>
                                @php $index++; @endphp
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex justify-between">
                    <div class="flex">
                        <a href="{{ route('prescriptions.edit', $prescription->id) }}">
                            <x-primary-button>Edit</x-primary-button>
                        </a>

                        <form class="ml-2" action="{{ route('prescriptions.destroy', $prescription->id) }}"
                            method="post">
                            @method('delete')
                            @csrf
                            <x-primary-button>Delete</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
