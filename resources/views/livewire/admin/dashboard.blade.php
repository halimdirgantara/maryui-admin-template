<div>
    <livewire:component.header :searchBar=false :filterButton=false :createButton=false :title="$title" :subTitle="$subTitle" />

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @if ($userRole === 'admin')
            <!-- Admin Cards -->
            <x-card title="User Stats" subtitle="Overview of your account" shadow separator>
                <div class="flex flex-col gap-2">
                    <p><strong>Total Users:</strong> {{ $stats['totalUsers'] ?? '-' }}</p>
                    <p><strong>Active Today:</strong> {{ $stats['activeToday'] ?? '-' }}</p>
                    <p><strong>New Registrations:</strong> {{ $stats['newRegistrations'] ?? '-' }}</p>
                </div>
            </x-card>

            <!-- Card 2: Sales Stats -->
            <x-card title="Notifications" subtitle="Recent alerts" shadow separator>
                <ul class="list-disc pl-5">
                    <li>New comment on your post</li>
                    <li>Password change request</li>
                    <li>System maintenance scheduled</li>
                </ul>
            </x-card>

            <!-- Card 3: Popular Items -->
            <x-card title="Popular Items">
                <x-slot:figure>
                    <img src="https://picsum.photos/500/200" alt="Popular Items" />
                </x-slot:figure>
                <x-slot:menu>
                    <x-button icon="o-share" class="btn-circle btn-sm" />
                    <x-icon name="o-heart" class="cursor-pointer" />
                </x-slot:menu>
                <x-slot:actions separator>
                    <x-button label="View All" class="btn-primary" />
                </x-slot:actions>
                Our top-selling products for this month.
            </x-card>

            <!-- Card 4: Notifications -->
            <x-card title="Sales Stats" subtitle="Monthly sales performance" shadow separator>
                <div class="flex flex-col gap-2">
                    <p><strong>Total Sales:</strong> $12,540</p>
                    <p><strong>Pending Orders:</strong> 23</p>
                    <p><strong>Refund Requests:</strong> 4</p>
                </div>
            </x-card>
        @elseif ($userRole === 'manager')
            <!-- Manager Cards -->
            <x-card title="Team Stats" subtitle="Your team overview" shadow separator>
                <div class="flex flex-col gap-2">
                    <p><strong>Team Members:</strong> {{ $stats['teamMembers'] ?? '-' }}</p>
                    <!-- ...other manager stats... -->
                </div>
            </x-card>
        @else
            <!-- Regular User Cards -->
            <x-card title="Welcome" subtitle="Your dashboard" shadow separator>
                <div class="flex flex-col gap-2">
                    <p>Welcome to your dashboard!</p>
                </div>
            </x-card>
        @endif

        <!-- Cards visible to all roles -->
        <x-card title="Notifications" subtitle="Recent alerts" shadow separator>
            <ul class="list-disc pl-5">
                <li>New comment on your post</li>
                <li>Password change request</li>
                <li>System maintenance scheduled</li>
            </ul>
        </x-card>
    </div>
</div>
