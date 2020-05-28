import React, { FunctionComponent } from 'react';
import { render } from 'react-dom';
import Rating from 'react-rating';
import SSOrderApp from '../core/components/SSOrderApp';

interface RatingProps {
    legacyFieldSelector: string;
}

const RatingLegacy: FunctionComponent<RatingProps> = props => {
    const onChange = (value: number): void => {
        $(props.legacyFieldSelector).val(value.toString());
    };
    const defaultValue = parseInt(
        $(props.legacyFieldSelector).val() as string,
        10,
    );

    return (
        <Rating
            initialRating={defaultValue}
            start={0}
            stop={5}
            onChange={onChange}
            fullSymbol={<span className="material-icons">star</span>}
            emptySymbol={<span className="material-icons">star_border</span>}
        />
    );
};

$(function() {
    render(
        <SSOrderApp>
            <RatingLegacy legacyFieldSelector={'#foodrating-rating'} />
        </SSOrderApp>,
        $('#foodrating-rating')
            .closest('.react-wrapper')
            .find('.react-view-container')
            .get(0),
    );
});
