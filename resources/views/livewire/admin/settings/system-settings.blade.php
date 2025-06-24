<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-base-content mb-2">System Settings</h2>
        <p class="text-base-content/70">Configure system maintenance and performance settings.</p>
    </div>

    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Maintenance Mode Section --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-base-content mb-4">Maintenance Mode</h3>
            </div>

            {{-- Maintenance Mode --}}
            <div class="form-control md:col-span-2">
                <label class="label cursor-pointer">
                    <span class="label-text font-medium">Maintenance Mode</span>
                    <input 
                        type="checkbox" 
                        wire:model="maintenance_mode"
                        class="toggle toggle-warning" 
                    />
                </label>
                <label class="label">
                    <span class="label-text-alt text-base-content/70">
                        Put the application in maintenance mode. Users will see a maintenance page.
                    </span>
                </label>
            </div>

            {{-- Maintenance Message --}}
            <div class="form-control md:col-span-2">
                <label class="label">
                    <span class="label-text font-medium">Maintenance Message</span>
                </label>
                <textarea 
                    wire:model="maintenance_message"
                    class="textarea textarea-bordered" 
                    rows="3"
                    placeholder="Enter the message to display during maintenance"
                ></textarea>
                @error('maintenance_message') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Caching Section --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-base-content mb-4">Caching</h3>
            </div>

            {{-- Enable Caching --}}
            <div class="form-control">
                <label class="label cursor-pointer">
                    <span class="label-text font-medium">Enable Caching</span>
                    <input 
                        type="checkbox" 
                        wire:model="cache_enabled"
                        class="toggle toggle-primary" 
                    />
                </label>
                <label class="label">
                    <span class="label-text-alt text-base-content/70">
                        Enable application caching for better performance.
                    </span>
                </label>
            </div>

            {{-- Cache Duration --}}
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Cache Duration (seconds)</span>
                </label>
                <input 
                    type="number" 
                    wire:model="cache_duration"
                    class="input input-bordered" 
                    min="300"
                    max="86400"
                />
                @error('cache_duration') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Logging Section --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-base-content mb-4">Logging</h3>
            </div>

            {{-- Log Level --}}
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Log Level</span>
                </label>
                <select wire:model="log_level" class="select select-bordered">
                    @foreach ($logLevels as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('log_level') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Backup Section --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-base-content mb-4">Backup</h3>
            </div>

            {{-- Enable Backups --}}
            <div class="form-control">
                <label class="label cursor-pointer">
                    <span class="label-text font-medium">Enable Automatic Backups</span>
                    <input 
                        type="checkbox" 
                        wire:model="backup_enabled"
                        class="toggle toggle-primary" 
                    />
                </label>
                <label class="label">
                    <span class="label-text-alt text-base-content/70">
                        Automatically backup the database and files.
                    </span>
                </label>
            </div>

            {{-- Backup Frequency --}}
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Backup Frequency</span>
                </label>
                <select wire:model="backup_frequency" class="select select-bordered">
                    @foreach ($backupFrequencies as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('backup_frequency') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
        </div>

        {{-- System Actions Section --}}
        <div class="mt-8 p-6 bg-base-200 rounded-lg">
            <h3 class="text-lg font-semibold text-base-content mb-4">System Actions</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-button 
                    wire:click="clearCache"
                    icon="o-trash" 
                    class="btn-outline btn-warning"
                    spinner="clearCache"
                >
                    Clear Cache
                </x-button>
                <x-button 
                    wire:click="optimize"
                    icon="o-cog" 
                    class="btn-outline btn-info"
                    spinner="optimize"
                >
                    Optimize Application
                </x-button>
            </div>
        </div>

        {{-- Warning Card --}}
        <div class="alert alert-warning mt-6">
            <x-icon name="o-exclamation-triangle" class="w-5 h-5" />
            <div>
                <h3 class="font-medium">Warning</h3>
                <div class="text-sm">
                    Enabling maintenance mode will make your application unavailable to users. 
                    Make sure to disable it when you're done with maintenance.
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end mt-8">
            <x-button 
                type="submit" 
                icon="o-check" 
                class="btn-primary"
                spinner="save"
            >
                Save Settings
            </x-button>
        </div>
    </form>
</div> 