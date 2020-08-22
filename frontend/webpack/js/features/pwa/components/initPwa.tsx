import React, { ReactNode } from 'react';
import ApiService from '../../core/services/ApiService';
import { useServiceContainer } from '../../core/context/serviceContainer';
import { useAsync } from 'react-async';
import { DictRestaurantCategories } from '../../core/redux/dictionary/types';
import { useDispatch } from 'react-redux';
import { setRestaurantCategoriesActionCreator } from '../../core/redux/dictionary/actions';

const asyncFn = (
    props: { apiService: ApiService },
    { signal }: AbortController,
): Promise<DictRestaurantCategories> => {
    return props.apiService.fetchRestaurantCategoriesDict(signal);
};

const InitPWA: React.FC<{ children: ReactNode }> = props => {
    const serviceContainer = useServiceContainer();
    const dispatch = useDispatch();

    const { isFulfilled, isRejected, isPending } = useAsync<
        DictRestaurantCategories
    >(asyncFn as any, {
        onResolve: dict => dispatch(setRestaurantCategoriesActionCreator(dict)),
        apiService: serviceContainer.apiService,
    });

    if (isPending) return <span>Loading...</span>;
    if (isRejected) {
        return <>{props.children}</>;
    }
    if (isFulfilled) {
        return <>{props.children}</>;
    }

    return null;
};

export default InitPWA;
