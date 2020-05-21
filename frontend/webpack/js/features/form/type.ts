import { FieldProps } from 'formik';

export type ChildComponentProps = Omit<FieldProps, 'meta'> & {
    className?: string;
};
