<table>
    <thead>
    <tr>
        @if($type == 'rekapitulasi_laporan_bulanan_hijau')
            <th colspan="1" rowspan="1">
                <img src="images/logo-tabalong.jpeg" style="text-align: center;" width="65">
            </th>
            <th colspan="15" rowspan="1" style="text-align: center;">
                <b>
                    REKAPITULASI LAPORAN BULANAN<br>
                    PENDAPATAN DAERAH KABUPATEN TABALONG<br>
                    TAHUN ANGGARAN {{ Auth::user()->year }}<br><br>
                    WAKTU: {{ $start_date }} S/D {{$end_date}} {{ Auth::user()->year }} <br>
                </b>
            </th>
        @elseif($type == 'laporan_bulanan_merah')
            <th colspan="1" rowspan="1">
                <img src="images/logo-tabalong.jpeg" style="text-align: center;" width="65">
            </th>
            <th colspan="15" rowspan="1" style="text-align: center;">
                <b>
                    LAPORAN BULANAN <br>
                    PENDAPATAN DAERAH KABUPATEN TABALONG <br>
                    TAHUN ANGGARAN {{ Auth::user()->year }} <br><br>
                    WAKTU: {{ $start_date }} S/D {{$end_date}} {{ Auth::user()->year }} <br>
                </b>
            </th>
        @else
            <th colspan="1" rowspan="1">
                <img src="images/logo-tabalong.jpeg" style="text-align: center;" width="65">
            </th>
            <th colspan="23" rowspan="1" style="text-align: center;">
                <b>
                    LAPORAN BULANAN PENDAPATAN ASLI DAERAH, DANA PERIMBANGAN DAN <br>
                    LAIN-LAIN PENDAPATAN YANG SAH KABUPATEN TABALONG <br><br>
                    WAKTU: {{ $start_date }} S/D {{$end_date}} {{ Auth::user()->year }} <br>
                </b>
            </th>
        @endif
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

    @if($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
        <tr>
            <th rowspan="2" colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Kode
                Rekening
            </th>
            <th rowspan="2" colspan="4" style="text-align: center; font-weight:bold; border: 1px solid black;">Uraian
                Pendapatan
            </th>
            <th rowspan="2" colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Target
            </th>
            <th rowspan="1" colspan="4" style="text-align: center; font-weight:bold; border: 1px solid black;">Realisasi
                S/D Bulan Lalu
            </th>
            <th rowspan="1" colspan="4" style="text-align: center; font-weight:bold; border: 1px solid black;">Realisasi
                Bulan Ini
            </th>
            <th rowspan="1" colspan="4" style="text-align: center; font-weight:bold; border: 1px solid black;">Realisasi
                S/D Bulan Ini
            </th>
            <th rowspan="2" colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Total S/D
                Bulan Ini
            </th>
            <th rowspan="2" colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">%</th>
        </tr>
        <tr>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Tahun Lalu</th>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Tahun Berjalan</th>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Tahun Lalu</th>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Tahun Berjalan</th>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Tahun Lalu</th>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Tahun Berjalan</th>
        </tr>
    @endif

    @if($type != 'laporan_bulanan_pad')
        <tr>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Kode Rekening</th>
            <th colspan="4" style="text-align: center; font-weight:bold; border: 1px solid black;">Uraian Pendapatan
            </th>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Target</th>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Realisasi S/D Bulan
                Ini
            </th>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">%</th>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Dasar Hukum</th>
            <th colspan="2" style="text-align: center; font-weight:bold; border: 1px solid black;">Keterangan</th>
        </tr>
    @endif
    </thead>
    <tbody>
    @if($type != 'rekapitulasi_laporan_bulanan_hijau' && $type != 'laporan_bulanan_merah')
        @foreach($account as $item_1)
            @if(count($item_1->children) > 0)
                @foreach($array_summary as $item_2)
                    @if($item_1->id == $item_2['id'])
                        <tr>
                            <td colspan="2" style="text-align: left; border: 1px solid black;">
                                <b>{{ $item_2['number'] ?? '0' }}</b></td>
                            <td colspan="4" style="text-align: left; border: 1px solid black;">
                                <b>{{ $item_2['name'] }}</b></td>
                            <td colspan="2" style="text-align: right; border: 1px solid black;">
                                <b>{{ $item_2['target'] }}</b></td>
                            <td colspan="2" style="text-align: right; border: 1px solid black;">
                                <b>{{ $item_2['realisasi_until_last_month_before'] }}</b></td>
                            <td colspan="2" style="text-align: right; border: 1px solid black;">
                                <b>{{ $item_2['realisasi_until_last_month_after'] }}</b></td>
                            <td colspan="2" style="text-align: right; border: 1px solid black;">
                                <b>{{ $item_2['realisasi_this_month_before'] }}</b></td>
                            <td colspan="2" style="text-align: right; border: 1px solid black;">
                                <b>{{ $item_2['realisasi_this_month_after'] }}</b></td>
                            <td colspan="2" style="text-align: right; border: 1px solid black;">
                                <b>{{ $item_2['realisasi_until_last_month_before'] + $item_2['realisasi_this_month_before'] }}</b></td>
                            <td colspan="2" style="text-align: right; border: 1px solid black;">
                                <b>{{ $item_2['realisasi_until_last_month_after'] + $item_2['realisasi_this_month_after'] }}</b></td>
                            @php
                                $total = $item_2['realisasi_until_last_month_before'] + $item_2['realisasi_this_month_before'] + $item_2['realisasi_until_last_month_after'] + $item_2['realisasi_this_month_after'];
                                if($total != 0 && $item_2['target'] != 0)
                                {
                                  $persen = $total / $item_2['target']  * 100;
                                }else{
                                  $persen = 0;
                                }
                            @endphp
                            <td colspan="2" style="text-align: right; border: 1px solid black;"><b>{{ $total }}</b></td>
                            <td style="text-align: center; border: 1px solid black;" colspan="2"><b>{{ $persen }}</b>
                            </td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td style="text-align: left; border: 1px solid black;" colspan="2">{{ $item_1->number }}</td>
                    <td colspan="4" style="text-align: left; border: 1px solid black;">{{ $item_1->name }}</td>
                    <td colspan="2" style="text-align: right; border: 1px solid black;">
                        @if($change == 'sebelum_perubahan')
                            {{ $item_1->target_before }}
                        @elseif($change == 'sesudah_perubahan')
                            {{ $item_1->target_after }}
                        @else
                            0
                        @endif
                    </td>
                    <td colspan="2"
                        style="text-align: right; border: 1px solid black;">{{ $item_1->realisasi_until_last_month_before->sum('value') }}</td>
                    <td colspan="2"
                        style="text-align: right; border: 1px solid black;">{{ $item_1->realisasi_until_last_month_after->sum('value') }}</td>
                    <td colspan="2"
                        style="text-align: right; border: 1px solid black;">{{ $item_1->realisasi_this_month_before->sum('value') }}</td>
                    <td colspan="2"
                        style="text-align: right; border: 1px solid black;">{{ $item_1->realisasi_this_month_after->sum('value') }}</td>
                    <td colspan="2"
                        style="text-align: right; border: 1px solid black;">{{ $item_1->realisasi_until_last_month_before->sum('value') +  $item_1->realisasi_this_month_before->sum('value')   }}</td>
                    <td colspan="2"
                        style="text-align: right; border: 1px solid black;">{{$item_1->realisasi_until_last_month_after->sum('value') + $item_1->realisasi_this_month_after->sum('value') }}</td>
                    @php
                        $total = $item_1->realisasi_until_last_month_before->sum('value') + $item_1->realisasi_this_month_before->sum('value')  + $item_1->realisasi_until_last_month_after->sum('value') + $item_1->realisasi_this_month_after->sum('value');
                        if($change == 'sebelum_perubahan')
                        {
                          $target = $item_1->target_before;
                        }
                        elseif($change == 'sesudah_perubahan')
                        {
                          $target = $item_1->target_after;
                        }
                        else
                        {
                          $target = 0;
                        }
                        if($total != 0 && $target != 0)
                        {
                          $persen = $total / $target  * 100;
                        }else{
                          $persen = 0;
                        }
                    @endphp
                    <td colspan="2" style="text-align: right; border: 1px solid black;">{{ $total }}</td>
                    <td style="text-align: center; border: 1px solid black;" colspan="2">{{ $persen }}</td>
                </tr>
            @endif
        @endforeach
    @endif

    @if($type == 'rekapitulasi_laporan_bulanan_hijau')
        @foreach($account as $item_1)
            @if($item_1->mark_1 == 1)
                @if(count($item_1->children) > 0)
                    @foreach($array_summary as $item_2)
                        @if($item_1->id == $item_2['id'])
                            <tr>
                                <td colspan="2" style="text-align: left; border: 1px solid black;">
                                    <b>{{ $item_2['number'] ?? '0' }}</b></td>
                                <td colspan="4" style="text-align: left; border: 1px solid black;">
                                    <b>{{ $item_2['name'] }}</b></td>
                                <td colspan="2" style="text-align: right; border: 1px solid black;">
                                    <b>{{ $item_2['target'] }}</b></td>
                                @php
                                    $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                                    if($total != 0 && $item_2['target'] != 0)
                                    {
                                      $persen = $total / $item_2['target']  * 100;
                                    }else{
                                      $persen = 0;
                                    }
                                @endphp
                                <td colspan="2" style="text-align: right; border: 1px solid black;"><b>{{ $total }}</b>
                                </td>
                                <td style="text-align: center; border: 1px solid black;" colspan="2">
                                    <b>{{ $persen }}</b></td>
                                <td colspan="2" style="border: 1px solid black;">
                                    <b>{{ $item_2['legal_basis'] ?? '-' }}</b></td>
                                <td colspan="2" style="border: 1px solid black;">
                                    <b>{{ $item_2['description'] ?? '-' }}</b></td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td style="text-align: left; border: 1px solid black;" colspan="2">{{ $item_1->number }}</td>
                        <td colspan="4" style="text-align: left; border: 1px solid black;">{{ $item_1->name }}</td>
                        <td colspan="2" style="text-align: right; border: 1px solid black;">
                            @if($change == 'sebelum_perubahan')
                                {{ $item_1->target_before }}
                            @elseif($change == 'sesudah_perubahan')
                                {{ $item_1->target_after }}
                            @else
                                0
                            @endif
                        </td>
                        @php
                            $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                            if($change == 'sebelum_perubahan')
                            {
                              $target = $item_1->target_before;
                            }
                            elseif($change == 'sesudah_perubahan')
                            {
                              $target = $item_1->target_after;
                            }
                            else
                            {
                              $target = 0;
                            }
                            if($total != 0 && $target != 0)
                            {
                              $persen = $total / $target  * 100;
                            }else{
                              $persen = 0;
                            }
                        @endphp
                        <td colspan="2" style="text-align: right; border: 1px solid black;">{{ $total }}</td>
                        <td style="text-align: center; border: 1px solid black;" colspan="2">{{ $persen }}</td>
                        <td colspan="2" style="border: 1px solid black;">{{ $item_1->legal_basis ?? '-' }}</td>
                        <td colspan="2" style="border: 1px solid black;">{{ $item_1->description ?? '-' }}</td>
                    </tr>
                @endif
            @endif
        @endforeach
    @endif

    @if($type == 'laporan_bulanan_merah')
        @foreach($account as $item_1)
                @if($item_1->mark_2 == 1)
                    @if(count($item_1->children) > 0)
                        @foreach($array_summary as $item_2)
                            @if($item_1->id == $item_2['id'])
                                <tr>
                                    <td colspan="2" style="text-align: left; border: 1px solid black;">
                                        <b>{{ $item_2['number'] ?? '0' }}</b></td>
                                    <td colspan="4" style="text-align: left; border: 1px solid black;">
                                        <b>{{ $item_2['name'] }}</b></td>
                                    <td colspan="2" style="text-align: right; border: 1px solid black;">
                                        <b>{{ $item_2['target'] }}</b></td>
                                    @if($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                                        @php
                                            $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];
                                            if($total != 0 && $item_2['target'] != 0)
                                            {
                                              $persen = $total / $item_2['target']  * 100;
                                            }else{
                                              $persen = 0;
                                            }
                                        @endphp
                                    @endif
                                    {{--                              @php--}}
                                    {{--                                $total = $item_2['realisasi_until_this_month_before'] + $item_2['realisasi_until_this_month_after'];--}}
                                    {{--                                if($total != 0 && $item_2['target'] != 0)--}}
                                    {{--                                {--}}
                                    {{--                                  $persen = $total / $item_2['target']  * 100;--}}
                                    {{--                                }else{--}}
                                    {{--                                  $persen = 0;--}}
                                    {{--                                }--}}
                                    {{--                              @endphp--}}
                                    <td colspan="2" style="text-align: right; border: 1px solid black;">
                                        <b>{{ $total }}</b></td>
                                    <td style="text-align: center; border: 1px solid black;" colspan="2">
                                        <b>{{ $persen }}</b></td>
                                    <td colspan="2" style="border: 1px solid black;">
                                        <b>{{ $item_2['legal_basis'] ?? '-' }}</b></td>
                                    <td colspan="2" style="border: 1px solid black;">
                                        <b>{{ $item_2['description'] ?? '-' }}</b></td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td style="text-align: left; border: 1px solid black;"
                                colspan="2">{{ $item_1->number }}</td>
                            <td colspan="4" style="text-align: left; border: 1px solid black;">{{ $item_1->name }}</td>
                            <td colspan="2" style="text-align: right; border: 1px solid black;">
                                @if($change == 'sebelum_perubahan')
                                    {{ number_format($item_1->target_before, 2,',','.') }}
                                @elseif($change == 'sesudah_perubahan')
                                    {{ number_format($item_1->target_after, 2,',','.') }}
                                @else
                                    0
                                @endif
                            </td>
                            @php
                                $total = $item_1->realisasi_until_this_month_before->sum('value') + $item_1->realisasi_until_this_month_after->sum('value');
                                if($change == 'sebelum_perubahan')
                                {
                                  $target = $item_1->target_before;
                                }
                                elseif($change == 'sesudah_perubahan')
                                {
                                  $target = $item_1->target_after;
                                }
                                else
                                {
                                  $target = 0;
                                }
                                if($total != 0 && $target != 0)
                                {
                                  $persen = $total / $target  * 100;
                                }else{
                                  $persen = 0;
                                }
                            @endphp
                            <td colspan="2" style="text-align: right; border: 1px solid black;">{{ $total }}</td>
                            <td style="text-align: center; border: 1px solid black;" colspan="2">{{ $persen }}</td>
                            <td colspan="2" style="border: 1px solid black;">{{ $item_1->legal_basis ?? '-' }}</td>
                            <td colspan="2" style="border: 1px solid black;">{{ $item_1->description ?? '-' }}</td>
                        </tr>
                    @endif
                @endif
        @endforeach
    @endif
    </tbody>
    <tfoot>
    @if($type == 'laporan_bulanan_pad')
        <tr>
            <th colspan="14" rowspan="12"></th>
            <th colspan="10" rowspan="12" style="text-align: center;">
                <br><br>

                KEPALA BADAN PENDAPATAN DAERAH KABUPATEN TABALONG<br><br><br><br>
                <b> Drs. H. NANANG MULKANI, M.Si </b><br>
                <small> Pembina Utama Muda </small><br>
                <small> NIP. 19720306 199203 1 004 </small>
            </th>
        </tr>
    @endif
    @if($type != 'laporan_bulanan_pad')
        <tr>
            <th colspan="6" rowspan="12" style="text-align: center;">
                @if($type == 'rekapitulasi_laporan_bulanan_hijau' || $type == 'laporan_bulanan_merah')
                    MENGETAHUI: <br><br>
                    AN. BUPATI TABALONG : <br>
                    SEKRETARIS DAERAH KABUPATEN, <br><br><br><br>
                    <b> HJ. HAMIDA MUNAWARAH, S.T., M.T </b><br>
                    <small> Pembina Utama Muda </small><br>
                    <small> NIP. 19670518 199803 2004 </small>
                @endif
            </th>
            <th colspan="4" rowspan="12"></th>
            <th colspan="6" rowspan="12" style="text-align: center;">
                <br><br>

                KEPALA BADAN PENDAPATAN DAERAH KABUPATEN TABALONG <br><br><br><br>
                <b> Drs. H. NANANG MULKANI, M.Si </b><br>
                <small> Pembina Utama Muda </small><br>
                <small> NIP. 19720306 199203 1 004 </small>
            </th>
        </tr>
    @endif
    </tfoot>
</table>
