<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Все лоты</title>
  <link href="css/normalize.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
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
        $lot = $template_data['info_lot'];
        $errors = $template_data['errors'];
        $error_descr = $template_data['error_descr'];
        
    ?>
  <form class="form form--add-lot container <?php echo count($errors) ? "form--invalid" : ""; ?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
      <?php
            $classname = isset($errors['lot-name']) ? "form__item--invalid" : "";
            $value = isset($lot['lot-name']) ? $lot['lot-name'] : "";
            $error = isset($errors['lot-name']) ? $error_descr['lot-name']: "";
      ?>
      <div class="form__item  <?= $classname ?>"> <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= $value; ?>">
        <span class="form__error"><?= $error; ?></span>
      </div>
      
      <?php
            $classname = isset($errors['category']) ? "form__item--invalid" : "";
            $value = isset($lot['category']) ? $lot['category'] : "";
            $error = isset($errors['category']) ? $error_descr['category']: "";
      ?>
      <div class="form__item <?= $classname ?>">
        <label for="category">Категория</label>
        <select id="category" name="category">
          <option>Выберите категорию</option>
            <?php 
                foreach ($template_data['categories'] as $cat): ?>      
                <option value="<?=$cat;?>"<?php if($cat == $value): echo ' selected'; endif;?>><?=$cat?></option>
            <?php endforeach; ?>
            
        </select>
        <span class="form__error"><?= $error; ?></span>
      </div>
    </div>
    
    <?php
            $classname = isset($errors['message']) ? "form__item--invalid" : "";
            $value = isset($lot['message']) ? $lot['message'] : "";
            $error = isset($errors['message']) ? $error_descr['message']: "";
      ?>
    <div class="form__item form__item--wide <?= $classname ?>">
      <label for="message">Описание</label>
      <textarea id="message" name="message" placeholder="Напишите описание лота"><?=$value; ?></textarea>
      <span class="form__error"><?= $error; ?></span>
    </div>
    
    <div class="form__item form__item--file"> <!-- form__item--uploaded -->
      <label>Изображение</label>
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
    </div>

    <div class="form__container-three">
    
      <?php
            $classname = isset($errors['lot-rate']) ? "form__item--invalid" : "";
            $value = isset($lot['lot-rate']) ? $lot['lot-rate'] : "";
            $error = isset($errors['lot-rate']) ? $errors['lot-rate']: "";      
      ?>
      <div class="form__item form__item--small <?= $classname ?>">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value=<?= $value; ?>>
        <span class="form__error"><?= $error; ?></span>
      </div>
      
       <?php
            $classname = isset($errors['lot-step']) ? "form__item--invalid" : "";
            $value = isset($lot['lot-step']) ? $lot['lot-step'] : "";
            $error = isset($errors['lot-step']) ? $errors['lot-step']: "";      
      ?>
      <div class="form__item form__item--small <?= $classname ?>">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="text" name="lot-step" placeholder="0" value=<?= $value; ?>>
        <span class="form__error"><?= $error; ?></span>
      </div>
      
      <?php
            $classname = isset($errors['lot-date']) ? "form__item--invalid" : "";
            $value = isset($lot['lot-date']) ? $lot['lot-date'] : "";
            $error = isset($errors['lot-date']) ? $error_descr['lot-date']: "";      
      ?>
      
      <div class="form__item <?= $classname; ?>">
        <label for="lot-date">Дата окончания торгов</label>
        <input class="form__input-date" id="lot-date" type="date" name="lot-date" value= <?= $value; ?>>
        <span class="form__error"><?= $error; ?></span>
      </div>
    </div>
    <span class="form__error form__error--bottom"><?php echo count($errors) ? "Пожалуйста, исправьте ошибки в форме." : ""; ?></span>
    <button type="submit" class="button">Добавить лот</button>
  </form>
</body>
</html>
