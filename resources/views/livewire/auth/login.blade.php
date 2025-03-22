<div class="flex items-center justify-center min-h-screen">
    <x-card title="Welcome Back" class="w-full max-w-md shadow-xl">
        <x-slot:figure>
            <div class="relative h-40 overflow-hidden rounded-t-lg">
                <img src="#" alt="Login" class="w-full object-cover"
                    onerror="this.src='https://picsum.photos/800/300?blur=2'" />
                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                    <x-icon name="o-user-circle" class="w-20 h-20 text-white" />
                </div>
            </div>
        </x-slot:figure>

        <form class="space-y-6" wire:submit.prevent="login">
            <div>
                <x-input wire:model="email" label="Email" placeholder="Your email" icon="o-envelope" />
            </div>

            <div>
                <x-password wire:model="password" label="Right toggle" right />
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <x-checkbox name="remember" wire:model="remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <x-slot:actions>
                <div class="flex flex-col w-full gap-4">
                    <x-button wire:click="login" label="Sign In" class="btn-primary w-full" />
                </div>
            </x-slot:actions>
        </form>
    </x-card>
</div>
