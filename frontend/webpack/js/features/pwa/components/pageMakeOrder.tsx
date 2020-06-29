import React from 'react';
import { useParams, useHistory } from 'react-router-dom';
import AppLink from '../../core/components/AppLink';
import { generateUrl } from '../../utils';
import MakeOrderForm from './makeOrderForm';

const PageMakeOrder: React.FC = props => {
    const params = useParams<{ foodId: string }>();
    const history = useHistory();

    return (
        <main>
            <h2 className={'mb-3'}>
                <AppLink to={generateUrl('home')}>Lista restauracji</AppLink>
                &nbsp;&rarr;&nbsp; Nowe zamówienie
            </h2>
            <MakeOrderForm
                foodId={Number(params.foodId)}
                initialValues={{ remarks: '' }}
                onSuccess={() => history.push(generateUrl('home'))}
            />
        </main>
    );
};

export default PageMakeOrder;
