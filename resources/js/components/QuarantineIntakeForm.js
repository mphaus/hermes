/**
 * @typedef {Object} State
 * @property {boolean} disabled
 * @property {boolean} loading
 * @property {HTMLOptionElement} [element]
 * @property {string} [id]
 * @property {boolean} [selected]
 * @property {string} text
 * @property {string} [title]
 * @property {string} [_resultId]
 */

export default function QuarantineIntakeForm () {
    const maxDate = this.$refs.startsAt.dataset.nextMonthMaxDate;
    let startsAtFlatpickrInstance = null;

    return {
        serialNumberRemainingCharacters: 256,
        descriptionRemainingCharacters: 512,
        init () {
            this.initStartsAtFlatpickr();
            this.initPrimaryFaultClassificationSelect2();
        },
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
            this.$wire.form.project_or_opportunity = '';
            this.$wire.form.technical_supervisor = null;
            this.$wire.form.serial_number_status = 'serial-number-exists';
            this.$wire.form.serial_number = '';
            this.$wire.form.product_id = null;
            this.$wire.form.starts_at = '';
            this.$wire.form.description = '';

            this.$dispatch( 'hermes:quarantine-intake-cleared' );
        },
        initStartsAtFlatpickr () {
            startsAtFlatpickrInstance = flatpickr( this.$refs.startsAt, {
                altInput: true,
                altFormat: 'd-M-Y',
                minDate: 'today',
                maxDate,
                /**
                 * @param {Date[]} _ 
                 * @param {string} dateStr 
                 */
                onChange: ( _, dateStr ) => {
                    this.$wire.form.starts_at = dateStr;
                },
            } );
        },
        clearStartsAtFlatpickr () {
            if ( startsAtFlatpickrInstance === null ) {
                return;
            }

            startsAtFlatpickrInstance.clear();
        },
        initPrimaryFaultClassificationSelect2 () {
            $( this.$refs.primaryFaultClassification )
                .select2( {
                    placeholder: 'Select an option',
                    width: '100%',
                    /**
                     * @param {State} state
                     */
                    templateResult ( state ) {
                        const { element, text } = state;

                        if ( element === undefined ) {
                            return state.text;
                        }

                        /** @type {{ example: string }} */
                        const { example } = element.dataset;

                        return $( /* html */`<span class="font-semibold">${ text }</span><br><span class="text-sm">${ example }</span>` );
                    },
                } )
                .on( 'change.select2', () => this.$wire.form.classification = $( this.$refs.primaryFaultClassification ).val() );
        },
        clearPrimaryFaultClassificationSelect2 () {
            $( this.$refs.primaryFaultClassification ).val( '' ).trigger( 'change' );
        },
        handleQuarantineIntakeCreated () {
            this.clearStartsAtFlatpickr();
            this.clearPrimaryFaultClassificationSelect2();
        },
        handleQuarantineIntakeCleared () {
            this.clearStartsAtFlatpickr();
            this.clearPrimaryFaultClassificationSelect2();
        },
    };
}
