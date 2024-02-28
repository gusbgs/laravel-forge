{{-- ///////////////////////////////Tabel Pendapatan////////////////////////////////// --}}

<!--<div class="pagebreak"> </div>-->
<!--begin::Content-->
<!--<div class="d-flex flex-row income-table mb-6">-->
<!--  <div class="flex-row-fluid">-->
    <!--begin::Card-->

<!--    <div class="card card-custom card-stretch">-->
      <!--begin::Form-->
      <!--begin::Body-->
<!--      <div class="card-body">-->

<!--        <div class="letter mt-2 mb-4">-->
<!--          <div class="row">-->
<!--            <div class="col-2">-->
<!--              <img src="/images/logo-tabalong.jpeg" alt="Logo">-->
<!--            </div>-->
<!--            <div class="col-8">-->
<!--              <b>-->
<!--                LAPORAN REALISASI PENERIMAAN PENDAPATAN PER SKPD  <br>-->
<!--                LINGKUP PEMERINTAH KABUPATEN TABALONG <br>-->
<!--                Tahun Anggaran {{ Auth::user()->year }} <br>-->
<!--              </b>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->

<!--        <div class="letter-2 mt-6 mb-4">-->
<!--          <div class="row">-->
<!--            {{-- <div class="col-2">-->
<!--              Semua SKPD-->
<!--            </div> --}}-->
<!--            <div class="col-10">-->

<!--            </div>-->
<!--          </div>-->

<!--          <div class="row">-->
<!--            <div class="col-2">-->
<!--              Bulan-->
<!--            </div>-->
<!--            <div class="col-10">-->
<!--              : {{ $month_income ?? '-' }} {{ Auth::user()->year }}-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->

<!--        <table width="100%" id="table_id_4" class="table_id compact d-lg-table">-->
<!--          <thead>-->
<!--            <tr>-->
<!--              <th style="display: none;">Akun Order No</th>-->
<!--              <th>Kode Rekening</th>-->
<!--              <th>Uraian Pendapatan</th>-->
<!--              <th>Target</th>-->
<!--              <th>Realisasi S/D Bulan Lalu</th>-->
<!--              <th>Realisasi Bulan Ini</th>-->
<!--              <th>Realisasi S/D Bulan Ini</th>-->
<!--              <th>%</th>-->
<!--            </tr>-->
<!--          </thead>-->
<!--          <tbody>-->
<!--            @foreach($income as $item)-->
<!--              @php-->
<!--                if($item['realisasi_until_this_month'] != 0 && $item['target'] != 0)-->
<!--                {-->
<!--                  $persen = $item['realisasi_until_this_month'] / $item['target']  * 100;-->
<!--                }else{-->
<!--                  $persen = 0;-->
<!--                }-->
<!--              @endphp-->
<!--              <tr>-->
<!--                <td style="display: none;">{{ $item['order_number'] }}</td>-->
<!--                <td>{{ $item['number'] }}</td>-->
<!--                <td>{{ $item['name'] }}</td>-->
<!--                <td style="text-align: right;">{{ number_format($item['target'], 2, ",", ".") ?? '0' }}</td>-->
<!--                <td style="text-align: right;">{{ number_format($item['realisasi_until_last_month'], 2, ",", ".") ?? '0' }}</td>-->
<!--                <td style="text-align: right;">{{ number_format($item['realisasi_this_month'], 2, ",", ".") ?? '0' }}</td>-->
<!--                <td style="text-align: right;">{{ number_format($item['realisasi_until_this_month'], 2, ",", ".") ?? '0' }}</td>-->
<!--                <td style="text-align: center;">{{ number_format($persen, 2) }}</td>-->
<!--              </tr>-->
<!--            @endforeach-->
<!--          </tbody>-->
<!--        </table>-->

<!--        <div class="letter-footer mt-6" style="break-inside: avoid;">-->
<!--          <div class="row">-->
<!--            <div class="col-8">-->
<!--            </div>-->
<!--            <div class="col-4">-->
<!--              <br><br>-->
<!--              Kepala Bidang Pengendalian  <br><br><br><br>-->
<!--              <b> LYNA HOLWATI, S.STP </b><br>-->
<!--              <small> NIP. 19840918 200312 2 001  </small>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
  <!--end::Body-->
  <!--end::Form-->
<!--</div>-->
<!--end::Content-->
