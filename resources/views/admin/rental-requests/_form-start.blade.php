<form class="{{ $formClass ?? 'rental-action-form form-grid rental-admin-form' }}" method="POST" action="{{ route('admin.rental-requests.update', $rental) }}">
    @csrf @method('PUT')
    <input type="hidden" name="version" value="{{ $rental->version }}">
    <input type="hidden" name="action" value="{{ $action }}">
