import { Controller } from '@hotwired/stimulus';
import { visit } from '@hotwired/turbo';
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
	static targets = ['name', 'categories'];

    connect() {
		const url = new URL(window.location.href);
		const name = url.searchParams.get('name');
		if (name != null) {
			this.nameTarget.focus();
			this.nameTarget.setSelectionRange(name.length, name.length);
		}
	}
	
	namefilter(event) {

		const name = event.target.value;

		const url = new URL(window.location.href);
        url.searchParams.set('name', name);
		if (name == '' || name == ' ' || name == null) {
			url.searchParams.delete('name');
		}

		visit(url);
	}

	categoryfilter(event) {
		const categoryValues = Array.from(this.categoriesTarget.children)
			.filter(child => child.hasAttribute('data-value'))
			.map(child => child.getAttribute('data-value'));
		
		const url = new URL(window.location.href);
		url.searchParams.set('categories', categoryValues);
		if (categoryValues.length == 0) {
			url.searchParams.delete('categories');
		}
		console.log(url);
		visit(url);
	}
}