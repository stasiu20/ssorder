import React from 'react';
import { toast } from 'react-toastify';
import { useAsync } from 'react-async';
import RestaurantCardsCollection from './restaurantCardCollection';
import { Restaurant } from '../types';
import { useServiceContainer } from '../../core/context/serviceContainer';
import FetchError from '../../pwa/components/fetchError';
import { useDispatch } from 'react-redux';
import { fetchRestaurantCategoriesActionCreator } from '../../core/redux/dictionary/actions';
import { ApiServiceType } from '../../contract';

const asyncFn = (
    props: { apiService: ApiServiceType },
    { signal }: AbortController,
): Promise<{ data: Restaurant[] }> => {
    return props.apiService.fetchRestaurant(signal);
};

const RestaurantsFetch: React.FC = () => {
    const serviceContainer = useServiceContainer();
    const dispatch = useDispatch();
    dispatch(fetchRestaurantCategoriesActionCreator());

    const { data, error, isPending } = useAsync<{ data: Restaurant[] }>(
        asyncFn as any,
        {
            onReject: () =>
                toast.error('Error during fetching', { autoClose: false }),
            apiService: serviceContainer.apiService,
        },
    );

    if (isPending) return <span>Loading...</span>;
    if (error) {
        return (
            <FetchError error={error}>
                {`Something went wrong: ${error.message}`}
            </FetchError>
        );
    }
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
