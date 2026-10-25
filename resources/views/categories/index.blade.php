@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1 text-white">Kategori Diecast</h3>
        <p class="text-secondary small mb-0">Klasifikasi tipe diecast (Mainline, Premium Car Culture, RLC, dll.).</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card-custom p-4">
            <h5 class="fw-bold mb-3 text-white">Tambah Kategori</h5>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold text-light">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" required placeholder="Contoh: Pop Culture">
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-semibold text-light">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Keterangan singkat kategori..."></textarea>
                </div>
                <button type="submit" class="btn-pill-red w-100 justify-content-center">
                    Simpan Kategori
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-custom">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th>Total Unit</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $cat)
                        <tr>
                            <td class="fw-bold text-white">{{ $cat->name }}</td>
                            <td class="small text-secondary">{{ $cat->description ?? '-' }}</td>
                            <td><span class="badge bg-dark border border-secondary border-opacity-50 text-light rounded-pill px-3">{{ $cat->products_count }} item</span></td>
                            <td class="text-end">
                                <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle p-2" style="width: 36px; height: 36px;" title="Hapus Kategori">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-secondary">Belum ada kategori yang ditambahkan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection