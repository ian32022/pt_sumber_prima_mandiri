<div class="sidebar">

<div class="sidebar-header">

<div class="sidebar-logo">

<img src="{{ asset('images/logo-pt-sumber-prima-mandiri.png') }}" alt="logo">

<div>

<div class="sidebar-title">
PT Sumber Prima Mandiri
</div>

<div class="sidebar-sub">
Production System
</div>

</div>

</div>

</div>


<div class="menu">

<a href="{{ route('machining.dashboard') }}" 
class="{{ request()->is('machining/dashboard') ? 'active' : '' }}">

<i class="bi bi-grid"></i>
Dashboard

</a>


<a href="{{ route('machining.request') }}" 
class="{{ request()->is('machining/request') ? 'active' : '' }}">

<i class="bi bi-file-text"></i>
Request Management

</a>


<a href="#">

<i class="bi bi-table"></i>
Master Schedule

</a>


<a href="{{ route('machining.schedule.index') }}" 
class="{{ request()->is('machining/schedule') ? 'active' : '' }}">

<i class="bi bi-tools"></i>
Schedule MFG

</a>


<hr>


<a href="#">

<i class="bi bi-gear"></i>
Settings

</a>


<a href="#">

<i class="bi bi-question-circle"></i>
Help Desk

</a>

</div>

</div>
