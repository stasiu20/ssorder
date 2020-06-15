import LoginForm from '../user/components/loginForm';
import { render } from 'react-dom';
import SSOrderApp from '../core/components/SSOrderApp';
import React from 'react';

$(function() {
    const $el = $('#react-pwa');

    render(
        <SSOrderApp>
            <LoginForm
                initialValues={{
                    username: '',
                    password: '',
                }}
            />
        </SSOrderApp>,
        $el.get(0),
    );
});
