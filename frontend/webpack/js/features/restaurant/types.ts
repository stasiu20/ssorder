export interface Restaurant {
    category: number;
    deliveryPrice: number;
    id: number;
    imageUrl: string;
    name: string;
    packPrice: number;
    telNumber: string;
}

export interface Food {
    id: number;
    restaurantId: number;
    foodName: string;
    foodInfo: string;
    foodPrice: number;
}

export interface RestaurantCategory {
    id: number;
    name: string;
}
