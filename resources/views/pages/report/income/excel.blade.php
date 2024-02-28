<table>
    <thead>
        <tr>
            <th colspan="1" rowspan="1">
                <img src="images/logo-tabalong.jpeg" style="text-align: center;" width="65">
            </th>
            <th colspan="19" rowspan="1" style="text-align: center;">
                <b>
                  LAPORAN REALISASI PENERIMAAN PENDAPATAN PER SKPD  <br>
                  LINGKUP PEMERINTAH KABUPATEN TABALONG <br>
                  Tahun Anggaran {{ Auth::user()->year }} <br>
                </b>
            </th>
        </tr>
        <!--<tr>-->
        <!--</tr>-->
        <!--<tr>-->
        <!--</tr>-->
        <!--<tr>-->
        <!--</tr>-->
        <!--<tr>-->
        <!--</tr>-->
        <!--<tr>-->
        <!--</tr>-->
      <tr>
          <th colspan="20" style="border: 1px solid black;">SKPD: {{ $skpd }}</th>
      </tr>
      <tr>
          <th colspan="20" style="border: 1px solid black;">Bulan:  {{ $start_date }} S/D {{$end_date}} {{ Auth::user()->year }}</th>
      </tr>
      <tr>
        <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Kode Rekening</th>
        <th colspan="8" style="text-align: center; font-weight:bold; border: 1px solid black;">Uraian Pendapatan</th>
        <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Target</th>
        <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Realisasi S/D Bulan Lalu</th>
        <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Realisasi Bulan Ini</th>
        <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Realisasi S/D Bulan Ini</th>
        <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">%</th>
      </tr>
    </thead>
    <tbody>
        @foreach($income as $item)
            @php
                if($item['realisasi_until_this_month'] != 0 && $item['target'] != 0)
                {
                    $persen = $item['realisasi_until_this_month'] / $item['target']  * 100;
                }else{
                    $persen = 0;
                }
            @endphp
            <tr>
                <td colspan="2" style="text-align: left; border: 1px solid black;">{{ $item['number'] }}</td>
                <td colspan="8" style="text-align: left; border: 1px solid black;">{{ $item['name'] }}</td>
                <td colspan="2" style="text-align: right; border: 1px solid black;">{{ $item['target'] }}</td>
                <td colspan="2" style="text-align: right; border: 1px solid black;">{{ $item['realisasi_until_last_month'] }}</td>
                <td colspan="2" style="text-align: right; border: 1px solid black;">{{ $item['realisasi_this_month'] }}</td>
                <td colspan="2" style="text-align: right; border: 1px solid black;">{{ $item['realisasi_until_this_month'] }}</td>
                <td colspan="2" style="text-align: center; border: 1px solid black;">{{ $persen }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="14" rowspan="10"></th>
            <th colspan="6" rowspan="10" style="text-align: center;">
                <br><br>
                KEPALA BIDANG PENAGIHAN DAN PENGENDALIAN,  <br><br><br><br>
                <b> IRWANSYAH BUDIMAN, SE, MM </b><br>
               <small> NIP. 19840414 200804 1 001  </small>
            </th>
        </tr>
    </tfoot>
</table>
