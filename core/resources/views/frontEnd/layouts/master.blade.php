<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Building Technology Architecture</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/2.3.3/css/dataTables.bootstrap5.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="{{ URL::asset('assets/frontend_new/assets/css/style.css') }}" rel="stylesheet" />
  <link href="{{ URL::asset('assets/frontend_new/assets/css/responsive.css') }}" rel="stylesheet" />
</head>
<body>


<!-- ======= Header ======= -->
@include('frontEnd.layouts.header')

<!-- ======= Main contents ======= -->
<main id="main" class="{{ (Helper::GeneralSiteSettings("style_header"))?"":"" }}">
    @yield('content')
</main>
<!-- ======= Footer ======= -->
@include('frontEnd.layouts.footer')

  
  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-7+2Lo3qK8nH+iJzH8YfjML0eOZL+eZzHn6Vs/5E/HWQ=" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

    <!-- DataTables v2 core JS -->
  <script src="https://cdn.datatables.net/2.3.3/js/dataTables.min.js"></script>

  <!-- DataTables Bootstrap 5 integration JS -->
  <script src="https://cdn.datatables.net/2.3.3/js/dataTables.bootstrap5.min.js"></script>


  <script>
    // new DataTable('#data-table');
    // const navbar = document.getElementById('mainNavbar');

    // window.addEventListener('scroll', () => {
    //   if (window.scrollY > 100) {
    //     navbar.classList.add('sticky-nav', 'show');
    //   } else {
    //     navbar.classList.remove('sticky-nav', 'show');
    //   }
    // });

    $('#payment-table').DataTable({
        pageLength: 10,
        ordering: true,
        searching: true
    });

    $('#booked-table').DataTable({
        pageLength: 10,
        ordering: true,
        searching: true
    });
  </script>
  <script>
    function handleFiles(files) {
      const previewGallery = document.getElementById('previewGallery');
      previewGallery.innerHTML = ''; // clear previous
      const maxPreview = 3;

      const fileArray = Array.from(files);

      fileArray.slice(0, maxPreview).forEach(file => {
        const reader = new FileReader();
        reader.onload = function (e) {
          const imgBox = document.createElement('div');
          imgBox.classList.add('preview-item');
          imgBox.innerHTML = `<img src="${e.target.result}" alt="">`;
          previewGallery.appendChild(imgBox);
        };
        reader.readAsDataURL(file);
      });

      if (fileArray.length > maxPreview) {
        const remaining = fileArray.length - maxPreview;
        const moreBox = document.createElement('div');
        moreBox.classList.add('preview-item');
        const reader = new FileReader();
        reader.onload = function (e) {
          moreBox.innerHTML = `<img src="${e.target.result}" alt=""><div class="more">+${remaining}</div>`;
          previewGallery.appendChild(moreBox);
        };
        reader.readAsDataURL(fileArray[maxPreview]);
      }
    }
  </script>


</body>

</html>