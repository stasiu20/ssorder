import React from 'react';
import { FieldProps } from 'formik';
import { ChildComponentProps } from '../type';

interface FormFieldTextProps {
    label: string;
    type?: string | React.ComponentType<ChildComponentProps>;
}

type AppFieldProps = FormFieldTextProps & Omit<FieldProps, 'meta'>;

const toTextFieldProp = (props): React.HTMLAttributes<HTMLInputElement> => {
    return {
        ...props,
    };
};

const FormFieldText: React.FC<AppFieldProps> = ({ label, type, ...props }) => {
    const { field, form, ...rest } = props;
    const { touched, errors } = form;
    const isInvalidClass =
        touched[field.name] && errors[field.name] ? 'is-invalid' : '';
    const inputAttributes = toTextFieldProp(rest);

    const renderField = (
        type?: string | React.ComponentType<ChildComponentProps>,
    ): React.ReactNode => {
        if (typeof type === 'function') {
            return React.createElement(type, {
                field,
                form,
                className: `form-control ${isInvalidClass}`,
            });
        }

        if (typeof type === 'string') {
            return (
                <input
                    {...field}
                    {...inputAttributes}
                    type={type}
                    className={`form-control ${isInvalidClass}`}
                />
            );
        }

        return null;
    };

    return (
        <div className={'form-group'}>
            <label htmlFor={inputAttributes.id || field.name}>{label}</label>
            {renderField(type)}
            <div className="invalid-feedback">{errors[field.name]}</div>
        </div>
    );
};
FormFieldText.defaultProps = {
    type: 'text',
};
export default FormFieldText;
