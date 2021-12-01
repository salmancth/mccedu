

<?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/mobilemenu.tpl.php'); ?>
<!-- ket thuc menu dinh trang mobile-menu--> 

<div id="page-inner-wrap">
    <div class="page-cover mobile-menu-close"></div>
    <?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/header.tpl.php'); ?>
    <!--backtop open -->
    <div id = "back-top"><i class = "fa fa-long-arrow-up"></i></div>
    <div class="page-wrap bkwrapper container">
        <div class="row bksection">
            <?php if ($page['content']): ?> 
                <section class="shop-page col-md-8 col-sm-12 three-cols">
                    <?php
                    if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])):
                        print render($tabs);
                    endif;
                    print $messages;
                    ?>
                    <?php print render($page['content']) ?>
                </section>
            <?php endif; ?>
            <?php if ($page['sidebar']): ?> 
                <div id="page-sidebar" class="sidebar col-md-4 col-sm-12">
                    <aside class="sidebar-wrap stick" id="bk-shop-sidebar">
                        <?php print render($page['sidebar']) ?>
                    </aside>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
<?php require_once(drupal_get_path('theme', 'sensen') . '/tpl/footer.tpl.php'); ?>
