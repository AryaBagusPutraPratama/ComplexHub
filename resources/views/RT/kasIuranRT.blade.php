@extends('layouts.welcome')

@section('content')
<style>
    /* Layout and Whitespace */


/* Color and Contrast */
body {
  background-color: #fff; /* Light background for better contrast */
}



/* Buttons */
.search-button,
.edit-button,
.delete-button {
  background-color: #337ab7; /* Blue for primary buttons */
  color: #fff; /* White text for contrast */
  border: none;
  border-radius: 4px; /* Rounded corners */
  padding: 8px 16px; /* Adjust padding for comfortable click area */
  cursor: pointer; /* Indicate clickable button */
}
.search-button:hover,
.edit-button:hover,
.delete-button:hover {
  background-color: #286090; /* Darker shade on hover */
}

</style>
<main class="mx-auto p-36 contain-responsive" style="min-height: 100vh; background-color: #FBEEC1;">
    <div class="rounded-md relative p-16 top-32 left-16" style="background-color: white">
        <p class="mb-10" style="font-size: 24px; font-family: 'Poppins', sans-serif; font-weight: 600; color: black;">Data Iuran Warga:</p>
        <hr class="mb-6">

        <!-- Search form -->
        <form method="GET" action="{{ route('search') }}">
            <div class="mb-4 flex items-center">
                <input type="text" id="rt_search" name="rt_search" class="mt-1 block w-1/3 px-2 py-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Masukkan Nama">
                <button type="submit" class="ml-2 search-button">Cari</button>
            </div>
        </form>
        

        <table class="md:table-fixed w-full mt-6">
            <thead>
                <tr>
                    <th class="border px-4 py-2 text-center" style="color: black; width: 10%;">No</th>
                    <th class="border px-4 py-2 text-center" style="color: black; width: 10%;">Nama</th>
                    <th class="border px-4 py-2 text-center" style="color: black; width: 10%;">Periode</th>
                    <th class="border px-4 py-2 text-center" style="color: black; width: 10%;">Total</th>
                    <th class="border px-4 py-2 text-center" style="color: black; width: 15%;">Bukti</th>
                    <th class="border px-4 py-2 text-center" style="color: black; width: 10%;">RT</th>
                    <th class="border px-4 py-2 text-center" style="color: black; width: 10%;">Status</th>
                    <th class="border px-4 py-2 text-center" style="color: black; width: 15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($iuran as $ir)
                <tr>
                    <td class="border px-4 py-2 text-center" style="color: black">{{ $ir->id }}</td>
                    <td class="border px-4 py-2 text-center" style="color: black">{{ $ir->nama }}</td>
                    <td class="border px-4 py-2 text-center" style="color: black">{{ $ir->periode }}</td>
                    <td class="border px-4 py-2 text-center" style="color: black">{{ $ir->total }}</td>
                    <td class="border px-4 py-2 text-center" style="color: black">
                        <div class="flex justify-center">
                            <img src="{{ asset('storage/' . $ir->bukti) }}" alt="Bukti" style="max-width: 100px; max-height: 100px;">
                        </div>
                    </td>
                    <td class="border px-4 py-2 text-center" style="color: black">{{ $ir->rt_id }}</td>
                    <td class="border px-4 py-2 text-center" style="color: black">
                        @if($ir->status == 'diproses')
                            <button class="bg-gray-500 text-white font-bold py-2 px-4 rounded">Diproses</button>
                        @elseif($ir->status == 'disetujui')
                            <button class="bg-green-500 text-white font-bold py-2 px-4 rounded">Disetujui</button>
                        @elseif($ir->status == 'ditolak')
                            <button class="bg-red-500 text-white font-bold py-2 px-4 rounded">Ditolak</button>
                        @endif
                    </td>
                    <td class="border px-4 py-2 text-center" style="color: black">
                        <div class="flex justify-center">
                            <a href="{{ url('/RT/' . $ir->id . '/edit') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                            <form action="{{ url('/RT/' . $ir->id) }}" method="POST" class="ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" id="delete">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script type="text/javascript">
    $(function(){
        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            var form = $(this).closest('form'); // get the closest form to the button

            Swal.fire({
                title: "Apakah Anda Yakin?",
                text: "Data Yang dihapus tidak bisa kembali!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "YA, Hapus Data!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // submit the form if the user confirms
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                }
            });
        });
    });
</script>

@endsection
