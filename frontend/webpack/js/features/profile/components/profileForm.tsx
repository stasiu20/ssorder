import React from 'react';
import { FormikProps, Formik, Form, Field } from 'formik';
import * as Yup from 'yup';
import FormFieldText from '../../form/components/formFieldText';
import { useAsync } from 'react-async';
import { toast } from 'react-toastify';

interface Values {
    email: string;
    rocketChatId: string;
    newPassword: string;
}

interface FormProps {
    initUserData: Values;
}

const validationSchema = Yup.object<Partial<Values>>({
    email: Yup.string()
        .required('Required')
        .max(200, 'Invalid email address')
        .email('Invalid email address'),
    rocketChatId: Yup.string().max(20, 'Invalid rocketchat ID'),
    newPassword: Yup.string()
        .min(4, 'Password too short')
        .max(200, 'Password too long'),
});

const submitForm = (
    [values, setSubmitting]: [Values, (isSubmitting: boolean) => void],
    props,
    { signal },
): Promise<unknown> => {
    const headers = {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    };
    return fetch('/profile-ajax/update-profile', {
        signal,
        headers,
        method: 'POST',
        body: JSON.stringify({
            // eslint-disable-next-line @typescript-eslint/camelcase
            rocketchat_id: values.rocketChatId,
            // eslint-disable-next-line @typescript-eslint/camelcase
            new_password: values.newPassword,
            email: values.email,
        }),
    })
        .then(res => (res.ok ? res : Promise.reject(res)))
        .then(res => res.json())
        .finally(() => setSubmitting(false));
};

const ProfileForm: React.FC<FormProps> = props => {
    const { run } = useAsync({
        deferFn: submitForm,
        onReject: () =>
            toast('Error during saving', { type: 'error', autoClose: false }),
        onResolve: () => toast('Saved!', { type: 'success' }),
    });

    return (
        <Formik
            initialValues={props.initUserData}
            onSubmit={(values, { setSubmitting }): void => {
                run(values, setSubmitting);
            }}
            validationSchema={validationSchema}
        >
            {(formik: FormikProps<Values>): JSX.Element => (
                <Form>
                    <Field
                        component={FormFieldText}
                        type="email"
                        name="email"
                        placeholder="Email"
                        label="Email"
                    />
                    <Field
                        component={FormFieldText}
                        type="text"
                        name="rocketChatId"
                        placeholder="Rocketchat Id"
                        label="Rocketchat Id"
                    />
                    <Field
                        autoComplete="new-password"
                        type="password"
                        name="newPassword"
                        label="Nowe hasło"
                        component={FormFieldText}
                    />
                    <button
                        disabled={formik.isSubmitting}
                        type="submit"
                        className="btn btn-primary"
                    >
                        Aktualizuj
                    </button>
                </Form>
            )}
        </Formik>
    );
};

export default ProfileForm;
