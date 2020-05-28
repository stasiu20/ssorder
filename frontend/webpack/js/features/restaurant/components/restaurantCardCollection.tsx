import React from 'react';
import { Restaurant } from '../types';
import RestaurantCard from './restaurantCard';

interface Props {
    restaurants: Restaurant[];
}

const RestaurantCardsCollection: React.FC<Props> = props => {
    const { restaurants } = props;
    return (
        <>
            {restaurants.map(restaurant => {
                return (
                    <RestaurantCard
                        key={restaurant.id}
                        restaurant={restaurant}
                    />
                );
            })}
        </>
    );
};

export default RestaurantCardsCollection;
