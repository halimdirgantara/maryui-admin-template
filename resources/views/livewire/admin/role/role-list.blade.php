<div>
    <livewire:component.header :searchBar=true :title=$title :subTitle=$subTitle />

    <x-drawer wire:model="showDrawer" class="w-11/12 lg:w-1/3" right>
        <div>...</div>
        <x-button label="Close" @click="$wire.showDrawer = false" />
    </x-drawer>
</div>
