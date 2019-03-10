<?php

use yii\db\Migration;

/**
 * Class m010310_103254_schema
 */
class m010310_103254_schema extends Migration
{
    public function up()
    {
        $categorySql = 'CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
        $this->execute($categorySql);


        $sql = 'CREATE TABLE IF NOT EXISTS `imagesmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurantId` int(11) NOT NULL,
  `imagesMenu_url` varchar(360) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
        $this->execute($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurantId` int(11) NOT NULL,
  `foodName` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `foodInfo` text COLLATE utf8_polish_ci NOT NULL,
  `foodPrice` varchar(11) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
        $this->execute($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foodId` int(11) NOT NULL,
  `restaurantId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `uwagi` text COLLATE utf8_polish_ci NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=782 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
        $this->execute($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `restaurants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `restaurantName` varchar(360) COLLATE utf8_polish_ci NOT NULL,
  `tel_number` varchar(11) COLLATE utf8_polish_ci NOT NULL,
  `delivery_price` varchar(11) COLLATE utf8_polish_ci DEFAULT NULL,
  `pack_price` varchar(11) COLLATE utf8_polish_ci DEFAULT NULL,
  `img_url` varchar(300) COLLATE utf8_polish_ci NOT NULL,
  `categoryId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
        $this->execute($sql);
    }

    public function down()
    {
        $this->dropTable('category');
        $this->dropTable('imagesmenu');
        $this->dropTable('menu');
        $this->dropTable('order');
        $this->dropTable('restaurants');
    }
}
