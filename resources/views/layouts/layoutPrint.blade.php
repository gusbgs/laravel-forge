<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head><base href="">
  <meta charset="utf-8" />
  <title>E-penda | Print</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!--begin::Fonts-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
  <!--end::Fonts-->
  <!--begin::Page Vendors Styles(used by this page)-->
  <link href="/metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
  <!--end::Page Vendors Styles-->
  <!--begin::Global Theme Styles(used by all pages)-->
  <link href="/metronic/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
  <link href="/metronic/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
  <link href="/metronic/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
  <!--end::Global Theme Styles-->
  <!--begin::Layout Themes(used by all pages)-->
  <!--end::Layout Themes-->
  <link rel="shortcut icon" href="/images/logo-4-small.png" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">

  @yield('link')

  @yield('style')

  <style type="text/css" media="print">
    @page
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */
    }
</style>

</head>
<!--end::Head-->
<div class="">
  @yield('content')
</div>
<!--begin::Body-->
<body>

  <!--begin::Global Theme Bundle(used by all pages)-->
  <script src="/metronic/assets/plugins/global/plugins.bundle.js"></script>
  <script src="/metronic/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
  <script src="/metronic/assets/js/scripts.bundle.js"></script>
  <!--end::Global Theme Bundle-->
  <!--begin::Page Vendors(used by this page)-->
  <script src="/metronic/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
  <!--end::Page Vendors-->
  <!--begin::Page Scripts(used by this page)-->
  <script src="/metronic/assets/js/pages/widgets.js"></script>
  <!--end::Page Scripts-->

  <script src="/assets/printPage.js" charset="utf-8"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>

  @yield('script')

    <script>
      Swal.fire("Preview Print", "Halaman Siap Untuk di Print", "info");
    </script>

</body>
<!--end::Body-->
</html>
