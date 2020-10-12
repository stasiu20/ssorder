import React from 'react';
import { Food } from '../types';
import { toast } from 'react-toastify';
import RestaurantFoodCardCollection from './restaurantFoodCardCollection';
import FetchError from '../../pwa/components/fetchError';
import { useServiceContainer } from '../../core/context/serviceContainer';
import { useAsync } from 'react-async';
import { ApiServiceType } from '../../contract';

interface Props {
    restaurantId: number;
}

const asyncFn = (
    props: { apiService: ApiServiceType; restaurantId: number },
    { signal }: AbortController,
): Promise<{ data: Food[] }> => {
    return props.apiService.fetchRestaurantMenu(props.restaurantId, signal);
};

const RestaurantMenuFetch: React.FC<Props> = props => {
    const serviceContainer = useServiceContainer();
    const { restaurantId } = props;
    const { data, error, isPending } = useAsync<Food[]>(asyncFn as any, {
        onReject: () =>
            toast.error('Error during fetching', { autoClose: false }),
        apiService: serviceContainer.apiService,
        restaurantId: restaurantId,
        watch: restaurantId,
    });

    if (isPending) return <span>Loading...</span>;
    if (error) {
        return (
            <FetchError error={error}>
                {`Something went wrong: ${error.message}`}
            </FetchError>
        );
    }
    if (data) {
        return <RestaurantFoodCardCollection foods={data} />;
    }

    return null;
};

export default RestaurantMenuFetch;
