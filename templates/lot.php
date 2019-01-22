<!DOCTYPE html>
<html lang="ru">
<head>
    
    <?php
        $lot = $template_data['lot'];
        echo '**';
    ?>
    
  <meta charset="UTF-8">
  <title><?php print($lot['name']); ?></title>
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
   
  <section class="lot-item container">
    <?php foreach ($lot as $value):?>
    <h2><?php print($value['name']); ?></h2>
    <div class="lot-item__content">
      <div class="lot-item__left">
        <div class="lot-item__image">
          <img src="<?php print($value['url']); ?>" width="730" height="548" alt="Изображение">
        </div>
        <p class="lot-item__category">Категория: <span><?php print($value['cat_name']); ?></span></p>
        <p class="lot-item__description"><?= $value['description'];?></p>
      </div>
      <div class="lot-item__right">
        
        <div class="lot-item__state">
          <div class="lot-item__timer timer">
            <?php print(setTime($value['data_create'], $value['data_stop'])); ?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?php print(format_number($value['start_price'])); ?></span>
            </div>
            <div class="lot-item__min-cost">
              Мин. ставка: <span><?=$value['bet_step'];?> р</span>
            </div>
          </div>
          <?php if (isset($_SESSION['user'])) { ?>
          
          <?php        
                $bet = $template_data['bet'];
                $errors = $template_data['errors'];
            ?>
            
            <?php
                $classname = isset($errors['cost']) ? "form__item--invalid" : "";
                $error = isset($errors['cost']) ? $errors['cost']: "";
            ?>    
          
          <form class="lot-item__form <?= $classname; ?>" action="lot.php" method="post">
            <p class="lot-item__form-item">
              <label for="cost">Ваша ставка</label>
              <input id="cost" type="number" name="cost" placeholder="12 000">
              <span class="form__error"><?= $error;?></span>
            </p>
            <button type="submit" class="button">Сделать ставку</button>
          </form>
          <?php } ?>
        </div>
        <div class="history">
          <h3>История ставок (<span>10</span>)</h3>
          <table class="history__list">
            <tr class="history__item">
              <td class="history__name">Иван</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">5 минут назад</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Константин</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">20 минут назад</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Евгений</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">Час назад</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Игорь</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 08:21</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Енакентий</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 13:20</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Семён</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 12:20</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Илья</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 10:20</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Енакентий</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 13:20</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Семён</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 12:20</td>
            </tr>
            <tr class="history__item">
              <td class="history__name">Илья</td>
              <td class="history__price">10 999 р</td>
              <td class="history__time">19.03.17 в 10:20</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </section>

</body>
</html>
