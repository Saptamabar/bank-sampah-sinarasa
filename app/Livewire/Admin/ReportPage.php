<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\WasteSubmission;
use App\Models\Redemption;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class ReportPage extends Component
{
    public $startDate;
    public $endDate;

    public function mount()
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function exportUsers()
    {
        $users = User::where('role', 'user')->get();
        
        $csvData = "ID,Nama,NIK,Email,Telepon,Alamat,Total Poin,Status Aktif,Tanggal Daftar\n";
        foreach ($users as $user) {
            $csvData .= "{$user->id},\"{$user->name}\",\"{$user->nik}\",{$user->email},\"{$user->phone}\",\"{$user->address}\",{$user->points_total}," . ($user->is_active ? 'Ya' : 'Tidak') . ",{$user->created_at->format('Y-m-d')}\n";
        }

        return response()->streamDownload(function() use ($csvData) {
            echo $csvData;
        }, 'Laporan_Nasabah_' . date('Ymd') . '.csv');
    }

    public function exportSubmissions()
    {
        $query = WasteSubmission::with(['user', 'collectionPost'])
                                ->whereBetween('submission_date', [$this->startDate, $this->endDate]);
        
        $submissions = $query->get();
        
        $csvData = "ID Setoran,Tanggal,Nasabah,Pos Bank Sampah,Status,Poin Diperoleh,Divalidasi Oleh\n";
        foreach ($submissions as $sub) {
            $validator = $sub->validator ? $sub->validator->name : '-';
            $csvData .= "{$sub->id},{$sub->submission_date->format('Y-m-d')},\"{$sub->user->name}\",\"{$sub->collectionPost->name}\",{$sub->status},{$sub->total_points_earned},\"{$validator}\"\n";
        }

        return response()->streamDownload(function() use ($csvData) {
            echo $csvData;
        }, 'Laporan_Setoran_' . $this->startDate . '_ke_' . $this->endDate . '.csv');
    }

    public function exportRedemptions()
    {
        $query = Redemption::with(['user', 'reward'])
                           ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);
        
        $redemptions = $query->get();
        
        $csvData = "ID Penukaran,Tanggal,Nasabah,Reward,Poin Digunakan,Status\n";
        foreach ($redemptions as $red) {
            $csvData .= "{$red->id},{$red->created_at->format('Y-m-d')},\"{$red->user->name}\",\"{$red->reward->name}\",{$red->points_used},{$red->status}\n";
        }

        return response()->streamDownload(function() use ($csvData) {
            echo $csvData;
        }, 'Laporan_Penukaran_' . $this->startDate . '_ke_' . $this->endDate . '.csv');
    }

    public function render()
    {
        // Calculate basic stats based on filters
        $totalSubmissions = WasteSubmission::whereBetween('submission_date', [$this->startDate, $this->endDate])->count();
        $totalPointsIssued = WasteSubmission::whereBetween('submission_date', [$this->startDate, $this->endDate])
                                            ->where('status', 'validated')
                                            ->sum('total_points_earned');
                                            
        $totalRedemptions = Redemption::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])->count();
        $totalPointsRedeemed = Redemption::whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
                                         ->whereNotIn('status', ['rejected'])
                                         ->sum('points_used');

        return view('livewire.admin.report-page', [
            'stats' => [
                'total_submissions' => $totalSubmissions,
                'total_points_issued' => $totalPointsIssued,
                'total_redemptions' => $totalRedemptions,
                'total_points_redeemed' => $totalPointsRedeemed,
            ],
            'total_users' => User::where('role', 'user')->count()
        ]);
    }
}
