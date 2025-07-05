<x-dashboard-layout>
    <h1 class="text-3xl font-bold mb-6">Users</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-xl shadow-lg">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b text-left text-sm font-bold text-gray-700 uppercase">ID</th>
                    <th class="px-6 py-3 border-b text-left text-sm font-bold text-gray-700 uppercase">Username</th>
                    <th class="px-6 py-3 border-b text-left text-sm font-bold text-gray-700 uppercase">Email</th>
                    <th class="px-6 py-3 border-b text-left text-sm font-bold text-gray-700 uppercase">Phone Number</th>
                    <th class="px-6 py-3 border-b text-left text-sm font-bold text-gray-700 uppercase">Role</th>
                    <th class="px-6 py-3 border-b text-center text-sm font-bold text-gray-700 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 border-b">{{ $user->id }}</td>
                        <td class="px-6 py-4 border-b">{{ $user->username }}</td>
                        <td class="px-6 py-4 border-b">{{ $user->email }}</td>
                        <td class="px-6 py-4 border-b">{{ $user->phone_number }}</td>
                        <td class="px-6 py-4 border-b">{{ ucfirst($user->role) }}</td>
                        <td class="px-6 py-4 border-b text-center">
                            <a href="{{ route('user.edit', $user->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 font-semibold text-xs uppercase">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-dashboard-layout>
