<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\User;
use App\Models\Iuran;
use App\Models\Activity;
use App\Models\suggestion;
use App\Models\DataPenduduk;
use Illuminate\Http\Request;
use App\Models\AnggotaKeluarga;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class dashboardController extends Controller
{
    public function indexRT()
{
    $user = auth()->user();
    
    // Mengambil jumlah warga berdasarkan rt_id
    $jumlahWarga = AnggotaKeluarga::join('data_kartu_keluargas', 'anggota_keluargas.kk_id', '=', 'data_kartu_keluargas.id')
                        ->where('data_kartu_keluargas.rt_id', $user->rt_id)
                        ->count();
    
    $izinUsaha = Umkm::where('status_rt', 'disetujui')
    ->where('status_rw', 'disetujui')
    ->get();
    $suggestions = Suggestion::where('user_id', $user->id)->get();
    $activities = Activity::where('user_id', $user->id)->get();
    $iuran = Iuran::where('rt_id', $user->rt_id)->sum('total');
    
    $breadcrumb = (object)[
        'title' => 'Daftar dashboard',
        'subtitle' => '',
    ];

        return view('dashboardRT', compact('izinUsaha', 'suggestions', 'activities', 'breadcrumb', 'user', 'jumlahWarga','iuran'));
    }


    public function indexRW(Request $request)
    {
        $user = auth()->user();
        $selectedRtId = $request->input('rt_id', $user->rt_id);

        // Get distinct rt_id values for the dropdown
        $allRts = User::select('rt_id')->distinct()->pluck('rt_id');

        // Get users based on the selected rt_id
        $users = User::where('rt_id', $selectedRtId)->get();

        // Get data penduduk based on the selected rt_id
        $dataPenduduk = AnggotaKeluarga::where('kk_id', $selectedRtId)->get();

        // Get izin usaha based on the selected rt_id
        $izinUsaha = Umkm::where('status_rt', 'disetujui')
        ->where('status_rw', 'disetujui')
        ->get();

        // Get suggestions based on the selected rt_id
        $suggestions = suggestion::whereHas('user', function ($query) use ($selectedRtId) {
            $query->where('rt_id', $selectedRtId);
        })->get();

        // Get activities based on the selected rt_id
        $activities = Activity::whereHas('user', function ($query) use ($selectedRtId) {
            $query->where('rt_id', $selectedRtId);
        })->get();

        // Get total iuran based on the selected rt_id
        $iuran = Iuran::where('rt_id', $selectedRtId)->sum('total');

        $breadcrumb = (object)[
            'title' => 'Daftar dashboard',
            'subtitle' => '',
        ];

        return view('dashboardRW', compact('izinUsaha', 'suggestions', 'activities', 'breadcrumb', 'user', 'users', 'iuran', 'allRts', 'selectedRtId', 'dataPenduduk'));
    }





    public function indexPD()
    {
        $user = auth()->user();

        // Mengambil jumlah warga berdasarkan rt_id
        $jumlahWarga = AnggotaKeluarga::join('data_kartu_keluargas', 'anggota_keluargas.kk_id', '=', 'data_kartu_keluargas.id')
                            ->where('data_kartu_keluargas.rt_id', $user->rt_id)
                            ->count();
        
        $izinUsaha = Umkm::where('status_rt', 'disetujui')
        ->where('status_rw', 'disetujui')
        ->get();
        $suggestions = Suggestion::where('user_id', $user->id)->get();
        $activities = Activity::where('user_id', $user->id)->get();
        $iuran = Iuran::where('rt_id', $user->rt_id)->sum('total');

        $breadcrumb = (object)[
            'title' => 'Daftar dashboard',
            'subtitle' => '',
        ];

        return view('dashboardPD', compact('izinUsaha', 'suggestions', 'activities', 'breadcrumb', 'user', 'jumlahWarga', 'iuran'));
}
    public function getChartDataPD()
    {
        // Ambil data user_id dan rt_id dari database, dan filter out rt_id = 0
        $keluarga = AnggotaKeluarga::where('kk_id', '!=', 0)->select('id', 'kk_id')->get();

        // Kelompokkan user_id berdasarkan rt_id
        $data = $keluarga->groupBy('kk_id')->map(function ($group) {
            return $group->count();
        });

        return response()->json($data);
    }

    public function getChartDataRT()
    {
        // Ambil data user_id dan rt_id dari database, dan filter out rt_id = 0
        $keluarga = AnggotaKeluarga::where('kk_id', '!=', 0)->select('id', 'kk_id')->get();

        // Kelompokkan user_id berdasarkan rt_id
        $data = $keluarga->groupBy('kk_id')->map(function ($group) {
            return $group->count();
        });

        return response()->json($data);
    }
    public function getChartDataRW()
    {
        // Ambil data user_id dan rt_id dari database, dan filter out rt_id = 0
        $keluarga = AnggotaKeluarga::where('kk_id', '!=', 0)->select('id', 'kk_id')->get();

        // Kelompokkan user_id berdasarkan rt_id
        $data = $keluarga->groupBy('kk_id')->map(function ($group) {
            return $group->count();
        });

        return response()->json($data);
    }
    public function getIuranDataPD(Request $request)
    {
        $userId = Auth::id(); // Get the ID of the authenticated user
        Log::info('User ID: ' . $userId);

        // Mengambil data iuran dari database untuk user_id tertentu
        $data = Iuran::selectRaw('MONTH(periode) as month, SUM(total) as total')
            ->where('user_id', $userId)
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        Log::info('Iuran Data: ' . json_encode($data));

        // Menghitung total keseluruhan iuran
        $totalIuran = array_sum($data);
        Log::info('Total Iuran: ' . $totalIuran);

        // Menghitung persentase per bulan
        $dataPersentase = [];
        foreach ($data as $month => $total) {
            $dataPersentase[$month] = ($total / $totalIuran) * 100;
        }

        Log::info('Data Persentase: ' . json_encode($dataPersentase));

        return response()->json($dataPersentase);
    }


    public function getIuranDataRT(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user
        $rtId = $user->rt_id; // Assume rt_id is a column in the users table

        Log::info('RT ID: ' . $rtId);

        // Mengambil data iuran dari database untuk rt_id tertentu
        $data = Iuran::selectRaw('MONTH(periode) as month, SUM(total) as total')
            ->where('rt_id', $rtId)
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        Log::info('Iuran Data: ' . json_encode($data));

        // Menghitung total keseluruhan iuran
        $totalIuran = array_sum($data);
        Log::info('Total Iuran: ' . $totalIuran);

        // Menghitung persentase per bulan
        $dataPersentase = [];
        foreach ($data as $month => $total) {
            $dataPersentase[$month] = ($total / $totalIuran) * 100;
        }

        Log::info('Data Persentase: ' . json_encode($dataPersentase));

        return response()->json($dataPersentase);
    }
    public function getIuranDataRW(Request $request)
    {
        $rtId = $request->input('rt_id'); // Mendapatkan rt_id dari permintaan

        // Validasi rtId sesuai dengan kebutuhan aplikasi Anda
        // Misalnya, pastikan rt_id adalah integer atau ada di basis data

        Log::info('RT ID: ' . $rtId);

        // Mengambil data iuran dari database untuk rt_id tertentu
        $data = Iuran::selectRaw('MONTH(periode) as month, SUM(total) as total')
                     ->where('rt_id', $rtId)
                     ->groupBy('month')
                     ->get()
                     ->pluck('total', 'month')
                     ->toArray();

        Log::info('Iuran Data: ' . json_encode($data));

        // Menghitung total keseluruhan iuran
        $totalIuran = array_sum($data);
        Log::info('Total Iuran: ' . $totalIuran);

        // Menghitung persentase per bulan
        $dataPersentase = [];
        foreach ($data as $month => $total) {
            $dataPersentase[$month] = ($total / $totalIuran) * 100;
        }

        Log::info('Data Persentase: ' . json_encode($dataPersentase));

        return response()->json($dataPersentase);
    }

}
