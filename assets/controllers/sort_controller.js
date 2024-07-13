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
	static targets = ['sortItem'];

	static values = {
        route: String,
    };

    connect() {
		console.log('Sort controller connected');
		this.initDraggable();
	}
	
	initDraggable() {
        this.sortItemTargets.forEach(item => {
            item.addEventListener('dragstart', this.handleDragStart.bind(this));
            item.addEventListener('dragenter', this.handleDragEnter.bind(this));
            item.addEventListener('dragover', this.handleDragOver.bind(this));
            item.addEventListener('dragleave', this.handleDragLeave.bind(this));
            item.addEventListener('drop', this.handleDrop.bind(this));
            item.addEventListener('dragend', this.handleDragEnd.bind(this));
        });
	}
	
	handleDragStart(event) {
        this.dragSrcEl = event.currentTarget;
        this.dragSrcEl.classList.add('dragging');
        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/html', this.dragSrcEl.innerHTML);
        this.startPosition = Array.from(this.dragSrcEl.parentNode.children).indexOf(this.dragSrcEl);
    }

    handleDragEnter(event) {
        event.currentTarget.classList.add('over');
    }

    handleDragOver(event) {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';
    }

    handleDragLeave(event) {
        event.currentTarget.classList.remove('over');
    }

    handleDrop(event) {
        event.preventDefault();
        event.stopPropagation();

        if (this.dragSrcEl !== event.currentTarget) {
            this.endPosition = Array.from(this.dragSrcEl.parentNode.children).indexOf(event.currentTarget);
            this.dragSrcEl.innerHTML = event.currentTarget.innerHTML;
            event.currentTarget.innerHTML = event.dataTransfer.getData('text/html');

            this.updatePosition(this.dragSrcEl.getAttribute('rel'), this.endPosition);
        }

        event.currentTarget.classList.remove('over');
    }

    handleDragEnd(event) {
        this.dragSrcEl.classList.remove('dragging');
        this.sortItemTargets.forEach(item => {
            item.classList.remove('over');
        });
    }

    updatePosition(id, position) {
        axios.post(`/${this.routeValue}/sort/${id}/${position}`, {}, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.data.success) {
                console.log('Position updated successfully');
            } else {
                console.error('Failed to update position');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
