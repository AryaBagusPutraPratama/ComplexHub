@extends('layouts.welcome')
@section('content')
    {{-- Content --}}
    <style>
        /* Hide default arrow */
        .custom-select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background: transparent;
            border: none;
            padding-right: 20px;
            /* Add some padding to avoid text being cut off */
            position: relative;
        }

        .custom-select::after {
            content: '';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #fff;
            /* You can change the color of the arrow here */
            pointer-events: none;
        }
    </style>

    <main class="mx-auto p-36 " style="min-height: 100vh; background-color: #FBEEC1;">

        <div class="opsi flex flex-col md:flex-row md:justify-between mt-20 gap-4">
            <div class="w-full md:w-2/5 h-96 rounded-md"
                style="background-color: #659DBD; filter: drop-shadow(12px 13px 4px rgba(2, 109, 124, 0.25));">
                <p class="relative md:left-20 top-16 text-center md:text-left"
                    style="font-size: 60px; font-family: 'Poppins', sans-serif; font-weight: 600; color: #FFFEFE;">
                    RT :
                </p>
                <div class="relative md:left-20 top-12 text-center md:text-left"
                    style="font-size: 96px; font-family: 'Poppins', sans-serif; font-weight: 600; color: #FFFEFE;">
                    <div class="w-full md:w-auto">
                        <div class="mb-4">
                            <select id="rt_id" name="rt_id"
                                class="custom-select font-size: 16px; font-family: 'Poppins', sans-serif; font-weight: 600; text-white bg-transparent border-none outline-none"
                                onchange="filterRT()">
                                <option value="">00</option>
                                @foreach ($rts as $rt)
                                    <option value="{{ $rt->id }}">{{ $rt->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- tambahkan opsi lainnya sesuai kebutuhan -->
                    </div>
                </div>
            </div>

            <div class="w-full md:w-2/5 h-96 rounded-md"
                style="background-color: #659DBD; filter: drop-shadow(12px 13px 4px rgba(2, 109, 124, 0.25));">
                <p class="relative md:left-20 top-16 text-center md:text-left"
                    style="font-size: 60px; font-family: 'Poppins', sans-serif; font-weight: 600; color: #FFFEFE;">
                    Total Pengaduan :
                </p>
                <div id="total-saran" class="relative md:left-20 top-12 text-center md:text-left"
                    style="font-size: 96px; font-family: 'Poppins', sans-serif; font-weight: 600; color: #FFFEFE;">
                    <div class="bg-transparent border-white outline-none text-white w-full md:w-auto">
                        {{ str_pad(count($suggestions), 2, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
            </div>
        </div>







<div class="overflow-x-auto mt-10">
    <p class="mb-10 text-xl md:text-2xl font-semibold text-gray-800 ml-24">Daftar Saran dan Pengaduan RW:</p>
    <table class="table-auto mx-auto w-4/5 border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200 text-black font-medium text-center">
                <th class="border px-2 sm:px-4 py-2">No</th>
                <th class="border px-2 sm:px-4 py-2">Tanggal</th>
                <th class="border px-2 sm:px-4 py-2">Hal yang diadukan</th>
                <th class="border px-2 sm:px-4 py-2">Bidang</th>
                <th class="border px-2 sm:px-4 py-2">Isi Laporan</th>
                <th class="border px-2 sm:px-4 py-2">Status</th>
                <th class="border px-2 sm:px-4 py-2">Lingkup</th>
                <th class="border px-2 sm:px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody id="saran-table">
            @foreach ($suggestions as $index => $suggestion)
            <tr data-id="{{ $suggestion->rt_id }}">
                <td class="border px-4 py-2 text-center bg-white" data-number="{{ $index + 1 }}">{{ $index + 1 }}</td>
                <td class="border px-4 py-2 text-center bg-white">{{ $suggestion->tanggal }}</td>
                <td class="border px-4 py-2 text-center bg-white">{{ $suggestion->name }}</td>
                <td class="border px-4 py-2 text-center bg-white">{{ $suggestion->field }}</td>
                <td class="border px-4 py-2 text-center bg-white">{{ $suggestion->laporan }}</td>
                <td class="border px-4 py-2 text-center bg-white">{{ $suggestion->status }}</td>
                <td class="border px-4 py-2 text-center bg-white">RT {{ $suggestion->rt_id }}</td>
                <td class="border px-4 py-2 text-center bg-white">
                    <div class="flex justify-center items-center gap-2 bg-white">
                        <a href="{{ route('detailSaranRW', ['id' => $suggestion->id]) }}">
                            <button class="w-10 h-8 rounded-md bg-blue-600">
                                <svg class="mx-auto mt-1" width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.5 3H21.5V9" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M9.5 21H3.5V15" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M21.5 3L14.5 10" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M3.5 21L10.5 14" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </a>
                        <form action="{{ route('rejectSaranRW', ['id' => $suggestion->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-10 h-8 rounded-md bg-red-600">
                                <svg class="mx-auto mt-1" width="25" height="24" viewBox="0 0 25 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.5 6L6.5 18" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M6.5 6L18.5 18" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </form>
                        <form action="{{ route('accSaranRW', ['id' => $suggestion->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-10 h-8 rounded-md bg-green-600">
                                <svg class="mx-auto mt-1" width="19" height="13" viewBox="0 0 19 13" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.5 1L6.5 12L1.5 7" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

    </main>
    <script>
        function filterRT() {
            var selectedRT = document.getElementById('rt_id').value;
            var rows = document.querySelectorAll('#saran-table tr');
            var totalKegiatan = 0;
            for (var i = 0; i < rows.length; i++) { // Mulai dari indeks 1 untuk melewati baris header
                var rtIdCell = rows[i].getAttribute('data-id');
                if (selectedRT === "" || rtIdCell === selectedRT) {
                    rows[i].style.display = "";
                    totalKegiatan++;
                } else {
                    rows[i].style.display = "none";
                }
            }
            // Update total kegiatan
            document.getElementById('total-saran').innerText = totalKegiatan;
        }
    </script>
@endsection
