/* eslint-disable @typescript-eslint/camelcase */

import React from 'react';
import { FormikProps, Formik, Form, Field } from 'formik';
import * as Yup from 'yup';
import { toast } from 'react-toastify';
import { useAsync } from 'react-async';
import 'cleave.js/dist/addons/cleave-phone.pl.js';
import { ReactstrapInput, ReactstrapSelect } from 'reactstrap-formik';
import FormFieldText from '../../form/components/formFieldText';
import CleavePrice from '../../form/components/cleavePrice';
import CleavePhone from '../../form/components/cleavePhone';
import '@availity/phone/src/validatePhone';
import { useSelector } from 'react-redux';
import { AppState } from '../../core/redux';
import { Dict } from '../../core/redux/dictionary/types';
import { useAppCtx } from '../../core/context/app';
import definedMessages, { KEYS } from '../translation/pl';
import { addMessages } from '../../core/translations/pl';

interface Values {
    restaurantName: string;
    tel_number: string;
    delivery_price: number;
    pack_price: number;
    categoryId: number;
}

interface RestaurantFormProps {
    initValues: Values;
    restaurantId: number | null;
}

const mapCategoryDictToOptions = (
    dict: Dict,
): { id: string; name: string }[] => {
    return Object.entries(dict).map(([id, name]) => {
        return { name, id };
    });
};

const validationSchema = Yup.object<Partial<Values>>({
    restaurantName: Yup.string()
        .required('Required')
        .max(200, 'Invalid restaurant name'),
    tel_number: Yup.string()
        .required('Required')
        .validatePhone('This phone number is invalid.', false, 'PL'),
    delivery_price: Yup.number()
        .required('Required')
        .min(0, 'Wrong price')
        .max(100, 'Wrong price'),
    pack_price: Yup.number()
        .required('Required')
        .min(0, 'Wrong price')
        .max(100, 'Wrong price'),
    categoryId: Yup.number().required('Required'),
});

const submitForm = (
    [values, setSubmitting, restaurantId]: [
        Values,
        (isSubmitting: boolean) => void,
        number | null,
    ],
    props,
    { signal },
): Promise<{ id: number }> => {
    const headers = {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    };
    const url = restaurantId
        ? `/restaurant-ajax/update?id=${restaurantId}`
        : '/restaurant-ajax/create';
    return fetch(url, {
        signal,
        headers,
        method: 'POST',
        body: JSON.stringify(values),
    })
        .then(res => (res.ok ? res : Promise.reject(res)))
        .then(res => res.json())
        .finally(() => setSubmitting(false));
};

const RestaurantForm: React.FunctionComponent<RestaurantFormProps> = props => {
    const { restaurantId } = props;
    const app = useAppCtx();
    const categories = useSelector<AppState, Dict>(
        state => state.dict.restaurantCategories,
    );
    const { run } = useAsync({
        deferFn: submitForm,
        onReject: () =>
            toast(app.translate('error' as KEYS), {
                type: 'error',
                autoClose: false,
            }),
        onResolve: response => {
            toast(app.translate('restaurantSaved' as KEYS), {
                type: 'success',
            });
            window.location.href = `/restaurants/${response.id}/update`;
        },
    });

    return (
        <Formik
            initialValues={props.initValues}
            onSubmit={(values, { setSubmitting }): void => {
                run(values, setSubmitting, restaurantId);
            }}
            validationSchema={validationSchema}
        >
            {(formik: FormikProps<Values>): JSX.Element => (
                <Form>
                    <Field
                        component={ReactstrapInput}
                        type="text"
                        name="restaurantName"
                        label={app.translate('restaurantName' as KEYS)}
                        id="restaurantFormName"
                    />
                    <Field
                        component={FormFieldText}
                        name="tel_number"
                        label={app.translate('phoneNumber' as KEYS)}
                        type={CleavePhone}
                    />
                    <Field
                        component={FormFieldText}
                        name="delivery_price"
                        label={app.translate('deliveryPrice' as KEYS)}
                        type={CleavePrice}
                    />
                    <Field
                        component={FormFieldText}
                        name="pack_price"
                        label={app.translate('packPrice' as KEYS)}
                        type={CleavePrice}
                    />
                    <Field
                        component={ReactstrapSelect}
                        name="categoryId"
                        inputprops={{
                            name: 'categoryId',
                            id: 'restaurantFormCategory',
                            options: mapCategoryDictToOptions(categories),
                            defaultOption: app.translate(
                                'chooseCategory' as KEYS,
                            ),
                        }}
                        placeholder="Category"
                        label={app.translate('category' as KEYS)}
                    />
                    {props.restaurantId && (
                        <vaadin-upload
                            target={`/upload/restaurant-logo?id=${props.restaurantId}`}
                            accept="image/*"
                            max-files={1}
                            form-data-name="imageFile"
                        />
                    )}
                    <button
                        disabled={formik.isSubmitting}
                        type="submit"
                        className="btn btn-primary"
                    >
                        {app.translate('save' as KEYS)}
                    </button>
                </Form>
            )}
        </Formik>
    );
};

RestaurantForm.defaultProps = {};
addMessages(definedMessages);
export default RestaurantForm;
