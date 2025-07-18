<x-dashboard-layout>
<a href="{{ route('admin.dashboard') }}" class="inline-block mb-4 px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"><i class="fas fa-arrow-left mr-2"></i>Back</a>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Payment Management</h1>
        <div class="flex space-x-2">
            <button onclick="refreshPayments()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Refresh
            </button>
        </div>
    </div>

    <!-- Payment Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700">Total Payments</h3>
            <p class="text-2xl font-bold text-blue-600">{{ $payments->total() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700">Successful</h3>
            <p class="text-2xl font-bold text-green-600">{{ $payments->where('status', 'success')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700">Pending</h3>
            <p class="text-2xl font-bold text-yellow-600">{{ $payments->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-700">Failed</h3>
            <p class="text-2xl font-bold text-red-600">{{ $payments->where('status', 'failed')->count() }}</p>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            #{{ $payment->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $payment->user->name }}<br>
                            <span class="text-gray-500">{{ $payment->user->email }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            MWK {{ number_format($payment->amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $payment->status === 'success' ? 'bg-green-100 text-green-800' : 
                                   ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($payment->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $payment->transaction_id ?: 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $payment->created_at->format('M d, Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button 
                                    onclick="verifyPayment({{ $payment->id }})" 
                                    class="text-blue-600 hover:text-blue-900 {{ $payment->status === 'pending' ? '' : 'opacity-50 cursor-not-allowed' }}"
                                    {{ $payment->status !== 'pending' ? 'disabled' : '' }}
                                >
                                    Verify
                                </button>
                                <button 
                                    onclick="viewPaymentDetails({{ $payment->id }})" 
                                    class="text-green-600 hover:text-green-900"
                                >
                                    Details
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $payments->links() }}
        </div>
    </div>
</div>

<!-- Payment Details Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Details</h3>
            <div id="paymentDetails" class="text-sm text-gray-600">
                <!-- Payment details will be loaded here -->
            </div>
            <div class="mt-4 flex justify-end">
                <button onclick="closePaymentModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function verifyPayment(paymentId) {
    if (confirm('Are you sure you want to verify this payment?')) {
        fetch(`/payments/${paymentId}/verify`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Payment verified successfully!');
                location.reload();
            } else {
                alert('Verification failed: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Verification failed. Please try again.');
        });
    }
}

function viewPaymentDetails(paymentId) {
    fetch(`/admin/payments/${paymentId}`)
        .then(response => response.json())
        .then(data => {
            const detailsDiv = document.getElementById('paymentDetails');
            detailsDiv.innerHTML = `
                <div class="space-y-2">
                    <p><strong>Payment ID:</strong> #${data.payment.id}</p>
                    <p><strong>User:</strong> ${data.payment.user.name} (${data.payment.user.email})</p>
                    <p><strong>Amount:</strong> MWK ${parseFloat(data.payment.amount).toLocaleString()}</p>
                    <p><strong>Status:</strong> ${data.payment.status}</p>
                    <p><strong>Transaction ID:</strong> ${data.payment.transaction_id || 'N/A'}</p>
                    <p><strong>Provider:</strong> ${data.payment.provider}</p>
                    <p><strong>Created:</strong> ${new Date(data.payment.created_at).toLocaleString()}</p>
                    <p><strong>Updated:</strong> ${new Date(data.payment.updated_at).toLocaleString()}</p>
                    ${data.payment.provider_data ? `<p><strong>Provider Data:</strong></p><pre class="bg-gray-100 p-2 rounded text-xs overflow-auto">${JSON.stringify(JSON.parse(data.payment.provider_data), null, 2)}</pre>` : ''}
                </div>
            `;
            document.getElementById('paymentModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to load payment details.');
        });
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}

function refreshPayments() {
    location.reload();
}
</script>
</x-dashboard-layout> 