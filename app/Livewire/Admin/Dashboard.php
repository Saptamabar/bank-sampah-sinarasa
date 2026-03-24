<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\WasteSubmission;
use App\Models\Redemption;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        $activeUsersCount = User::where('role', 'user')->where('is_active', true)->count();
        $todaySubmissionsCount = WasteSubmission::whereDate('submission_date', Carbon::today())->count();
        
        $circulatingPoints = User::where('role', 'user')->sum('points_total');
        
        $pendingSubmissionsCount = WasteSubmission::where('status', 'pending')->count();
        $pendingRedemptionsCount = Redemption::where('status', 'pending')->count();

        $latestPendingSubmissions = WasteSubmission::with(['user', 'collectionPost'])
            ->where('status', 'pending')
            ->latest('submission_date')
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'activeUsersCount' => $activeUsersCount,
            'todaySubmissionsCount' => $todaySubmissionsCount,
            'circulatingPoints' => $circulatingPoints,
            'pendingSubmissionsCount' => $pendingSubmissionsCount,
            'pendingRedemptionsCount' => $pendingRedemptionsCount,
            'latestPendingSubmissions' => $latestPendingSubmissions,
        ]);
    }
}
