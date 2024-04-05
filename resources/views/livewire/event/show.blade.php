<?php

use Livewire\Volt\Component;
use App\Models\{EventAttendees, Event};

new class extends Component {
    public $event = null;
    public $rows = [];

    public $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'name', 'label' => 'Name'],
        ['index' => 'email', 'label' => 'Email'],
        ['index' => 'subscription_date', 'label' => 'Subscription Date']
    ];

    public function mount($event){
        $this->event = $event;
        $this->rows = EventAttendees::where('event_id', $event->id)->get();
        $this->rows = $this->rows->map(function($row){
            return [
                'id' => $row->id,
                'name' => $row->user->name,
                'email' => $row->user->email,
                'subscription_date' => $row->created_at->format('d M Y')
            ];
        });
    }
};
?>

<div class="bg-white shadow-md rounded-xl">
    <div class="md:flex">
        <div class="p-8">
            <div class="text-sm font-semibold tracking-wide text-indigo-500 uppercase">{{ $event->title }}</div>
            <p class="mt-2 text-gray-500">
                <span>Event details:</span>
                <span>{{ $event->details !== null && $event->details !== "''" ? 'Any detail provided for this event.' : $event->details }}</span>
            </p>
            <div class="mt-2">
                <span class="text-gray-500">Event date: </span>
                <span class="text-gray-900">{{ $event->date }}</span>
            </div>
            <div class="mt-2">
                <span class="text-gray-500">Maximum attendees: </span>
                <span class="text-gray-900">{{ $event->maximum_attendees ?? 'Not specified' }}</span>
            </div>
        </div>
    </div>

    <div class="p-8">
        <h2 class="text-lg font-semibold text-gray-800">Attendees</h2>
    </div>
    <x-ts-table :$headers :$rows />
</div>
