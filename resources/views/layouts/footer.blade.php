<!-- Main Footer -->
<footer class="main-footer" @if(count(Session::get('user_roles')) === 1) style='margin: 0; position: fixed; bottom: 0; width: 100%'@endif>
    <!-- Default to the left -->
    <strong>Copyright © {{date("Y")}} </strong> All rights reserved
</footer>
<!-- /.footer -->
