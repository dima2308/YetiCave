<?php
$lot = $template_data['lot'];
$search = $template_data['search'];

?>

<div class="container">
  <section class="lots">
    <?php
    if (!$search) { ?>
      <h2>Ничего не найдено по вашему запросу</h2>
    <?php } else { ?>
      <h2>Результаты поиска по запросу «<span><?= $search; ?></span>»</h2>
      <ul class="lots__list">
        <?php foreach ($lot as $value) : ?>
          <li class="lots__item lot">
            <div class="lot__image">
              <img src="<?= $value['url']; ?>" width="350" height="260" alt="Сноуборд">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= $value['cat_name']; ?></span>
              <h3 class="lot__title"><a class="text-link" href="lot.php?num=<?= $value['id']; ?>"><?= $value['name']; ?></a></h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?php print(format_number($value['start_price'])); ?></span>
                </div>
                <div class="lot__timer timer">
                  <?php print(setTime($value['data_create'], $value['data_stop'])); ?>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach; ?>

  </section>
  <ul class="pagination-list">
    <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
    <li class="pagination-item pagination-item-active"><a>1</a></li>
    <li class="pagination-item"><a href="#">2</a></li>
    <li class="pagination-item"><a href="#">3</a></li>
    <li class="pagination-item"><a href="#">4</a></li>
    <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
  </ul>
</div>
<?php }; ?>