@extends('layouts.main')

@section('content')
<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="text-gray-900 dark:text-white text-center mb-10">
            <img class="mx-auto w-48 h-48 border-gray-800" src="{{ asset('img/logo-pbp.png') }}" alt="Foto Pengguna">
            <div class="text-xl font-semibold">PERPUSTAKAAN ONLINE</div>
        </div>

        <div class="flex flex-wrap justify-between">
            @foreach ($buku as $b)
                <div class="max-w-sm my-7 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="card-body justify-center">
                        <table class="flex items-center justify-center">
                            <tr class="mt-3">
                                <td class="border px-4 py-2 flex justify-center">
                                    <img src="{{ asset('coverbuku/'.$b->file_gambar) }}" alt="Book Cover" class="w-10 h-10 inline-block align-middle">
                                </td>
                            </tr>
                            <tr class="mt-3">
                                <td class="border px-4 py-2">
                                    <span class="inline-block align-middle ml-2">{{ $b->judul }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="p-1 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex flex-wrap justify-between">
            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

            </div>
            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

            </div>
            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

            </div>
        </div>
    </div>
</div>

@endsection
