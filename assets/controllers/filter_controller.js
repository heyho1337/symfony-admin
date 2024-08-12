import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['filtersContainer', 'applyButton'];

    connect() {
        this.loadFilters();
    }

    loadFilters() {
        const filterUrl = this.filtersContainerTarget.getAttribute('data-href');

        fetch(filterUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok.');
                }
                return response.text();
            })
            .then(html => {
                this.filtersContainerTarget.innerHTML = html;
                this.initializeFilters();
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
	}

    initializeFilters() {
        const sidebarFilter = this.filtersContainerTarget;

        sidebarFilter.querySelectorAll('.filter-heading a').forEach(toggle => {
            toggle.setAttribute('aria-expanded', 'true');
        });

        sidebarFilter.querySelectorAll('.filter-content').forEach(content => {
            content.classList.remove('collapse');
            content.style.display = 'block';
        });

        const filterFields = sidebarFilter.querySelectorAll('.filter-field');
        filterFields.forEach(field => {
            const inputs = field.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                if (input.type === 'radio') {
                    input.addEventListener('change', () => {
                        if (input.checked) {
                            field.querySelector('.filter-checkbox').checked = true;
                        }
                    });
                } else {
                    input.addEventListener('input', () => {
                        field.querySelector('.filter-checkbox').checked = input.value.trim() !== '';
                    });
                }
            });
        });

        const filtersForm = sidebarFilter.querySelector('form');
        filtersForm.querySelectorAll('input, textarea').forEach(input => {
            input.addEventListener('keypress', event => {
                if (event.key === 'Enter' || event.keyCode === 13) {
                    event.preventDefault();
                    this.applyButtonTarget.click();
                }
            });
        });
    }

    applyFilters(event) {
		event.preventDefault();
		
		const filterModal = this.filtersContainerTarget;
		const form = filterModal.querySelector('form');
		const formData = new FormData(form);
		const params = new URLSearchParams();
		let emptySelect = false;
	
		formData.forEach((value, key) => {
			if (value === '0' && key === 'filters[prod_category][value][]') {
				emptySelect = true;
			}
		});
	
		formData.forEach((value, key) => {
			if (emptySelect && (key === 'filters[prod_category][comparison]' || key === 'filters[prod_category][value][]')) {
				return;
			}
	
			if(key != 'filters[prod_category][comparison]'){
				if (Array.isArray(value)) {
					value.forEach(val => {
						params.append(key, val);
					});
				} else {
				params.append(key, value);
				}
			}
		});
	
		let queryString = params.toString().replace(/%5B%5D%5B%5D/g, '%5B%5D');
		const baseUrl = new URL(window.location.href);
		baseUrl.search = queryString;
		var stringUrl = baseUrl.toString();

		if (emptySelect == false) {
			stringUrl = stringUrl + "&filters%5Bprod_category%5D%5Bcomparison%5D=%3D";
		}
	
		window.location.href = stringUrl;
	}
}
