import React, { Component } from 'react';
import Lightbox from 'react-image-lightbox';

interface RestaurantGalleryLightboxProps {
    images: { url: string; deleteUrl: string; id: number }[];
}

interface RestaurantGalleryLightboxState {
    photoIndex: number;
    isOpen: boolean;
}

export default class RestaurantGalleryLightbox extends Component<
    RestaurantGalleryLightboxProps,
    RestaurantGalleryLightboxState
> {
    constructor(props) {
        super(props);

        this.state = {
            photoIndex: 0,
            isOpen: false,
        };
    }

    render() {
        const { photoIndex, isOpen } = this.state;

        let images = this.props.images;
        return (
            <div>
                {images.map((item, index) => {
                    return (
                        <div className="responsive" key={item.id}>
                            <div className="img">
                                <a className="delete" href={item.deleteUrl}>
                                    <span className="glyphicon glyphicon-remove-sign" />
                                </a>
                                <a
                                    style={{ cursor: 'pointer' }}
                                    onClick={() =>
                                        this.setState({
                                            isOpen: true,
                                            photoIndex: index,
                                        })
                                    }
                                >
                                    <img className="menuImage" src={item.url} />
                                </a>
                            </div>
                        </div>
                    );
                })}

                {isOpen && (
                    <Lightbox
                        mainSrc={images[photoIndex].url}
                        nextSrc={images[(photoIndex + 1) % images.length].url}
                        prevSrc={
                            images[
                                (photoIndex + images.length - 1) % images.length
                            ].url
                        }
                        reactModalStyle={{ overlay: { zIndex: 2000 } }}
                        onCloseRequest={() => this.setState({ isOpen: false })}
                        onMovePrevRequest={() =>
                            this.setState({
                                photoIndex:
                                    (photoIndex + images.length - 1) %
                                    images.length,
                            })
                        }
                        onMoveNextRequest={() =>
                            this.setState({
                                photoIndex: (photoIndex + 1) % images.length,
                            })
                        }
                    />
                )}
            </div>
        );
    }
}
