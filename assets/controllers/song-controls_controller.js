import { Controller } from '@hotwired/stimulus';
import axios from 'axios';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="article-controls" attribute will cause
 * this controller to be executed. The name "article-controls" comes from the filename:
 * article-controls_controller.js -> "article-controls"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    static values = {
        infoUrl: String
    }

    play(event) {
        event.preventDefault();
        axios.get(this.infoUrlValue)
            .then((response) => {
                const audio = new Audio(response.data.url);
                audio.play();
            });
    }
}
