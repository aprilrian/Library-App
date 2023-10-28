@extends('layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
         <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
             <p class="text-3xl font-bold text-gray-900 dark:text-white">Daftar Buku</p>
         </div>

            <div class="py-12 flex items-center justify-center">
                <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        @if(session('success'))
                        <div class="p-4 mt-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif
                        <div class="p-6 text-gray-900 dark:text-gray-100 relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table border="1" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class=" text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 text-center">
                                    <tr>
                                        <th class="border px-4 py-2">ID</th>
                                        <th class="border px-4 py-2">ISBN</th>
                                        <th class="border px-4 py-2">Judul Buku</th>
                                        <th class="border px-4 py-2">Deskripsi</th>
                                        <th class="border px-4 py-2">Stok</th>
                                        <th class="border px-4 py-2">Stok Tersedia</th>
                                        <th class="border px-4 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($buku as $b)
                                    <tr class="text-s bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border py2">{{ $b->id }}</th>
                                        <td class="border px-4 py-2">{{ $b->isbn }}</td>
                                        <td class="border px-4 py-2">
                                            <img src="{{ asset('buku/'.$b->file_gambar) }}" alt="Book Cover" class="w-10 h-10 inline-block align-middle">
                                            <br>
                                            <span class="inline-block align-middle ml-2">{{ $b->judul }}</span>
                                        </td>
                                        <td class="border px-4 py-2">
                                            Pengarang: {{ $b->pengarang }}
                                            <br>
                                            Kategori: {{ $b->nama_kategori }}
                                            <br>
                                            Penerbit: {{ $b->penerbit }}, {{ $b->kota_terbit }}
                                            <br>
                                            Editor: {{ $b->editor }}
                                        </td>
                                        <td class="border px-4 py-2">{{ $b->stok }}</td>
                                        <td class="border px-4 py-2">{{ $b->stok_tersedia }}</td>
                                        <td class="border px-4 py-2">
                                            <form action="{{ route('buku.destroy', $b->isbn) }}" method="POST" class="flex justify-center">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('buku.edit', $b->isbn) }}" class="text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">Edit</a>
                                                <button class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
