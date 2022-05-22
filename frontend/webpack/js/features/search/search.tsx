import React from 'react';
import { render } from 'react-dom';
import { InstantSearch, Configure } from 'react-instantsearch-dom';
import { instantMeiliSearch } from '@meilisearch/instant-meilisearch';
import SSOrderApp from '../core/components/SSOrderApp';
import FoodAutocomplete, { SuggestionFood, SuggestionRestaurant } from './autocomplete';
import './autocomplete.css';
import appConfig from 'appConfig';

const searchClient = instantMeiliSearch(
    appConfig.meiliSearch.url,
    appConfig.meiliSearch.apiKey,
);

const redirectToPage = (model: SuggestionFood | SuggestionRestaurant): void => {
    if (model.type === 'food') {
        window.location.href = `/order/uwagi?id=${model.food.id}`;
    } else if (model.type === 'restaurant') {
        window.location.href = `/restaurants/details?id=${model.restaurant.id}`;
    }
};

const SearchComponent = () => (
    <InstantSearch
        indexName="food"
        searchClient={searchClient}
    >
        <Configure
            hitsPerPage={6}
            attributesToHighlight={['restaurant_name_search', 'food_name_search']}
        />
        <FoodAutocomplete
            currentRefinement={''}
            onSuggestionSelected={redirectToPage}
        />
    </InstantSearch>
);

const $elMeilisearch = $('#react-meilisearch');
if ($elMeilisearch.length) {
    render(
        <SSOrderApp>
            <SearchComponent/>
        </SSOrderApp>,
        $elMeilisearch.get(0),
    );
}
