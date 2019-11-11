import React, { Component } from 'react';
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

    render() {
        const { isOpen } = this.state;

        return (
            <div>
                <a
                    style={{ cursor: 'pointer' }}
                    onClick={() => this.setState({ isOpen: true })}
                >
                    <img
                        src={this.props.src}
                        className="img-responsive img-thumbnail"
                    />
                </a>
                {isOpen && (
                    <Lightbox
                        mainSrc={this.props.src}
                        reactModalStyle={{ overlay: { zIndex: 2000 } }}
                        onCloseRequest={() => this.setState({ isOpen: false })}
                    />
                )}
            </div>
        );
    }
}
