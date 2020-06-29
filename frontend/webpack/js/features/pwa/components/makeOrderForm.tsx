import React from 'react';
import { FormikProps, Formik, Form, Field } from 'formik';
import { useAsync } from 'react-async';
import { toast } from 'react-toastify';
import * as Yup from 'yup';
import { ReactstrapInput } from 'reactstrap-formik';
import authTokenService from '../../core/services/authTokenService';

interface Values {
    remarks: string;
}

interface Props {
    foodId: number;
    initialValues: Values;
    onSuccess: () => void;
}

const validationSchema = Yup.object<Partial<Values>>({
    remarks: Yup.string(),
});

const submitForm = (args, props, { signal }): Promise<void> => {
    const token = authTokenService.getToken();

    // Still waiting for https://github.com/async-library/react-async/pull/247
    const [values, setSubmitting] = args as [
        Values,
        (isSubmitting: boolean) => void,
    ];
    const headers = {
        Accept: 'application/json',
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`,
    };
    return fetch('/v1/orders', {
        signal,
        headers,
        method: 'POST',
        body: JSON.stringify({ ...values, foodId: 75 }),
    })
        .then(res => (res.ok ? res : Promise.reject(res)))
        .then(res => res.json())
        .finally(() => setSubmitting(false));
};

const MakeOrderForm: React.FC<Props> = props => {
    const { initialValues } = props;
    const { run } = useAsync<void>({
        deferFn: submitForm,
        onReject: () =>
            toast('Error during saving', { type: 'error', autoClose: false }),
        onResolve: () => {
            toast('Order saved!', { type: 'success' });
            props.onSuccess();
        },
    });

    return (
        <Formik
            initialValues={initialValues}
            onSubmit={(values, { setSubmitting }): void => {
                run(values, setSubmitting);
            }}
            validationSchema={validationSchema}
        >
            {(formik: FormikProps<Values>): JSX.Element => (
                <Form>
                    <Field
                        component={ReactstrapInput}
                        type="textarea"
                        name="remarks"
                        label="Remarks"
                    />
                    <button
                        disabled={formik.isSubmitting}
                        type="submit"
                        className="btn btn-primary"
                    >
                        Order
                    </button>
                </Form>
            )}
        </Formik>
    );
};

export default MakeOrderForm;
