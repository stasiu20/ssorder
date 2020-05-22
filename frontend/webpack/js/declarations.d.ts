declare namespace JSX {
    interface IntrinsicElements {
        'vaadin-upload': VaadinUploadAttributes;
    }
}

interface VaadinUploadAttributes {
    target: string;
    accept: string;
    'max-files': number;
    'form-data-name': string;
}
