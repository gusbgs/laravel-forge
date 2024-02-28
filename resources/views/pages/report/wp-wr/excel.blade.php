<table>
    <thead>
        <tr>
            <th colspan="1" rowspan="1">
                <img src="images/logo-tabalong.jpeg" style="text-align: center;" width="65">
            </th>
            <th colspan="11" rowspan="1" style="text-align: center;">
                <b>
                  <h5> PEMERINTAH KABUPATEN TABALONG </h5> <br>
                  <h4>LAPORAN REALISASI PENDAPATAN DAERAH </h4> <br>
                  <!--<small> BUKU BESAR </small>-->
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
        <th colspan="4" style="text-align: center; border: 1px solid black;">SKPD</th>
        <th colspan="8" style="text-align: center; border: 1px solid black;">
          @if($skpd_account != null)
            {{ $skpd_account->skpd->name }}
          @else
            -
          @endif
        </th>
      </tr>

      <tr>
        <th colspan="4" style="text-align: center; border: 1px solid black;">Kode Akun</th>
        <th colspan="4" style="text-align: center; border: 1px solid black;">
          @if($skpd_account != null)
            {{ $skpd_account->account->number }}
          @else
            -
          @endif
        </th>
        @php
          $total = $last_year + $this_year;
        @endphp
        <th colspan="4" style="text-align: center; border: 1px solid black;"> {{ $total ?? '0' }} </th>
      </tr>

      <tr>
        <th colspan="4" style="text-align: center; border: 1px solid black;">Nama Akun</th>
        <th colspan="4" style="text-align: center; border: 1px solid black;">
          @if($skpd_account != null)
            {{ $skpd_account->account->name }}
          @else
            -
          @endif
        </th>
        <th colspan="2" style="text-align: center; border: 1px solid black;"> {{ $last_year ?? '0' }} </th>
        <th colspan="2" style="text-align: center; border: 1px solid black;"> {{ $this_year ?? '0' }} </th>
      </tr>

      <tr>
        <th colspan="4" style="text-align: center; border: 1px solid black;">Bulan</th>
        <th colspan="8" style="text-align: center; border: 1px solid black;">
          @if($month != null)
            {{ $month }}
          @else
            -
          @endif
        </th>
      </tr>

      <tr class="bg-primary">
        <th colspan="2" style="text-align: center; background-color: #3569fe; color:white; border: 1px solid black;">No</th>
        <th colspan="2" style="text-align: center; background-color: #3569fe; color:white; border: 1px solid black;">Tanggal</th>
        <th colspan="2" style="text-align: center; background-color: #3569fe; color:white; border: 1px solid black;">Bukti</th>
        <th colspan="2" style="text-align: center; background-color: #3569fe; color:white; border: 1px solid black;">Uraian</th>
        <th colspan="2" style="text-align: center; background-color: #3569fe; color:white; border: 1px solid black;">Tahun Lalu</th>
        <th colspan="2" style="text-align: center; background-color: #3569fe; color:white; border: 1px solid black;">Tahun Berjalan</th>
      </tr>
    </thead>
    <tbody>
      @php $no = 1; @endphp
      @foreach($wp_wr as $item)
        <tr>
          <td colspan="2" style="text-align: left; border: 1px solid black;">{{ $no++ }}</td>
          <td colspan="2" style="text-align: left; border: 1px solid black;">{{ date('d-m-Y', strtotime($item->date)) }}</td>
          <td colspan="2" style="text-align: left; border: 1px solid black;">{{ $item->evidance }}</td>
          <td colspan="2" style="text-align: left; border: 1px solid black;">{{ $item->description }}</td>
          <td colspan="2" style="text-align: right; border: 1px solid black;">
            @if($item->last_year == 1)
              {{ $item->value }}
            @else
              0
            @endif
          </td>
          <td colspan="2" style="text-align: right; border: 1px solid black;">
            @if($item->last_year == 0)
              {{ $item->value }}
            @else
              0
            @endif
          </td>
        </tr>
      @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" rowspan="10" style="text-align: center;">
                MENGETAHUI: <br><br>
                AN. BUPATI TABALONG : <br>
                SEKRETARIS DAERAH KABUPATEN, <br><br><br><br>
                <b> HJ. HAMIDA MUNAWARAH, S.T., M.T </b><br>
                <small> Pembina Utama Muda </small><br>
                <small> NIP. 19670518 199803 2004 </small>
            </th>
            <th colspan="4" rowspan="10" style="text-align: center;"></th>
            <th colspan="4" rowspan="10" style="text-align: center;">
                <br><br>
                KEPALA BADAN PENDAPATAN DAERAH <br>
                KABUPATEN TABALONG, <br><br><br><br>
                <b> Drs. H. NANANG MULKANI, M.Si </b><br>
                <small> Pembina Utama Muda </small><br>
                <small> NIP. 19720306 199203 1 004 </small>
            </th>
        </tr>
    </tfoot>
</table>
