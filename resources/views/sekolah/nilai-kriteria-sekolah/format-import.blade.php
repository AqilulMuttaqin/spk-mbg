<table>
    <thead>
        <tr>
            <th>Sekolah</th>
            <th>Kelurahan</th>
            <th>Kecamatan</th>
            @foreach ($kriteria as $k)
                <th>{{ $k->nama_kriteria }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
            <tr>
                <td>{{ $d['sekolah'] }}</td>
                <td>{{ $d['kelurahan'] }}</td>
                <td>{{ $d['kecamatan'] }}</td>
                @foreach ($kriteria as $k)
                    <td>{{ $d[$k->nama_kriteria] }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>