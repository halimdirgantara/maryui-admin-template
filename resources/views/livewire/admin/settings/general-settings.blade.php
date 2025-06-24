<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-base-content mb-2">General Settings</h2>
        <p class="text-base-content/70">Configure basic application settings and preferences.</p>
    </div>

    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Application Name --}}
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Application Name</span>
                </label>
                <input 
                    type="text" 
                    wire:model="app_name"
                    class="input input-bordered" 
                    placeholder="Enter application name"
                />
                @error('app_name') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Application URL --}}
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Application URL</span>
                </label>
                <input 
                    type="url" 
                    wire:model="app_url"
                    class="input input-bordered" 
                    placeholder="https://example.com"
                />
                @error('app_url') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Application Description --}}
            <div class="form-control md:col-span-2">
                <label class="label">
                    <span class="label-text font-medium">Application Description</span>
                </label>
                <textarea 
                    wire:model="app_description"
                    class="textarea textarea-bordered" 
                    rows="3"
                    placeholder="Enter a brief description of your application"
                ></textarea>
                @error('app_description') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Timezone --}}
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Timezone</span>
                </label>
                <select wire:model="app_timezone" class="select select-bordered">
                    @foreach ($timezones as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('app_timezone') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Locale --}}
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Default Locale</span>
                </label>
                <select wire:model="app_locale" class="select select-bordered">
                    @foreach ($locales as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('app_locale') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Debug Mode --}}
            <div class="form-control md:col-span-2">
                <label class="label cursor-pointer">
                    <span class="label-text font-medium">Debug Mode</span>
                    <input 
                        type="checkbox" 
                        wire:model="app_debug"
                        class="toggle toggle-primary" 
                    />
                </label>
                <label class="label">
                    <span class="label-text-alt text-base-content/70">
                        Enable debug mode for development. Shows detailed error messages and stack traces.
                    </span>
                </label>
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