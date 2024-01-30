<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=$title;?></title>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap Styles-->
    <link href="/resoucre/admin/assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="/resoucre/admin/assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Summernote CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.css">
<!-- Summernote JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.js"></script>
    <!-- Morris Chart Styles-->
    <link href="/resoucre/admin/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="/resoucre/admin/assets/css/nguyenall.css?v=<?=rand(1,99999999);?>" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="/resoucre/admin/assets/css/custom-stylesadmin.css?v=<?=rand(1,99999999);?>" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <link href="/resoucre/admin/assets/js/dataTables/dataTables.bootstrap.css?v=<?=rand(1,99999999);?>" rel="stylesheet" />
    <!-- jQuery Js -->
<script src="/resoucre/admin/assets/js/jquery-1.10.2.js"></script>
<!-- Bootstrap Js -->
<script src="/resoucre/admin/assets/js/bootstrap.min.js"></script>
<!-- Metis Menu Js -->
<script src="/resoucre/admin/assets/js/jquery.metisMenu.js"></script>
<!-- Morris Chart Js -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css?v=<?=rand(1,99999999);?>">
<script src="/resoucre/admin/assets/js/dataTables/jquery.dataTables.js"></script>
<script src="/resoucre/admin/assets/js/dataTables/dataTables.bootstrap.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
</head>
<?php CheckLogin();?>
<?php CheckAdmin();?>