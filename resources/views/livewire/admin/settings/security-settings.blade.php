<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-base-content mb-2">Security Settings</h2>
        <p class="text-base-content/70">Configure security and authentication settings for your application.</p>
    </div>

    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Password Requirements Section --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-base-content mb-4">Password Requirements</h3>
            </div>

            {{-- Minimum Password Length --}}
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Minimum Password Length</span>
                </label>
                <input 
                    type="number" 
                    wire:model="password_min_length"
                    class="input input-bordered" 
                    min="6"
                    max="50"
                />
                @error('password_min_length') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Password Requirements --}}
            <div class="form-control md:col-span-2">
                <label class="label">
                    <span class="label-text font-medium">Password Requirements</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="label cursor-pointer">
                        <span class="label-text">Require Uppercase Letters</span>
                        <input 
                            type="checkbox" 
                            wire:model="password_require_uppercase"
                            class="checkbox checkbox-primary" 
                        />
                    </label>
                    <label class="label cursor-pointer">
                        <span class="label-text">Require Lowercase Letters</span>
                        <input 
                            type="checkbox" 
                            wire:model="password_require_lowercase"
                            class="checkbox checkbox-primary" 
                        />
                    </label>
                    <label class="label cursor-pointer">
                        <span class="label-text">Require Numbers</span>
                        <input 
                            type="checkbox" 
                            wire:model="password_require_numbers"
                            class="checkbox checkbox-primary" 
                        />
                    </label>
                    <label class="label cursor-pointer">
                        <span class="label-text">Require Special Characters</span>
                        <input 
                            type="checkbox" 
                            wire:model="password_require_symbols"
                            class="checkbox checkbox-primary" 
                        />
                    </label>
                </div>
            </div>

            {{-- Session Settings Section --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-base-content mb-4">Session Settings</h3>
            </div>

            {{-- Session Lifetime --}}
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Session Lifetime (minutes)</span>
                </label>
                <input 
                    type="number" 
                    wire:model="session_lifetime"
                    class="input input-bordered" 
                    min="30"
                    max="1440"
                />
                @error('session_lifetime') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Email Verification --}}
            <div class="form-control">
                <label class="label cursor-pointer">
                    <span class="label-text font-medium">Require Email Verification</span>
                    <input 
                        type="checkbox" 
                        wire:model="require_email_verification"
                        class="toggle toggle-primary" 
                    />
                </label>
                <label class="label">
                    <span class="label-text-alt text-base-content/70">
                        Users must verify their email address before accessing the system.
                    </span>
                </label>
            </div>

            {{-- Login Protection Section --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-base-content mb-4">Login Protection</h3>
            </div>

            {{-- Maximum Login Attempts --}}
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Maximum Login Attempts</span>
                </label>
                <input 
                    type="number" 
                    wire:model="max_login_attempts"
                    class="input input-bordered" 
                    min="1"
                    max="20"
                />
                @error('max_login_attempts') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Lockout Duration --}}
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-medium">Lockout Duration (minutes)</span>
                </label>
                <input 
                    type="number" 
                    wire:model="lockout_duration"
                    class="input input-bordered" 
                    min="5"
                    max="60"
                />
                @error('lockout_duration') 
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
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