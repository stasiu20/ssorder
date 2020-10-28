import React from 'react';
import Navbar from 'react-bootstrap/Navbar';
import Nav from 'react-bootstrap/Nav';
import { useAuthStatus, useScrollToggle } from '../hooks';

const NavLogin: React.FC<{}> = props => {
    const isAuthenticated = useAuthStatus();

    if (isAuthenticated) {
        return null;
    }

    return (
        <Nav.Item>
            <Nav.Link href="#/login">Login</Nav.Link>
        </Nav.Item>
    );
};

const AppNavbar: React.FC<{}> = props => {
    const visible = useScrollToggle(true);

    return (
        <Navbar
            id={'navbar'}
            expand="lg"
            sticky={'top'}
            variant={'dark'}
            className={visible ? 'navbar--visible' : ''}
        >
            <div className={'container'}>
                <Navbar.Brand href="#/">
                    <img alt={'logo'} src={'/image/sensilabs-logo.png'} />
                </Navbar.Brand>
                <Navbar.Toggle aria-controls="basic-navbar-nav" />
                <Navbar.Collapse id="basic-navbar-nav">
                    <Nav className="ml-auto nav">
                        <NavLogin />
                    </Nav>
                </Navbar.Collapse>
            </div>
        </Navbar>
    );
};

export default AppNavbar;
