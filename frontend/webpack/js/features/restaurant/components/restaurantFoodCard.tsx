import React from 'react';
import { Food } from '../types';
import AppLink from '../../core/components/AppLink';
import styles from './restaurantFoodCard.scss?module';
import { useAppCtx } from '../../core/context/app';
import { useIntl } from 'react-intl';
import { generateUrl } from '../../utils';
import Currency from './currency';

interface Props {
    food: Food;
}

const RestaurantFoodCard: React.FC<Props> = props => {
    const { food } = props;
    const appCtx = useAppCtx();
    const inlt = useIntl();

    return (
        <div className={`d-flex flex-column p-3 ${styles['food-card']}`}>
            <span
                title={food.foodName}
                className={`mb-2 text-truncate ${styles['food-card__name']}`}
            >
                {food.foodName}
            </span>
            <div
                className={
                    'd-flex justify-content-between align-items-center mb-2'
                }
            >
                <span className={`${styles['food-card__price']}`}>
                    <Currency value={food.foodPrice} />
                </span>
                <AppLink
                    to={generateUrl('order', { id: food.id })}
                    className={'btn btn-primary btn-sm'}
                >
                    {appCtx.translate('Order')}
                </AppLink>
            </div>
            <span className={`${styles['food-card__info']}`}>
                {food.foodInfo}
            </span>
        </div>
    );
};

export default RestaurantFoodCard;
