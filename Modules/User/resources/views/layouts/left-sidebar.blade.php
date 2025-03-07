@extends('user::layouts.mainpage')

@section('content')
<div class="layout-container">
    <!-- Sidebar Kiri -->
    <aside class="w-1/4 bg-gray-200 p-4 rounded">
        <nav class="sidebar left">
            <ul>
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Profil</a></li>
                <li><a href="#">E-Form</a></li>
                <li><a href="#">Informasi Publik</a></li>
                <li><a href="#">Layanan Informasi</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Konten Utama -->
    <main class="content-side">
        @yield('content-side')
    </main>
</div>
@endsection
