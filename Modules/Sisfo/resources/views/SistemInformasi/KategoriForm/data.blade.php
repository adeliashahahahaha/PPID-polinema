@php
    use Modules\Sisfo\App\Models\Website\WebMenuModel;
    use Modules\Sisfo\App\Models\HakAkses\SetHakAksesModel;
    $kategoriFormUrl = WebMenuModel::getDynamicMenuUrl('kategori-form');
@endphp
<div class="d-flex justify-content-between align-items-center mb-2">
    <div class="showing-text">
        Showing {{ $kategoriForm->firstItem() }} to {{ $kategoriForm->lastItem() }} of {{ $kategoriForm->total() }}
        results
    </div>
</div>

<div class="table-responsive">
    <table class="table table-responsive-stack align-middle table-bordered table-striped table-hover table-sm">
    <thead>
        <tr>
            <th width="5%">Nomor</th>
            <th width="65%">Nama Kategori Form</th>
            <th width="30%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($kategoriForm as $key => $item)
                <tr>
                    <td>{{ ($kategoriForm->currentPage() - 1) * $kategoriForm->perPage() + $key + 1 }}</td>
                    <td>{{ $item->kf_nama }}</td>
                   <td class="text-center">
    <div class="btn-group" role="group">
        @if(
            Auth::user()->level->hak_akses_kode === 'SAR' ||
            SetHakAksesModel::cekHakAkses(Auth::user()->user_id, $kategoriFormUrl, 'update')
        )
            <button class="btn btn-sm btn-warning mx-1"
                onclick="modalAction('{{ url($kategoriFormUrl . '/editData/' . $item->kategori_form_id) }}')">
                <i class="fas fa-edit"></i> Edit
            </button>
        @endif
        <button class="btn btn-sm btn-info mx-1"
            onclick="modalAction('{{ url($kategoriFormUrl . '/detailData/' . $item->kategori_form_id) }}')">
            <i class="fas fa-eye"></i> Detail
        </button>
        @if(
            Auth::user()->level->hak_akses_kode === 'SAR' ||
            SetHakAksesModel::cekHakAkses(Auth::user()->user_id, $kategoriFormUrl, 'delete')
        )
            <button class="btn btn-sm btn-danger mx-1"
                onclick="modalAction('{{ url($kategoriFormUrl . '/deleteData/' . $item->kategori_form_id) }}')">
                <i class="fas fa-trash"></i> Hapus
            </button>
        @endif
    </div>
</td>
                </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">
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
</div>
<div class="mt-3">
    {{ $kategoriForm->appends(['search' => $search])->links() }}
</div>