<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-Form</title>
    @vite(['resources/css/e-form.css'])
</head>
<body>
    @include('layouts.header')
    @include('layouts.navbar')
    <section class="container py-5">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title"><strong> Identitas Pemohon Permohonan Informasi </strong></h3>
        </div>
        <div class="card-body">
            <form action="{{ url('SistemInformasi/EForm/PermohonanInformasi/storePermohonanInformasi') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="pi_kategori_pemohon">Permohonan Informasi Dilakukan Atas</label>
                    <select class="form-control" id="pi_kategori_pemohon" name="pi_kategori_pemohon" required>
                        <option value="">-- Silakan Pilih Kategori Pemohon --</option>
                        <option value="Diri Sendiri">Diri Sendiri</option>
                        <option value="Orang Lain">Orang Lain</option>
                        <option value="Organisasi">Organisasi</option>
                    </select>
                </div>

                <!-- Form untuk Orang Lain -->
                <div id="formOrangLain" style="display: none;">
                    <div class="form-group">
                        <label>Nama Pengguna Informasi</label>
                        <input type="text" class="form-control" name="pi_nama_pengguna_informasi">
                    </div>
                    <div class="form-group">
                        <label>Alamat Pengguna Informasi</label>
                        <input type="text" class="form-control" name="pi_alamat_pengguna_informasi">
                    </div>
                    <div class="form-group">
                        <label>No HP Pengguna Informasi</label>
                        <input type="text" class="form-control" name="pi_no_hp_pengguna_informasi">
                    </div>
                    <div class="form-group">
                        <label>Email Pengguna Informasi</label>
                        <input type="email" class="form-control" name="pi_email_pengguna_informasi">
                    </div>
                    <div class="form-group">
                        <label>Upload NIK Pengguna Informasi</label>
                        <input type="file" class="form-control" name="pi_upload_nik_pengguna_informasi" accept="image/*">
                    </div>
                </div>

                <!-- Form untuk Organisasi -->
                <div id="formOrganisasi" style="display: none;">
                    <div class="form-group">
                        <label>Nama Organisasi</label>
                        <input type="text" class="form-control" name="pi_nama_organisasi">
                    </div>
                    <div class="form-group">
                        <label>No Telepon Organisasi</label>
                        <input type="text" class="form-control" name="pi_no_telp_organisasi">
                    </div>
                    <div class="form-group">
                        <label>Email/Media Sosial Organisasi</label>
                        <input type="text" class="form-control" name="pi_email_atau_medsos_organisasi">
                    </div>
                    <div class="form-group">
                        <label>Nama Narahubung</label>
                        <input type="text" class="form-control" name="pi_nama_narahubung">
                    </div>
                    <div class="form-group">
                        <label>No Telepon Narahubung</label>
                        <input type="text" class="form-control" name="pi_no_telp_narahubung">
                    </div>
                    <div class="form-group">
                        <label>Upload Identitas Narahubung</label>
                        <input type="file" class="form-control" name="pi_identitas_narahubung" accept="image/*">
                    </div>
                </div>

                <!-- Form umum untuk semua kategori -->
                <div class="form-group">
                    <label>Informasi yang Dibutuhkan</label>
                    <textarea class="form-control" name="pi_informasi_yang_dibutuhkan" required rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Alasan Permohonan Informasi</label>
                    <textarea class="form-control" name="pi_alasan_permohonan_informasi" required rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Sumber Informasi</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="pi_sumber_informasi[]"
                            value="Pertanyaan Langsung Pemohon">
                        <label class="form-check-label">Pertanyaan Langsung Pemohon</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="pi_sumber_informasi[]"
                            value="Website / Media Sosial Milik Polinema">
                        <label class="form-check-label">Website / Media Sosial Milik Polinema</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="pi_sumber_informasi[]"
                            value="Website / Media Sosial Bukan Milik Polinema">
                        <label class="form-check-label">Website / Media Sosial Bukan Milik Polinema</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Alamat Sumber Informasi</label>
                    <input type="text" class="form-control" name="pi_alamat_sumber_informasi" required>
                </div>
                <button type="submit" class="btn btn-primary">Ajukan Permohonan</button>
            </form>
        </div>
    </div>
</section>
</body>
<footer>
    @include('layouts.footer')
</footer>
</html>