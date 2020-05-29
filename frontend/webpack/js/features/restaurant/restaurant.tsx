/* eslint-disable @typescript-eslint/camelcase */

import React from 'react';
import { render } from 'react-dom';
import RestaurantGalleryLightbox from '../core/components/galleryLightbox';
import RestaurantLogoLightbox from './components/logo';
import SSOrderApp from '../core/components/SSOrderApp';
import RestaurantForm from './components/restaurantForm';
import { store } from '../core/redux';
import { setRestaurantCategoriesActionCreator } from '../core/redux/dictionary/actions';
import RestaurantCardsCollection from './components/restaurantCardCollection';

$(function() {
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

        store.dispatch(setRestaurantCategoriesActionCreator(categories));

        render(
            <SSOrderApp>
                <RestaurantForm
                    restaurantId={restaurantData['id'] || null}
                    initValues={restaurantDataValues}
                />
            </SSOrderApp>,
            $elRestaurantForm.get(0),
        );
    }

    const $elRestaurantCards = $('#react-restaurant-cards');
    if ($elRestaurantCards.length) {
        const restaurants = window['__APP_DATA__']['restaurants'];
        const categories = window['__APP_DATA__']['categories'];
        store.dispatch(setRestaurantCategoriesActionCreator(categories));
        render(
            <SSOrderApp>
                <RestaurantCardsCollection restaurants={restaurants} />
            </SSOrderApp>,
            $elRestaurantCards.get(0),
        );
    }
});
