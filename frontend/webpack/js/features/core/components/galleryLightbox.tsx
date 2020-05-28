import React, { Component, ReactNode } from 'react';
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
    state: RestaurantGalleryLightboxState = {
        photoIndex: 0,
        isOpen: false,
    };

    render(): ReactNode {
        const { photoIndex, isOpen } = this.state;

        const images = this.props.images;
        const prevIndex = (photoIndex + images.length - 1) % images.length;
        return (
            <div className={'restaurant-gallery'}>
                {images.map((item, index) => {
                    return (
                        <div
                            className="restaurant-gallery__container"
                            key={item.id}
                        >
                            <a
                                className={'restaurant-gallery__delete'}
                                href={item.deleteUrl}
                            >
                                <span className="material-icons">delete</span>
                            </a>
                            <a
                                style={{ cursor: 'pointer' }}
                                onClick={(): void =>
                                    this.setState({
                                        isOpen: true,
                                        photoIndex: index,
                                    })
                                }
                            >
                                <img
                                    alt={'menu image'}
                                    className="restaurant-gallery__photo"
                                    src={item.url}
                                />
                            </a>
                        </div>
                    );
                })}

                {isOpen && (
                    <Lightbox
                        mainSrc={images[photoIndex].url}
                        nextSrc={images[(photoIndex + 1) % images.length].url}
                        prevSrc={images[prevIndex].url}
                        reactModalStyle={{ overlay: { zIndex: 2000 } }}
                        onCloseRequest={(): void =>
                            this.setState({ isOpen: false })
                        }
                        onMovePrevRequest={(): void =>
                            this.setState({
                                photoIndex:
                                    (photoIndex + images.length - 1) %
                                    images.length,
                            })
                        }
                        onMoveNextRequest={(): void =>
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
