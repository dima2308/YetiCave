<?php
	$cat_img = ['boards', 'attachment', 'boots', 'clothing', 'tools', 'other'];
    <li class="promo__item promo__item--boards">
                    <a class="promo__link" href="all-lots.html">Доски и лыжи</a>
                </li>
                <li class="promo__item promo__item--attachment">
                    <a class="promo__link" href="all-lots.html">Крепления</a>
                </li>
                <li class="promo__item promo__item--boots">
                    <a class="promo__link" href="all-lots.html">Ботинки</a>
                </li>
                <li class="promo__item promo__item--clothing">
                    <a class="promo__link" href="all-lots.html">Одежда</a>
                </li>
                <li class="promo__item promo__item--tools">
                    <a class="promo__link" href="all-lots.html">Инструменты</a>
                </li>
                <li class="promo__item promo__item--other">
                    <a class="promo__link" href="all-lots.html">Разное</a>
                </li>
                
    foreach ($cat_img as $cat) {
        <li class="promo__item promo__item--<?=$cat;?>">
                    <a class="promo__link" href="all-lots.html">Доски и лыжи</a>
                </li> ?>
