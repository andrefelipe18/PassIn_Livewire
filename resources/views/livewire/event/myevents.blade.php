<?php

use Livewire\Volt\Component;
use App\Models\Event;
use Carbon\Carbon;

new class extends Component {
    public $events = null;

    public function mount(){
        $this->events = Event::where('user_id', auth()->id())->get();
    }
};
?>

<div>
    <ul>
        @forelse ($events as $event)
        <li wire:key="{{ $event->id }}" class="my-5">
            <x-ts-card>
                <x-slot:header>
                    <div class="flex flex-col justify-between w-full">
                        <p class="flex items-center">{{ $event->title }} - <a href="{{ route('event', ['event' => $event]) }}"><x-ts-icon name="eye" class="w-5 h-5 ml-2"/></a></p>
                        @if($event->maximum_attendees !== null)
                            <p class="text-sm">Max Attendees: {{ $event->maximum_attendees }}</p>
                        @else
                            <p class="text-sm">No Attendees Limit</p>
                        @endif
                    </div>
                </x-slot:header>

                @if($event->details)
                    <p>{{ $event->details }}</p>
                @else
                    <p>No details available</p>
                @endif

                <x-slot:footer>
                    <div class="">
                        <p>{{ Carbon::parse($event->date)->format('d M Y') }}</p>
                    </div>
                </x-slot:footer>
            </x-ts-card>
        </li>
        @empty

        @endforelse
    </ul>
</div>
