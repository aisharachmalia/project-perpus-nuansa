  <h1>
      <b>{{ $title }}</b>
  </h1>

  <table border="1" cellpadding="2" class="table table-striped">
      <tr>
          <th>No</th>
          <th>Nama Penulis</th>
          <th>Kewarganegaraan</th>
          <th>Tanggal Lahir</th>
      </tr>
      @foreach ($penulis as $p)
          <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $p->dpenulis_nama_penulis }}</td>
              <td>{{ $p->dpenulis_kewarganegaraan }}</td>
              <td>{{ $p->dpenulis_tgl_lahir }}</td>
          </tr>
      @endforeach
  </table>
