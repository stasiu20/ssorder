import React from 'react';
import { render } from 'react-dom';
import RestaurantGalleryLightbox from '../components/restaurant/galleryLightbox';

$(document).ready(function() {
    const $el = $('#react-restaurant-gallery');
    const data = $el.data('gallery');

    render(<RestaurantGalleryLightbox images={data} />, $el.get(0));
});
