import React from 'react';
import { Restaurant } from '../types';
import { useAppCtx } from '../../core/context/app';
import { addMessages } from '../../core/translations/pl';
import definedMessages from '../translation/pl-card';
import styles from './restaurantCard.scss?module';
import { useSelector } from 'react-redux';
import { AppState } from '../../core/redux';
import { DictRestaurantCategories } from '../../core/redux/dictionary/types';
import AppLink from '../../core/components/AppLink';
import { generateUrl } from '../../utils';

interface Props {
    restaurant: Restaurant;
}

const RestaurantCard: React.FC<Props> = props => {
    const { restaurant } = props;
    const appCtx = useAppCtx();
    const categories = useSelector<AppState, DictRestaurantCategories>(
        state => state.dict.restaurantCategories,
    );

    return (
        <div className="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div className={`${styles['app-card']} mb-5`}>
                <div
                    className={`${styles['app-card__side']} ${styles['app-card__side--front']}`}
                >
                    <div className={`${styles['app-card__header']}`}>
                        <img
                            className={`${styles['app-card__img']}`}
                            src={restaurant.imageUrl}
                            alt={restaurant.name}
                        />
                        <h4 className={`${styles['app-card__title']}`}>
                            <span>{restaurant.name}</span>
                        </h4>
                    </div>
                    <div className={`${styles['app-card__details']}`}>
                        <ul>
                            <li>
                                <div
                                    className={`d-inline-flex align-items-center`}
                                >
                                    <span
                                        className={`material-icons d-inline-block mr-2`}
                                    >
                                        restaurant
                                    </span>
                                    <span>
                                        {categories[restaurant.category] ||
                                            restaurant.category}
                                    </span>
                                </div>
                            </li>
                            <li>
                                <div
                                    className={`d-inline-flex align-items-center`}
                                >
                                    <span
                                        className={`material-icons d-inline-block mr-2`}
                                    >
                                        phone
                                    </span>
                                    <span>{restaurant.telNumber}</span>
                                </div>
                            </li>
                            <li>
                                <div
                                    className={`d-inline-flex align-items-center`}
                                >
                                    <span
                                        className={`material-icons d-inline-block mr-2`}
                                    >
                                        local_shipping
                                    </span>
                                    <span>{restaurant.deliveryPrice}</span>
                                </div>
                            </li>
                            <li>
                                <div
                                    className={`d-inline-flex align-items-center`}
                                >
                                    <span
                                        className={`material-icons d-inline-block mr-2`}
                                    >
                                        shopping_basket
                                    </span>
                                    <span>{restaurant.packPrice}</span>
                                </div>
                            </li>
                        </ul>
                        <button
                            className={`${styles['app-card__show-more']} btn btn-block btn-secondary`}
                        >
                            {appCtx.translate('Details')}
                        </button>
                    </div>
                </div>
                <div
                    className={`${styles['app-card__side']} ${styles['app-card__side--back']} text-center`}
                >
                    <div className={`${styles['app-card__side-container']}`}>
                        <h4 className="mb-2">{restaurant.name}</h4>
                        <AppLink
                            className={`btn btn-light btn-lg`}
                            to={generateUrl('restaurant', {
                                id: restaurant.id,
                            })}
                        >
                            {appCtx.translate('Order')}
                        </AppLink>
                    </div>
                </div>
            </div>
        </div>
    );
};

addMessages(definedMessages);
export default RestaurantCard;
