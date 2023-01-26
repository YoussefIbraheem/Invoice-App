{{-- @include('layouts.head')



  <!-- ======= Header ======= -->
  @include('layouts.header')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('layouts.sidebar') --}}
<main id="main" class="main">
    <div class="pagetitle">
      <h1>@yield('pageTitle')</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">@yield('breadCrumb')</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
      @yield('content')
      </div>
    </section>
</main>    
@include('layouts.footer') 