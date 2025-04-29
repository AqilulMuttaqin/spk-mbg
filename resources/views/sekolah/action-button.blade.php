<div class="d-flex justify-content-center text-nowrap gap-2">
    <button type="button" class="btn btn-sm btn-outline-info edit-btn" data-id="{{ $id }}">
        Edit
    </button>
    <form action="{{ route('sekolah.destroy', $id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-outline-danger confirm-delete">
            Delete
        </button>
    </form>
</div>