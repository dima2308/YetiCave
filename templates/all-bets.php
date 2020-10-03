<?php
$bets = $template_data['bets'];
?>
<section class="rates container">
  <h2>Мои ставки</h2>
  <table class="rates__list">
    <?php foreach ($bets as $b) :
      if ((setTime1(date('Y-m-d H:i:s'), $b['data_stop'])) == 'Время истекло') {
        $classname_fin = "rates__item--end";
        $classname_now = "timer--finishing";
      } else {
        $classname_fin = "";
        $classname_now = "";
      }

      if ($b['winner_id'] == $b['user_id']) {
        $classname_fin = "rates__item--win";
        $timer = "timer--win";
      }
    ?>

      <tr class="rates__item <?= $classname_fin; ?>">
        <td class="rates__info">
          <div class="rates__img">
            <img src="<?= $b['url']; ?>" width="54" height="40" alt="img">
          </div>
          <?php if ($classname_fin == "rates__item--win") { ?>
            <div>
              <h3 class="rates__title"><a href="lot.php?num=<?= $b['lot_id']; ?>"><?= $b['name']; ?></a></h3>
              <p><?= $b['contact'] ?></p>
            </div>
          <?php } else { ?>
            <h3 class="rates__title"><a href="lot.php?num=<?= $b['lot_id']; ?>"><?= $b['name']; ?></a></h3>
          <?php } ?>

        </td>
        <td class="rates__category">
          <?= $b['cat_name']; ?>
        </td>
        <td class="rates__timer">
          <?php if ($b['winner_id'] != $b['user_id']) { ?>
            <div class="timer <?= $classname_fin, $classname_now; ?>">
            <?php } else { ?>
              <div class="timer <?= $timer; ?>"> <?php } ?>
              <?php
              if ($b['winner_id'] == $b['user_id']) {
                echo 'Ставка выиграла';
              } else
                print(setTime1(date('Y-m-d H:i:s'), $b['data_stop']));
              ?>
              </div>
        </td>
        <td class="rates__price">
          <?= $b['max_price']; ?>
        </td>
        <td class="rates__time">
          <?= $b['max_date']; ?>
        </td>
      </tr>
    <?php endforeach; ?>