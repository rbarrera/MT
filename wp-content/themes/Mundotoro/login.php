<?php
/*
Template Name: Login Form
*/
?>
<?php get_header();?>
<div id="main" role="main">
	<div id="single">
		<div id="single-new">
            <div class="login-form">
            	<?php if(!is_user_logged_in ()) { ?>
                <div class="login-box" >
                	<h1>Inicio de Ses&iacute;on</h1>

<strong>- Es necesario registrarse de nuevo para poder acceder a esta seccion para proteger la confidencialidad de sus datos personales.</strong><br />
(Ley Organica 15/1999, de 13 de diciembre, de Protecci&oacute;n de Datos de Car&aacute;cter Personal).<br/>
- Debe estar registrado para consultar esta secci&oacute;n.<br />
- Escriba el e-mail de registro y contrase&ntilde;a y presione <b>Iniciar</b> o <b>Registrese</b>.
<form method="post" action="<?php echo site_url(); ?>/wp-login.php" id="loginform_custom" name="loginform_custom">
                      <label>Username</label>
                        <input type="text" class="u-name" name="log" />
						<label>Password</label>
                        <input type="password" class="u-pass" name="pwd" />
                        <input type="submit"  name="submit" value="Login" />
                        <input type="hidden" name="redirect_to" value="<?php echo site_url(); ?>" />

            </form>
<a href="<?php echo site_url();?>/wp-login.php?action=register">A&uacute;n no se ha registrado?</a>  |  <a href="<?php echo wp_lostpassword_url(); ?>" title="Lost Password">Olvido su contrase&ntilde;a?</a>
                    
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="HRconte"></div>
</div>
<?php get_sidebar(); get_footer(); ?>