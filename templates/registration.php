<nav class="nav">
    <ul class="nav__list container">
      <li class="nav__item">
        <a href="all-lots.html">Доски и лыжи</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Крепления</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Ботинки</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Одежда</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Инструменты</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Разное</a>
      </li>
    </ul>
  </nav>
  
  <?php        
        $reg = $template_data['reg'];
        $errors = $template_data['errors'];  
    ?>
    
  <form class="form container <?php echo count($errors) ? "form--invalid" : "";?> action="registration.php" method="POST" enctype="multipart/form-data">
    <h2>Регистрация</h2>
    
    <?php
            $classname = isset($errors['email']) ? "form__item--invalid" : "";
            $value = isset($reg['email']) ? $reg['email'] : "";
            $error = isset($errors['email']) ? $errors['email']: "";
      ?>
    <div class="form__item <?= $classname; ?>"> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $value; ?>">
      <span class="form__error"><?= $error;?></span>
    </div>
    
    <?php
            $classname = isset($errors['password']) ? "form__item--invalid" : "";
            $value = isset($reg['password']) ? $reg['password'] : "";
            $error = isset($errors['password']) ? $errors['password']: "";
      ?>
    <div class="form__item <?= $classname; ?>">
      <label for="password">Пароль*</label>
      <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= $value; ?>">
      <span class="form__error"><?= $error; ?></span>
    </div>
    
    <?php
            $classname = isset($errors['name']) ? "form__item--invalid" : "";
            $value = isset($reg['name']) ? $reg['name'] : "";
            $error = isset($errors['name']) ? $errors['name']: "";
      ?>
    <div class="form__item <?= $classname; ?>">
      <label for="name">Имя*</label>
      <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $value; ?>">
      <span class="form__error"><?= $error; ?></span>
    </div>
    
     <?php
            $classname = isset($errors['contacts']) ? "form__item--invalid" : "";
            $value = isset($reg['contacts']) ? $reg['contacts'] : "";
            $error = isset($errors['contacts']) ? $errors['contacts']: "";
      ?>
    <div class="form__item <?= $classname; ?>">
      <label for="contacts">Контактные данные*</label>
      <textarea id="contacts" name="contacts" rows="5"></textarea>
      <span class="form__error"><?= $error; ?></span>
    </div>
    
    
    
    <div class="form__item form__item--file form__item--last "> <!-- form__item--uploaded -->
      <label>Аватар</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" id="photo2" name="filename" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
      <p>* - обязательные поля</p>
    </div>
    
    <button type="submit" class="button">Войти</button>
  </form>
