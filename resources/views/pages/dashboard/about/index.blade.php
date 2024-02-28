@extends('layouts.layoutDashboard')

@section('title', 'Tentang Aplikasi')

@section('link')

@endsection

@section('style')

  <style media="screen">

  .save-button{
    text-align: left;
    background: none;
    color: inherit;
    border: none;
    padding: 0;
    font: inherit;
    cursor: pointer;
    outline: inherit;
  }

  </style>

@endsection

@section('navigation')

@endsection

@section('content')

  <div class="d-flex flex-row">
    <!--begin::Content-->
    <div class="flex-row-fluid">
      <!--begin::Card-->
      <form class="form" action="{{ route('dashboard.about.update', $about->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card card-custom card-stretch">
          <!--begin::Header-->
          <div class="card-header py-3">
            <div class="card-title mt-5">
              <span class="card-icon mr-5">
                <span class="svg-icon svg-icon-md svg-icon-primary">
                  <!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Chart-bar1.svg-->
                  <i class="fa fa-info-circle" style="color:#3699ff; font-size:28px"></i>
                  <!--end::Svg Icon-->
                </span>
              </span>
              <h3 class="card-label">
                Tentang Aplikasi
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                  <li class="breadcrumb-item text-muted">
                    <a href="#" class="text-muted">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item text-muted active">
                    <a href="#" class="text-muted">Tentang Aplikasi</a>
                  </li>
                </ul>
              </h3>
            </div>
            <div class="card-toolbar">
              <!--begin::Button-->
              <button type="submit" class="save-button mt-2 mr-4">
                <a class="btn btn-success">
                  <i class="fa fa-save"></i>Simpan
                </a>
              </button>

              <a href="#" class="btn btn-primary mt-2" id="uploadButton">
                <i class="fa fa-upload"></i>Upload File
              </a>
              <!--end::Button-->
            </div>
          </div>
          <!--end::Header-->
          <!--begin::Form-->
          <!--begin::Body-->
          <div class="card-body">
            <textarea name="description" id="about_description" rows="20">
              {!! $about->description !!}
            </textarea>
          </div>
        </div>
      </div>
      <!--end::Body-->
      <!--end::Form-->
    </div>
  </form>
</div>
<!--end::Content-->
</div>

@endsection

@section('modal')

  <!--begin::Modal Create-->
  <div class="modal fade" id="uploadModal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary white">
          <h5 class="modal-title text-white">Upload File Tentang Aplikasi</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
        </div>
        <form action="{{ route('dashboard.about.upload', $about->id) }}" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            @csrf

            <div class="form-group">
              <h5>File Saat Ini</h5>
                <input type="text" class="form-control" value="{{ $about->file_name ?? 'No File' }}" disabled>
            </div>

            <div class="form-group">
              <h5>File Baru</h5>
              <input type="file" name="file" class="form-control" required>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Kembali</button>
            <button type="submit" class="btn btn-outline-primary">Upload</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!--end::Modal Create-->

@endsection

@section('script')

  <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

  <script type="text/javascript">
    CKEDITOR.replace('about_description').config.height = 370;
  </script>

  <script type="text/javascript">
  $("#uploadButton").on("click", function(){
    $("#uploadModal").modal();
  });
  </script>

  <script>
    var menu_link_1 = document.getElementById("kt_header_menu_1");
    menu_link_1.classList.add("active");

    var menu_link_2 = document.getElementById("kt_header_menu_mobile_1");
    menu_link_2.classList.add("active");

    var menu_link_3 = document.getElementById("kt_header_tab_1");
    menu_link_3.classList.add("active");
    menu_link_3.classList.add("show");

    var menu_link_4 = document.getElementById("menu_about");
    menu_link_4.classList.add("menu-item-active");
  </script>

@endsection
