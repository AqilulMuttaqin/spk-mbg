<div class="d-flex justify-content-center text-nowrap gap-2">
    <button type="button" class="btn btn-sm btn-outline-info edit-btn" data-id="{{ $id }}">
        <i class="ti ti-edit me-1"></i>
        Edit
    </button>
    <form action="{{ route('wilayah.kecamatan.destroy', $id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-outline-danger confirm-delete">
            <i class="ti ti-trash me-1"></i>
            Delete
        </button>
    </form>
</div>