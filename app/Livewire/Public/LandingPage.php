<?php

namespace App\Livewire\Public;

use App\Models\News;
use App\Models\User;
use App\Models\WasteSubmission;
use App\Models\Redemption;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class LandingPage extends Component
{
    public function render()
    {
        // 1. Stats calculation (cache these in production, but okay for now)
        $totalUsers = User::where('role', 'user')->where('is_active', true)->count();
        
        // Let's just sum points as 'waste collected value' proxy
        $totalPointsDistributed = WasteSubmission::where('status', 'validated')->sum('total_points_earned');
        $totalRedemptions = Redemption::where('status', 'delivered')->count();

        // 2. Latest News
        $latestNews = News::where('is_published', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('livewire.public.landing-page', [
            'totalUsers' => $totalUsers,
            'totalPointsDistributed' => $totalPointsDistributed,
            'totalRedemptions' => $totalRedemptions,
            'latestNews' => $latestNews
        ]);
    }
}
