import React from 'react';
import { render } from 'react-dom';
import RestaurantGalleryLightbox from '../core/components/galleryLightbox';
import SSOrderApp from '../core/components/SSOrderApp';

$(document).ready(function() {
    const $el = $('#react-restaurant-gallery');
    const data = $el.data('gallery');

    render(
        <SSOrderApp>
            <RestaurantGalleryLightbox images={data} />
        </SSOrderApp>,
        $el.get(0),
    );
});
