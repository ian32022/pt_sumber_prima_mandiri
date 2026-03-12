<!DOCTYPE html>
<html>

<head>

<title>Production System</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>

body{
margin:0;
font-family:Arial;
background:#f4f6f9;
}

/* SIDEBAR */

.sidebar{
width:250px;
height:100vh;
background:white;
position:fixed;
border-right:1px solid #e5e7eb;
top:0;
left:0;
}

/* HEADER */

.sidebar-header{
padding:20px;
border-bottom:1px solid #eee;
}

/* LOGO */

.sidebar-logo{
display:flex;
align-items:center;
gap:10px;
}

.sidebar-logo img{
width:40px;
height:40px;
object-fit:contain;
transform: rotate(-95deg);
}

/* TITLE */

.sidebar-title{
font-size:14px;
font-weight:600;
}

.sidebar-sub{
font-size:12px;
color:#777;
}

/* MENU */

.menu{
padding:20px;
}

.menu a{
display:flex;
align-items:center;
gap:10px;
padding:12px;
text-decoration:none;
color:#333;
border-radius:8px;
margin-bottom:5px;
}

.menu a:hover{
background:#f3f4f6;
}

.menu a.active{
background:#2563eb;
color:white;
}

/* MAIN */

.main{
margin-left:250px;
}

.content{
padding:30px;
}

/* TOPBAR */

.topbar{
height:70px;
background:#f3f4f6;
display:flex;
align-items:center;
justify-content:space-between;
padding:0 25px;
border-bottom:1px solid #e5e7eb;
}

/* SEARCH */

.search-box{
position:relative;
}

.search-box input{
width:420px;
height:40px;
padding-left:38px;
border-radius:10px;
border:1px solid #ddd;
}

.search-icon{
position:absolute;
left:12px;
top:10px;
color:#888;
}

/* RIGHT */

.topbar-right{
display:flex;
align-items:center;
gap:20px;
}

.notification{
font-size:20px;
color:black;
}

/* USER */

.user-card{
display:flex;
align-items:center;
gap:10px;
background:white;
padding:6px 12px;
border-radius:10px;
}

.avatar{
width:32px;
height:32px;
background:#2563eb;
color:white;
border-radius:8px;
display:flex;
align-items:center;
justify-content:center;
font-weight:bold;
}

.user-role{
font-size:12px;
color:#7c3aed;
}

/* LOGOUT */

.logout-btn{
display:flex;
align-items:center;
gap:6px;
background:white;
padding:8px 14px;
border-radius:10px;
border:1px solid #ddd;
text-decoration:none;
color:#333;
}

.logout-btn:hover{
background:#f9fafb;
}

</style>

</head>

<body>

{{-- SIDEBAR --}}
@include('layouts.sidebar')

<div class="main">

{{-- TOPBAR --}}
@include('layouts.topbar')

<div class="content">

@yield('content')

</div>

</div>

</body>
</html>