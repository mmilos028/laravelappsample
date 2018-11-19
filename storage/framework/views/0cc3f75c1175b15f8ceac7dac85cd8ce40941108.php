<header class="main-header">
    <!-- Logo -->
    <a href="" class="logo noblockui">
      <span class="logo-mini"><?php echo e(__("authenticated.Application Title Short")); ?></span>
      <span class="logo-lg">
          <img src="<?php echo e(asset('images/lucky6_logo.ico')); ?>" class="img-rounded" alt="Lucky Six Logo">
          <?php echo e(__("authenticated.Application Title Long")); ?>

      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <?php echo $__env->make('layouts.desktop_layout.header_navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    

    

    

    

    

    

    

    

    </nav>
</header>
<script>
    $(document).ready(function(){
        //$("#toggleSideBar").trigger("click");
    });
</script>
