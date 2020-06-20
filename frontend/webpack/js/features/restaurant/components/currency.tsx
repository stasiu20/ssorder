import React from 'react';
import { FormattedNumber } from 'react-intl';

interface Props {
    value: number;
}

const Currency: React.FC<Props> = props => {
    return (
        <FormattedNumber
            value={props.value}
            style={'currency'}
            currency={'PLN'}
        />
    );
};

export default Currency;
