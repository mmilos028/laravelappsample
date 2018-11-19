<?php if($show_cashier_menu): ?>
    <?php echo $__env->make('layouts.desktop_layout.submenu.cashier_menu_new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

<?php if($show_administrator_menu): ?>
    <?php echo $__env->make('layouts.desktop_layout.submenu.administrator_menu_new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

<?php if($show_structure_entity_menu): ?>
    <?php echo $__env->make('layouts.desktop_layout.submenu.structure_entity_menu_new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

<?php if($show_user_menu): ?>
    <?php echo $__env->make('layouts.desktop_layout.submenu.user_menu_new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

<?php if($show_player_menu): ?>
    <?php echo $__env->make('layouts.desktop_layout.submenu.player_menu_new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

<?php if($show_terminal_menu): ?>
    <?php echo $__env->make('layouts.desktop_layout.submenu.terminal_menu_new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

<?php if($show_ticket_details_menu): ?>
    <?php echo $__env->make('layouts.desktop_layout.submenu.ticket_details_menu_new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

<?php if($show_draw_model_setup_menu): ?>
    <?php echo $__env->make('layouts.desktop_layout.submenu.administration.draw_model_setup_menu_new', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>