import React from 'react';
import { Link } from 'react-router-dom';
import { isPwaApp } from '../../utils';

interface Props {
    to: string;
    className: string;
}

const AppLink: React.FC<Props> = props => {
    const isPwa = isPwaApp();

    if (isPwa) {
        return (
            <Link className={props.className} to={props.to}>
                {props.children}
            </Link>
        );
    } else {
        return (
            <a className={props.className} href={props.to}>
                {props.children}
            </a>
        );
    }
};

export default AppLink;
