<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>E-Form Permohonan Informasi</title>
    @vite(['resources/css/app.css','resources/js/upload-ktp.js'])
</head>
<body style="background: url('img/bg-eform.svg') center/cover no-repeat;>
    @include('user.layouts.header')
    <div class="title-page text-white">
        <h2> Formulir Permohonan Informasi</h2>
    </div>
    <section class="container e-form py-4 mb-5">


<div class="row row-cols-1 row-cols-md-2">
<div x-data="{ kategori: '' }">
    <div class="col ">
    <div class="card e-form-card mb-3">
        <div class="card-header">
            <h3 class="title-form"> Identitas Pemohon Permohonan Informasi</h3>
        </div>
        <div class="card-body ">
            <form action="{{ url('SistemInformasi/EForm/PermohonanInformasi/storePermohonanInformasi') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label class="label-form" for="pi_kategori_pemohon">Permohonan Informasi Dilakukan Atas</label>
                    <select  x-model="kategori" class="form-select" id="pi_kategori_pemohon" name="pi_kategori_pemohon" required>
                        <option value="">- Pilih Kategori Pemohon -</option>
                        <option value="Diri Sendiri">Diri Sendiri</option>
                        <option value="Orang Lain">Orang Lain</option>
                        <option value="Organisasi">Organisasi / Lembaga Masyarakat atau Yayasan atau Perusahaan</option>
                    </select>
                </div>
                <div id="formOrganisasi" x-show="kategori === 'Organisasi'" x-cloak>
                    <div class="row">
                        <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="label-form">Nama Organisasi <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" name="pi_nama_organisasi" >
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="label-form">No Telepon Organisasi <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" name="pi_no_telp_organisasi">
                    </div>
                    </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="label-form">Email dan Website / Media Sosial Organisasi <span class="text-danger">*</span> </label>
                        <p class="text-muted">
                            Contoh : <br>
                            * Email: organisasi@google.com, website: organisasi.co <br>
                            * Email: organisasi@google.com, IG: organisasi_sosial_masyarakat
                        </p>
                        <input type="text" class="form-control" name="pi_email_atau_medsos_organisasi">
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="label-form">Nama Narahubung Organisasi <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" name="pi_nama_narahubung">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label class="label-form">No Telepon Narahubung<span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" name="pi_no_telp_narahubung">
                    </div>
                    </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="label-form">Upload Foto Kartu Identitas Pemohon  <span class="text-danger">*</span> </label>
                        <br>
                        <label class="text-muted">Silakan scan / Foto kartu identitas (KTP/SIM/Paspor) pemohon. Semua data pada kartu identitas harus tampak jelas dan terang.</label>
                    {{-- <div class="col-md-6"> --}}
                    <div x-data="uploadHandler" class="upload-box">
                        <div class="upload-zone relative border-2 border-dashed border-gray-300 rounded-lg p-6 transition-all hover:border-orange-500 text-center"
                            @dragover.prevent="dragging = true; console.log('Dragging over')"
                            @dragleave="dragging = false; console.log('Dragging left')"
                            @drop.prevent="handleDrop($event); console.log('File dropped')"
                            :class="{ 'border-orange-500': dragging }">



                            <template x-if="previewUrl">
                                <img :src="previewUrl" class="upload-preview" alt="Preview">
                            </template>

                            <div x-show="!previewUrl" class="upload-placeholder">
                                <i class="fas fa-upload text-4xl text-gray-400 mb-3"></i>
                                <p class="text-sm text-gray-600">
                                   <strong> Drag and drop <span class="text-orange-500 font-semibold">or choose file</span> to
                                    upload </strong>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</p>
                                <div x-data>
                                    <button type="button" @click="$refs.fileInput.click()" class="btn upload-btn  px-4 py-2 shadow-sm">
                                        Pilih File
                                    </button>
                                    <input type="file" x-ref="fileInput" class="absolute invisible w-0 h-0" accept="image/*" @change="handleFileSelect">
                                </div>


                                <div id="file-error" class="text-red-500 text-sm mt-2" x-text="errorMessage"></div>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                            <div x-show="uploading" class="upload-progress mt-3">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-orange-500 h-2.5 rounded-full" :style="`width: ${uploadProgress}%`">
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 mt-2 text-center">
                                Mengupload... <span x-text="uploadProgress + '%'"></span>
                            </p>
                            </div>
                        </div>
                    {{-- </div> --}}
                    </div>
                    </div>
                    <div id="formOrangLain" x-show="kategori === 'Orang Lain'" x-cloak>
                        <div class="form-group mb-3">
                            <label class="label-form">Nama Pemohon <span class="text-danger">*</span> </label>
                            <br>
                            <label class="text-muted">Nama lengkap sesuai KTP</label>
                            <input type="text" class="form-control" name="pi_nama_pengguna_informasi">
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-form">Alamat Pemohon <span class="text-danger">*</span> </label>
                            <br>
                            <label class="text-muted">Alamat lengkap sesuai KTP</label>
                            <input type="text" class="form-control" name="pi_alamat_pengguna_informasi">
                        </div>
                        <div class="row">
                        <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="label-form">No HP / Telepon Pemohon <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" name="pi_no_hp_pengguna_informasi">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="label-form">Email Pemohon <span class="text-danger">*</span> </label>
                            <input type="email" class="form-control" name="pi_email_pengguna_informasi">
                        </div>
                        </div>
                        </div>
                        <div class="form-group mb-3">
                            <label class="label-form">Upload Foto Kartu Identitas Pemohon  <span class="text-danger">*</span> </label>
                            <br>
                            <label class="text-muted">Silakan scan / Foto kartu identitas (KTP/SIM/Paspor) pemohon. Semua data pada kartu identitas harus tampak jelas dan terang.</label>
                        {{-- <div class="col-md-6"> --}}
                        <div x-data="uploadHandler" class="upload-box">
                            <div class="upload-zone relative border-2 border-dashed border-gray-300 rounded-lg p-6 transition-all hover:border-orange-500 text-center"
                                @dragover.prevent="dragging = true; console.log('Dragging over')"
                                @dragleave="dragging = false; console.log('Dragging left')"
                                @drop.prevent="handleDrop($event); console.log('File dropped')"
                                :class="{ 'border-orange-500': dragging }">



                                <template x-if="previewUrl">
                                    <img :src="previewUrl" class="upload-preview" alt="Preview">
                                </template>

                                <div x-show="!previewUrl" class="upload-placeholder">
                                    <i class="fas fa-upload text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-sm text-gray-600">
                                       <strong> Drag and drop <span class="text-orange-500 font-semibold">or choose file</span> to
                                        upload </strong>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</p>
                                    <div x-data >
                                        <button type="button" @click="$refs.fileInput.click()" class="btn upload-btn  px-4 py-2 shadow-sm">
                                            Pilih File
                                        </button>
                                        <input type="file" x-ref="fileInput" class="absolute invisible w-0 h-0" accept="image/*" @change="handleFileSelect">
                                    </div>


                                    <div id="file-error" class="text-red-500 text-sm mt-2" x-text="errorMessage"></div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                                <div x-show="uploading" class="upload-progress mt-3">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-orange-500 h-2.5 rounded-full" :style="`width: ${uploadProgress}%`">
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-2 text-center">
                                    Mengupload... <span x-text="uploadProgress + '%'"></span>
                                </p>
                                </div>
                            </div>
                        {{-- </div> --}}
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>

</div>

     <!-- Form umum untuk semua kategori -->
    <div class="col ">
    <div class="card e-form-card">
        <div class="card-header">
            <h3 class="title-form "> Pertanyaan dan Kebutuhan Informasi</h3>
        </div>
        <div class="card-body ">
            <form action="{{ url('SistemInformasi/EForm/PermohonanInformasi/storePermohonanInformasi') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                    <label class="label-form">Informasi yang Dibutuhkan <span class="text-danger">*</span> </label>
                    <textarea class="form-control" name="pi_informasi_yang_dibutuhkan" required rows="4"></textarea>
                </div>
                <div class="form-group mb-3">
                    <label class="label-form">Alasan Permohonan Informasi <span class="text-danger">*</span> </label>
                    <textarea class="form-control" name="pi_alasan_permohonan_informasi" required rows="4"></textarea>
                </div>
                <div class="form-group  mb-3">
                    <label class="label-form">Sumber Informasi <span class="text-danger">*</span> </label>
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
                    <label class="label-form">Alamat Sumber Informasi <span class="text-danger">*</span> </label>
                    <label class="text-muted">Isikan tautan / alamat website jika pertanyaan bukan merupakan pertanyaan langsung pemohon</label>
                    <input type="text" class="form-control" name="pi_alamat_sumber_informasi" required>
                </div>
            </form>
        </div>
    </div>
    <button type="submit" class="form-btn mt-3 d-flex flex-column align-items-center">Submit</button>
    </div>

</div>

</section>
</body>
<footer>
    @include('user.layouts.footer')
</footer>
</html>
{{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> --}}
{{--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#pi_kategori_pemohon').change(function () {
            const selectedValue = $(this).val();

            // Sembunyikan semua form tambahan
            $('#formOrangLain, #formOrganisasi').hide();

            // Reset required attributes
            $('#formOrangLain input, #formOrganisasi input').prop('required', false);

            // Tampilkan form sesuai pilihan
            if (selectedValue === 'Orang Lain') {
                $('#formOrangLain').show();
                $('#formOrangLain input').prop('required', true);
            } else if (selectedValue === 'Organisasi') {
                $('#formOrganisasi').show();
                $('#formOrganisasi input').prop('required', true);
            }
        });
    });
</script> --}}
