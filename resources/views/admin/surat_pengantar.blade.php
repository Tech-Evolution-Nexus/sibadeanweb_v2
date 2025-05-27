<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Pengantar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 40px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2, .header h3, .header h4 {
            margin: 2px 0;
        }
        .title {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            margin: 20px 0 10px;
        }
        .nomor {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            margin-top: 10px;
        }
        .info-table {
            margin-left: 30px;
        }
        .info-table td {
            vertical-align: top;
            padding: 2px 0;
        }
        .footer {
            margin-top: 40px;
            width: 100%;
        }
        .footer-left {
            float: left;
            width: 60%;
        }
        .footer-right {
            float: right;
            width: 40%;
            text-align: center;
        }
        .clear {
            clear: both;
        }
        .lampiran {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>PEMERINTAH KABUPATEN BONDOWOSO</h3>
        <h4>KELURAHAN KOTAKULON</h4>
        <h4>KETUA RT {{$data->masyarakat->kartuKeluarga->rt }} / RW {{ $data->masyarakat->kartuKeluarga->rw }}</h4>
    </div>
    <hr>

    <div class="title">SURAT PENGANTAR</div>
    <div class="nomor">Nomor: {{ $totalPengantarRt }}/{{date('d/m/Y', strtotime($data->histori()->where("status_pengajuan","di_terima_rt")->first()->created_at))}}</div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Ketua RT.{{ $data->masyarakat->kartuKeluarga->rt }}/RW.{{ $data->masyarakat->kartuKeluarga->rw }} Kelurahan Kotakulon Kecamatan Bondowoso Kabupaten Bondowoso, bersama ini kami menghadapakan seorang warga:</p>

        <table class="info-table">
            <tr><td>Nama</td><td>: {{ $data->masyarakat->nama_lengkap }}</td></tr>
            <tr><td>Tempat, Tgl. Lahir</td><td>: {{ $data->masyarakat->tempat_lahir }}, {{ date('d-m-Y', strtotime($data->masyarakat->tanggal_lahir)) }}</td></tr>
            <tr><td>Jenis Kelamin</td><td>: {{ $data->masyarakat->jenis_kelamin }}</td></tr>
            <tr><td>Agama</td><td>: {{ $data->masyarakat->agama }}</td></tr>
            <tr><td>Nomor KTP / KK</td><td>: {{ $data->masyarakat->nik }} / {{$data->masyarakat->no_kk}}</td></tr>
            <tr><td>Pekerjaan</td><td>: {{ $data->masyarakat->pekerjaan }}</td></tr>
            <tr><td>Keperluan</td><td>: {{ $data->keterangan }}</td></tr>
        </table>

        <p>Orang tersebut di atas adalah benar-benar penduduk RT.{{ $data->masyarakat->kartuKeluarga->rt }}/ RW.{{ $data->masyarakat->kartuKeluarga->rw }} Kelurahan Kotakulon Kecamatan Bondowoso Kabupaten Bondowoso.</p>

        <p>Demikian surat pengantar ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="footer">
        <div class="footer-right">
            <p>Bondowoso, {{ date('d-m-Y', strtotime($data->histori()->where("status_pengajuan","di_terima_rt")->first()->created_at)) }}</p>
            <p>KETUA RT.{{ $data->rt }}/RW.{{ $data->rw }}</p>
            <br><br><br>
            <p><strong>{{ $data->nama_ketua_rt }}</strong></p>
        </div>
        <div class="clear"></div>
    </div>

    <div class="lampiran">
        <p>Melampirkan pula kelengkapan lainnya yaitu:</p>
        <ol>
            <li>KTP</li>
            <li>KK</li>
            <li>Pelunasan PBB</li>
        </ol>
    </div>
</body>
</html>
