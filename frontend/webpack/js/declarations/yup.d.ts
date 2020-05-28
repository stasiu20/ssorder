import { Schema, StringSchema } from 'yup';

declare module 'yup' {
    interface StringSchema<T extends string | null | undefined = string>
        extends Schema<T> {
        validatePhone(
            msg?: string,
            strict?: boolean,
            country?: string,
        ): StringSchema<T>;
    }
}
