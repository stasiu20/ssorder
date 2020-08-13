import React from 'react';
import { toast } from 'react-toastify';
import { useAsync } from 'react-async';
import RestaurantCardsCollection from './restaurantCardCollection';
import { Restaurant } from '../types';
import { useServiceContainer } from '../../core/context/serviceContainer';
import ApiService from '../../core/services/ApiService';

const asyncFn = (
    props: { apiService: ApiService },
    { signal }: AbortController,
): Promise<{ data: Restaurant[] }> => {
    return props.apiService.fetchRestaurant(signal);
};

const RestaurantsFetch: React.FC = () => {
    const serviceContainer = useServiceContainer();
    const { data, error, isPending } = useAsync<{ data: Restaurant[] }>(
        asyncFn as any,
        {
            onReject: () =>
                toast.error('Error during fetching', { autoClose: false }),
            apiService: serviceContainer.apiService,
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
