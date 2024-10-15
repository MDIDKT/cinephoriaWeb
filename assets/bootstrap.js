/*
import { startStimulusApp } from '@symfony/stimulus-bundle';

const app = startStimulusApp();
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
*/
/*import { Controller } from '@hotwired/stimulus';

/!*
export default class extends Controller {
    connect() {
        this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
    }
}*!/*/

// assets/bootstrap.js

import { startStimulusApp } from '@symfony/stimulus-bridge';

// Start the Stimulus application
startStimulusApp();