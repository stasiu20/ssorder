import React, { Component } from 'react';
import { connectAutoComplete } from 'react-instantsearch-dom';
import AutoSuggest from 'react-autosuggest';

interface Suggestion {
    type: string;
}

export interface SuggestionFood extends Suggestion{
    type: 'food';
    food: {
        id: number;
        name: string;
        price: string;
        info: string;
    };
    restaurant: {
        id: number;
        name: string;
    };
}

export interface SuggestionRestaurant extends Suggestion{
    type: 'restaurant';
    restaurant: {
        id: number;
        name: string;
    };
}

interface AutoCompleteProps {
    hits: object[];
    currentRefinement: string;
    refine: (value?: string) => void;
    onSuggestionSelected: (suggestion: SuggestionFood|SuggestionRestaurant) => void;
}

class AutoComplete extends Component<AutoCompleteProps> {
    state = {
        value: this.props.currentRefinement,
    };

    onChange = (_: unknown, { newValue }): void => {
        this.setState({
            value: newValue,
        });
    };

    onSuggestionsFetchRequested = ({ value }): void => {
        this.props.refine(value);
    };

    onSuggestionsClearRequested = (): void => {
        this.props.refine();
    };

    getSuggestionValue(hit): string {
        return hit.name;
    }

    renderSuggestion(hit: SuggestionRestaurant|SuggestionFood) {
        if (hit.type === 'restaurant') {
            return <div>
                <div className="hit-info">Restaurant: {hit.restaurant?.name}</div>
            </div>
        } else if (hit.type === 'food') {
            return <div>
                <div className="hit-info">Food: {hit.restaurant?.name} / {hit.food?.name}</div>
                <div className="hit-info">Price: {hit.food?.price}</div>
                <small>{hit.food?.info}</small>
            </div>
        }
    }

    render() {
        const { hits, onSuggestionSelected } = this.props;
        const { value } = this.state;

        const inputProps = {
            placeholder: 'Search for a food...',
            onChange: this.onChange,
            value: value || '',
        };

        return (
            <AutoSuggest
                suggestions={hits}
                onSuggestionsFetchRequested={this.onSuggestionsFetchRequested}
                onSuggestionsClearRequested={this.onSuggestionsClearRequested}
                onSuggestionSelected={(_: unknown, { suggestion }): void => onSuggestionSelected(suggestion)}
                getSuggestionValue={this.getSuggestionValue}
                renderSuggestion={this.renderSuggestion}
                inputProps={inputProps}
            />
        );
    }
}

export default connectAutoComplete(AutoComplete);
