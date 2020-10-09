import React from 'react';
import { useParams } from 'react-router-dom';
import RestaurantMenuFetch from '../../restaurant/components/restaurantMenuFetch';
import AppLink from '../../core/components/AppLink';
import { generateUrl } from '../../utils';

const PageRestaurantMenu: React.FC = props => {
    const params = useParams<{ restaurant: string }>();

    return (
        <main>
            <h2 className={'mb-3'}>
                <AppLink to={generateUrl('home')}>Lista restauracji</AppLink>
                &nbsp;&rarr;&nbsp; Menu
            </h2>
            <RestaurantMenuFetch restaurantId={Number(params.restaurant)} />
        </main>
    );
};

export default PageRestaurantMenu;
