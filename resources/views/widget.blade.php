<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Widget</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: transparent;
        }

        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="p-4">
    <div class="max-w-md mx-auto glass rounded-2xl shadow-2xl p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Support Ticket</h2>
        <form id="ticketForm" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone (E.164)</label>
                    <input type="text" name="phone" required placeholder="+1234567890"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Subject</label>
                <input type="text" name="subject" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Message</label>
                <textarea name="text" required rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-2 border"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Attachment (optional)</label>
                <input type="file" name="file"
                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>
            <div id="message" class="hidden text-sm p-2 rounded-md"></div>
            <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                Submit Ticket
            </button>
        </form>
    </div>

    <script>
        document.getElementById('ticketForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const messageDiv = document.getElementById('message');
            const submitBtn = form.querySelector('button[type="submit"]');

            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Submitting...';
            messageDiv.classList.add('hidden');

            try {
                const response = await fetch('/api/tickets', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    messageDiv.textContent = 'Ticket submitted successfully!';
                    messageDiv.classList.remove('hidden', 'bg-red-100', 'text-red-700');
                    messageDiv.classList.add('bg-green-100', 'text-green-700');
                    form.reset();
                } else {
                    messageDiv.textContent = result.message || 'Error submitting ticket.';
                    if (result.errors) {
                        const errorMsg = Object.values(result.errors).flat().join(' ');
                        messageDiv.textContent = errorMsg;
                    }
                    messageDiv.classList.remove('hidden', 'bg-green-100', 'text-green-700');
                    messageDiv.classList.add('bg-red-100', 'text-red-700');
                }
            } catch (error) {
                messageDiv.textContent = 'Network error. Please try again.';
                messageDiv.classList.remove('hidden', 'bg-green-100', 'text-green-700');
                messageDiv.classList.add('bg-red-100', 'text-red-700');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Submit Ticket';
                messageDiv.classList.remove('hidden');
            }
        });
    </script>
</body>

</html>
