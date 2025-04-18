<div class="d-flex justify-content-between align-items-center mb-2">
    <div class="showing-text">
        Showing {{ $berita->firstItem() }} to {{ $berita->lastItem() }} of {{ $berita->total() }} results
    </div>
</div>

<div class="table-responsive">
<table class="table table-responsive-stack table-bordered table-striped table-hover table-sm align-middle">
    <thead class="text-center">
        <tr>
            <th width="5%">Nomor</th>
            {{-- <th width="20%">Kategori</th> --}}
            <th width="25%">Judul</th>
            <th width="10%">Status</th>
            <th width="20%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($berita as $key => $item)
        <tr>
            <td table-data-label="Nomor" class="text-center">{{ ($berita->currentPage() - 1) * $berita->perPage() + $key + 1 }}</td>
            {{-- <td>{{ $item->BeritaDinamis ? $item->BeritaDinamis->bd_nama_submenu : '-' }}</td> --}}
            <td table-data-label="Judul Berita" class="text-start">{{ $item->berita_judul }}</td>
            <td table-data-label="Status" class="text-center">
                <span class="badge {{ $item->status_berita == 'aktif' ? 'badge-success' : 'badge-danger' }}">
                    {{ $item->status_berita }}
                </span>
            </td>
            <td table-data-label="Aksi" class="text-center">
                <button class="btn btn-sm btn-warning" onclick="modalAction('{{ url("adminweb/berita/editData/{$item->berita_id}") }}')">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-info" onclick="modalAction('{{ url("adminweb/berita/detailData/{$item->berita_id}") }}')">
                    <i class="fas fa-eye"></i> Detail
                </button>
                <button class="btn btn-sm btn-danger" onclick="modalAction('{{ url("adminweb/berita/deleteData/{$item->berita_id}") }}')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">
                @if(!empty($search))
                    Tidak ada data yang cocok dengan pencarian "{{ $search }}"
                @else
                    Tidak ada data
                @endif
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-3">
    {{ $berita->appends(['search' => $search])->links() }}
</div>
