 <?php
        $my_bets = $template_data['bets'];
    ?>

  <section class="lot-item container"> 
           <?php if (count($my_bets)) { ?>
          <h3>Мои ставки (<span>10</span>)</h3>
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
