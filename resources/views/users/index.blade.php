@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-0 text-dark">Manajemen Akun Pengguna</h3>
        <p class="text-muted small mb-0">Atur hak akses untuk 3 role: Admin, Staff Gudang, dan Customer.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card card-custom bg-white p-3">
            <h5 class="fw-bold mb-3 text-dark">Daftarkan Akun Baru</h5>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required placeholder="Nama petugas / user">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Alamat Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="user@redline.test">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Kata Sandi</label>
                    <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Tingkatan Hak Akses (Role)</label>
                    <select name="role" class="form-select" required>
                        <option value="staff">Staff Gudang (Operasional Kasir & PO)</option>
                        <option value="admin">Admin / Owner (Akses Penuh)</option>
                        <option value="customer">Customer / Kolektor (Belanja Saja)</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-danger w-100"><i class="fa-solid fa-user-plus me-1"></i> Buat Akun</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-custom bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Pengguna</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td class="fw-semibold text-dark">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                <span class="badge {{ $u->isAdmin() ? 'bg-danger' : ($u->isStaff() ? 'bg-primary' : 'bg-success') }}">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="text-end">
                                @if($u->id !== auth()->id())
                                <form action="{{ route('users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Hapus akun ini?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                </form>
                                @else
                                <span class="text-muted small">Sedang Aktif</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection