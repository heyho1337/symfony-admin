// image_controller.js

import { Controller } from '@hotwired/stimulus';
import axios from 'axios';

export default class extends Controller {
    connect() {

    }

    async change(event) {
        var html = [];
        const files = event.target.files;
        for (const file of files) {
            html.push(`<span>${file.name}</span>`);
        }
        var id = event.target.getAttribute('data-id');
        var folder = event.target.getAttribute('data-folder');
        var entity = event.target.getAttribute('data-entity');
        const grandParentElement = event.target.parentElement.parentElement;
        const labelElement = grandParentElement.querySelector('label');
        labelElement.innerHTML = html.join('');

        const formData = new FormData();
        formData.append('id',id);
        formData.append('folder',folder);
        formData.append('entity',entity);
        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]); // 'files[]' will be the key for the files array in the request
        }

        try {
            const response = await axios.post('/image/upload', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            console.log('Upload successful', response.data);
        } catch (error) {
            console.error('Upload failed', error);
        }
    }
}