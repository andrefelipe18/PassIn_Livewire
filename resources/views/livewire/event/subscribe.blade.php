<?php

use Livewire\Volt\Component;
use App\Models\EventAttendees;
use TallStackUi\Traits\Interactions;
use Livewire\Attributes\Computed;

new class extends Component {
    use Interactions;

    public $event = null;

    public ?string $errorMessage = '';

    public function mount($event){
        $this->event = $event;
    }

    public function subscribe(){

        if(auth()->user()->id === $this->event->user_id){ //O dono não pode se inscrever no próprio evento
            $this->errorMessage = 'You cannot subscribe to your own event.';
            return;
        }

        if($this->event->date < now()){ //O evento já aconteceu
            $this->errorMessage = 'You cannot subscribe to an event that has already happened.';
            return;
        }

        if($this->event->attendees->count() >= $this->event->maximum_attendees){ //O evento já está cheio
            $this->errorMessage = 'This event is already full.';
            return;
        }

        $attendee = EventAttendees::where('event_id', $this->event->id)->where('user_id', auth()->user()->id)->first();

        if($attendee){
            $this->errorMessage = 'You are already subscribed to this event.';
            return;
        }

        EventAttendees::create([
            'event_id' => $this->event->id,
            'user_id' => auth()->user()->id
        ]);

        $this->toast()->success('You have successfully subscribed to the event.')->send();
    }

     #[Computed]
    public function attendeesCount(){
        return $this->event->attendees->count();
    }

    #[Computed]
    public function notSubscribed(){
        $attendee = EventAttendees::where('event_id', $this->event->id)->where('user_id', auth()->user()->id)->first();
        return !$attendee; //Se não tiver inscrito, retorna true
    }
};
?>

<div>
    {{-- Para o botão aparecer --}}
    {{-- A data tem que ser maior ou igual a hoje --}}
    {{-- E o número de inscrições tem que ser menor que o maximo --}}
    {{-- E o usuário não pode estar inscrito no evento --}}
    {{-- E o usuário não pode ser o dono do evento --}}
    {{-- Se todas as condições forem verdadeiras, o botão aparece --}}
    {{-- Se não, aparece uma mensagem de erro --}}
    @if(
        $this->event->date >= now() &&
        $this->attendeesCount < $this->event->maximum_attendees &&
        $this->notSubscribed &&
        auth()->user()->id !== $this->event->user_id
        )
        <x-ts-button wire:click="subscribe()" icon="arrow-up-right" position="right">Subscribe</x-ts-button>
        @elseif(!$this->notSubscribed())
        <p>See my credential</p>
        @endif

        @if($this->errorMessage !== '')
        <div class="mt-2 text-red-500">{{ $this->errorMessage }}</div>
        @endif
</div>
