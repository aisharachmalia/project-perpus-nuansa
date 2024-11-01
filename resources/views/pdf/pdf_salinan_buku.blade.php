<h1 style="text-align:center">{{ $title}}</h1>

<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;justify-content:center">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="text-align: center" width="5%">No</th>
            <th style="text-align: center" width ="30%">No. Salinan</th>
            <th width="20%" style="text-align: center;">Kondisi</th>
            <th style="text-align: center;">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($salinan as $key => $item)
            <tr>
                <td style="text-align: center;background-color: #fefe76" width="5%">{{ $key + 1 }}</td>
                <td width="30%">{{ $item->dsbuku_no_salinan }}</td>
                <td style="text-align: center;" width="20%">{{ $item->dsbuku_kondisi }}</td>
                <td style="text-align: center">@if($item->dsbuku_status == 0) Tersedia @elseif($item->dsbuku_status == 1) Dipinjam @elseif($item->dsbuku_status == 2) Reservasi @endif</td>
            </tr>
        @endforeach
    </tbody>
</table>
