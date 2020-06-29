import React from 'react';
import { useScrollToggle } from '../hooks';

const ToggleNavbarOnScroll: React.FC = () => {
    useScrollToggle(
        document.getElementById('navbar') as HTMLElement,
        'navbar--visible',
    );
    return null;
};

export default ToggleNavbarOnScroll;
