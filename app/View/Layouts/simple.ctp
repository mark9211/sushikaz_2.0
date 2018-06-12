<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <?php echo $this->Html->charset('utf-8'); ?>
    <title>
        <?php echo $this->fetch('title'); ?>
    </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans+SC:300 rel="stylesheet">
    <?php
    echo $this->Html->meta('icon');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');

    # BEGIN GLOBAL MANDATORY STYLES
    echo $this->Html->css('assets/global/plugins/font-awesome/css/font-awesome.min.css');
    echo $this->Html->css('assets/global/plugins/simple-line-icons/simple-line-icons.min.css');
    echo $this->Html->css('assets/global/plugins/bootstrap/css/bootstrap.min.css');
    echo $this->Html->css('assets/global/plugins/uniform/css/uniform.default.css');
    # BEGIN THEME STYLES
    echo $this->Html->css('assets/global/css/components-rounded.css', array('id'=>'style_components'));
    echo $this->Html->css('assets/global/css/plugins.css');
    echo $this->Html->css('assets/admin/layout3/css/layout.css');
    echo $this->Html->css('assets/admin/layout3/css/themes/default.css', array('id'=>'style_color'));
    echo $this->Html->css('assets/admin/layout3/css/custom.css');
    # base js
    echo $this->Html->script('js/modernizr-2.6.2.min.js');
    # plugin js
    echo $this->Html->script('assets/global/plugins/jquery.min.js');
    echo $this->Html->script('assets/global/plugins/jquery-migrate.min.js');
    echo $this->Html->script('assets/global/plugins/jquery-ui/jquery-ui.min.js');
    echo $this->Html->script('assets/global/plugins/bootstrap/js/bootstrap.min.js');
    echo $this->Html->script('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js');
    echo $this->Html->script('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js');
    echo $this->Html->script('assets/global/plugins/jquery.blockui.min.js');
    echo $this->Html->script('assets/global/plugins/jquery.cokie.min.js');
    echo $this->Html->script('assets/global/plugins/uniform/jquery.uniform.min.js');
    echo $this->Html->script('jquery.ui.touch-punch.min.js');
    # layout
    echo $this->Html->script('assets/admin/layout3/scripts/demo.js');
    echo $this->Html->script('assets/admin/pages/scripts/ui-datepaginator.js');
    echo $this->Html->script('assets/admin/pages/scripts/components-form-tools.js');
    echo $this->Html->script('assets/admin/pages/scripts/components-pickers.js');

    ?>
</head>
<body>
    <div id="container">

        <div id="content">
            <?php echo $this->Session->flash(); ?>

            <?php echo $this->fetch('content'); ?>
        </div>

    </div>
</body>
</html>