import React from 'react';
import { render } from 'react-dom';
import RestaurantGalleryLightbox from '../core/components/galleryLightbox';
import ErrorBoundary from '../core/components/errorBoundary';

$(document).ready(function() {
    const $el = $('#react-restaurant-gallery');
    const data = $el.data('gallery');

    render(
        <ErrorBoundary>
            <RestaurantGalleryLightbox images={data} />
        </ErrorBoundary>,
        $el.get(0)
    );
});
