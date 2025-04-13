@php
    use Modules\Sisfo\App\Models\Log\NotifAdminModel;
    use Modules\Sisfo\App\Models\Log\NotifVerifikatorModel;

    $totalNotifikasiADM = NotifAdminModel::where('sudah_dibaca_notif_admin', null)->count();
    $totalNotifikasiVFR = NotifVerifikatorModel::where('sudah_dibaca_notif_verif', null)->count();

@endphp

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item d-flex align-items-center">
            <a class="nav-link d-flex align-items-center pr-2" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
            <span class="text-muted ml-2" style="font-size: 1.1rem; margin-top: 2px;">
                @if (Auth::user()->level->level_kode == 'ADM')
                    Administrator
                @elseif (Auth::user()->level->level_kode == 'SAR')
                    Sarana dan Prasarana
                @elseif (Auth::user()->level->level_kode == 'MPU')
                    Pimpinan
                @endif
            </span>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto mr-2 align-items-center">
        <!-- Notification -->
        <li class="nav-item dropdown d-flex align-items-center mr-3">
            {{-- by level --}}
            @if (Auth::user()->level->level_kode == 'SAR')
                <a href="{{ url('/Notifikasi/NotifSarpras') }}"
                    class="nav-link d-flex align-items-center "
                    style="font-size: 1.3rem;">
                    <i class="far fa-bell nav-icon"></i>
                    {{-- @if ($totalNotifikasiSAR > 0)
                        <span class="badge badge-danger navbar-badge" style="font-size: 12px; top: 0; right: 0;">
                            {{ $totalNotifikasiSAR }}
                        </span>
                    @endif --}}
                </a>
            @elseif (Auth::user()->level->level_kode == 'ADM')
                <a href="{{ url('/Notifikasi/NotifAdmin') }}"
                    class="nav-link d-flex align-items-center"
                    style="font-size: 1.3rem;">
                    <i class="far fa-bell nav-icon"></i>
                    @if ($totalNotifikasiADM > 0)
                        <span class="badge badge-danger navbar-badge" style="font-size: 12px; top: 0; right: 0;">
                            {{ $totalNotifikasiADM }}
                        </span>
                    @endif
                </a>
            @elseif (Auth::user()->level->level_kode == 'MPU')
                <a href="{{ url('/Notifikasi/NotifMPU') }}"
                    class="nav-link d-flex align-items-center"
                    style="font-size: 1.3rem;">
                    <i class="far fa-bell nav-icon"></i>
                    {{-- @if ($totalNotifikasiSAR > 0)
                        <span class="badge badge-danger navbar-badge" style="font-size: 12px; top: 0; right: 0;">
                            {{ $totalNotifikasiSAR }}
                        </span>
                    @endif --}}
                </a>
            @elseif (Auth::user()->level->level_kode == 'VFR')
                <a href="{{ url('/Notifikasi/NotifVFR') }}"
                    class="nav-link d-flex align-items-center"
                    style="font-size: 1.3rem;">
                    <i class="far fa-bell nav-icon"></i>
                    {{-- @if ($totalNotifikasiVFR > 0)
                        <span class="badge badge-danger navbar-badge" style="font-size: 12px; top: 0; right: 0;">
                            {{ $totalNotifikasiVFR }}
                        </span>
                    @endif --}}
                </a>
            @elseif (Auth::user()->level->level_kode == 'RPN')
                <a href="{{ url('/Notifikasi/NotifRPN') }}"
                    class="nav-link d-flex align-items-center"
                    style="font-size: 1.3rem;">
                    <i class="far fa-bell nav-icon"></i>
                    {{-- @if ($totalNotifikasiRPN > 0)
                        <span class="badge badge-danger navbar-badge" style="font-size: 12px; top: 0; right: 0;">
                            {{ $totalNotifikasiRPN }}
                        </span>
                    @endif --}}
                </a>
            @endif
        </li>

        <!-- User Profile -->
        <li class="nav-item d-flex align-items-center">
            <a href="{{ url('/profile') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : asset('img/userr.png') }}"
                    alt="User Profile Picture"
                    class="img-circle"
                    style="width: 32px; height: 32px; object-fit: cover; opacity: 0.9; margin-right: 10px;">
                    <span class="font-weight-bold text-primary" style="font-size: 1.1rem;">
                        {{ Auth::user()->nama_pengguna }}
                    </span>
            </a>
        {{-- <li class="nav-item d-flex align-items-center">
            <a href="{{ url('/profile') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : asset('img/userr.png') }}"
                    alt="User Profile Picture" class="img-circle"
                    style="width: 32; height: 32px; object-fit: cover; opacity: .9; margin-right: 10px;">
                <span class="font-weight-bold text-primary" style="font-size: 1.1rem;">
                    {{ Auth::user()->nama_pengguna }}
                </span>
                <span class="text-muted mx-2" style="font-size: 1.05rem;">/</span>
                <div class="d-flex flex-column justify-content-center">
                    <span class="text-muted" style="font-size: 1rem;">
                        @if (Auth::user()->level->level_kode == 'ADM')
                            Administrator
                        @elseif (Auth::user()->level->level_kode == 'SAR')
                            Sarana dan Prasarana
                        @elseif (Auth::user()->level->level_kode == 'MPU')
                            Pimpinan
                        @else
                            {{ Auth::user()->level->level_nama ?? 'Level Tidak Dikenal' }}
                        @endif
                    </span>
                </div>
            </a>
        </li> --}}
        {{-- <li class="nav-item d-flex align-items-center">
            <a href="{{ url('/profile') }}" class="d-flex align-items-center text-decoration-none">
                <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : asset('img/userr.png') }}"
                    alt="User Profile Picture"
                    class="img-circle"
                    style="width: 32px; height: 32px; object-fit: cover; opacity: 0.9; margin-right: 10px;">

                <div class="d-flex flex-column justify-content-center">
                    <span class="font-weight-bold text-primary" style="font-size: 1.1rem;">
                        {{ Auth::user()->nama_pengguna }}
                    </span>
                    <span class="text-muted" style="font-size: 0.85rem;">
                        @if (Auth::user()->level->level_kode == 'ADM')
                            Administrator
                        @elseif (Auth::user()->level->level_kode == 'SAR')
                            Sarana dan Prasarana
                        @elseif (Auth::user()->level->level_kode == 'MPU')
                            Pimpinan
                        @else
                            {{ Auth::user()->level->level_nama ?? 'Level Tidak Dikenal' }}
                        @endif
                    </span>
                </div>
            </a> --}}
        </li>

    </ul>

</nav>
