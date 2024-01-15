@extends('layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
         <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
             <p class="text-3xl font-bold text-gray-900 dark:text-white">Form Pengembalian Buku</p>
         </div>
         <form action="{{ route('transaksi.form-pengembalian', ['idtransaksi' => $transaksi->idtransaksi]) }}" method="POST" class="p-3">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="tgl_kembali" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pengembalian:</label>
                <input type="date" class="@error('tgl_kembali') is-invalid @enderror block w-1/2 p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="tgl_kembali" name="tgl_kembali" >
                @error('tgl_kembali')
                <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 w-1/2">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Simpan</button>
        </form>
        @if(session('success'))
        <div class="p-4 mt-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="p-4 mt-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            {{ session('error') }}
        </div>
        @endif
        </div>
    </div>
</div>
@endsection

<script>
    function addField(button) {
        var bukuTable = document.getElementById("buku-table");
        var newRow = document.createElement("tr");

        var bukuCell = document.createElement("td");
        var bukuContainer = document.createElement("div");
        bukuContainer.classList.add("mb-2");
        var bukuInput = document.createElement("input");
        bukuInput.type = "text";
        bukuInput.classList.add("block", "w-full", "p-2", "text-gray-900", "border", "border-gray-300", "rounded-lg", "bg-gray-50", "sm:text-xs", "focus:ring-blue-500", "focus:border-blue-500", "dark:bg-gray-700", "dark:border-gray-600", "dark:placeholder-gray-400", "dark:text-white", "dark:focus:ring-blue-500", "dark:focus:border-blue-500");
        bukuInput.name = "buku[]";
        bukuContainer.appendChild(bukuInput);

        bukuCell.appendChild(bukuContainer);

        var removeCell = document.createElement("td");
        var removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.classList.add("text-white", "bg-red-600", "hover:bg-red-700", "focus:ring-4", "focus:ring-red-300", "font-medium", "rounded-lg", "text-sm", "px-5", "py-2.5", "mr-2", "mb-2", "dark:bg-red-600", "dark:hover:bg-red-700", "focus:outline-none", "dark:focus:ring-red-800", "ml-2");
        removeButton.innerText = "Kurangi Buku";
        removeButton.onclick = function() {
            newRow.remove();
            button.disabled = false; // Re-enable the Add Field button
        };
        removeCell.appendChild(removeButton);

        newRow.appendChild(bukuCell);
        newRow.appendChild(removeCell);

        bukuTable.appendChild(newRow);

        button.disabled = true; // Disable the Add Field button after clicking it
    }
</script>
