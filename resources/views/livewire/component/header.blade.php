<div>
    <x-header title="{{ $title }}" subtitle="{{ $subTitle }}" separator>
        @if ($searchBar)
            <x-slot:middle class="!justify-end">
                <x-input icon="o-bolt" placeholder="Search..." wire:model.live="search" />
            </x-slot:middle>
        @endif
        <x-slot:actions>
            @if ($filterButton)
                <x-button icon="o-funnel" label="Filters" wire:click="showDrawerPage" />
            @endif
            @if ($createButton)
                <x-button icon="o-plus" class="btn-primary" wire:click="create" />
            @endif
            <x-theme-toggle class="btn btn-circle" />
        </x-slot:actions>
    </x-header>
</div>
