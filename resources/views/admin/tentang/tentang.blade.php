@extends('layouts.welcome')
@section('title', 'Tentang')
@include('sweetalert::alert')
<!-- partial -->
@section('content')
@if (session::has('success'))
<script>
    toastr.success('Berhasil Diupdate', '')
</script>
@endif
@if ($errors->any())
<script>
    toastr.error('Cek Kembali input', 'Gagal Diupdate')
</script>
@endif
<div class="card" style="border-radius: 2px;">
    <div class="card-body">
        <div class="container">
            @foreach ($data as $value)
            <form action="{{ url('/tentang/update/'. $value->id) }}" method="post">
                <h5 class="font-weight-bold text-dark">Edit Halaman Landing Page</h5>
                <h6 class="font-weight-bold text-dark mt-3">- Section Home</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_website">Nama Website:</label>
                            <input type="text" value="{{ $value->nama_website }}" class="form-control" id="nama_website" name="nama_website">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judul_home">Judul Halaman Home:</label>
                            <input type="text" value="{{ $value->judul_home }}" class="form-control" id="judul_home" name="judul_home">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="deskripsi_home">Deskripsi Halaman Home:</label>
                            <textarea class="form-control" id="deskripsi_home" name="deskripsi_home" rows="4">{{ $value->deskripsi_home }}</textarea>
                        </div>
                    </div>
                </div>
                <h6 class="font-weight-bold text-dark mt-3">- Section Tentang</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="judul_tentang">Judul Halaman Tentang:</label>
                            <input type="text" value="{{ $value->judul_tentang }}" class="form-control" id="judul_tentang" name="judul_tentang">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="link_download">Link Download Aplikasi:</label>
                            <input type="text" value="{{ $value->link_download }}" class="form-control" id="link_download" name="link_download">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="video_url">Video:</label>
                            <input type="text" value="{{ $value->video_url }}" class="form-control" id="video_url" name="video_url">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="token">Token:</label>
                            <input type="text" value="{{ $value->token }}" class="form-control" id="token" name="token">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tentang_aplikasi">Tentang Aplikasi:</label>
                            <textarea class="form-control" id="tentang_aplikasi" name="tentang_aplikasi" rows="4">{{ $value->tentang_aplikasi }}</textarea>
                        </div>
                    </div>
                </div>
                <h6 class="font-weight-bold text-dark mt-3">- Section Footer</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email_kelurahan">Email Kelurahan:</label>
                            <input type="text" value="{{ $value->email_kelurahan }}" class="form-control" id="email_kelurahan" name="email_kelurahan">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_telp">No Telp:</label>
                            <input type="text" value="{{ $value->no_telp }}" class="form-control" id="no_telp" name="no_telp">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="alamat_kelurahan">Alamat Kelurahan:</label>
                            <textarea class="form-control" id="alamat_kelurahan" name="alamat_kelurahan" rows="4">{{ $value->alamat_kelurahan }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success">Kirim</button>
                </div>
            </form>
            @endforeach
        </div>
    </div>
</div>
@endsection



<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

{{-- toast cdn --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- jquery cdn --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
