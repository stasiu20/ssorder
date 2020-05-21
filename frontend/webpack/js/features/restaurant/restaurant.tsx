/* eslint-disable @typescript-eslint/camelcase */

import React from 'react';
import { render } from 'react-dom';
import RestaurantGalleryLightbox from '../core/components/galleryLightbox';
import RestaurantLogoLightbox from './components/logo';
import SSOrderApp from '../core/components/SSOrderApp';
import RestaurantForm from './components/restaurantForm';

$(document).ready(function() {
    const $el = $('#react-restaurant-gallery');
    if ($el.length) {
        const data = $el.data('gallery');
        render(
            <SSOrderApp>
                <RestaurantGalleryLightbox images={data} />
            </SSOrderApp>,
            $el.get(0),
        );
    }

    const $elRestaurantImage = $('#react-restaurant-image');
    if ($elRestaurantImage.length) {
        const restaurantImgSrc = $elRestaurantImage.data('src');
        render(
            <SSOrderApp>
                <RestaurantLogoLightbox src={restaurantImgSrc} />
            </SSOrderApp>,
            $elRestaurantImage.get(0),
        );
    }

    const $elRestaurantForm = $('#react-restaurant-form');
    if ($elRestaurantForm.length) {
        const restaurantData = window['__APP_DATA__']['restaurantData'];
        const categories = window['__APP_DATA__']['categories'];
        const restaurantDataValues = {
            restaurantName: restaurantData['restaurantName'] || '',
            tel_number: restaurantData['tel_number'] || '',
            delivery_price: restaurantData['delivery_price'] || '',
            pack_price: restaurantData['pack_price'] || '',
            categoryId: restaurantData['categoryId'] || '',
        };

        render(
            <SSOrderApp>
                <RestaurantForm
                    categories={categories}
                    initValues={restaurantDataValues}
                />
            </SSOrderApp>,
            $elRestaurantForm.get(0),
        );
    }
});
