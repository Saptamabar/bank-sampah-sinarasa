<?php

namespace App\Livewire\Public;

use App\Models\CollectionPost;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class MapPage extends Component
{
    public function render()
    {
        $posts = CollectionPost::where('is_active', true)->get()->map(function($post) {
            return [
                'id' => $post->id,
                'name' => $post->name,
                'address' => $post->address,
                'pic_name' => $post->pic_name,
                'phone' => $post->phone,
                'latitude' => $post->latitude,
                'longitude' => $post->longitude,
            ];
        });

        return view('livewire.public.map-page', [
            'postsJson' => $posts->toJson()
        ]);
    }
}
