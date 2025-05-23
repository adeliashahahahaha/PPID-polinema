@php
    use Modules\Sisfo\App\Models\Website\WebMenuModel;
    use Modules\Sisfo\App\Models\HakAkses\SetHakAksesModel;
    $kategoriAksesCepatUrl = WebMenuModel::getDynamicMenuUrl('kategori-akses-cepat');
@endphp
<div class="d-flex justify-content-between align-items-center mb-2">
     <div class="showing-text">
         Showing {{ $kategoriAkses->firstItem() }} to {{ $kategoriAkses->lastItem() }} of {{ $kategoriAkses->total() }} results
     </div>
 </div>
 <div class="table-responsive">
    <table class="table table-responsive-stack align-middle table-bordered table-striped table-hover table-sm">
     <thead>
         <tr>
             <th width="10%">Nomor</th>
             <th width="60%">Judul Kategori</th>
             <th width="30%">Aksi</th>
         </tr>
     </thead>
     <tbody>
         @forelse($kategoriAkses as $key => $item)
         <tr>
             <td>{{ ($kategoriAkses->currentPage() - 1) * $kategoriAkses->perPage() + $key + 1 }}</td>
             <td>{{ $item->mka_judul_kategori }}</td>
             <td class="text-center">
    <div class="btn-group" role="group">
                @if(
                    Auth::user()->level->hak_akses_kode === 'SAR' ||
                    SetHakAksesModel::cekHakAkses(Auth::user()->user_id, $kategoriAksesCepatUrl, 'update')
                )
                    <button class="btn btn-sm btn-warning mx-1"
                        onclick="modalAction('{{ url($kategoriAksesCepatUrl . '/editData/' . $item->kategori_akses_id) }}')">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                @endif
                <button class="btn btn-sm btn-info mx-1"
                    onclick="modalAction('{{ url($kategoriAksesCepatUrl . '/detailData/' . $item->kategori_akses_id) }}')">
                    <i class="fas fa-eye"></i> Detail
                </button>
                @if(
                    Auth::user()->level->hak_akses_kode === 'SAR' ||
                    SetHakAksesModel::cekHakAkses(Auth::user()->user_id, $kategoriAksesCepatUrl, 'delete')
                )
                    {{-- <button class="btn btn-sm btn-danger"
                        onclick="modalAction('{{ url($kategoriAksesCepatUrl . '/deleteData/' . $item->kategori_akses_id) }}')">
                        <i class="fas fa-trash"></i> Hapus
                    </button> --}}
                @endif
            </td>
            </div>
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
     {{ $kategoriAkses->appends(['search' => $search])->links() }}
 </div>