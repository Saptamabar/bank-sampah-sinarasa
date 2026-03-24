<?php

namespace App\Livewire\User;

use App\Models\WasteSubmission;
use App\Models\Redemption;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        $recentSubmissions = WasteSubmission::with('collectionPost')
            ->where('user_id', $user->id)
            ->latest('submission_date')
            ->take(5)
            ->get();
            
        $recentRedemptions = Redemption::with('reward')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.user.dashboard', [
            'user' => $user,
            'recentSubmissions' => $recentSubmissions,
            'recentRedemptions' => $recentRedemptions,
        ]);
    }
}
