<!DOCTYPE html>
<html>

@include('partials.htmlheader')

<body class="skin-blue sidebar-mini">
<div class="wrapper">

    {{--@include('partials.mainheader') --}}

    @include('partials.sidebar')

    <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">

    {{--    @include('partials.contentheader')--}}

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('main-content')
        </section><!-- /.content -->
   </div> 

   @include('partials.controlsidebar')

</div>

@include('partials.scripts')

</body>
</html>