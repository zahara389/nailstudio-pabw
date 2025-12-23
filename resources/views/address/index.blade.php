@extends('layouts.app')

@section('title', 'My Addresses | Nail Studio')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-pink-700 mb-8">My Addresses</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($addresses as $address)
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <div class="flex justify-between items-start mb-4">
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded {{ $address->type === 'shipping' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                        {{ ucfirst($address->type) }}
                    </span>
                </div>
                
                <p class="text-gray-700 mb-4">{{ $address->address }}</p>
                
                <div class="flex gap-2">
                    <button onclick="editAddress({{ $address->id }}, '{{ addslashes($address->address) }}', '{{ $address->type }}')" 
                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium transition">
                        Edit
                    </button>
                    <form method="POST" action="{{ route('address.destroy', $address) }}" style="display:inline; flex: 1;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this address?')" 
                            class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm font-medium transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <button onclick="openAddModal()" class="mt-8 bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-lg font-semibold transition">
        + Add New Address
    </button>
</div>

<!-- Add/Edit Modal -->
<div id="addressModal" style="display:none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
        <h2 class="text-2xl font-bold mb-4" id="modalTitle">Add Address</h2>
        
        <form id="addressForm" method="POST" action="{{ route('address.store') }}">
            @csrf
            <input type="hidden" id="formMethod" name="_method" value="POST">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <textarea id="addressInput" name="address" rows="4" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select id="typeInput" name="type" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-pink-500 focus:border-pink-500">
                    <option value="shipping">Shipping</option>
                    <option value="billing">Billing</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded font-medium">
                    Cancel
                </button>
                <button type="submit" class="flex-1 bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded font-medium">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add Address';
    document.getElementById('addressForm').action = '{{ route("address.store") }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('addressForm').reset();
    document.getElementById('addressModal').style.display = 'flex';
}

function editAddress(id, address, type) {
    document.getElementById('modalTitle').textContent = 'Edit Address';
    document.getElementById('addressInput').value = address;
    document.getElementById('typeInput').value = type;
    document.getElementById('addressForm').action = `/address/${id}`;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('addressModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('addressModal').style.display = 'none';
    document.getElementById('addressForm').reset();
}

document.getElementById('addressModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endsection
