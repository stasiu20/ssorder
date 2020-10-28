import React from 'react';
import { FormikProps, Formik, Form, Field, FormikHelpers } from 'formik';
import { useAsync } from 'react-async';
import { toast } from 'react-toastify';
import * as Yup from 'yup';
import { ReactstrapInput } from 'reactstrap-formik';
import { useServiceContainer } from '../../core/context/serviceContainer';
import { ApiServiceType } from '../../contract';

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

const submitForm = (
    args,
    props: { apiService: ApiServiceType; foodId: number },
): Promise<void> => {
    // Still waiting for https://github.com/async-library/react-async/pull/247
    const [values, formikHelpers] = args as [Values, FormikHelpers<Values>];

    return props.apiService
        .createOrder(props.foodId, values.remarks)
        .finally(() => formikHelpers.setSubmitting(false));
};

const MakeOrderForm: React.FC<Props> = props => {
    const serviceContainer = useServiceContainer();
    const { initialValues } = props;
    const { run } = useAsync<void>({
        deferFn: submitForm as any,
        onReject: () =>
            toast('Error during saving', { type: 'error', autoClose: false }),
        onResolve: () => {
            toast('Order saved!', { type: 'success' });
            props.onSuccess();
        },
        apiService: serviceContainer.apiService,
        foodId: props.foodId,
        watch: props.foodId,
    });

    return (
        <Formik
            initialValues={initialValues}
            onSubmit={(values, formikHelpers): void => {
                run(values, formikHelpers, serviceContainer.apiService);
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
