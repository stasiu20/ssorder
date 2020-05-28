import React from 'react';
import Cleave from 'cleave.js/react';
import { ChildComponentProps } from '../type';

const stripCharacters = (value: string): string => {
    return value.replace(/,/g, '');
};

const CleavePrice: React.FunctionComponent<ChildComponentProps> = props => {
    const { field, form } = props;
    field.onChange = (event: React.ChangeEvent<HTMLInputElement>): void => {
        const cleanValue = stripCharacters(event.target.value);
        form.setFieldValue(field.name, cleanValue);
    };

    return (
        <Cleave
            className={props.className}
            options={{
                numeral: true,
                numeralThousandsGroupStyle: 'thousand',
                numeralPositiveOnly: true,
                stripLeadingZeroes: true,
                numeralDecimalMark: '.',
            }}
            {...field}
        />
    );
};

CleavePrice.defaultProps = {};
export default CleavePrice;
