@section('footer')
<?php
//dump($vars_for_template_view);
//dump($title);
?>
<div class="container-fluid">
    <h3 class='text-center'> FOOTER </h3>
    <div class="col-lg-1 col-lg-offset-4"> <img class="img-responsive" src="<?=asset('img/download.gif');?>"> </div>
    <div class="col-lg-3" style="text-align:center; color:white; padding:25px 0 50px 0;"> <p> Lutskyi Y. &nbsp; &copy;LITTUS - <?=( '2018' == date("Y") ) ? '2018' : '2018'.' - '.date("Y");?> </p> </div>
</div>

<!-- ____________________________________________________________________________________________________________________________ -->
<hr/>
<kbd style="display:inherit; text-align:center;"> <?php printf('<b>Controller::Method --></b> %s', $vars_for_template_view['show_controller_info']);?> </kbd>
<!-- ____________________________________________________________________________________________________________________________ -->
@endsection


