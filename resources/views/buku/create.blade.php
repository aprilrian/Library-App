@extends('layouts.main')

@section('content')

<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
         <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
             <p class="text-3xl font-bold text-gray-900 dark:text-white">Tambah Buku</p>
         </div>
            <form method="POST" autocomplete="on" action="{{route('buku.store')}}" class="p-3 ">
                @csrf
                <div>
                    <label for="isbn" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">ISBN</label>
                    <input name="isbn" type="text" id="isbn" value="{{ old('isbn') }}" required class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label for="judul" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Buku</label>
                    <input name="judul" type="text" id="judul" value="{{ old('judul') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label for="pengarang" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Pengarang</label>
                    <input name="pengarang" type="text" id="pengarang" value="{{ old('pengarang') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label for="penerbit" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Penerbit</label>
                    <input name="penerbit" type="text" id="penerbit" value="{{ old('penerbit') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label for="kota_terbit" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Kota Terbit</label>
                    <input name="kota_terbit" type="text" id="kota_terbit" value="{{ old('kota_terbit') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label for="editor" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Editor</label>
                    <input name="editor" type="text" id="editor" value="{{ old('editor') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label for="stok" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok</label>
                    <input name="stok" type="text" id="stok" value="{{ old('stok') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>

                <div>
                    <label for="stok_tersedia" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok Tersedia</label>
                    <input name="stok_tersedia" type="text" id="stok_tersedia" value="{{ old('stok_tersedia') }}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </div>


                <div>
                    <label for="kategori" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                    <select name="idkategori" id="kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value=""{{ old('idkategori') == '' ? 'selected' : '' }} disabled>Pilih Kategori</option>
                        <option value="1" {{ old('idkategori') == '1' ? 'selected' : '' }}>Fiksi</option>
                        <option value="2" {{ old('idkategori') == '2' ? 'selected' : '' }}>Non-Fiksi</option>
                        <option value="3" {{ old('idkategori') == '3' ? 'selected' : '' }}>Sains</option>
                        <option value="4" {{ old('idkategori') == '4' ? 'selected' : '' }}>Sejarah</option>
                        <option value="5" {{ old('idkategori') == '5' ? 'selected' : '' }}>Romansa</option>
                    </select>
                </div>

                <div>
                    <label for="file_gambar" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar Buku</label>
                    <input name="file_gambar"" id="file_gambar" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                </div>

                <div>
                    <button type="submit" class="ml-5 mt-5" value="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
