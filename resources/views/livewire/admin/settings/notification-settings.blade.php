<div class="p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-base-content mb-2">Notification Settings</h2>
        <p class="text-base-content/70">Configure email notifications and system alerts.</p>
    </div>

    <form wire:submit="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Email Notifications Section --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-base-content mb-4">Email Notifications</h3>
            </div>

            {{-- Enable Email Notifications --}}
            <div class="form-control md:col-span-2">
                <label class="label cursor-pointer">
                    <span class="label-text font-medium">Enable Email Notifications</span>
                    <input 
                        type="checkbox" 
                        wire:model="email_notifications_enabled"
                        class="toggle toggle-primary" 
                    />
                </label>
                <label class="label">
                    <span class="label-text-alt text-base-content/70">
                        Master switch for all email notifications. When disabled, no emails will be sent.
                    </span>
                </label>
            </div>

            {{-- Welcome Email --}}
            <div class="form-control">
                <label class="label cursor-pointer">
                    <span class="label-text font-medium">Welcome Email</span>
                    <input 
                        type="checkbox" 
                        wire:model="welcome_email_enabled"
                        class="toggle toggle-primary" 
                        @if(!$email_notifications_enabled) disabled @endif
                    />
                </label>
                <label class="label">
                    <span class="label-text-alt text-base-content/70">
                        Send welcome email to new users when they register.
                    </span>
                </label>
            </div>

            {{-- Password Reset Email --}}
            <div class="form-control">
                <label class="label cursor-pointer">
                    <span class="label-text font-medium">Password Reset Email</span>
                    <input 
                        type="checkbox" 
                        wire:model="password_reset_enabled"
                        class="toggle toggle-primary" 
                        @if(!$email_notifications_enabled) disabled @endif
                    />
                </label>
                <label class="label">
                    <span class="label-text-alt text-base-content/70">
                        Allow users to request password reset emails.
                    </span>
                </label>
            </div>

            {{-- User Registration Notification --}}
            <div class="form-control">
                <label class="label cursor-pointer">
                    <span class="label-text font-medium">New User Registration Notification</span>
                    <input 
                        type="checkbox" 
                        wire:model="user_registration_notification"
                        class="toggle toggle-primary" 
                        @if(!$email_notifications_enabled) disabled @endif
                    />
                </label>
                <label class="label">
                    <span class="label-text-alt text-base-content/70">
                        Notify administrators when new users register.
                    </span>
                </label>
            </div>

            {{-- System Alerts Section --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-base-content mb-4">System Alerts</h3>
            </div>

            {{-- System Alerts --}}
            <div class="form-control md:col-span-2">
                <label class="label cursor-pointer">
                    <span class="label-text font-medium">System Alerts</span>
                    <input 
                        type="checkbox" 
                        wire:model="system_alerts_enabled"
                        class="toggle toggle-primary" 
                    />
                </label>
                <label class="label">
                    <span class="label-text-alt text-base-content/70">
                        Show system alerts and notifications in the admin panel.
                    </span>
                </label>
            </div>
        </div>

        {{-- Information Card --}}
        <div class="alert alert-info mt-6">
            <x-icon name="o-information-circle" class="w-5 h-5" />
            <div>
                <h3 class="font-medium">Email Configuration</h3>
                <div class="text-sm">
                    Make sure your email settings are properly configured in your <code>.env</code> file 
                    for email notifications to work correctly.
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