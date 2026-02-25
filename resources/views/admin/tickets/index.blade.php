<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tickets</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Support Tickets</h1>

        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <form method="GET" action="{{ route('admin.tickets.index') }}"
                class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                        <option value="">All</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In
                            Progress</option>
                        <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" name="email" value="{{ request('email') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ request('phone') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white p-2 rounded-md hover:bg-indigo-700 transition">Filter</button>
                </div>
            </form>
        </div>

        <!-- Ticket Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Date</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Customer</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Subject</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{ $ticket->created_at->format('Y-m-d H:i') }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $ticket->customer->name }}</p>
                                <p class="text-gray-600 whitespace-no-wrap">{{ $ticket->customer->email }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $ticket->subject }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span
                                    class="relative inline-block px-3 py-1 font-semibold leading-tight 
                                {{ $ticket->status == 'new' ? 'text-blue-900' : ($ticket->status == 'in_progress' ? 'text-yellow-900' : 'text-green-900') }}">
                                    <span aria-hidden
                                        class="absolute inset-0 opacity-50 rounded-full 
                                    {{ $ticket->status == 'new' ? 'bg-blue-200' : ($ticket->status == 'in_progress' ? 'bg-yellow-200' : 'bg-green-200') }}"></span>
                                    <span class="relative">{{ ucfirst($ticket->status) }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 font-bold">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                {{ $tickets->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</body>

</html>
