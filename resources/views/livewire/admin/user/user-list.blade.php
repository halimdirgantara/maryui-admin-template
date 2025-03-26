<div>
    <livewire:component.header :filterButton=true :createButton=true :title=$title :subTitle=$subTitle />

    <x-drawer wire:model="showDrawer" class="w-11/12 lg:w-1/3" right>
        <x-toggle label="Show Not Verified Users" wire:model.live="isNotVerified"
            hint="Show users that have not been verified" right />
        <x-button label="Close" @click="$wire.showDrawer = false" />
    </x-drawer>

    <x-modal wire:model="userForm" title="User Form" subtitle="Create Or Edit User">
        <x-form no-separator>
            <x-input wire:model="name" label="Name" icon="o-user" placeholder="The full name" />
            <x-input wire:model="email" label="Email" icon="o-envelope" placeholder="The e-mail" />
            <x-select label="Users" wire:model="role" :options="$roles" placeholder="Select a role"
                placeholder-value="0" option-value="name" option-label="name" />
            <x-password wire:model="password" label="Password" icon="o-lock-closed"
                placeholder="Leave blank for default password" right />

            {{-- Notice we are using now the `actions` slot from `x-form`, not from modal --}}
            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.userForm = false" />
                <x-button label="Confirm" class="btn-primary" wire:click="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    <x-table :headers="$headers" :rows="$users" striped with-pagination>
        @scope('actions', $user)
            <div class="flex items-center space-x-2">
                <x-button icon="o-pencil" wire:click="edit({{ $user->id }})" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm" />
            </div>
        @endscope
    </x-table>
</div>
