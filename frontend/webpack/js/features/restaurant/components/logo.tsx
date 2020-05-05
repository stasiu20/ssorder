import React, { Component, ReactNode } from 'react';
import Lightbox from 'react-image-lightbox';

interface RestaurantLogoLightboxProps {
    src: string;
}

interface RestaurantLogoLightboxState {
    isOpen: boolean;
}

export default class RestaurantLogoLightbox extends Component<
    RestaurantLogoLightboxProps,
    RestaurantLogoLightboxState
> {
    constructor(props) {
        super(props);

        this.state = {
            isOpen: false,
        };
    }

    render(): ReactNode {
        const { isOpen } = this.state;

        return (
            <>
                <a
                    style={{ cursor: 'pointer' }}
                    onClick={(): void => this.setState({ isOpen: true })}
                >
                    <img
                        style={{ width: '100%' }}
                        alt={'logo'}
                        src={this.props.src}
                    />
                </a>
                {isOpen && (
                    <Lightbox
                        mainSrc={this.props.src}
                        reactModalStyle={{ overlay: { zIndex: 2000 } }}
                        onCloseRequest={(): void =>
                            this.setState({ isOpen: false })
                        }
                    />
                )}
            </>
        );
    }
}
