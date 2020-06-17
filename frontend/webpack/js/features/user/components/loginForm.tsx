import React from 'react';
import { FormikProps, Formik, Form, Field } from 'formik';
import * as Yup from 'yup';
import { toast } from 'react-toastify';
import { useAsync } from 'react-async';
import userService, { LoginResponse } from '../userService';
import { ReactstrapInput } from 'reactstrap-formik';
import authTokenService from '../../core/services/authTokenService';

interface Values {
    username: string;
    password: string;
}

interface Props {
    initialValues: Values;
}

const validationSchema = Yup.object<Partial<Values>>({
    username: Yup.string()
        .required('Required')
        .max(200, 'Invalid username'),
    password: Yup.string().required('Required'),
});

const submitForm = (args, props, { signal }): Promise<LoginResponse> => {
    // Still waiting for https://github.com/async-library/react-async/pull/247
    const [values, setSubmitting] = args as [
        Values,
        (isSubmitting: boolean) => void,
    ];
    return userService
        .loginUser(values.username, values.password, { signal })
        .finally(() => setSubmitting(false));
};

const LoginForm: React.FC<Props> = props => {
    const { initialValues } = props;
    const { run } = useAsync<LoginResponse>({
        deferFn: submitForm,
        onReject: e => {
            if (e instanceof Response && e.status === 422) {
                toast.error('Validation error', { autoClose: false });
            } else {
                toast.error('Error during sign in.', { autoClose: false });
            }
        },
        onResolve: response => {
            authTokenService.storeToken(response.token);
            toast.success('Logged');
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
                        type="text"
                        name="username"
                        placeholder="Your username"
                        label="Username"
                    />
                    <Field
                        component={ReactstrapInput}
                        type="password"
                        name="password"
                        placeholder=""
                        label="Password"
                    />
                    <button
                        disabled={formik.isSubmitting}
                        type="submit"
                        className="btn btn-primary"
                    >
                        Sign in
                    </button>
                </Form>
            )}
        </Formik>
    );
};

export default LoginForm;
