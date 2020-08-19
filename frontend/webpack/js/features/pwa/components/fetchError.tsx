import React from 'react';
import ResponseError from '../../core/exceptions/ResponseError';
import { useServiceContainer } from '../../core/context/serviceContainer';
import { toast } from 'react-toastify';
import { Redirect } from 'react-router-dom';

interface Props {
    error: Error;
}

const is401ResponseError = (error: Error): boolean =>
    error instanceof ResponseError && error.response.status === 401;

const FetchError: React.FC<Props> = props => {
    const { error } = props;
    const serviceContainer = useServiceContainer();

    if (is401ResponseError(error)) {
        toast.info('You was logged out');
        serviceContainer.authTokenService.clearToken();
        return <Redirect to={{ pathname: '/login' }} />;
    }

    return <>{props.children}</>;
};

export default FetchError;
