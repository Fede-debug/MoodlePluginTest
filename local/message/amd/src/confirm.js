
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

//namespace local_message;

/**
 * Hook callbacks for usertours.
 *
 * @module     local_message
 * @copyright  Federico Diana
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
//import ModalFactory from 'core/modal_factory';

// require(['jquery', 'core/modal_factory'], function($) {


//     window.console.log('test');
//     window.console.log($('.local_message_delete_button'));

//     var trigger = $('.local_message_delete_button');

//         ModalFactory.create({
//         title: 'test title',
//         body: '<p>test body content</p>',
//         footer: 'An example footer content',
//     }, trigger)
// .done(function(/*modal*/){
//     Y.log('Finished modal');
// });
// });
import ModalSaveCancel from 'core/modal_save_cancel';
import {get_string as getString} from 'core/str';
import jQuery from 'jquery';
import ModalEvents from 'core/modal_events';

export const init = async (button) => {
    const modal = await ModalSaveCancel.create({
        title: getString('message_deletion', 'local_message'),
        body: getString('delete_message_confirm', 'local_message'),
        // preShowCallBack: function(triggerelement, modalsingle) {
        //     window.console.log('test');
        //     window.console.log(triggerelement);

        //     let classListString = triggerelement.classList[0];
        //     let messageid = classListString.substr(classListString.lastIndexOf('local_message') + 'local_message'.length);

        //     modalsingle.params = {'messageid': messageid};
        // }
        large: true
    });

    window.console.log(button);
    
    modal.getRoot().on(ModalEvents.shown, (e) => {
        // window.console.log('test');
        //     window.console.log(e);

        //     let triggerElement = $(e);

        //     window.console.log(triggerElement);

            let classListString = button.classList[0];
            let messageid = classListString.substr(classListString.lastIndexOf('local_message') + 'local_message'.length);

            modal.params = {'messageid': messageid};

    });

    modal.getRoot().on(ModalEvents.save, (e) => {
        e.preventDefault();

        console.log(modal.params);

    });

    // ...
    modal.setSaveButtonText(getString('delete_button_modal', 'local_message'));
    //modal.param('messageid', messageid);
    modal.show();
};

//init.apply();
// jQuery('local_message_delete_button').click(function(){
//     //do something here
//     init.apply();
// });

// document.querySelector('.local_message_delete_button').addEventListener('click', event => init.apply());

const deleteButtons = document.querySelectorAll('.local_message_delete_button');
//deleteButton.addEventListener('click', onDeleteButtonClick);


deleteButtons.forEach( button => {button.addEventListener('click', onDeleteButtonClick);
    // let classListString = button.classList[0];
    // let myid = classListString.substr(classListString.lastIndexOf('local_message') + 'local_message'.length);
    //  button.myParam = myid;
                            });



function onDeleteButtonClick(){

    // window.console.log(this);
    //Y.log('Y log test');
//let messageid = classListString.substr(classListString.lastIndeOf('local_messageid') + 'local_messageid'.length);
//window.console.log(event.currentTarget.myParam);

let button = this;

window.console.log(button);

    init.call(this, button);
}