<?php

namespace App\Livewire\Frontend;

use App\Models\Room;
use App\Models\WebsiteSetting;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RoomShow extends Component
{
    #[Layout('layouts.frontend')]
    public Room $room;

    public function mount(Room $room): void
    {
        $this->room = $room->load('images');
    }

    public function render()
    {
        $settings = WebsiteSetting::first();

        $otherRooms = Room::where('id', '!=', $this->room->id)
            ->where('is_available', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        return view('livewire.frontend.room-show', [
            'settings' => $settings,
            'room' => $this->room,
            'otherRooms' => $otherRooms,
        ]);
    }
}

