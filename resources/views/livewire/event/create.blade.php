<?php

use Livewire\Volt\Component;
use App\Models\Event;
use Livewire\Attributes\Validate;
use Illuminate\Support\Str;
use Carbon\Carbon;
use TallStackUi\Traits\Interactions;

new class extends Component {
    use Interactions;

    public ?bool $modal = false;

    #[Validate('required|min:3')]
    public ?string $name = '';
    public ?string $details = '';
    public ?int $attendeeMaxQuantity = 0;
    #[Validate('required')]
    public ?string $eventDate = '';

    public function saveEvent(){
        $this->validate();

        $date = Carbon::parse($this->eventDate);

        $slug = self::generateUnicSlug($this->name);

        Event::create([
            'title' => $this->name,
            'details' => $this->details ?? '',
            'attendee_max_quantity' => $this->attendeeMaxQuantity ?? null,
            'date' => $this->eventDate,
            'slug' => $slug,
            'user_id' => auth()->id(),
        ]);

        $this->reset();

        $this->toast()->success('Event created successfully!')->send();
        $this->modal = false;
    }

    public static function generateUnicSlug(string $name): string {
        $slug = Str::slug($name);

        $slugExist = Event::where('slug', $slug)->exists();

        if(!$slugExist){
            return $slug;
        }

        return $slug . '-' . Carbon::now()->timestamp;
    }
}

?>
<div class="flex justify-center">
    <x-ts-button wire:click="$toggle('modal')">
        Want to create an event?
    </x-ts-button>

    <x-ts-modal title="New Event" center wire>
        <x-ts-input wire:model='name' label="Event Name *" hint="Insert name for event" />
        <x-ts-textarea wire:model='details' label="Details" hint="Insert the details for event, this is not required" />
        <div class="flex gap-2 w-full justify-between mt-2">
            <x-ts-number wire:model='attendeeMaxQuantity' chevron centralized label="Attendee max quantity"/>
            <x-ts-date wire:model='eventDate' label="Event Date *" format="DD [of] MMMM [of] YYYY" />
        </div>
        <div class="flex justify-end w-full mt-4">
            <x-ts-button wire:click="saveEvent()">
                Save
            </x-ts-button>
        </div>
    </x-ts-modal>


</div>
