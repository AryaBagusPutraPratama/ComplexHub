@extends('layouts.welcome')
@section('content')
    {{-- Content --}}
    <main class="mx-auto p-36 contain-responsive" style="min-height: 100vh; background-color: #FBEEC1;">
        <div class="rounded-md relative p-16 top-32 left-16" style="background-color: white">
            <p class="mb-10"  style="font-size: 24px; font-family: 'Poppins', sans-serif; font-weight: 600; color: black;">Detail Saran dan Pengaduan:</p>
            <hr class="mb-6">
            <div class="flex flex-col">
                <div class="mb-4">
                    <span class="font-bold" style="color: black;">Nama Pelapor:</span>
                    <span class="ml-2" style="color: black;">Miguel Santoso</span>
                </div>
                <div class="mb-4">
                    <span class="font-bold" style="color: black;">Judul:</span>
                    <span class="ml-2" style="color: black;">Bising di Malam Hari</span>
                </div>
                <div class="mb-4">
                    <span class="font-bold" style="color: black;">Isi:</span>
                    <p class="ml-2" style="color: black;">Saya ingin melaporkan adanya kebisingan di malam hari yang mengganggu ketenangan warga sekitar.</p>
                </div>
                <div class="mb-4">
                    <span class="font-bold" style="color: black;">Lampiran:</span>
                    <div class="flex justify-center mt-2">
                        <img src="{{ asset('lampiran/bukti_kebisingan.jpg') }}" alt="Bukti Kebisingan" style="max-width: 400px;">
                    </div>
                </div>
                <div class="mb-4">
                    <span class="font-bold" style="color: black;">Status:</span>
                    <span class="ml-2" style="color: black;">Belum Ditanggapi</span>
                </div>
            </div>
            <div class="mt-6">
                <a href="{{ url('/tanggapan') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2" style="border-radius: 10px;">Tanggapi</a>
                <a href="{{ url('/saran') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" style="border-radius: 10px;">Tutup</a>
            </div>
            
        </div>
    </main>
@endsection
