import React from 'react';
import { render } from 'react-dom';
import SSOrderApp from '../core/components/SSOrderApp';
import ProfileForm from './components/profileForm';
import WebPushStateManager from './components/webPushStateManage';

$(function() {
    const userData = window['__APP_DATA__']['userData']['data'];
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
            <WebPushStateManager />
        </SSOrderApp>,
        $el.get(0),
    );
});
