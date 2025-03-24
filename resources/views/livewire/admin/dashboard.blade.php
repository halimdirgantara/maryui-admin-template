<div>
    <livewire:component.header :searchBar=false :title=$title :subTitle=$subTitle />
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Card 1: User Stats -->
        <x-card title="User Stats" subtitle="Overview of your account" shadow separator>
            <div class="flex flex-col gap-2">
                <p><strong>Total Users:</strong> 1,024</p>
                <p><strong>Active Today:</strong> 87</p>
                <p><strong>New Registrations:</strong> 16</p>
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
    </div>
</div>
