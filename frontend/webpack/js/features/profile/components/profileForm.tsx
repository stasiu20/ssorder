import React from 'react';
import { FormikProps, Formik, Form, Field } from 'formik';
import * as Yup from 'yup';
import FormFieldText from '../../form/components/formFieldText';
import { DeferFn, useAsync } from 'react-async';
import { toast } from 'react-toastify';
import { AppContextType, useAppCtx } from '../../core/context/app';
import definedMessages, { KEYS } from '../translation/pl';
import { addMessages } from '../../core/translations/pl';

interface Values {
    email: string;
    rocketChatId: string;
    newPassword: string;
}

interface FormProps {
    initUserData: Values;
}

const validationSchema = (
    appContext: AppContextType,
): Yup.Schema<Partial<Values>> =>
    Yup.object<Partial<Values>>({
        email: Yup.string()
            .required(appContext.translate('Required'))
            .max(200, appContext.translate('InvalidEmail'))
            .email(appContext.translate('InvalidEmail')),
        rocketChatId: Yup.string().max(
            20,
            appContext.translate('InvalidRocketChatId'),
        ),
        newPassword: Yup.string()
            .min(4, appContext.translate('InvalidPasswordTooShort'))
            .max(200, appContext.translate('InvalidPasswordTooLong')),
    });

const submitForm: DeferFn<void> = (args, props, { signal }): Promise<void> => {
    const [values, setSubmitting] = args as [
        Values,
        (isSubmitting: boolean) => void,
    ];
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
    const app = useAppCtx();
    const { run } = useAsync<void>({
        deferFn: submitForm,
        onReject: () =>
            toast(app.translate('error' as KEYS), {
                type: 'error',
                autoClose: false,
            }),
        onResolve: () =>
            toast(app.translate('saved' as KEYS), { type: 'success' }),
    });

    return (
        <Formik
            initialValues={props.initUserData}
            onSubmit={(values, { setSubmitting }): void => {
                run(values, setSubmitting);
            }}
            validationSchema={(): Yup.Schema<Partial<Values>> =>
                validationSchema(app)
            }
        >
            {(formik: FormikProps<Values>): JSX.Element => (
                <Form>
                    <Field
                        component={FormFieldText}
                        type="email"
                        name="email"
                        placeholder={app.translate('email' as KEYS)}
                        label={app.translate('email' as KEYS)}
                    />
                    <Field
                        component={FormFieldText}
                        type="text"
                        name="rocketChatId"
                        placeholder={app.translate('rocketchatId' as KEYS)}
                        label={app.translate('rocketchatId' as KEYS)}
                    />
                    <Field
                        autoComplete="new-password"
                        type="password"
                        name="newPassword"
                        label={app.translate('newPassword' as KEYS)}
                        component={FormFieldText}
                    />
                    <button
                        disabled={formik.isSubmitting}
                        type="submit"
                        className="btn btn-primary"
                    >
                        {app.translate('update' as KEYS)}
                    </button>
                </Form>
            )}
        </Formik>
    );
};

addMessages(definedMessages);
export default ProfileForm;
