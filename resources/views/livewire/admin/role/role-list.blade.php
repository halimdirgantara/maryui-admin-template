<div>
    <livewire:component.header searchBar=true :filterButton=false :createButton=true :title=$title :subTitle=$subTitle />

    <x-drawer wire:model="showDrawer" class="w-11/12 lg:w-1/3" right>
        <div>...</div>
        <x-button label="Close" @click="$wire.showDrawer = false" />
    </x-drawer>

    <x-modal wire:model="roleForm" title="Role Form" subtitle="Create Or Edit Role">
        <x-form no-separator>
            <x-input wire:model="name" label="Name" icon="o-user" placeholder="Role name" />

            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.roleForm = false" />
                <x-button label="Confirm" class="btn-primary" wire:click="save" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    <x-modal wire:model="editPermissionsModal" title="Edit Role Permissions" subtitle="Edit permissions for {{ $selectedRoleName }}">
        <div class="space-y-4">
            @if(count($allPermissions) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 max-h-60 overflow-y-auto border rounded-lg p-3">
                    @foreach($allPermissions as $permission)
                        <div class="flex items-center space-x-2 p-2 hover:bg-gray-50 dark:hover:bg-gray-500 rounded">
                            <x-checkbox
                                wire:model="selectedPermissionsForEdit"
                                value="{{ $permission['name'] }}"
                                class="checkbox-sm"
                            />
                            <span class="text-sm">{{ ucfirst(str_replace(['-', '_'], ' ', $permission['name'])) }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <x-icon name="o-exclamation-triangle" class="w-12 h-12 text-yellow-500 mx-auto mb-2" />
                    <p class="text-gray-500">No permissions available</p>
                </div>
            @endif
        </div>

        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.editPermissionsModal = false" />
            <x-button label="Save Permissions" class="btn-primary" wire:click="savePermissions" />
        </x-slot:actions>
    </x-modal>

    <x-table :headers="$headers" :rows="$roles" striped with-pagination>
        @scope('actions', $user)
            <div class="flex items-center space-x-2">
                <x-button icon="o-key" wire:click="editPermissions({{ $user->id }})" spinner class="btn-sm" tooltip="Edit Permissions" />
                <x-button icon="o-pencil" wire:click="edit({{ $user->id }})" spinner class="btn-sm" />
                <x-button icon="o-trash" wire:click="delete({{ $user->id }})" spinner class="btn-sm" />
            </div>
        @endscope
    </x-table>
</div>
