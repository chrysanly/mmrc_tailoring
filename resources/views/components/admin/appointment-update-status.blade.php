 @props(['id' => '', 'status' => '', 'button' => ''])
 
 <form
     action="{{ route('admin.appointment.update-status', [
         'appointment' => $id,
         'status' => $status,
     ]) }}"
     method="post">
     @csrf
     @method('PATCH')
     <button type="submit" class="dropdown-item">{{ $button }}</button>
 </form>
