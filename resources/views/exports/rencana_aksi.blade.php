<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Rencana Aksi</th>
            <th>Unit Kerja</th>
            <th>Target Waktu</th>
            <th>Realisasi</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rencana as $key => $item)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $item->rencana_aksi }}</td>
            <td>{{ $item->masterunitkerja->name }}</td>
            <td>{{\Carbon\Carbon::parse($item->tanggal_waktu)->isoFormat('dddd, D MMMM Y')}}</td>
            <td>{{$item->status != 'Belum Upload' ? \Carbon\Carbon::parse($item->updated_at)->isoFormat('dddd, D MMMM
                Y') : ''}}</td>
            <td>{{ $item->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>