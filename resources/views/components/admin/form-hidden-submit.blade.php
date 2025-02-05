<form action="{{ route('admin.appointment.update-status', ['appointment' => $appointment->id]) }}" method="POST"
    style="display:inline-block;">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" value="rejected" id="">
    <button type="submit"
        class="btn btn-sm btn-danger {{ $appointment->status !== 'pending' ? 'disabled' : '' }}">Reject</button>
</form>