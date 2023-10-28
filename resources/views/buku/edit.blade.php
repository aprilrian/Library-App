@extends('layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
         <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
             <p class="text-3xl font-bold text-gray-900 dark:text-white">Edit Buku</p>
         </div>
            <form method="POST" autocomplete="on" action="{{ route('buku.update', ['isbn' => $buku->isbn]) }}" class="p-3 grid grid-cols-2 gap-4" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <label for="isbn" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">ISBN</label>
                    <input name="isbn" type="text" id="isbn" value="{{ $buku->isbn }}" class="@error('isbn') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('isbn')
                    <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="judul" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul Buku</label>
                    <input name="judul" type="text" id="judul" value="{{ $buku->judul }}" class="@error('judul') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('judul')
                    <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="pengarang" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Pengarang</label>
                    <input name="pengarang" type="text" id="pengarang" value="{{ $buku->pengarang }}" class="@error('pengarang') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('pengarang')
                    <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="penerbit" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Penerbit</label>
                    <input name="penerbit" type="text" id="penerbit" value="{{ $buku->penerbit }}" class="@error('penerbit') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('penerbit')
                    <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="kota_terbit" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Kota Terbit</label>
                    <input name="kota_terbit" type="text" id="kota_terbit" value="{{ $buku->kota_terbit }}" class="@error('kota_terbit') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('kota_terbit')
                    <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="editor" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Editor</label>
                    <input name="editor" type="text" id="editor" value="{{ $buku->editor }}" class="@error('editor') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('editor')
                    <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="stok" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok</label>
                    <input name="stok" type="text" id="stok" value="{{ $buku->stok }}" class="@error('stok') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('stok')
                    <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="stok_tersedia" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok Tersedia</label>
                    <input name="stok_tersedia" type="text" id="stok_tersedia" value="{{ $buku->stok_tersedia }}" class="@error('stok_tersedia') is-invalid @enderror block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 sm:text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('stok_tersedia')
                    <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="idkategori" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
                    <select name="idkategori" id="idkategori" class="@error('idkategori') is-invalid @enderror bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected value="" disabled>Pilih Kategori</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->idkategori }}" {{ ($buku->idkategori == $k->idkategori) ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('idkategori')
                    <div class="p-4 mt-3 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert"">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="file_gambar" class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar Buku</label>
                    <input name="file_gambar" id="file_gambar" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                </div>

                <div>
                    <button type="submit" class="ml-5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" value="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
