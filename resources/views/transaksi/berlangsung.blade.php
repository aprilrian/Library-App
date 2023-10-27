@extends('layouts.main')

@section('content')
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
       <div class="grid grid-cols-2 gap-4 mb-2">
          <div class="flex items-center justify-center h-12 rounded bg-gray-50 dark:bg-gray-800 col-span-2">
          <p class="text-2xl font-bold text-gray-900 dark:text-white">Riwayat Transaksi Berlangsung</p>
          </div>
    </div>
    <div class="py-10">
             <div class="bg-white dark:bg-gray-800 overflow-hidden sm:rounded-lg">
                 <div class="p-6 text-gray-900 dark:text-gray-100 relative overflow-x-auto sm:rounded-lg">
                     <table border="1" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                         <thead class=" text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 text-center">
                             <tr>
                                 <th class="border px-4 py-2">ID</th>
                                 <th class="border px-4 py-2">ISBN</th>
                                 <th class="border px-4 py-2">Nama Buku</th>
                                 <th class="border px-4 py-2">Nama Peminjam</th>
                                 <th class="border px-4 py-2">Tanggal Peminjaman</th>
                                 <th class="border px-4 py-2">Nama Petugas</th>
                             </tr>
                         </thead>
                         <tbody>
                             @foreach($transaksiBerlangsung as $t)
                                 <tr class="text-s bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center">
                                     <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border py2">{{ $t->idtransaksi }}</th>
                                     <td class="border px-4 py-2">{{ $t->isbn }}</td>
                                     <td class="border px-4 py-2">{{ $t->judul_buku }}</td>
                                     <td class="border px-4 py-2">{{ $t->nama }}</td>
                                     <td class="border px-4 py-2">{{ $t->tanggal_peminjaman }}</td>
                                     <td class="border px-4 py-2">{{ $t->namapetugas }}</td>
                                 </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
 </div>
@endsection
