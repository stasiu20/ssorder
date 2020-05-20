import React from 'react';
import { FieldProps } from 'formik';

interface FormFieldTextProps {
    label: string;
    type?: string;
}

type COS = FormFieldTextProps & Omit<FieldProps, 'meta'>;

const toTextFieldProp = (props): React.HTMLAttributes<HTMLInputElement> => {
    return {
        ...props,
    };
};

const FormFieldText: React.FC<COS> = ({ label, type, ...props }) => {
    const { field, form, ...rest } = props;
    const { touched, errors } = form;
    const isInvalidClass =
        touched[field.name] && errors[field.name] ? 'is-invalid' : '';
    const inputAttributes = toTextFieldProp(rest);

    return (
        <div className={'form-group'}>
            <label htmlFor={inputAttributes.id || field.name}>{label}</label>
            <input
                {...field}
                {...inputAttributes}
                type={type}
                className={`form-control ${isInvalidClass}`}
            />
            <div className="invalid-feedback">{errors[field.name]}</div>
        </div>
    );
};
FormFieldText.defaultProps = {
    type: 'text',
};
export default FormFieldText;
