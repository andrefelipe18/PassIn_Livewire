<?php

use Livewire\Volt\Component;
use App\Models\Event;
use Livewire\WithPagination;
use Carbon\Carbon;

new class extends Component {
    use WithPagination;

    public function getEventsProperty(){
        return Event::paginate(6);
    }
};
?>

<div>
    {{-- Grid para exibir os eventos --}}
    <div class">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach($this->events as $event)
            @if($event->date >= now())
            <div class="bg-white shadow-md rounded-xl">
                <div class="md:flex">
                    <div class="p-8">
                        <div class="text-sm font-semibold tracking-wide text-indigo-500 uppercase">
                            {{$event->title}}</div>
                        <p class="mt-2 text-gray-500">
                            <span>Event details:</span>
                            <span>{{ $event->details !== null && $event->details !== "''" ? 'Any detail
                                provided for this event.' : $event->details }}</span>
                        </p>
                        <div class="mt-2">
                            <span class="text-gray-500">Event date: </span>
                            <span class="text-gray-900">{{ Carbon::parse($event->date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="mt-2">
                            <span class="text-gray-500">Maximum attendees: </span>
                            <span class="text-gray-900">{{ $event->maximum_attendees ?? 'Not specified'
                                }}</span>
                        </div>
                        @if($event->maximum_attendees !== null)
                        <div class="mt-2">
                            {{-- Vagas restantes --}}
                            <span class="text-gray-500">Remaining vacancies: </span>
                            <span class="text-gray-900">{{ $event->maximum_attendees - $event->attendees->count()
                                }}</span>
                        </div>
                        @endif
                        @if(auth()->user()->id === $event->user_id)
                        <div class="mt-2">
                            <x-ts-link href="{{ route('event', ['event' => $event]) }}" text="View"
                                icon="arrow-up-right" position="right" />
                        </div>
                        @else
                        <div class="mt-2">
                            @livewire('event.subscribe', ['event' => $event])
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="mt-4">
            {{ $this->events->links() }}
        </div>
    </div>
