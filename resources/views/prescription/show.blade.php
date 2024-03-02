<x-app-layout>
    <div class="w-3/4 mx-auto text-center" style="margin-top: 100px; margin-bottom: 100px;">
        <!-- Set width to 75%, center it, and center all items -->
        <h1 class="text-black text-lg font-bold">Prescription Id : {{ $prescription->id }}</h1>
        <div class="max-w-3/4 lg:max-w-4/5 mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div>
                @if (!auth()->user()->isAdmin())
                    <div>
                        <a href="{{ route('prescriptions.show', $prescription->id) }}">
                            <div class="max-w-3/4 lg:max-w-4/5" style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                                <p style="margin: 10px; padding: 10px;">Delivery Address :
                                    {{ $prescription->delivery_address }}</p>
                                <p style="margin: 10px; padding: 10px; color:blue;">
                                    {{ $prescription->created_at->diffForHumans() }}</p>
                            </div>
                        </a>

                        <div class="max-w-3/4 lg:max-w-4/5" style="margin: 20px; display: flex; justify-content: space-between;">
                            <a href="{{ $prescription->attachment }}">Attachments :</a>
                            <div>
                                @foreach (json_decode($prescription->attachment, true) as $image)
                                    @if (!empty($image))
                                        <a href="/storage/{{ $image }}" target="_blank">
                                            <img src="/storage/{{ $image }}" alt="attachment" class="w-20 h-20"
                                                style="margin-right: 10px; padding-right: 10px;">
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex justify-between">
                        <div
                            style="background-color: grey; width: 45%; padding: 20px; height: 500px; border-right: 2px solid black; overflow-y: auto;">
                            <!-- Content for the first section -->
                            <div style="height: 80%; border-bottom: 2px solid black;">
                                <div id="previewImage" style="width: 100%; height: 100%; overflow: hidden;"></div>
                                <!-- Container to display the preview image -->
                            </div>
                            <div style="height: 20%; display: flex; align-items: center;">
                                @foreach (json_decode($prescription->attachment, true) as $image)
                                    @if (!empty($image))
                                        <!-- Trigger JavaScript function to display image in top section -->
                                        <a href="javascript:void(0);" onclick="displayImage('{{ $image }}')">
                                            <img src="/storage/{{ $image }}" alt="attachment" class="w-20 h-20"
                                                style="margin-right: 10px;">
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div style="background-color: grey; width: 55%; padding: 20px;">
                            <!-- Content for the second section -->
                            <div style="height: 60%; border-bottom: 2px solid black; overflow-y: auto;">
                                <!-- Table of drugs, quantity, and amount -->
                                <table id="drugTable" style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr style="border-bottom: 1px solid black;">
                                            <th style="border: 1px solid black; padding: 8px;">Drug</th>
                                            <th style="border: 1px solid black; padding: 8px;">Quantity</th>
                                            <th style="border: 1px solid black; padding: 8px;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="drugList">
                                        <tr style="border-bottom: 1px solid black;">
                                            {{-- <td style="border: 1px solid black; padding: 8px;">Drug 1</td>
                                            <td style="border: 1px solid black; padding: 8px;">10</td>
                                            <td style="border: 1px solid black; padding: 8px;">$100</td> --}}
                                        </tr>
                                        <!-- Add more rows if needed -->
                                    </tbody>
                                </table>
                            </div>
                            <div
                                style="height: 40%; display: flex; flex-direction: column; justify-content: space-between;">
                                <!-- Input fields for drug and quantity -->
                                <div>
                                    <br>
                                    <label for="drug" style="margin-bottom: 10px;">Drug:</label>
                                    <input type="text" id="drug" placeholder="Drug"
                                        style="margin-bottom: 10px; border: 1px solid black; padding: 5px;">
                                    <label for="quantity" style="margin-bottom: 10px;">Quantity:</label>
                                    <input type="text" id="quantity" placeholder="Quantity"
                                        style="margin-bottom: 10px; border: 1px solid black; padding: 5px;">
                                </div>
                                <!-- Add button -->
                                <div class="display-flex">
                                    <button id="addButton"
                                        style="width: 100px; padding: 10px; background-color: green; color: white; border: none;">Add</button>
                                </div>
                                <!-- Display total amount -->
                                <div id="totalAmount" style="padding: 8px; border-top: 1px solid black;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-4">
                        <x-primary-button>Send Quotation</x-primary-button>
                        
                    </div>
                @endif

                <br>

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
                    @if (auth()->user()->isAdmin())
                        <div class="flex">
                            <form action="{{ route('prescriptions.update', $prescription->id) }}" method="post">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="status" value="resolved" />
                                <x-primary-button>Resolve</x-primary-button>
                            </form>
                            <form action="{{ route('prescriptions.update', $prescription->id) }}" method="post">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="status" value="rejected" />
                                <x-primary-button class="ml-2">Reject</x-primary-button>
                            </form>
                        </div>
                    @else
                        <p class="text-white">Status: {{ $prescription->status }} </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function displayImage(imageUrl) {
            var previewDiv = document.getElementById('previewImage');
            previewDiv.innerHTML = '<img src="/storage/' + imageUrl +
                '" alt="attachment" style="width: 100%; height: 100%;">';
        }
    </script>

    <script>
        document.getElementById("addButton").addEventListener("click", function() {
            var drug = document.getElementById("drug").value;
            var quantity = document.getElementById("quantity").value;
            var amount = 100 * parseInt(quantity);
            var table = document.getElementById("drugList");
            var newRow = table.insertRow(table.rows.length);
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);
            cell1.innerHTML = drug;
            cell2.innerHTML = quantity;
            cell3.innerHTML = "$" + amount;
            newRow.style.borderBottom = "1px solid black";
            newRow.style.border = "1px solid black";
            newRow.style.padding = "8px";
            // Calculate total amount
            var totalAmount = 0;
            var rows = document.querySelectorAll("#drugList tr");
            for (var i = 1; i < rows.length; i++) {
                var rowCells = rows[i].getElementsByTagName("td");
                totalAmount += parseInt(rowCells[2].innerHTML.replace("$", ""));
            }
            document.getElementById("totalAmount").innerHTML = "Total Amount: $" + totalAmount;
        });
    </script>

</x-app-layout>
