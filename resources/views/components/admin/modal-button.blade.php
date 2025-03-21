@props([
    'modalId' => 'exampleModal',
    'size' => '',
    'confirmButtonLabel' => 'Save Changes',
    'modalConfirmId' => '',
    'buttonLabel' => 'Label',
    'isButton' => false
])

<button type="button" class="{{ $isButton ? 'btn btn-primary btn-sm' : 'dropdown-item' }}" onclick="openModal('{{ $modalId }}')">
    {{ $buttonLabel }}
</button>

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
  <div class="modal-dialog {{ $size }}">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="{{ $modalId }}Label">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{ $slot }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="{{ $modalConfirmId ?: $modalId . '-confirm' }}" class="btn btn-primary">
            {{ $confirmButtonLabel }}
        </button>
      </div>
    </div>
  </div>
</div>
