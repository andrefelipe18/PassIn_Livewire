<?php

use Livewire\Volt\Component;

new class extends Component {
    public $event = null;

    public function mount($event){
        $this->event = $event;
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
</div>
