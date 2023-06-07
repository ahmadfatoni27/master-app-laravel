@include('template.head')
<!--  sidebar Top bar -->
@include('template.navbar-side')
@include('template.navbar-top')
<!-- Page wrapper  -->
<!-- ============================================================== -->
<div class="app-content content">
 <div class="content-overlay"></div>
 <div class="content-wrapper">

   <!-- content -->
   @yield('content')
   <!-- end content -->

 </div><!-- content-wrapper -->
</div><!-- app-content -->
<!-- footer -->
@include('template.foot')