import React from 'react';
import { render } from 'react-dom';
import RestaurantGalleryLightbox from '../core/components/galleryLightbox';
import RestaurantLogoLightbox from './components/logo';
import ErrorBoundary from '../core/components/errorBoundary';

$(document).ready(function() {
    const $el = $('#react-restaurant-gallery');
    const data = $el.data('gallery');

    const $elRestaurantImage = $('#react-restaurant-image');
    const restaurantImgSrc = $elRestaurantImage.data('src');

    render(
        <ErrorBoundary>
            <RestaurantGalleryLightbox images={data} />
        </ErrorBoundary>,
        $el.get(0)
    );

    render(
        <ErrorBoundary>
            <RestaurantLogoLightbox src={restaurantImgSrc} />
        </ErrorBoundary>,
        document.getElementById('react-restaurant-image')
    );
});
