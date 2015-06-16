<?php
/**
 * admin.blade.php 
 * 
 * {File description}
 * 
 * @author defus
 * @created Nov 13, 2014
 * 
 */
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="AGRITECH, plateforme de marché d'échange entre les agriculteurs, les acheteurs et les povoirs publiques'">
    <meta name="keywords" content="AGRITECH, technique, achat, vente, produits, production, agriculture, acheteurs, pourvoir publiques, météo, Niger, Afrique">
    <meta name="author" content="Lim Consulting, IsofLab">

    <title>@yield('title') - AGRITECH</title>

    <!-- Bootstrap Core CSS -->
    {{ HTML::style('assets/css/bootstrap.min.css') }}

    <!-- MetisMenu CSS -->
    {{ HTML::style('assets/css/plugins/metisMenu/metisMenu.min.css') }}

    <!-- Timeline CSS -->
    {{ HTML::style('assets/css/plugins/timeline.css') }}
    
    <!-- Custom CSS -->
    {{ HTML::style('assets/css/sb-admin-2.css') }}
    
    <!-- Morris Charts CSS -->
    {{ HTML::style('assets/css/plugins/morris.css') }}
    
    <!-- Custom Fonts -->
    {{ HTML::style('assets/font-awesome-4.3.0/css/font-awesome.min.css') }}
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    @yield('css')

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="icon" href="/v2/public/favicon.ico">
</head>

<body>

    <div id="wrapper">
        @include('includes.navigation')

        @yield('content')

    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    {{ HTML::script('assets/js/jquery-1.11.0.js') }}

    <!-- Bootstrap Core JavaScript -->
    {{ HTML::script('assets/js/bootstrap.min.js') }}
    
    <!-- Metis Menu Plugin JavaScript -->
    {{ HTML::script('assets/js/plugins/metisMenu/metisMenu.min.js') }}
    
    <!-- Morris Charts JavaScript -->
    {{ HTML::script('assets/js/plugins/morris/raphael.min.js') }}
    {{ HTML::script('assets/js/plugins/morris/morris.min.js') }}
    
    <!-- DataTables JavaScript -->
    {{ HTML::script('assets/js/plugins/dataTables/jquery.dataTables.js') }}
    {{ HTML::script('assets/js/plugins/dataTables/dataTables.bootstrap.js') }}
    
    <!-- Custom Theme JavaScript -->
    {{ HTML::script('assets/js/sb-admin-2.js') }}

    @yield('scripts')


</body>

</html>
