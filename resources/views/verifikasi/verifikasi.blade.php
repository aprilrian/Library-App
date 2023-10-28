@extends('layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
         <div class="flex items-center justify-center h-20 mb-4 rounded bg-gray-50 dark:bg-gray-800">
             <p class="text-3xl font-bold text-gray-900 dark:text-white">Verifikasi Anggota</p>
         </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-sm text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-5 text-sm">
                                Nomor KTP
                            </th>
                            <th scope="col" class="px-6 py-5 text-sm">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-5 text-sm">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-5 text-sm">
                                Alamat
                            </th>
                            <th scope="col" class="px-6 py-5 text-sm">
                                Kota
                            </th>
                            <th scope="col" class="px-6 py-5 text-sm">
                                Aksi
                            </th>
                        </tr>
                        @foreach($anggota as $a)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-4">{{ $a['noktp'] }}
                            <td class="px-6 py-4">{{ $a['nama'] }}
                            <td class="px-6 py-4">{{ $a['email'] }}
                            <td class="px-6 py-4">{{ $a['alamat'] }}
                            <td class="px-6 py-4">{{ $a['kota'] }}
                            <td class="px-6 py-4">{{ $a['aksi']}}
                                <form method="POST" action="{{ route('verifikasi') }}">
                                    @csrf
                                    <input type="hidden" name="noktp" value="{{ $a['noktp'] }}">
                                    <button type="submit" class="btn btn-primary px-2 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" data-toggle="modal" data-target="#resultModal">Verifikasi</button>
                                </form>
                            </tr>
                    </thead>
                            <tbody>
                            </td>
                        </tr>
                        @endforeach
                </table>
            </div>
        @if(session('success'))
        <div class="p-4 mt-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="p-4 mt-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
            {{ session('error') }}
        </div>
    </div>
</div>
@endif
@endsection
