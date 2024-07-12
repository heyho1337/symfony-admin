import { Controller } from '@hotwired/stimulus';
import axios from 'axios';
/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {

    connect() {
		
    }

	change(event) {
		const button = event.target;
		const id = button.getAttribute('value');
        axios.post(`/component/${id}/onoff`)
			.then(response => {
				console.log(response);
				if (response.data.success) {
					if (response.data.result == 1) {
						button.checked = true;
                    } else {
                        button.checked = false;
                    }
                    console.log('Component activated successfully');
                } else {
                    console.error('Failed to activate component');
                }
            })
            .catch(error => {
                console.error('Error activating component:', error);
            });
    }
}
