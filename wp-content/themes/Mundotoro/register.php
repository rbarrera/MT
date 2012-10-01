<?php
/*
 * Template Name: Register Form
 */
global $wpdb, $user_ID, $paises;
if($user_ID){
  wp_redirect( home_url() ); exit;  
}
if($_POST){
  $user_name = $wpdb->escape($_POST['username']);
  $email = $wpdb->escape($_POST['email']);
  $first_name = $wpdb->escape($_POST['first_name']);
  $last_name = $wpdb->escape($_POST['last_name']);
  $country = $wpdb->escape($_POST['country']);
  $phone = $wpdb->escape($_POST['phone']);
  $address = $wpdb->escape($_POST['address']);
  $city = $wpdb->escape($_POST['city']);
  $password = $wpdb->escape($_POST['password']);
  $password_conf = $wpdb->escape($_POST['password_conf']);
  
  $register_errors = array();
  # Validar los datos del usuario
  if(empty($user_name)){
    $register_errors [] = "El nombre de usario es obligatorio";
  }
  if(username_exists($user_name)){
    $register_errors [] = "El usuario ya existe";
  }

  # Correo electronico valido y unico
  if(empty($email)){
    $register_errors [] = "El correo electronico es obligatorio";
  }else
    if(email_exists($email)){
      $register_errors [] = "El correo electronico ya esta registrado";
    }else
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $register_errors [] = "El correo electronico no es valido";
      }

  # Passwords que coincidan
  if(empty($password) || empty($password_conf)){
    $register_errors [] = "La contrase&ntilde;a es obligatoria";
  }else
    if($password != $password_conf){
      $register_errors [] = "Las contrase&ntilde;as no coinciden";
    }else
      if(strlen($password) < 6){
        $register_errors [] = "La contrase&ntilde;a debe ser mayor a <strong>6</strong> caracteres";
      }
  # Agregar el usuario a la base de datos
  if(!count($register_errors) > 0){
    $user = wp_create_user($user_name,$password,$email);
    if(!($user instanceof WP_Error)){
      update_user_meta($user,'first_name',$first_name);
      update_user_meta($user,'last_name',$last_name);
      add_user_meta($user,'country',$country);
      add_user_meta($user,'phone',$phone);
      add_user_meta($user,'address',$address);
      add_user_meta($user,'city',$city);
      $user_object = wp_signon(array(
        'user_login' => $user_name,
        'user_password' => $password
      ));
      if($user_object instanceof WP_User){
        wp_redirect( home_url() ); exit;
      }
    }else{
      // @TODO manejar los errores de WP
    }
  }
}
?>
<?php get_header();?>
<div id="main" role="main">
  <div id="single">
    <div id="single-new">
      <div class="register-form">
        <div class="login-box" >
        <h1>Registro de Usuario</h1>
        <?php if(count($register_errors) > 0):?>
          <div class="error"><?php echo implode("<br>",$register_errors); ?></div>
        <?php endif; ?>
        <form method="post" action="" id="register_form" name="register_form">
          <fieldset>
            <legend>Inicio de Sesi&oacute;n <span style="font-size: 10px">(* requeridos)</span></legend>
            <div class="input">
              <label for="username">Nombre de Usuario (*)</label>
              <input type="text" name="username" id="username" value="<?php echo (isset($user_name) ? $user_name : '') ?>" required/>
            </div>
            <div class="input">
              <label for="email">Correo electr&oacute;nico (*)</label>
              <input type="email" name="email" id="email" value="<?php echo (isset($email) ? $email : '')?>" required/>
            </div>
            <div class="input">
              <label for="password">Contrase&ntilde;a (*)</label>
              <input type="password" name="password" id="password" value="" required/>
            </div>
            <div class="input">
              <label for="password_conf">Confirmar Contrase&ntilde;a (*)</label>
              <input type="password" name="password_conf" id="password_conf" value="" required/>
            </div>
          </fieldset>
          <fieldset>
            <legend>Informacion de Contacto</legend>
            <div class="input">
              <label for="name">Nombre</label>
              <input type="text" name="first_name" id="first_name" value="<?php echo (isset($first_name) ? $first_name : ''); ?>" />
            </div>
            <div class="input">
              <label for="last_name">Apellido</label>
              <input type="text" name="last_name" id="last_name" value="<?php echo (isset($last_name) ? $last_name : '') ?>" />
            </div>
            <div class="input">
              <label for="address">Direccion</label>
              <textarea name="address" id="address"><?php echo (isset($address) ? $address : '') ?></textarea>
            </div>
            <div class="input">
              <label for="country">Pais</label>
              <select name="country" id="country">
                <?php echo getPaises(((isset($country) & !empty($country)) ? $_POST['country'] : false)) ?>
              </select>
            </div>
            <div class="input">
              <label for="city">Ciudad</label>
              <input type="text" name="city" id="city" value="<?php echo (isset($city) ? $city : '') ?>" />
            </div>
            <div class="input">
              <label for="phone">Telefono</label>
              <input type="text" name="phone" id="phone" value="<?php echo (isset($phone) ? $phone : '') ?>" />
            </div>
          </fieldset>
          <input type="submit"  name="submit" value="Registro" />
        </form>
        <div class="clearfix"></div>
        <p>Le informamos de que sus datos serán tratados, conforme a los previsto en la Ley 15/1999 de Protección de Datos, y serán incluidos en un fichero inscrito en el Registro General de la Agencia de Protección de Datos cuyo responsable es “TAUROCOM, S.L.”. Estos datos serán almacenados en dicho fichero durante el período de tiempo que la empresa se dedique a su actividad y la finalidad de la recogida será la gestión comercial y administrativa, además de para informarle de nuestros productos y servicios, incluso por medios electrónicos. Usted podrá revocar su consentimiento en cualquier momento y ejercer los derechos de acceso, rectificación, cancelación u oposición (ARCO), dirigiendo un escrito a la siguiente dirección: C/ Altamirano, nº 37 C.P. 28008 Madrid o por email al correo electrónico: mundotoro@mundotoro.com </p>
      </div>
    </div>
  </div>
</div>
<div class="HRconte"></div>
</div>
<?php get_sidebar(); get_footer(); ?>
