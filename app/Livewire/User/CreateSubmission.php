<?php

namespace App\Livewire\User;

use App\Models\CollectionPost;
use App\Models\WasteCategory;
use App\Models\WasteSubmission;
use App\Models\WasteSubmissionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class CreateSubmission extends Component
{
    public $collection_post_id = '';
    public $submission_date = '';
    public $notes = '';
    
    // Dynamic array for holding items
    public $items = [];
    
    // Derived total points
    public $estimated_points = 0;

    public function mount()
    {
        $this->submission_date = date('Y-m-d');
        // Initialize with one empty row
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = [
            'category_id' => '',
            'quantity' => 1,
            'points_per_unit' => 0,
            'subtotal' => 0
        ];
        $this->calculateTotals();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // re-index
        $this->calculateTotals();
    }

    // Auto calculate when any item changes
    public function updatedItems()
    {
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->estimated_points = 0;
        
        $categories = WasteCategory::whereIn('id', collect($this->items)->pluck('category_id')->filter())->get()->keyBy('id');

        foreach ($this->items as $i => $item) {
            if (!empty($item['category_id'])) {
                $category = $categories->get($item['category_id']);
                if ($category) {
                    $qty = floatval($item['quantity'] ?: 0);
                    $subtotal = $qty * floatval($category->points_per_unit);
                    
                    $this->items[$i]['points_per_unit'] = $category->points_per_unit;
                    $this->items[$i]['subtotal'] = $subtotal;
                    
                    $this->estimated_points += $subtotal;
                }
            } else {
                $this->items[$i]['subtotal'] = 0;
            }
        }
    }

    public function store()
    {
        $this->validate([
            'collection_post_id' => 'required|exists:collection_posts,id',
            'submission_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.category_id' => 'required|exists:waste_categories,id',
            'items.*.quantity' => 'required|numeric|min:0.1',
        ], [
            'collection_post_id.required' => 'Pos Bank Sampah wajib dipilih.',
            'items.*.category_id.required' => 'Kategori sampah tidak boleh kosong.',
            'items.*.quantity.min' => 'Jumlah minimal adalah 0.1.',
        ]);

        // Recalculate one last time to be safe
        $this->calculateTotals();

        DB::transaction(function () {
            $submission = WasteSubmission::create([
                'user_id' => Auth::id(),
                'collection_post_id' => $this->collection_post_id,
                'submission_date' => $this->submission_date,
                'status' => 'pending',
                'notes' => $this->notes,
                'total_points_earned' => 0, // 0 right now since it's pending (will be computed accurately on validation)
            ]);

            foreach ($this->items as $item) {
                WasteSubmissionItem::create([
                    'waste_submission_id' => $submission->id,
                    'waste_category_id' => $item['category_id'],
                    'quantity' => $item['quantity'],
                    'points_per_unit' => $item['points_per_unit'],
                    'subtotal_points' => $item['subtotal'],
                ]);
            }
        });

        $this->dispatch('flash', type: 'success', message: 'Setoran berhasil diajukan! Menunggu instruksi dan validasi pos/admin.');
        
        // Redirect to history later, for now back to current/dashboard
        return $this->redirect(route('dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.user.create-submission', [
            'posts' => CollectionPost::where('is_active', true)->get(),
            'categories' => WasteCategory::where('is_active', true)->get(),
        ]);
    }
}
