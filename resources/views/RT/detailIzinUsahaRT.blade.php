@extends('layouts.welcome')
@section('content')
<main class="detail h-dvh w-3/4 mx-auto relative top-30">
    <div class="flex justify-center items-center h-screen">
        <div class="flex flex-col items-center py-5" style="max-width: none; width: 100%;">
            <div class="rounded-md relative p-8 mb-8 mx-auto" style="background-color: white; max-width: 3000px; width: 90%; position: relative; border-radius: 16px;">
                <p class="text-start font-semibold text-xl mb-4">Detail Izin Usaha</p>
                <hr class="mb-4">
                <div class="mb-4">
                    <label for="namaLengkap" class="block text-lg font-bold text-gray-700">Nama :</label>
                    <p class="font-medium">{{ $izinUsaha->nama_warga }}</p>
                </div>
                <div class="mb-4">
                    <label for="namaUsaha" class="block text-lg font-bold text-gray-700">Nama Usaha : </label>
                    <p class="font-medium">{{ $izinUsaha->nama_usaha }}</p>
                </div>
                <div class="mb-4">
                    <label for="deskripsiUsaha" class="block text-lg font-bold text-gray-700">Deskripsi :</label>
                    <p class="font-medium">{{ $izinUsaha->deskripsi }}</p>
                </div>
                <div class="mb-4">
                    <label for="fotoProduk" class="block text-lg font-bold text-gray-700">Foto Produk :</label>
                    <img class="ml-0" src="{{ asset('storage/' . $izinUsaha->foto_produk) }}" alt="" style="max-width: 100%; height: auto;">
                </div>
                <div class="absolute right-0 bottom-0 left-0 px-4 pb-4">
                    <a href="{{ route('izinUsahaRT') }}" style="text-decoration:none"><button type="button" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded w-full">Kembali</button></a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
