import React from 'react';
import { render } from 'react-dom';
import SSOrderApp from '../core/components/SSOrderApp';
import ProfileForm from './components/profileForm';

$(function() {
    const userData = window['__APP_DATA__']['userData'];
    const $el = $('#react-profile');

    render(
        <SSOrderApp>
            <ProfileForm
                initUserData={{
                    newPassword: '',
                    email: userData.email || '',
                    rocketChatId: userData.rocketchat_id || '',
                }}
            />
        </SSOrderApp>,
        $el.get(0),
    );
});
