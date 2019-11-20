import React from 'react';
import { render } from 'react-dom';
import RestaurantGalleryLightbox from '../components/restaurant/galleryLightbox';
import RestaurantLogoLightbox from '../components/restaurant/logo';

$(document).ready(function() {
    const $el = $('#react-restaurant-gallery');
    const data = $el.data('gallery');

    const $elRestaurantImage = $('#react-restaurant-image');
    const restaurantImgSrc = $elRestaurantImage.data('src');

    render(<RestaurantGalleryLightbox images={data} />, $el.get(0));

    render(
        <RestaurantLogoLightbox src={restaurantImgSrc} />,
        document.getElementById('react-restaurant-image')
    );
});
