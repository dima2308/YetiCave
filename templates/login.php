  <?php
  $info_login = $template_data['info_login'];
  $errors = $template_data['errors'];
  $user = $template_data['user'];
  echo $user;
  ?>

  <form class="form container <?php echo count($errors) ? "form--invalid" : ""; ?> action=" login.php" method="post">
    <h2>Вход</h2>

    <?php
    $classname = isset($errors['email']) ? "form__item--invalid" : "";
    $value = isset($info_login['email']) ? $info_login['email'] : "";
    $error = isset($errors['email']) ? $errors['email'] : "";
    ?>
    <div class="form__item <?= $classname; ?>">
      <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="email" name="email" placeholder="Введите e-mail" value="<?= $value; ?>">
      <span class="form__error"><?= $error; ?></span>
    </div>

    <?php
    $classname = isset($errors['password']) ? "form__item--invalid" : "";
    $value = isset($info_login['password']) ? $info_login['password'] : "";
    $error = isset($errors['password']) ? $errors['password'] : "";
    ?>
    <div class="form__item form__item--last <?= $classname; ?>">
      <label for="password">Пароль*</label>
      <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= $value; ?>">
      <span class="form__error"><?= $error; ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
  </form>