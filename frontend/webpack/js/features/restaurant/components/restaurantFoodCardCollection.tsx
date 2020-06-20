import React from 'react';
import { Food } from '../types';
import RestaurantFoodCard from './restaurantFoodCard';

interface Props {
    foods: Food[];
}

const RestaurantFoodCardCollection: React.FC<Props> = props => {
    const { foods } = props;

    return (
        <div
            style={{
                display: 'grid',
                gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))',
                gridGap: '1rem',
            }}
        >
            {foods.map(food => {
                return <RestaurantFoodCard key={food.id} food={food} />;
            })}
        </div>
    );
};

export default RestaurantFoodCardCollection;
