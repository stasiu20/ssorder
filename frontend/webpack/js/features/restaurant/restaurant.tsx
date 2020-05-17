import React from 'react';
import { render } from 'react-dom';
import RestaurantGalleryLightbox from '../core/components/galleryLightbox';
import RestaurantLogoLightbox from './components/logo';
import SSOrderApp from '../core/components/SSOrderApp';

$(document).ready(function() {
    const $el = $('#react-restaurant-gallery');
    const data = $el.data('gallery');

    const $elRestaurantImage = $('#react-restaurant-image');
    const restaurantImgSrc = $elRestaurantImage.data('src');

    render(
        <SSOrderApp>
            <RestaurantGalleryLightbox images={data} />
        </SSOrderApp>,
        $el.get(0),
    );

    render(
        <SSOrderApp>
            <RestaurantLogoLightbox src={restaurantImgSrc} />
        </SSOrderApp>,
        document.getElementById('react-restaurant-image'),
    );
});
