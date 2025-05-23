@php
  use Modules\Sisfo\App\Models\Website\WebMenuModel;
  $regulasiDinamisUrl = WebMenuModel::getDynamicMenuUrl('regulasi-dinamis');
@endphp
<div class="modal-header">
  <h5 class="modal-title">Edit Regulasi Dinamis</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>

<div class="modal-body">
  <form id="formUpdateRegulasiDinamis" action="{{ url($regulasiDinamisUrl . '/updateData/' . $RegulasiDinamis->regulasi_dinamis_id) }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="rd_judul_reg_dinamis">Judul Regulasi Dinamis <span class="text-danger">*</span></label>
      <input type="text" class="form-control" id="rd_judul_reg_dinamis" name="m_regulasi_dinamis[rd_judul_reg_dinamis]" maxlength="150" placeholder="Masukkan judul regulasi dinamis" value="{{ $RegulasiDinamis->rd_judul_reg_dinamis }}">
      <div class="invalid-feedback" id="rd_judul_reg_dinamis_error"></div>
      <small class="form-text text-muted">Contoh: Regulasi.</small>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
  <button type="button" class="btn btn-success" id="btnSubmitForm">
    <i class="fas fa-save mr-1"></i> Simpan Perubahan
  </button>
</div>

<script>
  $(document).ready(function () {
      // Hapus error ketika input berubah
      $(document).on('input change', 'input, select, textarea', function() {
          $(this).removeClass('is-invalid');
          const errorId = `#${$(this).attr('id')}_error`;
          $(errorId).html('');
      });

      // Handle submit form
      $('#btnSubmitForm').on('click', function() {
          // Reset semua error
          $('.is-invalid').removeClass('is-invalid');
          $('.invalid-feedback').html('');
          
          const form = $('#formUpdateRegulasiDinamis');
          const formData = new FormData(form[0]);
          const button = $(this);
          
          // Ambil nilai input untuk validasi
          const judulRegulasi = $('#rd_judul_reg_dinamis').val().trim();

          // Validasi client-side
          let isValid = true;

          // Validasi Judul Regulasi Dinamis
          if (judulRegulasi === '') {
              $('#rd_judul_reg_dinamis').addClass('is-invalid');
              $('#rd_judul_reg_dinamis_error').html('Judul Regulasi Dinamis wajib diisi.');
              isValid = false;
          } else if (judulRegulasi.length > 150) {
              $('#rd_judul_reg_dinamis').addClass('is-invalid');
              $('#rd_judul_reg_dinamis_error').html('Maksimal 150 karakter.');
              isValid = false;
          }

          // Jika validasi gagal, tampilkan pesan error dan batalkan pengiriman form
          if (!isValid) {
              Swal.fire({
                  icon: 'error',
                  title: 'Validasi Gagal',
                  text: 'Mohon periksa kembali input Anda.'
              });
              return;
          }

          // Tampilkan loading state pada tombol submit
          button.html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').attr('disabled', true);

          $.ajax({
              url: form.attr('action'),
              type: 'POST',
              data: formData,
              processData: false,
              contentType: false,
              success: function(response) {
                  if (response.success) {
                      $('#myModal').modal('hide');
                      
                      // Reload table data
                      reloadTable();
                      
                      Swal.fire({
                          icon: 'success',
                          title: 'Berhasil',
                          text: response.message
                      });
                  } else {
                      if (response.errors) {
                          // Tampilkan pesan error pada masing-masing field
                          $.each(response.errors, function(key, value) {
                              if (key.startsWith('m_regulasi_dinamis.')) {
                                  const fieldName = key.replace('m_regulasi_dinamis.', '');
                                  $(`#${fieldName}`).addClass('is-invalid');
                                  $(`#${fieldName}_error`).html(value[0]);
                              } else {
                                  $(`#${key}`).addClass('is-invalid');
                                  $(`#${key}_error`).html(value[0]);
                              }
                          });

                          Swal.fire({
                              icon: 'error',
                              title: 'Validasi Gagal',
                              text: 'Mohon periksa kembali input Anda'
                          });
                      } else {
                          Swal.fire({
                              icon: 'error',
                              title: 'Gagal',
                              text: response.message || 'Terjadi kesalahan saat menyimpan data'
                          });
                      }
                  }
              },
              error: function(xhr) {
                  Swal.fire({
                      icon: 'error',
                      title: 'Gagal',
                      text: 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
                  });
              },
              complete: function() {
                  // Kembalikan tombol submit ke keadaan semula
                  button.html('<i class="fas fa-save mr-1"></i> Simpan Perubahan').attr('disabled', false);
              }
          });
      });
  });
</script>
