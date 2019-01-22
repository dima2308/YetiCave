<?php
    $categories = $template_data['categories_db'];
?>
<section class="promo">
            <h2 class="promo__title">Нужен стафф для катки?</h2>
            <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>

            <ul class="promo__list">
                <?php foreach ($categories as $cat): ?>
                    <li class="promo__item promo__item--<?=$cat['cat_img'];?>">
                        <a class="promo__link" href="all-lots.html"><?=$cat['cat_name'];?></a>
                    </li> 
                 <?php endforeach; ?>
            </ul>
</section>
       
<section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>

          <ul class="lots__list">
            <?php foreach ($template_data['lots'] as $key => $value):
            ?>
            <li class="lots__item lot">
                <div class="lot__image">
                        <img src="<?php print($value['url']); ?>" width="350" height="260" alt="Изображение">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?php print($value['cat_name']); ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php<?php print('?' . 'num' . '=' . $value['id']);?>"><?php print($value['name']); ?></a></h3>

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
        </ul>
</section>
    
    
