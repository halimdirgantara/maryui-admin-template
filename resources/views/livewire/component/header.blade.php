<div>
    <x-header title="{{ $title }}" subtitle="{{ $subTitle }}" separator>
        @if ($searchBar)
            <x-slot:middle class="!justify-end">
                <x-input icon="o-bolt" placeholder="Search..." wire:model.live="search" />
            </x-slot:middle>
        @endif
        <x-slot:actions>
            <x-theme-toggle class="btn btn-circle" />
            <x-button icon="o-funnel" label="Filters" wire:click="showDrawerPage" />
            <x-button icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>
</div>
