import React from 'react';
import { render } from 'react-dom';
import { toast, ToastContainer } from 'react-toastify';
import { fromEventSource } from './utils/rxjsHelper';

$(function() {
    render(
        <ToastContainer
            position={toast.POSITION.TOP_RIGHT}
            pauseOnFocusLoss={true}
            pauseOnHover={true}
            autoClose={5000}
            draggable={false}
        />,
        document.getElementById('react-toastify'),
    );
    if (EventSource) {
        const subscription = fromEventSource('/sse').subscribe(
            data => {
                toast(data.message, { type: 'info' });
            },
            () => {
                toast('Zerwano połączenie z usługą powiadomień', {
                    type: 'error',
                    autoClose: false,
                });
            },
        );
        // dla firefoxa...
        window.addEventListener('beforeunload', () => {
            subscription.unsubscribe();
        });
    }
});
