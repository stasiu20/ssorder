import React from 'react';
import { Food } from '../types';
import { toast } from 'react-toastify';
import { useApiFetch } from '../../pwa/hooks';
import RestaurantFoodCardCollection from './restaurantFoodCardCollection';

interface Props {
    restaurantId: number;
}

const RestaurantMenuFetch: React.FC<Props> = props => {
    const { restaurantId } = props;
    const { data, error, isPending } = useApiFetch<Food[]>(
        `/v1/restaurants/${restaurantId}/foods`,
        {},
        {
            onReject: () =>
                toast.error('Error during fetching', { autoClose: false }),
            json: true,
        },
    );

    if (isPending) return <span>Loading...</span>;
    if (error) return <span>{`Something went wrong: ${error.message}`}</span>;
    if (data) {
        return <RestaurantFoodCardCollection foods={data} />;
    }

    return null;
};

export default RestaurantMenuFetch;
