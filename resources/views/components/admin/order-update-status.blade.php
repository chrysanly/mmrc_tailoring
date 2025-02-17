 @props(['id' => '', 'status' => '', 'button' => '', 'icon' => ''])
 
 <form
     action="{{ route('admin.order.update-status', [
         'order' => $id,
         'status' => $status,
     ]) }}"
     method="post">
     @csrf
     @method('PATCH')
     <button type="submit" class="dropdown-item">  <i class="bi {{ $icon }}"></i> {{ $button }}</button>
 </form>
