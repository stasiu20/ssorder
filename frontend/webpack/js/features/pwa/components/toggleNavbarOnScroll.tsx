import React from 'react';
import { useScrollToggle } from '../hooks';

const ToggleNavbarOnScroll: React.FC = () => {
    const element = document.getElementById('navbar') as HTMLElement;
    element.classList.add('navbar--visible');

    useScrollToggle(element, 'navbar--visible');
    return null;
};

export default ToggleNavbarOnScroll;
