<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ticket Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto p-8 max-w-4xl">
        <div class="mb-4">
            <a href="{{ route('admin.tickets.index') }}" class="text-indigo-600 hover:text-indigo-900 font-bold">&larr;
                Back to List</a>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $ticket->subject }}</h1>
                    <p class="text-sm text-gray-500">Submitted on {{ $ticket->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div>
                    <span
                        class="px-4 py-2 font-semibold leading-tight rounded-full 
                        {{ $ticket->status == 'new' ? 'bg-blue-100 text-blue-800' : ($ticket->status == 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </div>
            </div>

            <hr class="mb-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h2 class="text-xl font-bold mb-4 text-gray-700">Customer Information</h2>
                    <ul class="space-y-2">
                        <li><span class="font-semibold">Name:</span> {{ $ticket->customer->name }}</li>
                        <li><span class="font-semibold">Email:</span> {{ $ticket->customer->email }}</li>
                        <li><span class="font-semibold">Phone:</span> {{ $ticket->customer->phone }}</li>
                    </ul>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-4 text-gray-700">Update Status</h2>
                    <form action="{{ route('admin.tickets.updateStatus', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="flex gap-4">
                            <select name="status"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                                <option value="new" {{ $ticket->status == 'new' ? 'selected' : '' }}>New</option>
                                <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="processed" {{ $ticket->status == 'processed' ? 'selected' : '' }}>
                                    Processed</option>
                            </select>
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">Update</button>
                        </div>
                    </form>
                    @if ($ticket->manager_response_date)
                        <p class="mt-2 text-sm text-green-600">Processed on:
                            {{ $ticket->manager_response_date->format('Y-m-d H:i') }}</p>
                    @endif
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Ticket Content</h2>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 text-gray-800 whitespace-pre-wrap">
                    {{ $ticket->text }}</div>
            </div>

            @if ($ticket->hasMedia('tickets'))
                <div>
                    <h2 class="text-xl font-bold mb-4 text-gray-700">Attachments</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($ticket->getMedia('tickets') as $media)
                            <div class="border rounded-lg p-2 flex flex-col items-center bg-gray-50">
                                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z">
                                    </path>
                                </svg>
                                <a href="{{ $media->getFullUrl() }}" target="_blank"
                                    class="mt-2 text-xs text-indigo-600 hover:text-indigo-900 font-bold truncate w-full text-center">
                                    {{ $media->file_name }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
