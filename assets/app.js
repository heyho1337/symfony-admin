import './bootstrap.js';
import { shouldPerformTransition, performTransition } from 'turbo-view-transitions';

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// ... lines 6 - 9
document.addEventListener('turbo:before-render', (event) => {
    if (shouldPerformTransition()) {
        event.preventDefault();
        performTransition(document.body, event.detail.newBody, async () => {
            await event.detail.resume();
        });
    }
});
document.addEventListener('turbo:load', () => {
    // View Transitions don't play nicely with Turbo cache
    if (shouldPerformTransition()) Turbo.cache.exemptPageFromCache();
});
