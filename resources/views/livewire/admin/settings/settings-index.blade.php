<div>
    <x-header title="Settings" subtitle="Manage your application settings">
        <x-slot:actions>
            <x-button icon="o-arrow-left" class="btn-ghost" link="{{ route('dashboard') }}" />
        </x-slot:actions>
    </x-header>

    <div class="p-4">
        {{-- Tabs Navigation --}}
        <div class="tabs tabs-boxed bg-base-200 mb-6">
            @foreach ($tabs as $tabKey => $tab)
                <button 
                    wire:click="setTab('{{ $tabKey }}')"
                    class="tab {{ $activeTab === $tabKey ? 'tab-active' : '' }}"
                >
                    <x-icon name="{{ $tab['icon'] }}" class="w-4 h-4 mr-2" />
                    {{ $tab['name'] }}
                </button>
            @endforeach
        </div>

        {{-- Tab Content --}}
        <div class="bg-base-100 rounded-lg shadow-sm border">
            @if ($activeTab === 'general')
                <livewire:admin.settings.general-settings />
            @elseif ($activeTab === 'security')
                <livewire:admin.settings.security-settings />
            @elseif ($activeTab === 'notifications')
                <livewire:admin.settings.notification-settings />
            @elseif ($activeTab === 'system')
                <livewire:admin.settings.system-settings />
            @endif
        </div>
    </div>
</div> 