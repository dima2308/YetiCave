	<?php
        $lot = $template_data['lot'];
        $my_bets = $template_data['bets'];
    ?>

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
        <?php if (setTime1(date('Y-m-d H:i:s'), $value['data_stop']) != 'Время истекло') {?>

        <div class="lot-item__state">
          <div class="lot-item__timer timer">
            <?php print(setTime1(date('Y-m-d H:i:s'), $value['data_stop'])); ?>
          </div>
          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <span class="lot-item__amount">Текущая цена</span>
              <span class="lot-item__cost"><?php print(format_number($value['start_price'])); ?></span>
            </div>
            <div class="lot-item__min-cost">
              Мин. ставка: <span><?=$value['bet_step'] + $value['start_price'];?> р</span>
            </div>
          </div>
          
        <? } else { ?>
            <div class="lot-item__state">
          <div class="lot-item__timer timer">
            <?php print(setTime1(date('Y-m-d H:i:s'), $value['data_stop'])); ?>
          </div>

          <div class="lot-item__cost-state">
            <div class="lot-item__rate">
              <?php if (isset($my_bets[0]['data_bet'])) { ?>
              <span class="lot-item__amount">Лот продан за</span>
              <span class="lot-item__cost"><?php print(format_number($value['start_price'])); ?></span>
              <?php } else { ?>
              <span class="lot-item__cost">Лот не был разыгран</span>
              <?php } ?>
              <?php if (isset($my_bets[0]['name'])) { ?>
              <span class="lot-item__amount">Лот выиграл</span>
              <span class="lot-item__cost"><?= $my_bets[0]['name'];?></span>
              <?php } ?>
            </div>   
          </div>    
        <?php } ?>
          
          <?php if ((isset($_SESSION['user']))) { 
            if (setTime1(date('Y-m-d H:i:s'), $value['data_stop']) != 'Время истекло') {
                if ($_SESSION['user']['id'] != $value['author_id']) {?>
          
          <?php        
                $bet = $template_data['bet'];
                $errors = $template_data['errors'];
            ?>
            
            <?php
                $classname = isset($errors) ? "form__item--invalid form__item--invalid--bet" : "";
                $error = isset($errors['cost']) ? $errors['cost']: "";
                
            ?>    
          
          <form class="lot-item__form <?php echo count($errors) ? "form--invalid" : ""; ?>" action="lot.php?num=<?=$_GET['num'];?>" method="post">
            <p class="lot-item__form-item <?= $classname; ?>">
              <label for="cost">Ваша ставка</label>
              <input id="cost" type="text" name="cost" placeholder="<?=$value['bet_step'] + $value['start_price'];?>">
              <span class="form__error"><?= $error;?></span>
            </p>
            <button type="submit" class="button">Поставить</button>
          </form>
          <?php } } }?>        
        </div>
        <div class="history">
           <?php if (count($my_bets)) { ?>
          <h3>История ставок (<span>10</span>)</h3>
          <table class="history__list">
            <?php 
                foreach ($my_bets as $b): ?>
                <tr class="history__item">
                  <td class="history__name"><?= $b['name']; ?></td>
                  <td class="history__price"><?= format_number($b['price']); ?></td>
                  <td class="history__time"><?= $b['data_bet']; ?></td>
                </tr>
            <?php endforeach; ?>
           <? } ?>
          </table>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </section>
</body>
</html>