import React from 'react';
import { toast } from 'react-toastify';
import { useFetch } from 'react-async';
import RestaurantCardsCollection from './restaurantCardCollection';
import { Restaurant } from '../types';
import authTokenService from '../../core/services/authTokenService';

const RestaurantsFetch: React.FC = () => {
    // todo mmo custom hook
    const token = authTokenService.getToken();
    const { data, error, isPending } = useFetch<{ data: Restaurant[] }>(
        '/v1/restaurants',
        { headers: { Authorization: `Bearer ${token}` } },
        {
            onReject: () =>
                toast.error('Error during fetching', { autoClose: false }),
            json: true,
        },
    );

    if (isPending) return <span>Loading...</span>;
    if (error) return <span>{`Something went wrong: ${error.message}`}</span>;
    if (data) {
        return (
            <div className={'row'}>
                <RestaurantCardsCollection restaurants={data.data} />
            </div>
        );
    }

    return null;
};

export default RestaurantsFetch;
