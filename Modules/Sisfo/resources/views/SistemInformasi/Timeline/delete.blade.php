<!-- views/SistemInformasi/Timeline/delete.blade.php -->
@php
  use Modules\Sisfo\App\Models\Website\WebMenuModel;
  $timelineUrl = WebMenuModel::getDynamicMenuUrl('timeline');
@endphp
<div class="modal-header">
  <h5 class="modal-title">Konfirmasi Hapus Timeline</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="modal-body">    
  <div class="alert alert-danger mt-3">
    <i class="fas fa-exclamation-triangle mr-2"></i> Menghapus timeline ini juga akan menghapus semua langkah-langkah yang terkait. 
    Apakah Anda yakin ingin menghapus timeline dengan detail berikut:
 </div>
  
  <div class="card">
    <div class="card-body">
      <table class="table table-borderless">
        <tr>
          <th width="200">Kategori Form</th>
          <td>{{ $timeline->TimelineKategoriForm->kf_nama ?? 'Tidak ada' }}</td>
        </tr>
        <tr>
          <th>Judul Timeline</th>
          <td>{{ $timeline->judul_timeline }}</td>
        </tr>
        <tr>
          <th>Tanggal Dibuat</th>
          <td>{{ date('d-m-Y H:i:s', strtotime($timeline->created_at)) }}</td>
        </tr>
        <tr>
          <th>Dibuat Oleh</th>
          <td>{{ $timeline->created_by }}</td>
        </tr>
        @if($timeline->updated_by)
        <tr>
          <th>Terakhir Diperbarui</th>
          <td>{{ date('d-m-Y H:i:s', strtotime($timeline->updated_at)) }}</td>
        </tr>
        <tr>
          <th>Diperbarui Oleh</th>
          <td>{{ $timeline->updated_by }}</td>
        </tr>
        @endif
      </table>
    </div>
  </div>
  
  <div class="card mt-3">
    <div class="card-header">
      <h5 class="card-title">Langkah-langkah Timeline</h5>
    </div>
    <div class="card-body">
      @if($timeline->langkahTimeline->count() > 0)
        <ol class="pl-3">
          @foreach($timeline->langkahTimeline as $langkah)
            <li class="mb-2">{{ $langkah->langkah_timeline }}</li>
          @endforeach
        </ol>
      @else
        <div class="alert alert-info">
          Tidak ada langkah timeline yang tersedia.
        </div>
      @endif
    </div>
  </div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
  <button type="button" class="btn btn-danger" id="confirmDeleteButton" 
    onclick="confirmDelete('{{ url($timelineUrl . '/deleteData/' . $timeline->timeline_id) }}')">
    <i class="fas fa-trash mr-1"></i> Hapus
  </button>
</div>

<script>
  function confirmDelete(url) {
    const button = $('#confirmDeleteButton');
    
    button.html('<i class="fas fa-spinner fa-spin"></i> Menghapus...').prop('disabled', true);
    
    $.ajax({
      url: url,
      type: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        $('#myModal').modal('hide');
        
        if (response.success) {
          reloadTable();
          
          Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: response.message
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: response.message
          });
        }
      },
      error: function(xhr) {
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.'
        });
        
        button.html('<i class="fas fa-trash mr-1"></i> Hapus').prop('disabled', false);
      }
    });
  }
</script>