<x-dashboard-layout>
    <h1>Profile</h1>
    <div class="flex flex-col gap-4">
        <div class="flex flex-col gap-2">
            <h2 class="text-2xl font-bold">Personal Information</h2>
            <p class="text-gray-600">Name: {{ $user->name }}</p>
            <p class="text-gray-600">Email: {{ $user->email }}</p>
        </div>
    </div>
</x-dashboard-layout>