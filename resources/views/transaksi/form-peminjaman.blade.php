@extends('layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
         <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
             <p class="text-3xl font-bold text-gray-900 dark:text-white">Edit Buku</p>
         </div>
         <form action="{{ route('transaksi.form-peminjaman') }}" method="POST" class="p-3">
            @csrf
            <div class="mb-4">
                <label for="isbn" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor KTP Anggota</label>
                <input type="text" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="noktp" name="noktp" required>
            </div>

            <div class="mb-4">
                <label for="idbuku" class="text-gray-700 dark:text-white">ID Buku:</label>
                <table id="buku-table" class="w-full">
                    <tr>
                        <td class="w-3/4">
                            <div class="mb-2">
                                <input type="text" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="buku[]" value="{{ old('buku[]') }}">
                            </div>
                        </td>
                        <td class="w-1/4">
                            <button type="button" class="ml-2 focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" onclick="addField(this)">Tambah Buku</button>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="mb-4">
                <label for="tgl_pinjam" class="text-gray-700 dark:text-white">Tanggal Pinjam:</label>
                <input type="date" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="tgl_pinjam" name="tgl_pinjam" required>
            </div>

            <div class="mb-4">
                <label for="idpetugas" class="text-gray-700 dark:text-white">ID Petugas:</label>
                <input type="text" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="idpetugas" name="idpetugas" required>
            </div>

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Simpan</button>
        </form>
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