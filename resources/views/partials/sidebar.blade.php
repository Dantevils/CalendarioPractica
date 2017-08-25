<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

       <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Modulo Planificacion</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>Home</span></a></li>
            <li><a href="{{ route('ordenes.index')}}"><i class='fa fa-edit'></i> <span>Ordenes de trabajo</span></a></li>
            <!--<li><a href="/gcalendar"><i class='fa fa-calendar'></i> <span>Agenda</span></a></li>-->
            <li><a href="/gcalendarsync"><i class='fa fa-spinner'></i> <span>Sync Google</span></a></li>
            <li><a href="#"><i class='fa fa-spinner'></i> <span>Sync OutLock</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
