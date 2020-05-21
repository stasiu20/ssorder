import React from 'react';
import Cleave from 'cleave.js/react';
import { ChildComponentProps } from '../type';

const CleavePhone: React.FunctionComponent<ChildComponentProps> = props => {
    const { field } = props;

    return (
        <Cleave
            className={props.className}
            options={{
                phone: true,
                phoneRegionCode: 'PL',
            }}
            {...field}
        />
    );
};

CleavePhone.defaultProps = {};
export default CleavePhone;
