/**
 * @typedef {Object} TechnicalSupervisor
 * @property {number} id
 * @property {string} name
 */

/**
 * @typedef {Object} QiSelectOpportunityData
 * @property {string} id
 * @property {boolean} selected
 * @property {string} technical_supervisor_id
 * @property {string} text
 */

/**
 * @param {TechnicalSupervisor[]} technicalSupervisors 
 */
export default function QuarantineIntakeForm ( technicalSupervisors ) {
    return {
        technicalSupervisorName: '',
        serialNumberRemainingCharacters: 256,
        descriptionRemainingCharacters: 512,
        /**
         * @param {string} status
         */
        maybeClearSerialNumber ( status ) {
            if ( status === 'serial-number-exists' ) {
                return;
            }

            this.$wire.form.serial_number = '';
            this.serialNumberRemainingCharacters = 256;
        },
        clear () {
            this.$wire.form.opportunity = '';
            this.$wire.form.technical_supervisor = null;
            this.$wire.form.serial_number_status = 'serial-number-exists';
            this.$wire.form.serial_number = '';
            this.$wire.form.product_id = null;
            this.$wire.form.starts_at = this.$root.dataset.currentDate;
            this.$wire.form.instake_location = '';
            this.$wire.form.classification = '';
            this.$wire.form.description = '';
            this.technicalSupervisorName = '';

            /** @type {HTMLElement[]} */
            const squareCheckIconElements = this.$root.querySelectorAll( '[data-element="square-check-icon"]' );
            !!squareCheckIconElements.length && squareCheckIconElements.forEach( element => element.remove() );
        },
        /**
         * @param {CustomEvent<QiSelectOpportunityData | undefined>} e
         */
        handleSelectOpportunityChange ( e ) {
            const data = e.detail;

            if ( data === undefined ) {
                return;
            }

            const technicalSupervisor = technicalSupervisors.find( ts => ts.id === data.technical_supervisor_id );

            if ( technicalSupervisor === undefined ) {
                return;
            }

            this.$wire.form.technical_supervisor = technicalSupervisor.id;
            this.technicalSupervisorName = technicalSupervisor.name;
        },
        /**
         * @param {string} iconSelector
         */
        removeSquareCheckIcon ( iconSelector ) {
            if ( !this.$root.querySelector( iconSelector ) ) {
                return;
            }

            this.$root.querySelector( iconSelector ).remove();
        },
    };
}
